<?php
namespace App\Controller\Admin;

use App\Controller\Admin;
use App\Model\Eloquent\User;

class Users extends Admin
{
    public function index()
    {
        return $this->view->render(
            '/users.phtml',
            [
                'users' => User::getAllMessages()
            ]
        );
    }

    public function saveUser()
    {
        $id = (int) $_POST['id'];
        $username = (string) $_POST['username'];
        $email = (string) $_POST['email'];
        $password = (string) $_POST['password'];

        $user = User::getById($id);
        if (!$user) {
            return $this->response(['error' => 'No user was found']);
        }

        if (!$username) {
            return $this->response(['error' => 'Please fill out username']);
        }

        if (!$email) {
            return $this->response(['error' => 'Please fill out email']);
        }

        if ($password && mb_strlen($password) < 5) {
            return $this->response(['error' => 'Password is too short']);
        }

        $user->username = $username;
        $user->email = $email;

        $emailUser = User::getByEmail($email);
        if ($emailUser && $emailUser->id != $id) {
            return $this->response(['error' => 'This email already used by ' . $emailUser->id]);
        }

        if ($password) {
            $user->password = User::setHash($password);
        }
        $user->save();

        return $this->response(['result' => 'Info was successfully modified']);

    }

    public function deleteUser()
    {
        $id = (int) $_POST['id'];

        $user = User::getById($id);
        if (!$user) {
            return $this->response(['error' => 'No user with this username was found']);
        }

        $user->delete();

        return $this->response(['result' => 'User was successfully deleted']);
    }

    public function addUser()
    {
        $username = (string) $_POST['username'];
        $email = (string) $_POST['email'];
        $password = (string) $_POST['password'];

        if (!$username) {
            return $this->response(['error' => 'Please fill out username']);
        }

        if (!$password) {
            return $this->response(['error' => 'Please fill out password']);
        }

        if (!$email) {
            return $this->response(['error' => 'Please fill out email']);
        }

        if (!$password || mb_strlen($password) < 5) {
            return $this->response(['error' => 'Password is too short']);
        }

        $emailUser = User::getByEmail($email);
        if ($emailUser) {
            return $this->response(['error' => 'This email already used by ' . $emailUser->id]);
        }

        $userData = [
            'username' => $username,
            'password' => User::setHash($password),
            'date' => date('Y-m-d H:i:s'),
            'email' => $email,
        ];
        $user = new User($userData);
        $user->save();

        return $this->response(['result' => 'New user has been successfully added']);

    }

    public function response(array $data)
    {
        header('Content-type: application/json');
        return json_encode($data);
    }
}