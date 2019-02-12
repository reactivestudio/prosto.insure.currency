<?php

namespace app\commands;

use yii\console\Controller;
use Yii;

/**
 * Консольный контроллер для управления данными курса валют
 *
 * Class CurrencyController
 * @package app\commands
 */
class CurrencyController extends Controller
{
    /**
     * Экшн для обновления (импорт из внешнего источника) данных курса валют
     */
    public function actionUpdate()
    {
        Yii::$app->currency->update();
        print_r(Yii::$app->currency->message);
    }
}