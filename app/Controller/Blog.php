<?php

namespace App\Controller;

use App\Model\User as UserModel;
use App\Model\Message;
use Base\AbstractController;
use Base\Session;
use Intervention\Image\ImageManagerStatic as Image;

class Blog extends AbstractController
{

    public function indexAction()
    {
        $Session = Session::getInstance();
        if ($Session->getUserId()) {
            $user = UserModel::getById($_SESSION['user_id']);
            $this->setUser($user);
        }
        if (!$this->user) {
            $this->redirect('/user/login');
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

    public function sendmessageAction()
    {
        if (!$this->user) {
            $this->redirect('/user/login');
        }
        $success = true;
        if (isset($_POST['text'])) {

            $text = htmlentities($_POST['text']);
            $text = htmlspecialchars($text);
            $image = "";
            if (!empty($_FILES['userfile']['tmp_name'])) {
                $blogImage = Image::make($_FILES['userfile']['tmp_name']);
                $image = md5(';blabla' . time());
                $publicPath = PROJECT_ROOT_DIR . '/images/';
                $blogImage->resize(200, 200);
                self::addWatermark($blogImage, "watermark");
                $blogImage->save($publicPath . $image);
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

    public function deletemessageAction()
    {
        if (!$this->user) {
            $this->redirect('/user/login');
        }
        $success = true;
        if (isset($_GET['id']) && is_numeric($_GET['id']) && $this->user->isAdmin()) {
            try {
                $message = Message::getById($_GET['id']);
                if (file_exists(PROJECT_ROOT_DIR . '/images/' . $message->getImage())) {
                    unlink(PROJECT_ROOT_DIR . '/images/' . $message->getImage());
                }
                Message::deleteById($_GET['id']);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }

        $this->redirect('/blog/index');
    }

    public function getimageAction()
    {
        if (!$this->user) {
            $this->redirect('/user/login');
        }
        $fileId = $_GET['id'];
        if (file_exists(PROJECT_ROOT_DIR . '/images/' . $fileId)) {
            $img = Image::make(PROJECT_ROOT_DIR . '/images/' . $fileId);
            return $img->response();
        } else
            include PROJECT_ROOT_DIR . '/images/no_image.png';
    }

    public static function addWatermark(\Intervention\Image\Image $image, string $text = "")
    {
        $image->text(
                $text,
                5,
                15,
                function ($font) {
                    $font->file(PROJECT_ROOT_DIR . '/html/fonts/' . 'arial.ttf')->size('24');
                    $font->color('#FFFFFF');
                    $font->align('left');
                    $font->valign('top');
                });
    }

}
