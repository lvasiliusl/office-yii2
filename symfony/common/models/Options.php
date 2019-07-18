<?php
namespace common\models;

use yii\db\ActiveRecord;

/**
 * Options model
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 */
class Options extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%options}}';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'name',
                    'value'
                ],
                'trim'
            ]
        ];
    }
    
    public static function getOption( $name )
    {
        $option = self::find()->where(['name' => $name])->one();
        
        if( $option ) {
            $value = @unserialize($option->value);
            
            if( $value !== false ) {
                $option->value = $value;
            }
        }
        
        return $option;
    }
}