<?php
namespace common\models;

use common\models\OfficeBalance;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;


/**
 *
 */
class BalanceTransactions extends ActiveRecord
{

    public function rules()
    {
        return
        [
            [['title', 'description', 'balance', 'summ'], 'required'],
            ['balance', 'exist', 'targetClass' => 'common\models\OfficeBalance', 'targetAttribute' => 'id'],
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


    public function getOfficeBalance()
    {
        return $this->hasOne(OfficeBalance::className(), ['id' => 'balance']);
    }
}
