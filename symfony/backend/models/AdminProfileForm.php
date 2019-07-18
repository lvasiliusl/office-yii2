<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Edit Admin Profile form
 */
class AdminProfileForm extends Model
{
    public $id;
    public $email;
    public $first_name;
    public $last_name;
    public $password;
    public $password_repeat;
    public $username;
    private $user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email'], 'required'],
            [['first_name', 'last_name', 'email'], 'trim'],
            ['username', 'default', 'value' => $this->email],
            ['email', 'unique', 'targetAttribute' => 'email', 'targetClass' => '\common\models\User', 'when' => function($model){
                return $this->user->isAttributeChanged('email');
            }],
            ['password', 'string', 'min' => 6, 'skipOnEmpty' => true],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"Passwords don't match"],
        ];
    }
    
    public function getDisplay_name()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Update User model.
     *
     * @return bool whether the email was send
     */
    public function save()
    {
        $this->username = $this->email;
        $this->user = Yii::$app->user->identity;
        $this->user->email = $this->email;
        $this->user->first_name = $this->first_name;
        $this->user->last_name = $this->last_name;
        $this->user->setPassword( $this->password );
        $this->user->generateAuthKey();
        
        if( !$this->validate() ) {
            return false;
        }
        
        return $this->user->save();
    }
}
