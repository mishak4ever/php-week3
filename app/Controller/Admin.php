<?php

namespace App\Controller;

use App\Model\Message;
use Base\Session;
use App\Model\UserORM;
use Base\AbstractController;

class Admin extends AbstractController
{

    private $userOrm;

    public function __construct()
    {
        $Session = Session::getInstance();
        if ($Session->getUserId()) {
            $user = UserORM::find($Session->getUserId());
            $this->userOrm = $user;
        }
        if (!$this->userOrm) {
            $this->redirect('/user/login');
        }
    }

    public function indexAction()
    {
        $users = UserORM::all();
        $admin = UserORM::find($_SESSION[Session::USER_ID]);
        return $this->view->render('Admin/index.phtml', compact('users', 'admin'));
    }

    public function editAction($user_id = null)
    {
        if (isset($_POST['id'])) {
            $user = UserORM::find($_POST['id']);
            if ($user) {
                $user->update([
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'is_admin' => isset($_POST['is_admin']) ? true : false,
                ]);
            }
            $this->redirect('/admin/index');
        } else if ($user_id) {
            $user = UserORM::find($user_id);
            return $this->view->render('Admin/edit.phtml', compact('user'));
        }
    }

    public function addAction()
    {
        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
            $user = UserORM::where('email', '=', trim($_POST['email']))->first();

            if (!$user) {
                $newuser = UserORM::create([
                            'email' => trim($_POST['email']),
                            'name' => trim($_POST['name']),
                            'password' => UserORM::getPasswordHash(trim($_POST['password'])),
                            'is_admin' => isset($_POST['is_admin']) ? true : false,
                ]);
                $this->redirect('/admin/index');
            } else {
                $this->view->assign('error', 'Пользователь с таким Email уже существует');
            }
        }
        $add_new = true;
        return $this->view->render('Admin/edit.phtml', compact('add_new'));
    }

    public function deleteAction($user_id = null)
    {
        if ($user_id) {
            $user = UserORM::find($user_id);
            if ($user) {
                $user->delete();
            }
        }
        $users = UserORM::all();
        return $this->view->render('Admin/index.phtml', compact('users'));
    }

    public function signinAction($user_id = null)
    {
        $Session = Session::getInstance();

        $Session->setUserId($user_id);
        $this->redirect('/blog/index');
    }

}
