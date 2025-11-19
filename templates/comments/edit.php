<?php include __DIR__ . '/../header.php'; ?>

<div style="max-width: 600px; margin: 0 auto;">
    <h1>Редактирование комментария</h1>
    
    <?php if (!empty($error)): ?>
        <div style="background-color: red; padding: 5px; margin: 15px; color: white;"><?= $error ?></div>
    <?php endif; ?>
    
    <form action="/lesson_2_my_project/www/index.php?route=comments/<?= $comment->getId() ?>/edit" method="post">
        <textarea name="text" rows="6" style="width: 100%;"><?= htmlspecialchars($comment->getText()) ?></textarea>
        <br><br>
        <input type="submit" value="Сохранить">
        <a href="/lesson_2_my_project/www/index.php?route=articles/<?= $comment->getArticleId() ?>">Отмена</a>
    </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>