<?php
namespace common\web;

use common\models\Currency;
use yii\web\Controller;
use yii\helpers\ArrayHelper;


class BaseController extends Controller
{

    public $bodyClass = [];

    /**
    *@inheritDoc
    */
    public static function getCurrencys()
    {
        $currencysModel = [];
        $currencysArrModel = [];
        $currencysArr =[];

        $currencysModel = Currency::find()->all();
        $currencysArrModel = ArrayHelper::toArray($currencysModel,
        [
            'common\models\Currency' => [
                'id',
                'symbol_position',
                'symbol',
                'code'
            ]
        ]);

        return $currencysArrModel;
    }
}
