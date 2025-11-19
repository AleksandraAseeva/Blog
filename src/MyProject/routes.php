<?php
// Связывает URL-адреса с методами контроллеров
return [
    // Если URL: "/bye/John
    '~^bye/(.*)$~' => [\MyProject\Controllers\MainController::class, 'sayBye'],
    // Если URL: "/hello/John
    '~^hello/(.*)$~' => [\MyProject\Controllers\MainController::class, 'sayHello'],
    '~^articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [\MyProject\Controllers\ArticlesController::class, 'edit'], // 4.3
    '~^articles/add$~' => [\MyProject\Controllers\ArticlesController::class, 'add'], // 4.3
    '~^articles/(\d+)/delete$~' => [\MyProject\Controllers\ArticlesController::class, 'delete'],
    '~^users/register$~' => [\MyProject\Controllers\UsersController::class, 'signUp'], // маршрут для регистрации 5.2
    '~^users/login$~' => [\MyProject\Controllers\UsersController::class, 'login'], // 5.3
    '~^users/logout$~' => [\MyProject\Controllers\UsersController::class, 'logout'],
    '~^articles/(\d+)/comments$~' => [\MyProject\Controllers\CommentsController::class, 'add'],
    '~^comments/(\d+)/edit$~' => [\MyProject\Controllers\CommentsController::class, 'edit'],
    '~^comments/(\d+)/delete$~' => [\MyProject\Controllers\CommentsController::class, 'delete'], //
    // Если URL: "/"
    '~^$~' => [\MyProject\Controllers\MainController::class, 'main'],
];
