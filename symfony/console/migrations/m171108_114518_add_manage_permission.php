<?php

use yii\db\Migration;

/**
 * Class m171108_114518_add_manage_permission
 */
class m171108_114518_add_manage_permission extends Migration
{
    /**
     * @inheritdoc
     */
    public function Up()
    {
        $auth = Yii::$app->authManager;

        // Add permission

        //manageAdmin
        $permission = $auth->createPermission('manageAdmin');
        $permission->description = 'manageAdmin';
        $auth->add($permission);

        //addHolidays
        $permission = $auth->createPermission('addHolidays');
        $permission->description = 'addHolidays';
        $auth->add($permission);

        //manageProgrammer
        $permission = $auth->createPermission('manageProgrammer');
        $permission->description = 'manageProgrammer';
        $auth->add($permission);

        //manageManager
        $permission = $auth->createPermission('manageManager');
        $permission->description = 'manageManager';
        $auth->add($permission);

        //changeSalary
        $permission = $auth->createPermission('changeSalary');
        $permission->description = 'changeSalary';
        $auth->add($permission);

        $permission = $auth->createPermission('manageHolidays');
        $permission->description = 'manageHolidays';
        $auth->add($permission);

        //Add Role

        //admin namageAdmin
        $roleName=$auth->getRole('admin');
        $permissionName=$auth->getPermission('manageAdmin');
        $auth->addChild($roleName, $permissionName);

        //admin addHolidays
        $roleName=$auth->getRole('admin');
        $permissionName=$auth->getPermission('addHolidays');
        $auth->addChild($roleName, $permissionName);

        //manager manageProgrammer
        $roleName=$auth->getRole('manager');
        $permissionName=$auth->getPermission('manageProgrammer');
        $auth->addChild($roleName, $permissionName);

        //manager changeSalary
        $roleName=$auth->getRole('manager');
        $permissionName=$auth->getPermission('changeSalary');
        $auth->addChild($roleName, $permissionName);

        //admin manageProgrammer
        $roleName=$auth->getRole('admin');
        $permissionName=$auth->getPermission('manageProgrammer');
        $auth->addChild($roleName, $permissionName);

        //admin manageManager
        $roleName=$auth->getRole('admin');
        $permissionName=$auth->getPermission('manageManager');
        $auth->addChild($roleName, $permissionName);

        //admin changeSalary
        $roleName=$auth->getRole('admin');
        $permissionName=$auth->getPermission('changeSalary');
        $auth->addChild($roleName, $permissionName);

        $roleName=$auth->getRole('admin');
        $permissionName=$auth->getPermission('manageHolidays');
        $auth->addChild($roleName, $permissionName);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171108_114518_add_manage_permission cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171108_114518_add_manage_permission cannot be reverted.\n";

        return false;
    }
    */
}
