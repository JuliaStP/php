<?php
namespace App\Model\Eloquent;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'date',
        'email',
    ];

    public static function getByEmail(string $email)
    {
        return self::query()->where('email', '=', $email)->first();
    }

    public static function getById(int $id)
    {
        return self::query()->find($id);
    }

    public static function getAllMessages(int $limit = 10, int $offset = 0)
    {
        return self::query()->limit($limit)->offset($offset)->orderBy('id', 'DESC')->get();
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
