<?php

namespace MyProject\Models\Users;

class UsersAuthService
{
    public static function createToken(User $user): void
    {
        $token = $user->getId() . ':' . $user->getAuthToken();
        setcookie('token', $token, 0, '/lesson_2_my_project/', '', false, true);
    }

    public static function getUserByToken(): ?User
    {
        $token = $_COOKIE['token'] ?? '';

        if (empty($token)) {
            // echo "Токен пустой - возвращаем NULL</div>";
            return null;
        }

        [$userId, $authToken] = explode(':', $token, 2);

        $user = User::getById((int) $userId);

        if ($user === null) {
            // echo "<pre>Пользователь не найден по ID: " . $userId . "</pre>";
            return null;
        }

        // if ($user->getAuthToken() !== $authToken) {
        //     return null; // проблемное место
        // }

        if ($user->getAuthToken() !== $authToken) {
            return null;
        }

        // echo "Токены совпадают - возвращаем пользователя</div>";
        return $user;
    }
}
