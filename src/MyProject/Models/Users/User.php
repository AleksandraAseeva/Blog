<?php

namespace MyProject\Models\Users;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Exceptions\InvalidArgumentException;

/**
 * @property int $id
 * @property string $nickname
 * @property string $email
 * @property bool $isConfirmed
 * @property string $role
 * @property string $passwordHash
 * @property string $authToken
 * @property string $createdAt
 * 
 * @method string getPasswordHash()
 * @method bool getIsConfirmed()
 * @method void refreshAuthToken()
 * @method string getAuthToken()
 * @method string getNickname()
 * @method string getEmail()
 */

class User extends ActiveRecordEntity
{

    protected $nickname;
    protected $email;
    protected $isConfirmed;
    protected $role;
    protected $passwordHash;
    protected $authToken;
    protected $createdAt;

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getIsConfirmed(): bool
    {
        return $this->isConfirmed;
    }

    // метод регистрации
    public static function signUp(array $userData): User
    {
        // Проверки на пустые поля
        if (empty($userData['nickname'])) {
            throw new InvalidArgumentException('Не передан nickname');
        }

        // Проверка формата nickname
        if (!preg_match('/^[a-zA-Z0-9]+$/', $userData['nickname'])) {
            throw new InvalidArgumentException('Nickname может состоять только из символов латинского алфавита и цифр');
        }

        // Проверка email
        if (empty($userData['email']) || !filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email некорректен');
        }

        // Проверка пароля
        if (empty($userData['password']) || mb_strlen($userData['password']) < 8) {
            throw new InvalidArgumentException('Пароль должен быть не менее 8 символов');
        }

        // Проверка уникальности
        if (static::findOneByColumn('nickname', $userData['nickname']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким nickname уже существует');
        }

        if (static::findOneByColumn('email', $userData['email']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким email уже существует');
        }

        // Создание пользователя
        $user = new User();
        $user->nickname = $userData['nickname'];
        $user->email = $userData['email'];
        $user->passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->isConfirmed = false;
        $user->role = 'user';
        $user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->save();

        return $user;
    }

    public function refreshAuthToken()
    {
        $this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }

    public static function login(array $loginData): User
    {
        if (empty($loginData['email']) || empty($loginData['password'])) {
            throw new InvalidArgumentException('Не передан email или пароль');
        }

        $user = User::findOneByColumn('email', $loginData['email']);
        if ($user === null) {
            throw new InvalidArgumentException('Нет пользователя с таким email');
        }

        if (!password_verify($loginData['password'], $user->getPasswordHash())) {
            throw new InvalidArgumentException('Неправильный пароль');
        }

        // if (!$user->getIsConfirmed()) {
        //     throw new InvalidArgumentException('Пользователь не подтверждён');
        // }

        $user->refreshAuthToken();
        $user->save();

        return $user;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getAuthToken(): string
    {
        return $this->authToken;
    }
}
