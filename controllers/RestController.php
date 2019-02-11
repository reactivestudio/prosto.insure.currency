<?php

namespace app\controllers;

use yii\rest\ActiveController;
use app\models\Currency;
use yii\filters\auth\HttpBearerAuth;

class RestController extends ActiveController
{
    public $modelClass = Currency::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = HttpBearerAuth::class;
//        $behaviors['authenticator']['only'] = ['index', 'view'];
        return $behaviors;
    }
}