<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

use common\models\Model;
use common\models\OfficeBalance;
use common\models\CurrencyExchange;


/**
 *
 */
class Currency extends ActiveRecord
{

    public function rules()
    {
        return [
            [['title', 'code', 'symbol', 'symbol_position'], 'required'],
            ['title', 'string', 'max' => 30],
            ['code', 'string', 'max' => 5],
            ['symbol', 'string', 'max' => 5],
            ['symbol_position', 'integer', 'max' => 2],
        ];
    }

    public function getOfficeBalance()
    {
        return $this->hasMany(OfficeBalance::className(), ['currency_id' => 'id']);
    }

    public function getCurrencyExchange()
    {
        return $this->hasMany(CurrencyExchange::className(), ['currency_id' => 'id']);
    }

    public function getIncomeSource()
    {
        return $this->hasMany(IncomeSource::className(), ['currency_id' => 'id']);
    }

    public function getIncomeTransactions()
    {
        return $this->hasMany(IncomeSource::className(), ['currency_id' => 'id']);
    }
    public function getUser()
    {
        return $this->hasMany(User::className(), ['currency_id' => 'id']);
    }
}
