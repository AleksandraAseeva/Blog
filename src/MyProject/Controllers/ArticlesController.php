<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\View\View;

class ArticlesController extends AbstractController
{
    /** @var View */

    public function view(int $articleId): void
    {
        // echo "Ищем статью с ID: " . $articleId . "<br>";

        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $comments = \MyProject\Models\Comments\Comment::getByArticleId($articleId);

        // добавим это вместо логики получения и sql-запросов
        $this->view->renderHtml('articles/view.php', [
            'article' => $article,
            'comments' => $comments
        ]);
    }

    public function edit(int $articleId): void
    {
        /** @var Article $article */
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        // Если форма отправлена - обрабатываем данные
        if (!empty($_POST)) {
            $article->setName($_POST['name']);
            $article->setText($_POST['text']);
            $article->save();

            // Перенаправляем на страницу статьи после сохранения
            header('Location: /articles/' . $article->getId());
            exit;
        }

        // Если форма не отправлена - показываем форму редактирования
        $this->view->renderHtml('articles/edit.php', [
            'article' => $article
        ]);
    }

    // public function add(): void
    // {

    //     $author = User::getById(1);
    //     $article = new Article();
    //     $article->setAuthor($author);
    //     $article->setName('Новое название статьи');
    //     $article->setText('Новый текст статьи');
    //     $article->save();
    //     var_dump($article);
    // }

    public function add(): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!empty($_POST)) {
            try {
                if (empty($_POST['name'])) {
                    throw new InvalidArgumentException('Не заполнено название статьи');
                }

                if (empty($_POST['text'])) {
                    throw new InvalidArgumentException('Не заполнен текст статьи');
                }

                if (mb_strlen($_POST['name']) < 3) {
                    throw new InvalidArgumentException('Название статьи должно быть не менее 3 символов');
                }

                if (mb_strlen($_POST['text']) < 10) {
                    throw new InvalidArgumentException('Текст статьи должен быть не менее 10 символов');
                }


                $article = new Article();
                $article->setAuthor($this->user);
                $article->setName($_POST['name']);
                $article->setText($_POST['text']);
                $article->save();

                header('Location: /lesson_2_my_project/www/index.php?route=articles/' . $article->getId());
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/add.php', ['error' => $e->getMessage()]);
            }
        } else {
            $this->view->renderHtml('articles/add.php');
        }
    }

    public function delete(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        // Админ может удалять любые статьи, обычные пользователи - только свои
        if (!$this->user->isAdmin() && $article->getAuthorId() !== $this->user->getId()) {
            throw new UnauthorizedException('Вы можете удалять только свои статьи');
        }

        $article->delete();

        header('Location: /lesson_2_my_project/www/index.php');
        exit();
    }
}
