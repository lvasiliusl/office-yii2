<?php
namespace common\models;


use yii\db\ActiveRecord;


/**
 *
 */
class Holidays extends ActiveRecord
{
    public function rules()
    {
        return [
            [['day', 'description'], 'required'],
            ['day', 'number'],
            ['month', 'in', 'range' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']],
            ['description', 'string'],

        ];
    }

}
