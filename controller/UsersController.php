<?php

    include_once("model/User.php");
    include("model/DatabaseConnection.php");
    include "model/CrudOperations.php";
    $user = new User();

    class UsersController extends DatabaseConnection implements CrudOperations
    {
        private $pdo_statement = null;
        private string $sql_query;


        public function createRecord()
        {
            global $user;
            if (isset($_POST['btn_register'])){

                // set the values to the user model
                $user->setFirstName($_POST['first_name']);
                $user->setLastName($_POST['last_name']);
                $user->setEmail($_POST['email']);
                $user->setPassword($_POST['password']);

                // sql query or statement to insert the record
                $this->sql_query = "INSERT INTO users(first_name, last_name, email, password) VALUE(:first_name, :last_name, :email, :password)";

                // create a prepared statement to return an instance of PDOStatement
                $this->pdo_statement = $this->dbConnect()->prepare($this->sql_query);

                // execute the pdo statement
                $this->pdo_statement->execute([
                    "first_name" => $user->getFirstName(),
                    "last_name" => $user->getLastName(),
                    "email" => $user->getEmail(),
                    "password" => $user->getPassword()
                ]);

                // retrieve the last inserted record id
                $last_inserted_user_id = $this->dbConnect()->lastInsertId();

                // check in the insertion was successful
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
            $this->sql_query = "SELECT * FROM users";

            // execute the statement or sql query using the PDO query() method
            $this->pdo_statement = $this->dbConnect()->query($this->sql_query);

            // retrieve the query results into a variable
            $found_users = $this->pdo_statement->fetchAll(PDO::FETCH_ASSOC);

            $users_array = array();
            if ($found_users){
                foreach ($found_users as $found_user){
                    $users_array = $found_user;
                }
            }
            return $users_array;
        }

        public function readUserByEmail($_email): array
        {
            // sql query or statement to insert the record
            $this->sql_query = "SELECT * FROM users WHERE email=:email";

            // execute the statement or sql query using the PDO query() method
            $this->pdo_statement = $this->dbConnect()->query($this->sql_query);

            // bind the values
            $this->pdo_statement->bindParam(":email", $_email);

            // execute the statement
            $this->pdo_statement->execute();

            // retrieve the query results into a variable
            $found_user = $this->pdo_statement->fetchAll(PDO::FETCH_ASSOC);

            $users_array = array();
            if ($found_user){
                foreach ($found_user as $_user){
                    $users_array = $found_user;
                }
            }
            return $users_array;
        }

        public function updateRecord()
        {
            global $user;
            if (isset($_POST['btn_update_registration'])){

                // set the values to the user model
                $user->setUserId($_POST['id']);
                $user->setFirstName($_POST['first_name']);
                $user->setLastName($_POST['last_name']);
                $user->setEmail($_POST['email']);
                $user->setPassword($_POST['password']);

                // sql query or statement to insert the record
                $this->sql_query = "UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, password = :password WHERE id=:id";

                // create a prepared statement to return an instance of PDOStatement
                $this->pdo_statement = $this->dbConnect()->prepare($this->sql_query);

                // bind the parameters
                $this->pdo_statement->bindValue(":id",$user->getUserId(), PDO::PARAM_INT);
                $this->pdo_statement->bindValue(":first_name",$user->getFirstName());
                $this->pdo_statement->bindValue(":last_name",$user->getLastName());
                $this->pdo_statement->bindValue(":email",$user->getEmail());
                $this->pdo_statement->bindValue(":password", $user->getPassword());

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
            $this->sql_query = "DELETE FROM users WHERE id=:id LIMIT 1";

            // execute the statement or sql query using the PDO query() method
            $this->pdo_statement = $this->dbConnect()->query($this->sql_query);

            // bind the values
            $this->pdo_statement->bindParam(":id", $_id);

            // execute the statement
            return $this->pdo_statement->execute();
        }

        public function validateLogin($_email, $_password){
            $_users = $this->readUserByEmail($_email);

            if ($_users){
                foreach ($_users as $_user){
                    if ($_email === $_user["email"] && $_password === $_user["password"]){
                        echo ("login successful");
                    } else {
                        echo "invalid username or password";
                    }
                }
            }
        }
    }