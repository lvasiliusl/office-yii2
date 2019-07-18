<?php

use yii\db\Migration;
/**
 * add 'manager' role.
 *
 * php yii migrate/to m170929_190758_add_manager_role
 *
 */


class m170929_190758_add_manager_role extends Migration
{

    public function up()
    {
        $auth = Yii::$app->authManager;
        // $admin = $auth->createRole('admin');
        // $auth->add($admin);
        // $auth->assign($admin, 1);

        $programmer = $auth->createRole('programmer');
        $auth->add($programmer);
        $auth->assign($programmer, 2);

        $manager = $auth->createRole('manager');
        $auth->add($manager);
        $auth->assign($manager, 3);
    }

    public function down()
    {
        $auth = Yii::$app->authManager;
        $manager= $auth->remove($manager);
        $manager= $auth->remove($programmer);
        $manager= $auth->remove($admin);
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170929_190758_add_manager_role cannot be reverted.\n";

        return false;
    }
    */
}
