<?php
namespace App\Controller;

use App\Model\Message;
use Base\AbstractController;

class Api extends AbstractController
{
    public function getMessages()
    {
        $userId = (int) $_GET['user_id'] ?? 0;
        if (!$userId) {
            return $this->response(['error' => 'no_user_id']);
        }
        $allMessages = Message::getMessages($userId, 10);
        if (!$allMessages ) {
            return $this->response(['error' => 'no_messages']);
        }

        $data = array_map(function (Message $messages) {
            return $messages->getData();
        }, $allMessages );

        return $this->response(['allMessages' => $data]);
    }

    public function response(array $data)
    {
        header('Content-type: application/json');
        return json_encode($data);
    }
}