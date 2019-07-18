<?php
namespace common\models;

use Yii;
use common\models\Model;
use common\models\Currency;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;


/**
 *
 */
class CurrencyExchange extends ActiveRecord
{

    public function rules()
    {
        return [
            [['currency_id', 'rate'], 'required'],
            ['rate', 'number'],
            ['currency_id', 'exist', 'targetClass' => 'common\models\Currency', 'targetAttribute' => 'id'],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp'  => [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }
}
