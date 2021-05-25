<?php
namespace App\Model\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    public $timestamps = false;
    protected $fillable = [
        'text',
        'date',
        'user_id',
        'image',
    ];
    /**
     * @var mixed
     */
    private $author;

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function deleteMessage(int $messageId)
    {
        return self::destroy($messageId);
    }

    public static function getAllMessages(int $limit = 10, int $offset = 0)
    {
        return self::with('author')
            ->limit($limit)
            ->offset($offset)
            ->orderBy('id', 'DESC')
            ->get();
    }

    public static function getMessages(int $userId, int $limit)
    {
        return self::query()->where('user_id', '=', $userId)->limit($limit)->get();
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

    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
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