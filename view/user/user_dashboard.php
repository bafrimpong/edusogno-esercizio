<?php
    include_once("helper/Helper.php");

    $first_name = '';
    $email = '';
    $current_user = null;
    $all_events = null;

    if (isset($_SESSION["CURRENT_USER"])){
        $current_user = $_SESSION["CURRENT_USER"];
        $full_name = $current_user["first_name"]." ".$current_user["last_name"];
        $email = $current_user["email"];

        echo('<h3 id="form-title" class="login-form-title" style="margin-top: 78px !important;">'."Ciao {$full_name} ecco i tuoi eventi".'</h3>');

        if (isset($_SESSION["REGISTERED_EVENTS"])){
            // check if the array contains the current user email or not
            $all_events = $_SESSION["REGISTERED_EVENTS"];

            // registered events
            echo("<div id='registered-events'><ul class='attendees-events'>");
                foreach ($_SESSION["REGISTERED_EVENTS"] as $event) {
                    echo(
                        "<li>&bull;&nbsp;".$event['event_name']."<small>".Helper::formatDate("Y-m-d", $event['event_date'])."</small></li>"
                    );
                }
            echo("</ul></div>");

            // unregistered events
            echo('<div class="card-container" style="margin-top: 20px">');
                if (isset($_SESSION["UNREGISTERED_EVENTS"])){
                    foreach ($_SESSION["UNREGISTERED_EVENTS"] as $unregistered_event){
                        echo('<div class="card">
                                <p class="event-title">'.$unregistered_event["event_name"].'</p>
                                <p class="event-date">'.Helper::formatDate("Y-m-d", $unregistered_event["event_date"]).'</p>
                        
                                <a href="#" class="general-button">join</a>
                        </div>');
                    }
                }
            echo('</div>');
        }
    }

    //unset($_SESSION["CURRENT_USER"]);


