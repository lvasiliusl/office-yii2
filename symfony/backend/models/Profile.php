<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\helpers\Role;
use common\models\User;

class Profile extends Model {

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $password_repeat;
    public $role;
    public $salary_type;
    public $salary;
    public $card;
    private $_user;


    public function rules()
    {
        return [
            ['id', 'number'],
            [['first_name', 'last_name', 'email'],'required'],
            [['first_name', 'last_name', 'email', 'password', 'role'], 'trim'],
            ['email', 'email'],
            ['card', 'number', 'when' => function($model) {
            return $model->card == !NULL; }, 'enableClientValidation' => false],
            ['email', 'unique', 'targetAttribute' => 'email', 'targetClass' => '\common\models\User', 'when' => function($model){
                return $model->_user->isAttributeChanged('email');
            }, 'skipOnEmpty' => false, 'skipOnError' => false],
            [['first_name', 'last_name', 'email'], 'string', 'min' => 2, 'max' => 255],
            ['password', 'string', 'min' => 8, 'max' => 42],
            ['password', 'required', 'when' => function($model) {
            return !$model->id;
            }, 'enableClientValidation' => false],
            ['password_repeat', 'required', 'when' => function($model) {
            return $model->password == !NULL;
            }, 'enableClientValidation' => false],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ],
        ];
    }

    public function findOne($params) {
        return $this->_user = User::findOne($params);
    }

    public function load($data, $formName = null) {
        $load = parent::load($data, $formName);

        if( $this->id ) {
            $this->_user = Profile::findOne(['id' => $this->id]);
        } else {
            $this->_user = new User();
        }

        $this->_user->first_name = $this->first_name;
        $this->_user->last_name = $this->last_name;
        $this->_user->email = $this->email;

        if( $this->password ) {
            $this->_user->setPassword($this->password);
            $this->_user->generateAuthKey();
        }

        return $load;
    }

    public function save()
    {
        $result = false;
        if($this->validate() ){
            $result = $this->_user->save();
        } else {
            return $result;
        }
    }
}
