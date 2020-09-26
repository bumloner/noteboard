<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;

/**
 * Команда для создания админа
 *
 * Использование: yii create-admin <username> <password>
 */
class CreateAdminController extends Controller
{
    public function actionIndex($username, $password)
    {
        $model = User::findByUsername($username);
        if (empty($model)) {
            $user = new User();
            $user->username = $username;
            $user->email = 'admin@notes-yii.loc';
            $user->setPassword($password);
            $user->generateAuthKey();
            $user->role = User::ROLE_ADMIN;
            if ($user->save()) {
                echo 'Admin created. Username: ' . $username . '. Password: ******';
                return ExitCode::OK;
            } else {
                echo 'Error: cannot create admin ' . $username;
                return ExitCode::UNSPECIFIED_ERROR;
            }
        } else {
            echo 'Username "' . $username . '"" already exists';
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }
}
