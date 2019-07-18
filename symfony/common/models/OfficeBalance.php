<?php
namespace common\models;

use common\models\Currency;
use common\models\IncomeTransactions;
use yii\db\ActiveRecord;

/**
 *
 */
class OfficeBalance extends ActiveRecord
{

    public function rules()
    {
        return [
            [['name', 'currency_id'], 'required'],
            ['name', 'string', 'max' => 30],
            ['money_amount', 'integer'],
            ['currency_id', 'exist', 'targetClass' => 'common\models\Currency', 'targetAttribute' => 'id'],
        ];
    }

    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    public function getIncomeTransactions()
    {
        return $this->hasMany(IncomeTransactions::className(), ['to_balance' => 'id']);
    }
}
