<?php

use yii\db\Migration;

class m171103_143647_create_user_meta extends Migration
{
    // public function safeUp()
    // {
    //
    // }
    //
    // public function safeDown()
    // {
    //     echo "m171103_143647_create_user_meta cannot be reverted.\n";
    //
    //     return false;
    // }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('user_meta', [
            'id'            => $this->primaryKey(),
            'user_id'       => $this->integer()->notnull(),
            'meta_name'     => $this->string(150),
            'meta_value'    => $this->text(),
        ]);
    }

    public function down()
    {
        $this->dropTable('user_meta');
    }

}
