<?php include __DIR__ . '/../header.php'; ?>

<div class="container">
    <h1>Редактирование статьи</h1>

    <form method="post" action="/articles/<?= $article->getId() ?>/edit">
        <div class="form-group">
            <label for="name">Название статьи:</label>
            <input type="text"
                id="name"
                name="name"
                value="<?= htmlspecialchars($article->getName()) ?>"
                class="form-control"
                required>
        </div>

        <div class="form-group">
            <label for="text">Текст статьи:</label>
            <textarea id="text"
                name="text"
                rows="10"
                class="form-control"
                required><?= htmlspecialchars($article->getText()) ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">Сохранить изменения</button>
            <a href="/articles/<?= $article->getId() ?>" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-actions {
        margin-top: 20px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
        margin-right: 10px;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 4px;
        display: inline-block;
    }
</style>

<?php include __DIR__ . '/../footer.php'; ?>