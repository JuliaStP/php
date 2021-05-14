<?php
namespace App\Model;

use Base\Database;

class User
{
    private $id;
    private $username;
    private $date;
    private $password;
    private $email;

    public function __construct(array $data)
    {
        $this->username = $data['username'];
        $this->password = $data['password'];;
        $this->date = $data['date'];
        $this->email = $data['email'];
    }

    public static function getByIds(array $userIds)
    {
        $db = Database::getInstance();
        $idsString = implode(',', $userIds);
        $data = $db->fetchAll(
            "SELECT * fROM users WHERE id IN($idsString)",
            __METHOD__
        );
        if (!$data) {
            return [];
        }

        $users = [];
        foreach ($data as $elem) {
            $user = new self($elem);
            $user->id = $elem['id'];
            $users[$user->id] = $user;
        }

        return $users;
    }

    public static function getByEmail(string $email)
    {
        $db = Database::getInstance();
        $data = $db->fetchOne(
            "SELECT * fROM users WHERE email = :email",
            __METHOD__,
            [':email' => $email]
        );
        if (!$data) {
            return null;
        }

        $user = new self($data);
        $user->id = $data['id'];
        return $user;
    }

    public function saveUser()
    {
        $db = Database::getInstance();
        $res = $db->exec(
            'INSERT INTO users (
                    username, 
                    password, 
                    date,
                    email
                    ) VALUES (
                    :username, 
                    :password, 
                    :date,
                    :email
                )',
            __FILE__,
            [
                ':username' => $this->username,
                ':password' => self::setHash($this->password),
                ':date' => $this->date,
                ':email' => $this->email,
            ]
        );

        $this->id = $db->lastInsertId();

        return $res;
    }

    public static function getById(int $id)
    {
        $db = Database::getInstance();
        $data = $db->fetchOne("SELECT * fROM users WHERE id = :id", __METHOD__, [':id' => $id]);
        if (!$data) {
            return null;
        }

        $user = new self($data);
        $user->id = $id;
        return $user;
    }


    public static function getAllMessages(int $limit = 10, int $offset = 0): array
    {
        $db = Database::getInstance();
        $data = $db->fetchAll(
            "SELECT * fROM users LIMIT $limit OFFSET $offset",
            __METHOD__
        );
        if (!$data) {
            return [];
        }

        $users = [];
        foreach ($data as $elem) {
            $user = new self($elem);
            $user->id = $elem['id'];
            $users[] = $user;
        }

        return $users;
    }

    public static function setHash(string $password)
    {
        return sha1('mklkefg7nmmkldrg..,djfi' . $password);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function isAdmin(): bool
    {
        return in_array($this->id, ADMIN);
    }
}