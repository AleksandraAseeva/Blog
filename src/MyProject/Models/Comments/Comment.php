<?php

namespace MyProject\Models\Comments;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;
use MyProject\Models\Articles\Article;

class Comment extends ActiveRecordEntity
{
    protected $text;
    protected $authorId;
    protected $articleId;
    protected $createdAt;

    // Text
    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    // Author Id
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    // Author
    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

    public function setAuthor(User $author): void
    {
        $this->authorId = $author->getId();
    }

    // Article
    public function getArticle(): Article
    {
        return Article::getById($this->articleId);
    }
    
    public function setArticle(Article $article): void
    {
        $this->articleId = $article->getId();
    }

    // Created At
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    // Table Name
    protected static function getTableName(): string
    {
        return 'comments';
    }

    public static function getByArticleId(int $articleId): array
{
    $db = \MyProject\Services\Db::getInstance();
    return $db->query(
        'SELECT * FROM `' . static::getTableName() . '` WHERE article_id = :article_id ORDER BY created_at DESC;',
        [':article_id' => $articleId],
        static::class
    );
}
}