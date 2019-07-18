<?php
namespace common\models;

use Yii;

use yii\db\ActiveRecord;


/*
*Client Model
*
*@property integer id
*@property string name
*@property string email
*@property string origin
*/

class Client extends ActiveRecord {


    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [[ 'name', 'email' , 'origin'], 'trim'],
            [[ 'name', 'email' , 'origin'], 'required'],
            [[ 'projects_count'], 'number'],
        ];
    }

    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['client_id' => 'id']);
    }
    
}
