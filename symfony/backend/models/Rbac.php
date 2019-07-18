<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\helpers\Role;

/**
 * Get Role List
 */

 class Rbac extends Model{

    static function addRole( $role ){
        $auth = Yii::$app->authManager;
        $author = $auth->createRole($role);
        $auth->add($role);
    }

    static function addAssigment( $role, $permission ){
        if (Role::hasPermission($role,$permission) === false){
            $auth = Yii::$app->authManager;
            $roleName=$auth->getRole($role);
            $permissionName=$auth->getPermission($permission);
            $auth->addChild($roleName, $permissionName);
        }
    }

    static function removeAssigment( $role, $permission ){
        if (Role::hasPermission($role,$permission) === true){
            $auth = Yii::$app->authManager;
            $roleName=$auth->getRole($role);
            $permissionName=$auth->getPermission($permission);
            $auth->removeChild($roleName, $permissionName);
        }
    }
}
