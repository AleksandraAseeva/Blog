<?php include __DIR__ . '/../header.php'; ?>

<?php foreach ($articles as $article): ?>
    <h2>
        <a href="/lesson_2_my_project/articles/<?= $article->getId() ?>">
            <?= $article->getName() ?>
        </a>
    </h2>
    <p><?= $article->getText() ?></p>
    <hr>
<?php endforeach; ?>

<?php if (!empty($user) && ($user->getId() === $article->getAuthorId() || $user->isAdmin())): ?>
    <form action="/lesson_2_my_project/www/index.php?route=articles/<?= $article->getId() ?>/delete" 
          method="post" 
          style="display: inline-block;"
          onsubmit="return confirm('Вы уверены, что хотите удалить статью \"<?= $article->getName() ?>\"?')">
        <input type="submit" value="Удалить статью" style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; cursor: pointer;">
        <?php if ($user->isAdmin() && $user->getId() !== $article->getAuthorId()): ?>
            <small style="color: #dc3545;">(админ)</small>
        <?php endif; ?>
    </form>
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>