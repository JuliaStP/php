<?php
namespace App\Controller;

use App\Model\User;
use Base\AbstractController;

class Signin extends AbstractController
{
    public function index()
    {
        if ($this->getUser()) {
            $this->redirect('/blog');
        }
        return $this->view->render(
            'signin.phtml',
            [
                'title' => 'Welcome!',
                'user' => $this->getUser(),
            ]
        );
    }

    /**
     * @throws \Base\RedirectException
     */
    public function auth()
    {
        $email = (string) $_POST['email'];
        $password = (string) $_POST['password'];

        $user = User::getByEmail($email);
        if (!$user) {
            return 'Wrong email or password';
        }

        if ($user->getPassword() !== User::setHash($password)) {
            return 'Wrong email or password';
        }

        $this->session->authUser($user->getId());

        $this->redirect('/blog');
    }

    /**
     * @throws \Base\RedirectException
     */
    public function signup()
    {
        $username = (string) $_POST['username'];
        $email = (string) $_POST['email'];
        $password = (string) $_POST['password'];
        $password2 = (string) $_POST['password_2'];

        if (!$username || !$password) {
            return 'Please fill out username and password fields';
        }

        if (!$email) {
            return 'Please fill out email field';
        }

        if ($password !== $password2) {
            return 'Passwords do not match';
        }

        if (mb_strlen($password) < 5) {
            return 'Password is too short';
        }

        $userData = [
            'username' => $username,
            'date' => date('Y-m-d H:i:s'),
            'password' => $password,
            'email' => $email,
        ];
        $username = new User($userData);
        $username->saveUser();

        $this->session->authUser($username->getId());
        $this->redirect('/blog');
    }
}