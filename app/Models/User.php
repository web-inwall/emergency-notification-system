<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    use HasFactory;

    protected $table = 'users'; // Указываем таблицу 'users' для модели Users

    protected $fillable = ['email', 'password']; // Указываем, какие поля можно заполнять

    public function getAuthIdentifierName()
    {
        return 'id'; // Имя столбца, используемого для идентификации пользователя
    }

    public function getAuthIdentifier()
    {
        return $this->getKey(); // Возвращает идентификатор пользователя
    }

    public function getAuthPassword()
    {
        return $this->password; // Возвращает пароль пользователя
    }

    public function getAuthPasswordName()
    {
        return 'password'; // Имя столбца, используемого для хранения пароля пользователя
    }

    public function getRememberToken()
    {
        return $this->remember_token; // Возвращает токен "remember" пользователя
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value; // Устанавливает токен "remember" пользователя
    }

    public function getRememberTokenName()
    {
        return 'remember_token'; // Имя столбца, используемого для токена "remember"
    }
}
