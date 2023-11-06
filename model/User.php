<?php

class User {
    // member variables
    private String $first_name;
    private String $last_name;
    private String $email;
    private String $password;
    private $user_id;
    private String $fullName;


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

    public function setFullName($_first_name, $_last_name): string
    {
        $this->fullName = $_first_name . ", " . strtoupper($_last_name);
        return $this->fullName;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUserId(){
        return $this->user_id;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }
}