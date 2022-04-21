<?php

namespace App\Controller;

use App\Model\User as UserModel;
use App\Model\Message;
use Base\AbstractController;

class Blog extends AbstractController {

    function indexAction() {
        if (!$this->user) {
            $this->redirect('/user/register');
        }
        $limit = 20;
        $offset = 0;
        if (isset($_GET['limit']) && is_numeric($_GET['limit']))
            $limit = $_GET['limit'];
        if (isset($_GET['offset']) && is_numeric($_GET['offset']))
            $offset = $_GET['offset'];

        $messages = Message::getList($limit, $offset);

        return $this->view->render('Blog/index.phtml', [
                    'user' => $this->user,
                    'messages' => $messages
        ]);
    }

    function sendmessageAction() {
        if (!$this->user) {
            $this->redirect('/user/login');
        }
        $success = true;
        if (isset($_POST['text'])) {

            $text = htmlentities($_POST['text']);
            $text = htmlspecialchars($text);
            $image = "";
            if (!empty($_FILES['userfile']['tmp_name'])) {
                $fileContent = file_get_contents($_FILES['userfile']['tmp_name']);
                $image = md5(';blabla' . time());
                $path = PROJECT_ROOT_DIR . '/images/' . $image . '.png';
                file_put_contents($path, $fileContent);
            }

            try {
                $Message = new Message($this->user->getId(), $text, $image);
                $Message->save();
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }


        $this->redirect('/blog/index');
    }

    function deletemessageAction() {
        if (!$this->user) {
            $this->redirect('/user/login');
        }
//            echo '<pre>';
//            print_r($_GET);
//            echo '</pre>';
//            die;
        $success = true;
        if (isset($_GET['id']) && is_numeric($_GET['id']) && $this->user->isAdmin()) {
            try {
                Message::deleteById($_GET['id']);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }

        $this->redirect('/blog/index');
    }

    function getimageAction() {
        if (!$this->user) {
            $this->redirect('/user/login');
        }
//        header('Content-type: image/png');
        $fileId = $_GET['id'];
        if (file_exists(PROJECT_ROOT_DIR . '/images/' . $fileId . '.png')) {
            include PROJECT_ROOT_DIR . '/images/' . $fileId . '.png';
//        echo '<pre>';
//            print_r($_SERVER['DOCUMENT_ROOT'] . '/images/' . $fileId . '.png');
//            echo '</pre>';
//            die;
        } else
            include PROJECT_ROOT_DIR . '/images/no_image.png';
    }

}
