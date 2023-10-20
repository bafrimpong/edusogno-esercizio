<?php

class User {
    // member variables
    private $first_name;
    private $last_name;
    private $email;
    private $password;
    private $user_id;


    // setters and getters
    public function setFirstName($_first_name){
        $this->first_name = $_first_name;
    }

    public function setLastName($_last_name){
        $this->last_name = $_last_name;
    }

    public function setEmail($_email){
        $this->email = $_email;
    }

    public function setPassword($_password){
        $this->password = $_password;
    }

    public function setUserId($_id){
        $this->user_id = $_id;
    }

    public function getFirstName(){
        return $this->first_name;
    }

    public function getLastName(){
        return $this->last_name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getUserId(){
        return $this->user_id;
    }

    public function getFullName(){
        return $this->first_name." ".$this->last_name;
    }
}