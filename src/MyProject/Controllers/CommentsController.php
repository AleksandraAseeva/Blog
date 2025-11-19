<?php

namespace MyProject\Controllers;


use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Comments\Comment;
use MyProject\Models\Articles\Article;


class CommentsController extends AbstractController
{
    public function add(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!empty($_POST)) {
            try {
                // ВАЛИДАЦИЯ КОММЕНТАРИЯ
                if (empty($_POST['text'])) {
                    throw new InvalidArgumentException('Не заполнен текст комментария');
                }

                if (mb_strlen($_POST['text']) < 5) {
                    throw new InvalidArgumentException('Текст комментария должен быть не менее 5 символов');
                }

                $comment = new Comment();
                $comment->setArticle($article);
                $comment->setAuthor($this->user);
                $comment->setText($_POST['text']);
                $comment->save();

                header('Location: /lesson_2_my_project/www/index.php?route=articles/' . $articleId . '#comment' . $comment->getId());

                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/view.php', [
                    'error' => $e->getMessage(),
                    'article' => $article,
                    'comments' => Comment::getByArticleId($articleId)
                ]);
            }
        } else {
            // ЕСЛИ НЕТ POST ДАННЫХ - ПРОСТО РЕДИРЕКТ
            header('Location: /lesson_2_my_project/www/index.php?route=articles/' . $articleId);
        }
    }

    public function edit(int $commentId)
    {
        $comment = Comment::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException();
        }

        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if ($comment->getAuthor()->getId() !== $this->user->getId()) {
            throw new UnauthorizedException('Вы можете редактировать только свои комментарии');
        }

        if (!empty($_POST)) {
            try {
                $comment->setText($_POST['text']);
                $comment->save();

                header('Location: /lesson_2_my_project/www/index.php?route=articles/' . $comment->getArticleId() . '#comment' . $comment->getId());
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('comments/edit.php', [
                    'error' => $e->getMessage(),
                    'comment' => $comment
                ]);
            }
        }

        $this->view->renderHtml('comments/edit.php', ['comment' => $comment]);
    }

    public function delete(int $commentId)
    {
        $comment = Comment::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException();
        }

        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        // if ($comment->getAuthorId() !== $this->user->getId()) {
        //     throw new UnauthorizedException('Вы можете удалять только свои комментарии');
        // }

        // Админ может удалять любые комментарии, обычные пользователи - только свои
        if (!$this->user->isAdmin() && $comment->getAuthorId() !== $this->user->getId()) {
            throw new UnauthorizedException('Вы можете удалять только свои комментарии');
        }


        $articleId = $comment->getArticleId();
        $comment->delete();

        header('Location: /lesson_2_my_project/www/index.php?route=articles/' . $articleId);
        exit();
    }
}
