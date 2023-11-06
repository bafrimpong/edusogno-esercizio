<?php

    include_once "route/Dispatcher.php";
    include_once "controller/UsersController.php";

    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $dispatcher = new Dispatcher($requestMethod, $requestUri);
    $dispatcher->dispatch();


