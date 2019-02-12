<?php

namespace app\components;

use yii\base\Component;
use yii\httpclient\Client;
use yii\helpers\ArrayHelper;
use app\models\Currency;
use Yii;

/**
 * Компонент приложения для управления импортом данных курса валют
 *
 * Class CurrencyImportManager
 * @package app\components
 */
class CurrencyImportManager extends Component
{
    /**
     * Xml тег списка курсов валют, используется для парсинга
     */
    const XML_LIST_TAG = 'Valute';

    /**
     * Xml тег для поля "Название" курса валюты, используется для парсинга
     */
    const XML_ITEM_NAME_TAG = 'Name';

    /**
     * Xml тег для поля "Значение" курса валюты, используется для парсинга
     */
    const XML_ITEM_RATE_TAG = 'Value';

    /**
     * @var string Url внешнего источника данных курса валют в xml формате
     */
    public $xmlUrl;

    /**
     * @var string Сообщение о ходе выполнения обновления данных
     */
    private $message = '';

    /**
     * Обновить данные курса валют из внешнего источника и сохранить в таблице
     *
     * @return bool true, в случае успеха, false – иначе
     */
    public function update()
    {
        $this->message .= 'Обновление данных курса валют'.PHP_EOL;

        try {
            $data = $this->getXmlData();
        } catch (\Exception $exception) {
            $this->message .= $exception->getMessage();
            return false;
        }

        if (empty($data)) {
            $this->message .= 'Нет данных для импорта'.PHP_EOL;
        }

        try {
            $this->truncate();
        } catch (\yii\db\Exception $exception) {
            $this->message .= $exception->getMessage();
            return false;
        }
        $this->message .= 'Очищены старые данные'.PHP_EOL;

        list($saved, $from) = $this->save($data);
        $this->message .= "Сохранены данные курса валют $saved/$from".PHP_EOL;

        return true;
    }

    /**
     * Получить и обработать данные курса валют из внешнего источника
     *
     * @return array Данные курса валют
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     * @throws \Exception
     */
    public function getXmlData ()
    {
        if (empty($this->xmlUrl)) {
            throw new \Exception('Не задан url для внешнего источника xml данных');
        }

        /**
         * Получаем данные из внешнего источника
         */
        $client = new Client(['baseUrl' => $this->xmlUrl]);
        $request = $client
            ->createRequest()
            ->setFormat(Client::FORMAT_XML);
        $response = $request->send();

        if (!$response->isOk) {
            throw new \Exception('Невозможно загрузить xml данные из внешнего источника');
        }

        $responseData = $response->getData();
        $values = array_key_exists(self::XML_LIST_TAG, $responseData) ? $responseData[self::XML_LIST_TAG] : [];

        /**
         * Обрабатываем данные из xml
         */
        $data = ArrayHelper::getColumn($values, function (array $item) {
            return [
                "name" => $item[self::XML_ITEM_NAME_TAG],
                "rate" => floatval(str_replace(',','.', $item[self::XML_ITEM_RATE_TAG])),
            ];
        });

        return $data;
    }

    /**
     * Очистить таблицу курса валют
     *
     * @return int Количество затронутых строк
     * @throws \yii\db\Exception
     */
    public function truncate() {
        $result = Yii::$app->db
            ->createCommand()
            ->truncateTable(Currency::tableName())
            ->execute();

        return $result;
    }

    /**
     * Сохранить курсы валют
     *
     * @param array $data Данные курса валют
     * @return array Количество сохраненных и входных данных
     */
    public function save(array $data)
    {
        $saved = 0;
        foreach ($data as $attributes) {
            $model = new Currency($attributes);
            if ($model->validate() && $model->save()) {
                $saved++;
            }
        }

        return [$saved, count($data)];
    }

    /**
     * Получить сообщение о ходе выполнения обновления данных
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}