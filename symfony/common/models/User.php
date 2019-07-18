<?php
namespace common\models;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

use common\models\UserBalance;
use common\models\UserMeta;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property string $company
 * @property integer $status
 * @property integer $last_login
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $meta = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email'], 'required'],
            [['first_name', 'last_name', 'email'], 'trim'],
            ['email', 'unique', 'targetAttribute' => 'email', 'targetClass' => '\common\models\User', 'when' => function($model){
                return $this->isAttributeChanged('email');
            }],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['salary_type'], 'in', 'range' => ['fixed', 'hourly']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function getUser_meta()
    {
        return $this->hasMany(UserMeta::className(), ['user_id' => 'id']);
    }

    public function getDisplay_name()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['client_id' => 'id']);
    }

    /**
     * @inheritDoc
     */
    public function beforeSave($insert) {
        return parent::beforeSave($insert);
    }

    /**
     * @inheritDoc
     */
    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        $this->saveMetaFields($insert);
    }

    /**
     * Save user meta
     *
     * @param bool $insert If `false`, it means the method is called while updating a record.
     * @return void
     */
    public function saveMetaFields($insert)
    {
        $postadata = Yii::$app->request->post('User');
        $meta = $postadata['meta'] ?? [];

        if( !empty($meta) ) {

            if( !$insert ) {
                foreach ($meta as $meta_key => $meta_value) {
                    $this->updateMeta($meta_key, $meta_value);
                }
            } else {
                foreach ($meta as $meta_key => $meta_value) {
                    $this->meta[] = [
                        'user_id' => $this->id,
                        'meta_name' => $meta_key,
                        'meta_value' => is_array($meta_value)? serialize($meta_value) : $meta_value
                    ];
                }

                $userMeta = new UserMeta;

                Yii::$app->db->createCommand()->batchInsert(UserMeta::tableName(), ['user_id', 'meta_name', 'meta_value'], $this->meta)->execute();
            }
        }
    }

    /**
     * @param string $id [User ID]
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @param string $token [description]
     * @param string $type
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByEmailAndRole($email, $role)
    {
        return static::find()
            ->select('user.*')
            ->leftJoin('auth_assignment', 'auth_assignment.user_id = user.id')
            ->where(['user.email' => $email])
            ->where(['auth_assignment.item_name' => $role])
            ->with('auth_assignment')
            ->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getMeta($key)
    {
        $userMeta = new UserMeta();
        return $userMeta->getMeta($this->id, $key);
    }

    public function addMeta($key, $value=null)
    {
        $userMeta = new UserMeta();
        return $userMeta->addMeta($this->id, $key, $value);
    }

    public function updateMeta($key, $value=null)
    {
        $result = false;
        $meta_field = UserMeta::find()->where(['user_id' => $this->id, 'meta_name' => $key])->one();

        if( !$meta_field ) {

            $meta = new UserMeta;
            $meta->user_id = $this->id;
            $meta->meta_name = $key;
            $meta->meta_value = is_array($value)? serialize($value) : $value;
            $result = $meta->save();

        } else {

            $meta_field->meta_value = is_array($value)? serialize($value) : $value;
            $result = $meta_field->update();

        }

        return $result;
    }

    public function deleteMeta($key)
    {
        $userMeta = new UserMeta();
        return $userMeta->getMeta($this->id, $key);
    }

    public function getUserBalance()
    {
        return $this->hasOne(UserBalance::className(), ['user_id' => 'id']);
    }

    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }
}
