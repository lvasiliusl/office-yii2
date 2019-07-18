<?php
namespace common\models;

use Yii;

use yii\db\ActiveRecord;


/*
*Client Model
*
*@property integer id
*@property integer client_id
*@property integer user_id
*@property string name
*@property string description
*@property integer string
*/

class Project extends ActiveRecord {


    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [[ 'name', 'description'], 'trim'],
            [[ 'name', 'user_id'],'required'],
            [[ 'price', 'client_id', 'user_id'], 'number'],
        ];
    }

    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    public function getClientName()
    {
        if (!empty($this->client)) {
            return $this->client->name;
        }
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getUserName()
    {
        if (!empty($this->user)) {
            return $this->user->first_name . ' ' . $this->user->last_name;
        }
    }
}
