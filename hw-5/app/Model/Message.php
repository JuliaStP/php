<?php
namespace App\Model;

use Base\Database;

class Message
{
    private $id;
    private $text;
    private $date;
    private $userId;
    private $author;
    private $image;

    public function __construct(array $data)
    {
        $this->text = $data['text'];
        $this->date = $data['date'];
        $this->userId = $data['user_id'];
        $this->image = $data['image'] ?? '';
    }

    public static function deleteMessage(int $messageId)
    {
        $pdo = Database::getInstance();
        $query = "DELETE FROM messages WHERE id = $messageId";
        return $pdo->exec($query, __METHOD__);
    }

    public function saveMessage()
    {
        $pdo = Database::getInstance();
        $res = $pdo->exec(
            'INSERT INTO messages (
                    text, 
                    date,
                    user_id,
                    image
                    ) VALUES (
                    :text, 
                    :date,
                    :user_id,
                    :image
                )',
            __FILE__,
            [
                ':text' => $this->text,
                ':date' => $this->date,
                ':user_id' => $this->userId,
                ':image' => $this->image,
            ]
        );

        return $res;
    }

    public static function getAllMessages(int $limit = 10, int $offset = 0): array
    {
        $pdo = Database::getInstance();
        $data = $pdo->fetchAll(
            "SELECT * fROM messages LIMIT $limit OFFSET $offset",
            __METHOD__
        );
        if (!$data) {
            return [];
        }

        $messages = [];
        foreach ($data as $elem) {
            $message = new self($elem);
            $message->id = $elem['id'];
            $messages[] = $message;
        }

        return $messages;
    }

    public static function getMessages(int $userId, int $limit): array
    {
        $pdo = Database::getInstance();
        $data = $pdo->fetchAll(
            "SELECT * fROM messages WHERE user_id = $userId LIMIT $limit",
            __METHOD__
        );
        if (!$data) {
            return [];
        }

        $messages = [];
        foreach ($data as $elem) {
            $message = new self($elem);
            $message->id = $elem['id'];
            $messages[] = $message;
        }

        return $messages;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getAuthorId()
    {
        return $this->userId;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    public function addImage(string $file)
    {
        if (file_exists($file)) {
            $this->image = $this->setImageName();
            move_uploaded_file($file,getcwd() . '/images/' . $this->image);
        }
    }

    private function setImageName()
    {
        return sha1(microtime(1) . mt_rand(1, 100000000)) . '.jpg';
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getData()
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'text' => $this->text,
            'date' => $this->date,
            'image' => $this->image
        ];
    }
}