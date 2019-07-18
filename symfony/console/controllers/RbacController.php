<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
/**
 * Initialize RBAC. Runs in terminal: php yii rbac/init
 */
class RbacController extends Controller {

    public function actionInit() {
        $auth = Yii::$app->authManager;

        $auth->removeAll(); //Clear DB...

        // Create admin and user roles
        $admin = $auth->createRole('admin');
        // $user = $auth->createRole('user');

        // Write to DB...
        $auth->add($admin);
        // $auth->add($user);

        // Create restrictions.
        $viewAdminPage = $auth->createPermission('viewAdminPage');
        $viewAdminPage->description = 'View Admin';

        // Write to DB...
        $auth->add($viewAdminPage);

        // Admin role can viewAdminPage
        $auth->addChild($admin, $viewAdminPage);

        $auth->assign($admin, 1);
    }
}
