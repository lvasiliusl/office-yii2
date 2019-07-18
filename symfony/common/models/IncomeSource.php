<?php
namespace common\models;

use Yii;
use common\models\Model;
use common\models\Currency;
use common\models\IncomeTransactions;
use yii\db\ActiveRecord;


/**
 *
 */
class IncomeSource extends ActiveRecord
{

    public function rules()
    {
        return [
            [['name', 'currency_id', 'commission_type'], 'required'],
            ['name', 'string', 'max' => 30],
            ['commission', 'number'],
            ['commission_type', 'in', 'range' => ['fixed', 'percentage']],
            ['currency_id', 'exist', 'targetClass' => 'common\models\Currency', 'targetAttribute' => 'id'],
        ];
    }

    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    public function getIncomeTransactions()
    {
        return $this->hasMany(IncomeTransactions::className(), ['from' => 'id']);
    }
}
