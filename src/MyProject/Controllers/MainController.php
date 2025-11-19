<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\View\View;

class MainController extends AbstractController 
{

    // Показать главную страницу
    public function main()
    {
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', ['articles' => $articles]); // тема 4
    }

    public function sayHello(string $name)
    {
        $this->view->renderHtml('main/hello.php', [
            'name' => $name,
            'title' => 'Страница приветствия'
        ]);
    }

    public function sayBye(string $name)
    {
        $this->view->renderHtml('main/bye.php', [
            'name' => $name,
            'title' => 'Страница прощания'
        ]);
    }
}
