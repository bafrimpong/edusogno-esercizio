<?php

    // include the event model to inherit
    include_once("model/Event.php");
    include_once "model/CrudOperations.php";

    class EventsController extends DatabaseConnection implements CrudOperations {

        private $pdo_statement = null;
        private string $sql_query;


        public function index(){
            include_once "view/event/events.php";
        }

        public function new() {
            include_once "view/event/new.php";
        }

        public function showDetails() {
            include_once "view/event/details.php";
        }

        public function editEvent() {
            include_once ("view/event/edit.php");
        }

        public function createRecord()
        {
            $event = new Event();

            // set the values to the user model
            $event->setEventName(trim($_POST['event_name']));
            $event->setEventAttendees($_POST['event_attendees']);
            $event->setEventDate(trim($_POST['event_date']));
            $event->setEventDescription(trim($_POST["event_description"]));

            // check if the user is admin before saving the record
            if (isset($_SESSION["CURRENT_USER"])){

                if ($_SESSION["CURRENT_USER"]["is_admin"] > 0){

                    // sql query or statement to insert the record
                    $this->sql_query = "INSERT INTO events(event_name, attendees, event_date, event_description) VALUE(:event_name, :event_attendees, :event_date, :event_description)";

                    // create a prepared statement to return an instance of PDOStatement
                    $this->pdo_statement = $this->dbConnect()->prepare($this->sql_query);

                    // convert the array to a string
                    $attendees = implode(",", $event->getEventAttendees());

                    // execute the pdo statement
                    $is_success = $this->pdo_statement->execute([
                        "event_name" => $event->getEventName(),
                        "event_attendees" => $attendees,
                        "event_date" => $event->getEventDate(),
                        "event_description" => $event->getEventDescription()
                    ]);

                    if ($is_success) {

                        // email the attendees
                        foreach ($event->getEventAttendees() as $attendee) {

                            $user_controller = new UsersController();
                            $user_record = $user_controller->readRecordByEmail($attendee);

                            $user_model = new User();
                            $user_model->setFullName($user_record[0]["first_name"], $user_record[0]["last_name"]);

                            $message = Helper::getEmailTemplateWithMessage($user_model->getFullName(), Helper::$EMAIL_TYPE_CREATE_EVENT, 'Welcome to '.$event->getEventName(), '');

                            Helper::sendEmail($attendee, "You Have an Upcoming Event", $message);
                        }

                        $_SESSION["ACTION_SUCCESS"] = "You have successfully created the ". $event->getEventName()." event";

                        header("Location: ".Route::getEventsPath());
                        exit();

                    } else {
                        // redirect to failed path
                        $_SESSION["ACTION_FAILED"] = "Record NOT created for the " . $event->getEventName() ." event due to unknown error.";

                        Helper::redirectToSuccessFailurePath();
                    }

                } else {

                    // redirect to failed path
                    $_SESSION["ACTION_FAILED"] = "You are not permitted to create an event. Only admins are allowed with this action.";

                    Helper::redirectToSuccessFailurePath();
                }
            }
        }

        public function readRecord(): array
        {
            // sql query or statement to insert the record
            $this->sql_query = "SELECT * FROM events";

            // execute the statement or sql query using the PDO query() method
            $this->pdo_statement = $this->dbConnect()->query($this->sql_query);

            // retrieve the query results and return
            return $this->pdo_statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public function readRecordById($_id): array
        {
            // sql query or statement to insert the record
            $this->sql_query = "SELECT * FROM events WHERE id = ".$_id;

            // execute the statement or sql query using the PDO query() method
            $this->pdo_statement = $this->dbConnect()->query($this->sql_query);

            // retrieve the query results and return
            return $this->pdo_statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public function readRecordByAttendee($email, $find_registered = true): array
        {
            // sql query or statement to insert the record
            if ($find_registered){
                $this->sql_query = "SELECT * FROM events WHERE FIND_IN_SET('$email', attendees) > 0";
            } else {
                $this->sql_query = "SELECT * FROM events WHERE FIND_IN_SET('$email', attendees) <= 0";
            }

            /// execute the statement or sql query using the PDO query() method
            $this->pdo_statement = $this->dbConnect()->prepare($this->sql_query);

            // bind the values
            $this->pdo_statement->bindParam(":attendee_email", $email);

            // execute the statement
            $this->pdo_statement->execute();

            // retrieve the query results and return it
            return $this->pdo_statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public function readEventByName($_event_name): array
        {
            // sql query or statement to insert the record
            $this->sql_query = "SELECT * FROM events WHERE event_name=:event_name";

            // execute the statement or sql query using the PDO query() method
            $this->pdo_statement = $this->dbConnect()->prepare($this->sql_query);

            // bind the values
            $this->pdo_statement->bindParam(":event_name", $_event_name);

            // execute the statement
            $this->pdo_statement->execute();

            // retrieve the query results into a variable
            $found_events = $this->pdo_statement->fetchAll(PDO::FETCH_ASSOC);

            $events_array = array();
            if ($found_events){
                foreach ($found_events as $found_event){
                    $events_array = $found_event;
                }
            }
            return $events_array;
        }

        public function updateRecord()
        {
            $event = new Event();

            // set the values to the user model
            $event->setEventName(trim($_POST['event_name']));
            $event->setEventAttendees($_POST['event_attendees']);
            $event->setEventDate(trim($_POST['event_date']));
            $event->setEventDescription(trim($_POST["event_description"]));
            $event->setEventId(trim($_POST["event_id"]));

            if (isset($_SESSION["CURRENT_USER"])){

                if ($_SESSION["CURRENT_USER"]["is_admin"] > 0) {

                    // sql query or statement to insert the record
                    $this->sql_query = "UPDATE events SET event_name = :event_name, attendees = :event_attendees, event_date = :event_date, event_description = :event_description WHERE id=:event_id";

                    // create a prepared statement to return an instance of PDOStatement
                    $this->pdo_statement = $this->dbConnect()->prepare($this->sql_query);

                    // convert the array to a string
                    $attendees = implode(",", $event->getEventAttendees());

                    // execute the pdo statement
                    $is_success = $this->pdo_statement->execute([
                        "event_id" => $event->getEventId(),
                        "event_name" => $event->getEventName(),
                        "event_attendees" => $attendees,
                        "event_date" => $event->getEventDate(),
                        "event_description" => $event->getEventDescription()
                    ]);

                    if ($is_success) {

                        // email the attendees
                        foreach ($event->getEventAttendees() as $attendee){

                            $user_controller = new UsersController();
                            $user_record = $user_controller->readRecordByEmail($attendee);

                            $user_model = new User();
                            $user_model->setFullName($user_record[0]["first_name"], $user_record[0]["last_name"]);

                            $message = Helper::getEmailTemplateWithMessage($user_model->getFullName(), Helper::$EMAIL_TYPE_UPDATE_EVENT, 'Welcome to '.$event->getEventName(), '');

                            Helper::sendEmail($attendee, "Upcoming Event Modification", $message);
                        }

                        $_SESSION["ACTION_SUCCESS"] = "You have successfully updated the " . $event->getEventName() ." event";

                        header("Location: ".Route::getEventsPath());
                        exit();

                    } else {
                        // redirect to failed path
                        $_SESSION["ACTION_FAILED"] = "Record NOT updated for the " . $event->getEventName() ." event due to unknown error.";

                        Helper::redirectToSuccessFailurePath();
                    }

                } else {

                    // redirect to failed path
                    $_SESSION["ACTION_FAILED"] = "You are not permitted to update this event. Only admins are allowed with this action.";

                    Helper::redirectToSuccessFailurePath();
                }
            }
        }

        public function deleteRecord()
        {
            if (isset($_REQUEST['key'])) {
                $_event_id = $_REQUEST['key'];

                // sql query or statement to insert the record
                $this->sql_query = "DELETE FROM events WHERE id = ".$_event_id;

                // execute the statement or sql query using the PDO query() method
                $this->pdo_statement = $this->dbConnect()->query($this->sql_query);

                // execute the statement
                $is_success = $this->pdo_statement->execute();

                if ($is_success){
                    $_SESSION["ACTION_SUCCESS"] = "Event record deleted successfully";
                } else {
                    $_SESSION["ACTION_FAILED"] = "Event record failed to delete due to error";
                }

                header("Location: ".Route::getEventsPath());
                exit();
            }
        }


    }
