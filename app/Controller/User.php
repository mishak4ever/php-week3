<?php

namespace App\Controller;

use App\Model\User as UserModel;
use Base\AbstractController;
use Base\Session;

class User extends AbstractController
{

    public function loginAction()
    {
        $email = isset($_POST['email']) ? trim($_POST['email']) : null;

        if ($email) {
            $password = $_POST['password'];
            $user = UserModel::getByEmail($email);
            if (!$user) {
                $this->view->assign('error', 'Логин.Неверный логин и пароль');
            }

            if ($user) {
                if ($user->getPassword() != UserModel::getPasswordHash($password)) {
                    $this->view->assign('error', 'Пасс. Неверный логин и пароль');
                } else {
                    $Session = Session::getInstance();

                    $Session->setUserId($user->getId());
                    $this->redirect('/blog/index');
                }
            }
        }

        return $this->view->render('User/register.phtml', [
//                    'user' => UserModel::getById((int) $_GET['id'])
        ]);
    }

    public function registerAction()
    {
        $name = $email = "";
        $success = true;
        if (isset($_POST['email'])) {

            $password = trim($_POST['password']);
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            /*
              if (!$email) {
              $this->view->assign('error', 'Email не может быть пустым');
              $success = false;
              }
             * 
             */

            if (mb_strlen($password) < 4) {
                $this->view->assign('error', 'Пароль не может быть менее 4х символов');
                $success = false;
            }

            $user = UserModel::getByEmail($email);
            if ($user) {
                $this->view->assign('error', 'Пользователь с таким Email уже существует');
                $success = false;
            }

            if ($success) {
                $user = (new UserModel())
                        ->setEmail($email)
                        ->setName($name)
                        ->setPassword(UserModel::getPasswordHash($password));

                $user->save();

                $Session = Session::getInstance();
                $Session->setUserId($user->getId());

                $this->setUser($user);

                $this->redirect('/blog/index');
            }
        }

        return $this->view->render('User/register.phtml', compact('name', 'email'));
    }

    public function profileAction()
    {
        return $this->view->render('User/profile.phtml', [
                    'user' => UserModel::getById((int) $_GET['id'])
        ]);
    }

    public function logoutAction()
    {
        $Session = Session::getInstance();
        $Session->destroy();

        $this->redirect('/user/login');
    }

}
