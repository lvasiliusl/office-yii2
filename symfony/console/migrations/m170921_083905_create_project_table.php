<?php

use yii\db\Migration;

/**
 * Handles the creation of table `project`.
 * Has foreign keys to the tables:
 *
 * - `client`
 *
 * php yii migrate/to m170921_083905_create_project_table
 */
class m170921_083905_create_project_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('project', [
            'id'            => $this->primaryKey(),
            'client_id'     => $this->integer(),
            'user_id'       => $this->integer()->notnull(),
            'name'          => $this->string(64),
            'description'   => $this->text(),
            'price'         => $this->integer(11),
        ],$tableOptions );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-project-user_id',
            'project',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-project-user_id',
            'project',
            'user_id',
            'user',
            'id'
        );

        // creates index for column `client_id`
        $this->createIndex(
            'idx-project-client_id',
            'project',
            'client_id'
        );

        // add foreign key for table `client`
        $this->addForeignKey(
            'fk-project-client_id',
            'project',
            'client_id',
            'client',
            'id'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-project-user_id',
            'project'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-project-user_id',
            'project'
        );

        // drops foreign key for table `client`
        $this->dropForeignKey(
            'fk-project-client_id',
            'project'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            'idx-project-client_id',
            'project'
        );

        $this->dropTable('project');
    }
}
