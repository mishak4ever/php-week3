<?php

namespace App\Controller;

use App\Model\User as UserModel;
use Base\AbstractController;
use Base\Session;
use Base\Mail;

class User extends AbstractController
{

    private $password;

    public function loginAction()
    {
        $email = isset($_POST['email']) ? trim($_POST['email']) : null;
        $isRegister = false;

        if ($email) {
            $password = $_POST['password'];
            $user = UserModel::getByEmail($email);
            if (!$user) {
                $this->view->assign('error', 'Неверный логин и пароль');
            }

            if ($user) {
                if ($user->getPassword() != UserModel::getPasswordHash($password)) {
                    $this->view->assign('error', 'Неверный логин и пароль');
                } else {
                    $Session = Session::getInstance();

                    $Session->setUserId($user->getId());
                    $this->redirect('/blog/index');
                }
            }
        }

        return $this->view->render('User/_register.twig', compact('isRegister'));
    }

    public function registerAction()
    {
        $name = $email = "";
        $isRegister = true;
        $success = true;
        if (isset($_POST['email'])) {

            $this->password = trim($_POST['password']);
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);

            if (mb_strlen($this->password) < 4) {
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
                        ->setPassword(UserModel::getPasswordHash($this->password));

                $user->save();

                $Session = Session::getInstance();
                $Session->setUserId($user->getId());

                $this->setUser($user);
                $this->createNotifyEmail();
                $this->redirect('/blog/index');
            }
        }

        return $this->view->render('User/_register.twig', compact('name', 'email', 'isRegister'));
    }

    public function changeAction()
    {
        $email = $_REQUEST['email'] ?? "";
        $user = UserModel::getById($_SESSION['user_id']);
        if ($user)
            $email = $user->getEmail();
        $success = true;
        if (isset($_POST['password'])) {

            $this->password = trim($_POST['password']);
            $email = trim($_POST['email']);
            $old_password = trim($_POST['old_password']);

            if (mb_strlen($this->password) < 4) {
                $this->view->assign('error', 'Пароль не может быть менее 4х символов');
                $success = false;
            }

            $user = UserModel::getByEmail($email);
            if ($user) {
                $this->setUser($user);
                if ($user->getPassword() != UserModel::getPasswordHash($old_password)) {
                    $this->view->assign('error', 'Неверный логин и пароль');
                } else {
                    $user->setPassword(UserModel::getPasswordHash($this->password));
                    if (($res = $user->update()) == true) {
                        $this->view->assign('success', 'Пароль изменен');
                        $this->changeNotifyEmail();
                    } else {
                        $this->view->assign('error', 'Невозможно сохранить в базе' . json_encode($res, 1));
                    }
                }
            }
        }

        return $this->view->render('User/_change.twig', compact('email'));
    }

    public function profileAction()
    {
        return $this->view->render('User/profile.phtml', [
                    'user' => UserModel::getById((int) $_GET['id'])
        ]);
    }

    public function changeavatarAction()
    {
        $user = UserModel::getById($_SESSION['user_id']);
        if ($user && !empty($_FILES['ava']['tmp_name'])) {
            $fileContent = file_get_contents($_FILES['ava']['tmp_name']);
            $image = md5(';blabla' . time());
            $path = PROJECT_ROOT_DIR . '/images/' . $image . '.png';
            file_put_contents($path, $fileContent);

            try {
                $user->setAva($image . '.png')->update();
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
        $this->redirect('/blog/index');
    }

    public function logoutAction()
    {
        $Session = Session::getInstance();
        $Session->destroy();

        $this->redirect('/user/login');
    }

    private function createNotifyEmail()
    {
        $mail = Mail::getInstance();
        $mail->sendMail($this->user->getEmail(),
                "Вы зарегистрированы на сайте " . SITE_NAME,
                "Вы успешно зарегистрировались на сайте" . PHP_EOL
                . "Ваш логин: {$this->user->getEmail()}" . PHP_EOL
                . "Ваш пароль: {$this->password}"
        );
    }

    private function changeNotifyEmail()
    {
        $mail = Mail::getInstance();
        $mail->sendMail($this->user->getEmail(),
                "Вы изменили пароль на сайте " . SITE_NAME,
                "Вы изменили пароль на сайте" . PHP_EOL
                . "Ваш логин: {$this->user->getEmail()}" . PHP_EOL
                . "Ваш пароль: {$this->password}"
        );
    }

}
