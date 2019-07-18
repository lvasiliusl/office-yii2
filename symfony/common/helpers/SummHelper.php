<?php
namespace common\helpers;

use Yii;
use common\web\BaseController;
use yii\helpers\ArrayHelper;

/**
 *
 */
class SummHelper
{
    /**
    *@inheritDoc
    */
    public static function curr($currency, $money_summ, $trig = null)
    {
        $currencysAll = [];
        $currentCurrency = [];
        $currentPos = '';
        $currentSymbol = '';

        $currencysAll = BaseController::getCurrencys();

        if (is_string($currency)) {
            $curr = strtoupper($currency);
            $currencysArr = ArrayHelper::index($currencysAll, 'code');
        }
        elseif (is_int($currency)) {
            $curr = $currency;
            $currencysArr = ArrayHelper::index($currencysAll, 'id');
        }

        if (isset($currencysArr)) {

            $currentCurrency = ArrayHelper::filter($currencysArr, [$curr]);
            $currentPos = ArrayHelper::getValue($currentCurrency, $curr.'.symbol_position');
            $currentSymbol = ArrayHelper::getValue($currentCurrency, $curr.'.symbol');

            if ($currentPos == 1) {
                return $currentSymbol . Yii::$app->formatter->asDecimal($money_summ);
            }
            elseif ($currentPos == 2) {
                return Yii::$app->formatter->asDecimal($money_summ) . $currentSymbol;
            }
        }
        else {
            return Yii::$app->formatter->asDecimal($money_summ);
        }
    }

    public static function moneyFormatter($money){


        switch (mb_strimwidth($money,0,1)) {
            case '+':
                $clr = '#48af03';
                $smbl = '';
                break;
            case '-':
                $clr = '#a80b0b';
                $smbl = '';
                break;
        }

        return '<span style="color: '.$clr.'">' . $smbl . $money . '</span>';
    }
}
