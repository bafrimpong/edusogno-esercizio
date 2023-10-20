<?php
    class Event {
        private $event_name;
        private $event_attendees;
        private $event_date;
        private $event_id;

        // setters and getters
        function setEventId($_id){
            $this->event_id = $_id;
        }

        function setEventName($_title) {
            $this->event_name = $_title;
        }

        function setEventAttendees($_attendees) {
            $this->event_attendees = $_attendees;
        }

        function setEventDate($_description) {
            $this->event_date = $_description;
        }

        function getEventId(){
            return $this->event_id;
        }

        function getEventName()
        {
            return $this->event_name;
        }

        function getEventAttendees()
        {
            return $this->event_attendees;
        }

        function getEventDate() {
            return $this->event_date;
        }
    }
