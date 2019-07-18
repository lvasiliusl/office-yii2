<?php
namespace common\models;

use Yii;
use common\models\Model;
use common\models\Currency;
use common\models\IncomeSource;
use common\models\OfficeBalance;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;


/**
 *
 */
class IncomeTransactions extends ActiveRecord
{

    public function rules()
    {
        return [
            [['title', 'description', 'from', 'to_balance', 'summ', 'currency_id'], 'required'],
            ['from', 'exist', 'targetClass' => 'common\models\IncomeSource', 'targetAttribute' => 'id'],
            ['to_balance', 'exist', 'targetClass' => 'common\models\OfficeBalance', 'targetAttribute' => 'id'],
            ['currency_id', 'exist', 'targetClass' => 'common\models\Currency', 'targetAttribute' => 'id'],
            ['description', 'string', 'max' => 150],
            ['title', 'string', 'max' => 50],
            ['summ', 'number'],
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

    public function getIncomeSource()
    {
        return $this->hasOne(IncomeSource::className(), ['id' => 'from']);
    }
    public function getOfficeBalance()
    {
        return $this->hasOne(OfficeBalance::className(), ['id' => 'to_balance']);
    }
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }
}
