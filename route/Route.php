<?php
class Route {
    public static array $routes = array();


    public static function getUsersPath() : string {
        return "/edusogno-esercizio/user/all";
    }

    public static function getDeleteUserPath() : string {
        return "/edusogno-esercizio/user/delete";
    }

    public static function getLogoutPath() : string {
        return "/edusogno-esercizio/user/logout";
    }

    // registration paths
    public static function getRegistrationPath() : string {
        return '/edusogno-esercizio/user/register';
    }

    public static function postCreateRegistrationPath() : string {
        return '/edusogno-esercizio/user/create-registration';
    }

    public static function getActionSuccessPath(): string
    {
        return '/edusogno-esercizio/user/registration-success';
    }

    // login and authentication paths
    public static function getLoginPath() : string {
        return '/edusogno-esercizio/user/login';
    }

    public static function postAuthenticationPath() : string {
        return '/edusogno-esercizio/user/auth';
    }

    public static function getProfilePath() : string {
        return '/edusogno-esercizio/user/profile';
    }

    // password resets and change paths
    public static function getPasswordResetPath() : string {
        return '/edusogno-esercizio/user/password-reset';
    }

    public static function getSendPasswordResetInstructionsPath(): string {
        return '/edusogno-esercizio/user/send-password-instruction';
    }

    public static function postPasswordUpdatePath() : string {
        return '/edusogno-esercizio/user/password-update';
    }

    public static function getPasswordEditPath(): string
    {
        return '/edusogno-esercizio/user/password-edit';
    }

    /* Routing for event*/
    public static function getEventsPath() : string {
        return "/edusogno-esercizio/event/all";
    }

    public static function getNewEventPath(): string
    {
        return "/edusogno-esercizio/event/new";
    }

    public static function getEventDetailsPath(): string {
        return "/edusogno-esercizio/event/details";
    }

    public static function getCreateEventPath(): string
    {
        return "/edusogno-esercizio/event/create";
    }

    public static function getEditEventPath(): string
    {
        return "/edusogno-esercizio/event/edit";
    }

    public static function getUpdateEventPath(): string
    {
        return "/edusogno-esercizio/event/update";
    }

    public static function getDeleteEventPath(): string
    {
        return "/edusogno-esercizio/event/delete";
    }

    public static function addRoute($method, $route, $action) {
        self::$routes[$method][$route] = $action;
    }

    public static function get($route, $action) {
        self::addRoute('GET', $route, $action);
    }

    public static function post($route, $action) {
        self::addRoute('POST', $route, $action);
    }

    public static function patch($route, $action) {
        self::addRoute('PATCH', $route, $action);
    }

    public static function put($route, $action) {
        self::addRoute('PUT', $route, $action);
    }
}



