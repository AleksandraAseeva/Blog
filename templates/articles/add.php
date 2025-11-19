<?php include __DIR__ . '/../header.php'; ?>

<div style="max-width: 600px; margin: 0 auto;">
    <h1>Добавить новую статью</h1>
    
    <?php if (!empty($error)): ?>
        <div style="background-color: red; padding: 5px; margin: 15px; color: white;"><?= $error ?></div>
    <?php endif; ?>
    
    <form action="/lesson_2_my_project/www/index.php?route=articles/add" method="post">
        <div style="margin-bottom: 15px;">
            <label for="name">Название статьи:</label><br>
            <input type="text" id="name" name="name" style="width: 100%; padding: 8px;" 
                   value="<?= $_POST['name'] ?? '' ?>" required>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="text">Текст статьи:</label><br>
            <textarea id="text" name="text" rows="10" style="width: 100%; padding: 8px;" 
                      required><?= $_POST['text'] ?? '' ?></textarea>
        </div>
        
        <input type="submit" value="Добавить статью" style="padding: 10px 20px;">
    </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>