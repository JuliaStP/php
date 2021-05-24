<?php
namespace App\Controller;

use App\Model\Eloquent\Message;
use Base\AbstractController;

class Admin extends AbstractController
{
    /**
     * @throws \Base\RedirectException
     */
    public function accessAdmin()
    {
        parent::accessAdmin();
        if(!$this->getUser() || !$this->getUser()->isAdmin()) {
            $this->redirect('/');
        }
    }

    /**
     * @throws \Base\RedirectException
     */
    public function deleteMessage()
    {
        $messageId = (int) $_GET['id'];
        Message::deleteMessage($messageId);
        $this->redirect('/blog');
    }
}