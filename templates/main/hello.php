<?php include __DIR__ . '/../header.php'; ?>

<?php if (!empty($user)): ?>
    <div style="text-align: center; padding: 50px;">
        <h1>Привет, <?= $user->getNickname() ?>! </h1>
    </div>
<?php else: ?>
    <div style="text-align: center; padding: 50px;">
        <h1>Привет, <?= $name ?>!</h1>
        <p>Приветствуем нового посетителя!</p>
        <p><a href="/lesson_2_my_project/www/index.php?route=users/register">Зарегистрируйтесь</a> 
        или <a href="/lesson_2_my_project/www/index.php?route=users/login">войдите</a>, чтобы получить полный доступ.</p>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>