<?php
namespace common\models;

use common\models\OfficeBalance;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;


/**
 *
 */
class BalanceTransactionsTemp extends ActiveRecord
{

    public function rules()
    {
        return
        [
            [['description', 'from_balance', 'to_balance', 'from_summ', 'to_summ'], 'required'],
            ['from_balance', 'exist', 'targetClass' => 'common\models\OfficeBalance', 'targetAttribute' => 'id'],
            ['to_balance', 'exist', 'targetClass' => 'common\models\OfficeBalance', 'targetAttribute' => 'id'],
            ['description', 'string', 'max' => 150],
            ['from_title', 'string', 'max' => 50],
            ['to_title', 'string', 'max' => 50],
            ['from_summ', 'number'],
            ['to_summ', 'number'],
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

    public function load($data, $formName = NULL)
    {

        $from_balance_name = OfficeBalance::find()->indexBy('name')->where([
            'id' => $data['from_balance']
            ])->one()->getAttribute('name');
        $to_balance_name = OfficeBalance::find()->indexBy('name')->where([
            'id' => $data['to_balance']
            ])->one()->getAttribute('name');

        $this->from_title = 'Transaction from ' . $from_balance_name;
        $this->to_title = 'Transaction to ' . $to_balance_name;

        $this->from_balance = $data['from_balance'];
        $this->to_balance = $data['to_balance'];
        $this->from_summ = $data['from_summ'];
        $this->to_summ = $data['to_summ'];
        $this->description = $data['description'];

        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function getOfficeFromBalance()
    {
        return $this->hasOne(OfficeBalance::className(), ['id' => 'from_balance']);
    }
}
