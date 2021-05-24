<?php
namespace App\Controller;

use App\Model\Eloquent\Message;
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

        $message->save();
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