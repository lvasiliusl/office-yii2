<?php
namespace common\helpers;
use Yii;
/**
 *
 */
class Role
{
    public static function hasPermission($role_name, $role_permission)
    {
        $has_permission = false;

        foreach (Yii::$app->authManager->getPermissionsByRole($role_name) as $permission) {
            if( $role_permission ===  $permission->name) {
                $has_permission = true;
            }
        }

        return $has_permission;
    }

    public static function getAllowedRoles($to_array = false)
    {
        $role_list = [];

        if (!Yii::$app->user->isGuest) {
            $auth = Yii::$app->authManager;
            $role_list = $auth->getRoles();

            $role_list = array_filter($role_list, function($role) {
                $permission_name = 'manage' . ucfirst($role->name);
                return Yii::$app->user->can($permission_name);
            });
        }

        if( $to_array ) {
            $role_array = [];

            array_walk($role_list, function($role) use (&$role_array) {
                $role_array[ $role->name ] = ucfirst($role->name);
            });

            $role_list = $role_array;
        }

        return $role_list;
    }
}
