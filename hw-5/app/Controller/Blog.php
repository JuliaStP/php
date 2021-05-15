<?php
namespace App\Controller;

use App\Model\Message;
use Base\AbstractController;

class Blog extends AbstractController
{
    /**
     * @throws \Base\RedirectException
     */
    public function index()
    {
        if (!$this->getUser()) {
            $this->redirect('/signin');
        }
        $messages = Message::getAllMessages();
        if ($messages) {
            $userIds = array_map(function (Message $message) {
                return $message->getAuthorId();
            }, $messages);
            $users = \App\Model\User::getByIds($userIds);
            array_walk($messages, function (Message $message) use ($users) {
                if (isset($users[$message->getAuthorId()])) {
                    $message->setAuthor($users[$message->getAuthorId()]);
                }
            });
        }
        return $this->view->render('blog.phtml'
            , [
            'messages' => $messages,
            'user' => $this->getUser()
        ]);
    }

    /**
     * @throws \Base\RedirectException
     */
    public function addMessage()
    {
        if (!$this->getUser()) {
            $this->redirect('/signin');
        }

        $text = (string) $_POST['text'];

        $message = new Message([
            'text' => $text,
            'user_id' => $this->getUserId(),
            'date' => date('Y-m-d H:i:s')
        ]);

        if (isset($_FILES['image']['tmp_name'])) {
            $message->addImage($_FILES['image']['tmp_name']);
        }

        $message->saveMessage();
        $this->redirect('/blog');

    }

    public function signout()
    {
        $_SESSION['user_id'] = null;
        header('Location: /');
        exit();
    }

    public function twig()
    {
        return $this->view->getTwig('footer.twig', ['var' => 'this is footer']);
    }
}