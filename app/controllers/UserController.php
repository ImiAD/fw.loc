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
        if (!empty($_POST)) {
            $user = new User();
            if ($user->login()) {
                $_SESSION['success'] = 'Вы успешно авторизованы.';
            } else {
                $_SESSION['error'] = 'Логин или пароль введене не верно.';
            }
            redirect();
        }

        View::setMeta('Вход');
    }

    /**
     * метод для выхода авторизованного пользователя
     */
    public function logOutAction()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
            redirect('/user/login');
        }
    }
}