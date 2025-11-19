<?php include __DIR__ . '/../header.php'; ?>

<h1><?= $article->getName() ?></h1>
<p><?= $article->getText() ?></p>
<p><small>Создано: <?= $article->getCreatedAt() ?></small></p>
<p><strong>Автор:</strong> <?= $article->getAuthor()->getNickname() ?></p>

<!-- редактирование -->
<div style="margin-top: 20px;">
    <a href="/lesson_2_my_project/articles/<?= $article->getId() ?>/edit" class="btn btn-primary">
        Редактировать статью
    </a>
</div>

<!-- удаление (для автора или админа) -->
<?php if ($user !== null && ($user->getId() === $article->getAuthorId() || $user->isAdmin())): ?>
    <form action="/lesson_2_my_project/www/index.php?route=articles/<?= $article->getId() ?>/delete"
        method="post"
        style="display: inline-block; margin-left: 10px;"
        onsubmit="return confirm('Вы уверены, что хотите удалить эту статью?')">
        <input type="submit" value="Удалить статью" style="background-color: #dc3545; color: white; border: none; padding: 8px 15px; cursor: pointer;">
        <?php if ($user->isAdmin() && $user->getId() !== $article->getAuthorId()): ?>
            <small style="color: #dc3545;">(админ)</small>
        <?php endif; ?>
    </form>
<?php endif; ?>
</div>


<!-- добавление комментария -->
<?php if ($user !== null): ?>
    <div style="margin-top: 30px; border-top: 1px solid #ccc; padding-top: 20px;">
        <h3>Добавить комментарий</h3>
        <?php if (!empty($error)): ?>
            <div style="background-color: red; padding: 5px; margin: 15px; color: white;"><?= $error ?></div>
        <?php endif; ?>
        <form action="/lesson_2_my_project/www/index.php?route=articles/<?= $article->getId() ?>/comments" method="post">
            <textarea name="text" rows="4" style="width: 100%;" placeholder="Введите ваш комментарий..."><?= $_POST['text'] ?? '' ?></textarea>
            <br>
            <input type="submit" value="Добавить комментарий">
        </form>
    </div>
<?php else: ?>
    <p><a href="/lesson_2_my_project/www/index.php?route=users/login">Войдите</a>, чтобы оставить комментарий</p>
<?php endif; ?>

<!-- список комментариев -->
<div style="margin-top: 30px;">
    <h3>Комментарии (<?= count($comments) ?>)</h3>
    <?php foreach ($comments as $comment): ?>
        <div id="comment<?= $comment->getId() ?>" style="border: 1px solid #ccc; padding: 15px; margin: 10px 0; border-radius: 5px;">
            <p><strong><?= $comment->getAuthor()->getNickname() ?></strong>
                <small><?= $comment->getCreatedAt() ?></small>
            </p>
            <p><?= htmlspecialchars($comment->getText()) ?></p>

            <!-- ссылка редактирования (для автора) -->
            <?php if ($user !== null && ($user->getId() === $comment->getAuthorId() || $user->isAdmin())): ?>
                <div style="margin-top: 10px;">
                    <?php if ($user->getId() === $comment->getAuthorId()): ?>
                        <a href="/lesson_2_my_project/www/index.php?route=comments/<?= $comment->getId() ?>/edit"
                            style="margin-right: 15px;">Редактировать</a>
                    <?php endif; ?>

                    <form action="/lesson_2_my_project/www/index.php?route=comments/<?= $comment->getId() ?>/delete"
                        method="post"
                        style="display: inline-block;"
                        onsubmit="return confirm('Вы уверены, что хотите удалить этот комментарий?')">
                        <input type="submit" value="Удалить" style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; cursor: pointer;">
                        <?php if ($user->isAdmin() && $user->getId() !== $comment->getAuthorId()): ?>
                            <small style="color: #dc3545;">(админ)</small>
                        <?php endif; ?>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<?php include __DIR__ . '/../footer.php'; ?>