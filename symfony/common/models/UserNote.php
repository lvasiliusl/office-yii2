<?php
namespace common\models;

use common\models\User;
use yii\db\ActiveRecord;

/**
 * UserMeta model
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $date
 * @property string $leg_extension
 * @property string $leg_curls
 * @property string $incline_bench_press
 * @property string $lat_pulldown
 * @property string $seated_shoulder_press
 * @property string $triceps_pushdown
 * @property string $biceps_curl
 * @property string $leg_extension_rep
 * @property string $leg_curls_rep
 * @property string $incline_bench_press_rep
 * @property string $lat_pulldown_rep
 * @property string $seated_shoulder_press_rep
 * @property string $triceps_pushdown_rep
 * @property string $biceps_curl_rep
 */
class UserNote extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_note}}';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'date',
                    'note',
                ],
                'trim'
            ],
            [['date'], 'required' ],
            [['user_id'], 'filter', 'filter' => function($value) {
                return (int) $value;
            }]
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    /**
     * @inheritDoc
     */
    public function beforeSave($insert) {
        $this->date = (int) date('U', strtotime($this->date));
        return parent::beforeSave($insert);
    }
}