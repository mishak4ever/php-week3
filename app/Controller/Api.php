<?php

namespace App\Controller;

use App\Model\Message;
use Base\AbstractController;

class Api extends AbstractController {

    function getMessageAction() {
        $limit = 20;
        if (isset($_GET['limit']) && is_numeric($_GET['limit']))
            $limit = $_GET['limit'];
        if (isset($_GET['user_id']) && is_numeric($_GET['user_id']))
            $user_id = $_GET['user_id'];
        $messages = Message::getListByUser($user_id, $limit, $offset = 0);

        return json_encode($messages, 1);
    }

}
