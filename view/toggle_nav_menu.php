<?php
    if (isset($_SESSION["CURRENT_USER"])){
        if ($_SESSION["CURRENT_USER"]["is_admin"] > 0){
            echo('
                <div id="nav-menu" style="text-align: right; margin-right: 50px;">
                    <a href="'. Route::getUsersPath() .'">Users</a> |
                    <a href="'. Route::getEventsPath() .'">Events</a> |
                    <a href="'. Route::getLogoutPath() .'">Logout</a>
                </div>
            ');
        } else {
            echo('
                <div id="nav-menu" style="text-align: right; margin-right: 50px;">
                    <a href="'. Route::getLogoutPath() .'">Logout</a>
                </div>
            ');
        }
    }