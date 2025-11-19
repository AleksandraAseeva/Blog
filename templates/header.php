<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>
        <?= $title ?? 'Мой блог' ?>
    </title>
    <link rel="stylesheet" href="/lesson_2_my_project/styles/style.css">
</head>

<body>

    <!-- <div style="background: yellow; padding: 5px; margin: 5px;">
        Отладка: user = <?php var_dump($user ?? null); ?>
    </div> -->

    <table class="layout">
        <tr>
            <td colspan="2" class="header">
                Мой блог
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right">
                <?php if (!empty($user)): ?>
                    Привет, <?= $user->getNickname() ?>
                    <?php if ($user->isAdmin()): ?>
                        <small style="color: #dc3545;">(админ)</small>
                    <?php endif; ?>
                    <!-- | <a href="/lesson_2_my_project/users/logout">Выйти</a> -->
                    <a href="/lesson_2_my_project/www/index.php?route=users/logout">Выйти</a>
                <?php else: ?>
                    <!-- <a href="/lesson_2_my_project/users/login">Вход</a>
                | <a href="/lesson_2_my_project/users/register">Регистрация</a> -->
                    <a href="/lesson_2_my_project/www/index.php?route=users/login">Вход</a>
                    | <a href="/lesson_2_my_project/www/index.php?route=users/register">Регистрация</a>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>