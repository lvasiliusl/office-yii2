<?php

use yii\db\Migration;

/**
 * Handles the creation of table `client`.
 *
 * php yii migrate/to m170920_162534_create_client_table
 */
class m170920_162534_create_client_table extends Migration
{


    /**
     * @inheritdoc
     */
    public function up()
    {

        $tableOptions=null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('client', [
            'id'        => $this->primaryKey(),
            'name'      => $this->string(64)->notNull(),
            'email'     => $this->string(64)->notNull(),
            'origin'    => $this->string(64),
        ],$tableOptions );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('client');
    }
}
