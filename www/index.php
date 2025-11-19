<?php

try {
    spl_autoload_register(function (string $className) {

        $className = str_replace('\\', '/', $className);
        $filePath = __DIR__ . '/../src/' . $className . '.php';

        if (file_exists($filePath)) {
            require_once $filePath;
        } else {
            throw new Exception("Файл не найден: " . $filePath);
        }
    });


    $route = $_GET['route'] ?? '';

    $routes = require __DIR__ . '/../src/MyProject/routes.php';

    $isRouteFound = false;
    foreach ($routes as $pattern => $controllerAndAction) {

        preg_match($pattern, $route, $matches);
        if (!empty($matches)) {
            $isRouteFound = true;
            break;
        }
    }

    if (!$isRouteFound) {
        echo 'Страница не найдена!';
        return;
    }

    unset($matches[0]);

    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];

    $controller = new $controllerName();
    $controller->$actionName(...$matches);



} catch (\MyProject\Exceptions\DbException $e) {
    $view = new \MyProject\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('500.php', ['error' => $e->getMessage()], 500);
} catch (\MyProject\Exceptions\NotFoundException $e) {
    $view = new \MyProject\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('404.php', ['error' => $e->getMessage()], 404);
} catch (\MyProject\Exceptions\UnauthorizedException $e) {
    $view = new \MyProject\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('401.php', ['error' => $e->getMessage()], 401);
}

