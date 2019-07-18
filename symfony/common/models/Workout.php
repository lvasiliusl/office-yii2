<?php
namespace common\models;

use common\models\Currency;
use common\models\Project;
use common\models\User;
use yii\behaviors\TimestampBehavior;

use yii\db\ActiveRecord;


/**
 *
 */
class Workout extends ActiveRecord
{
    // public $description;

    public function rules()
    {
        return [
            [['user_id', 'rate_type', 'currency_id'], 'required'],
            ['rate_type', 'in', 'range' => ['fixed', 'hourly']],
            ['project_id', 'exist', 'targetClass' => 'common\models\Project', 'targetAttribute' => 'id'],
            ['user_id', 'exist', 'targetClass' => 'common\models\User', 'targetAttribute' => 'id'],
            ['currency_id', 'exist', 'targetClass' => 'common\models\Currency', 'targetAttribute' => 'id'],
            ['rate', 'number'],
            ['hours', 'time', 'format' => 'H:m:s'],
            ['fixed', 'number'],
            ['description', 'string'],
            ['workout_date', 'number'],
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

    /**
     *
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     *
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     *
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
