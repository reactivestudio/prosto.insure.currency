<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property int $id Идентификатор записи
 * @property string $name Название валюты
 * @property string $rate Курс по отношению к рублю
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'rate'], 'required'],
            [['rate'], 'number'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function fields()
    {
        return ['name', 'rate'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор записи',
            'name' => 'Название валюты',
            'rate' => 'Курс по отношению к рублю',
        ];
    }
}
