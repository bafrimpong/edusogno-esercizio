<?php
    include_once("route/Route.php");
    include_once("controller/UsersController.php");
    include_once("helper/Helper.php");

    class Dispatcher {
        private string $request_method;
        private string $request_uri;

        public function __construct($_request_method, $_request_uri) {
            $this->request_method = $_request_method;
            $this->request_uri = $_request_uri;
        }

        public function dispatch() {
            foreach (Route::$routes[$this->request_method] as $route => $action) {
                if ($route === $this->request_uri) {
                    return $this->executeAction($action);
                }
            }

            http_response_code(404);
            include_once("view/404.php");
        }

        private function executeAction($action) {
            if (is_callable($action)) {
                return $action();
            }

            list($controller, $method) = explode('@', $action);

            $controller = new $controller;
            return $controller->$method();
        }
    }

    Route::get(Route::getUsersPath(), function (){
        if (isset($_SESSION["CURRENT_USER"])){
            if ($_SESSION["CURRENT_USER"]["is_admin"] > 0) {
                include_once("view/user/users.php");
            }
        }
    });

    // route for login and auths
    Route::get(Route::getLoginPath(), function() {
        include_once("view/user/login.php");
    });
    Route::post(Route::postAuthenticationPath(), 'UsersController@authenticateLogin');
    Route::get(Route::getLogoutPath(), 'UsersController@logout');
    Route::get(Route::getProfilePath(), 'UsersController@showProfile');

    // routes for registration and updates
    Route::get(Route::getRegistrationPath(), 'UsersController@register');
    Route::post(Route::postCreateRegistrationPath(), 'UsersController@createRecord');
    Route::get(Route::getActionSuccessPath(), 'UsersController@createRecordSuccess');

    // routes for password resets and change
    Route::get(Route::getPasswordResetPath(), 'UsersController@passwordReset');
    Route::post(Route::getSendPasswordResetInstructionsPath(), 'UsersController@sendPasswordResetInstructions');
    Route::get(Route::getPasswordEditPath(), 'UsersController@editPassword');
    Route::post(Route::postPasswordUpdatePath(), 'UsersController@updatePassword');

    /* routes declaration for event */
    // routes for events
    Route::get(Route::getEventsPath(), function (){
        if (isset($_SESSION["CURRENT_USER"])){

            if ($_SESSION["CURRENT_USER"]["is_admin"] > 0){
                include_once ("view/event/events.php");
            }
        }
    });

    Route::get(Route::getEventsPath(), "EventsController@index");
    Route::get(Route::getNewEventPath(), 'EventsController@new');
    Route::get(Route::getEventDetailsPath(), 'EventsController@showDetails');
    Route::post(Route::getCreateEventPath(), 'EventsController@createRecord');
    Route::get(Route::getEditEventPath(), 'EventsController@editEvent');
    Route::post(Route::getUpdateEventPath(), 'EventsController@updateRecord');
    Route::get(Route::getDeleteEventPath(), 'EventsController@deleteRecord');
