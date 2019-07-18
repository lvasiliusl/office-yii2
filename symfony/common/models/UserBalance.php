<?php
namespace common\models;

use common\models\Currency;
use common\models\User;
use yii\db\ActiveRecord;

/**
 *
 */
class UserBalance extends ActiveRecord
{

    public function rules()
    {
        return [
            [['currency_id', 'user_id'], 'required'],
            ['money_amount', 'integer'],
            ['currency_id', 'exist', 'targetClass' => 'common\models\Currency', 'targetAttribute' => 'id'],
            ['user_id', 'exist', 'targetClass' => 'common\models\User', 'targetAttribute' => 'id'],
        ];
    }

    public function load($data, $formName = NULL)
    {
        $this->user_id = $data['user'];
        $this->currency_id = $data['currency_id'];

        return true;
    }

    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
