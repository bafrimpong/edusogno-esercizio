<?php

    interface CrudOperations {
        public function createRecord();
        public function readRecord();
        public function updateRecord();
        public function deleteRecord();
    }
