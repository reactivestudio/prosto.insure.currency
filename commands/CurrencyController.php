<?php

namespace app\commands;

use yii\console\Controller;
use yii\httpclient\Client;
use yii\helpers\ArrayHelper;
use app\models\Currency;
use Yii;

class CurrencyController extends Controller
{
    public function actionUpdate()
    {
        $client = new Client(['baseUrl' => 'http://www.cbr.ru/scripts/XML_daily.asp']);
        $response = $client
            ->createRequest()
            ->setFormat(Client::FORMAT_XML)
            ->send();

        $responseData = $response->getData();
        $values = $responseData['Valute'];

        $result = ArrayHelper::getColumn($values, function (array $item) {
            return [
                "name" => $item['Name'],
                "rate" => floatval(str_replace(',','.', $item['Value'])),
            ];
        });

        echo 'Очищены данные курса валют'.PHP_EOL;
        Yii::$app->db->createCommand()->truncateTable(Currency::tableName())->execute();

        $input = count($result);
        $saved = 0;
        foreach ($result as $attributes) {
            $model = new Currency($attributes);
            if ($model->validate()) {
                if ($model->save()) {
                    $saved++;
                }
            }
        }

        echo "Сохранены курсы валют $saved/$input".PHP_EOL;
    }
}