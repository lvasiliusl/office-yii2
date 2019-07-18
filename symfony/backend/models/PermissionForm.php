<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\helpers\Role;

/**
 * Get Role List
 */
class PermissionForm extends Model{

    public $name;
    public $description;
    public $roles;

    public function rules()
    {
        return [
            [[ 'name', 'description'], 'trim'],
            [[ 'name'],'required'],
        ];
    }

    static function newPermission($permissionName){
        $auth = Yii::$app->authManager;
        $permission = $auth->createPermission($permissionName);
        $permission->description = $permissionName;
        $auth->add($permission);
    }

    static function addAssigment($role, $permission){
        if (Role::hasPermission($role,$permission) === false){
            $auth = Yii::$app->authManager;
            $roleName=$auth->getRole($role);
            $permissionName=$auth->getPermission($permission);
            $auth->addChild($roleName, $permissionName);
        }
    }
}
