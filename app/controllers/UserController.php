<?php


namespace app\controllers;

use app\models\User;
use fw\core\base\View;

class UserController extends AppController
{
    public function signupAction()
    {
        if (!empty($_POST)) {
            $user = new User();
            $data = $_POST;
            $user->load($data);

            if (!$user->validate($data) || !$user->chekUnique()) {
                $user->getErrors();
                $_SESSION['form_data'] = $data;
                redirect();
            }

            $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);

            if ($user->save('user')) {
                $_SESSION['success'] = 'Вы успешно зарегистрованы.';
            } else {
                $_SESSION['error'] = 'Ошибка попробуйте позже.';
            }

            redirect();
        }
        View::setMeta('Регистрация');
    }

    /**
     * метод для авторизации пользователя
     */
    public function loginAction()
    {

    }

    /**
     * метод для выхода авторизованного пользователя
     */
    public function logOutAction()
    {

    }
}