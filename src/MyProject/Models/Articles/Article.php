<?php

namespace MyProject\Models\Articles;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;

class Article extends ActiveRecordEntity
{
    protected $name;
    protected $text;
    protected $authorId;
    protected $createdAt;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    // Прямо в геттере просим сущность юзера выполнить запрос в базу 
    // и получить нужного пользователя, по id, который хранится в статье. 
    // При этом запрос будет выполнен только если мы вызовем этот геттер
    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

    public function setAuthor(User $author): void
    {
        $this->authorId = $author->getId();
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }

}
