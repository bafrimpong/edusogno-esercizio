<?php

    // include the event model to inherit
    include_once("../model/Event.php");
    include_once "model/CrudOperations.php";

    class EventsController extends DatabaseConnection implements CrudOperations {

        private $pdo_statement = null;
        private string $sql_query;


        public function createRecord()
        {
            $event = new Event();
            if (isset($_POST['btn_add_event'])){

                // set the values to the user model
                $event->setEventName($_POST['event_name']);
                $event->setEventAttendees($_POST['event_attendees']);
                $event->setEventDate($_POST['event_date']);

                // sql query or statement to insert the record
                $this->sql_query = "INSERT INTO events(event_date, attendees, event_date) VALUE(:event_name, :event_attendees, :event_date)";

                // create a prepared statement to return an instance of PDOStatement
                $this->pdo_statement = $this->dbConnect()->prepare($this->sql_query);

                // execute the pdo statement
                $this->pdo_statement->execute([
                    "event_name" => $event->getEventName(),
                    "event_attendees" => $event->getEventAttendees(),
                    "event_date" => $event->getEventDate()
                ]);

                // retrieve the last inserted record id
                $last_inserted_user_id = $this->dbConnect()->lastInsertId();

                // check if the insertion was successful
                if ($last_inserted_user_id){
                    print_r($last_inserted_user_id);
                } else {
                    print_r("No record saved");
                }
            }
        }

        public function readRecord(): array
        {
            // sql query or statement to insert the record
            $this->sql_query = "SELECT * FROM events";

            // execute the statement or sql query using the PDO query() method
            $this->pdo_statement = $this->dbConnect()->query($this->sql_query);

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

        public function readEventByName($_event_name): array
        {
            // sql query or statement to insert the record
            $this->sql_query = "SELECT * FROM events WHERE event_name=:event_name";

            // execute the statement or sql query using the PDO query() method
            $this->pdo_statement = $this->dbConnect()->query($this->sql_query);

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
            if (isset($_POST['btn_update_event'])){

                // set the values to the user model
                $event->setEventId($_POST['id']);
                $event->setEventName($_POST['event_name']);
                $event->setEventAttendees($_POST['event_attendees']);
                $event->setEventDate($_POST['event_date']);

                // sql query or statement to insert the record
                $this->sql_query = "UPDATE events SET event_name = :event_name, attendees = :event_attendees, event_date = :event_date WHERE id=:id";

                // create a prepared statement to return an instance of PDOStatement
                $this->pdo_statement = $this->dbConnect()->prepare($this->sql_query);

                // bind the parameters
                $this->pdo_statement->bindValue(":id",$event->getEventId(), PDO::PARAM_INT);
                $this->pdo_statement->bindValue(":event_name",$event->getEventName());
                $this->pdo_statement->bindValue(":event_attendees",$event->getEventAttendees());
                $this->pdo_statement->bindValue(":event_date",$event->getEventDate());

                // execute the pdo statement
                $update_success = $this->pdo_statement->execute();

                // check if the update was successful
                if ($update_success){
                    print_r("Update successful");
                } else {
                    print_r("No record saved");
                }
            }
        }

        public function deleteRecord($_id): bool
        {
            // sql query or statement to insert the record
            $this->sql_query = "DELETE FROM events WHERE id=:id LIMIT 1";

            // execute the statement or sql query using the PDO query() method
            $this->pdo_statement = $this->dbConnect()->query($this->sql_query);

            // bind the values
            $this->pdo_statement->bindParam(":id", $_id);

            // execute the statement
            return $this->pdo_statement->execute();
        }

    }
