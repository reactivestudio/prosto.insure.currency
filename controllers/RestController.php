<?php

namespace app\controllers;

use yii\rest\ActiveController;
use app\models\Currency;
use yii\filters\auth\HttpBearerAuth;

/**
 * Контроллер для реализации Rest API
 *
 * Class RestController
 * @package app\controllers
 */
class RestController extends ActiveController
{
    /**
     * @var string Класс модели данных курса валют
     */
    public $modelClass = Currency::class;

    /**
     * Реализация поведения Bearer авторизации по токену
     *
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = HttpBearerAuth::class;

        return $behaviors;
    }
}