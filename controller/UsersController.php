<?php

    include_once("model/User.php");
    include_once("connection/DatabaseConnection.php");
    include_once "model/CrudOperations.php";
    include_once("controller/EventsController.php");
    //include_once "EventsController.php";

    $user = new User();

    class UsersController extends DatabaseConnection implements CrudOperations
    {
        private $pdo_statement = null;
        private string $sql_query;

        public function index(){
            include_once "view/user/users.php";
        }

        public function createRecord()
        {
            global $user;

            // set the values to the user model
            $user->setFirstName(trim($_POST['first_name']));
            $user->setLastName(trim($_POST['last_name']));
            $user->setEmail(trim($_POST['email']));
            $user->setPassword(trim($_POST['password']));

            // check if the email address exist or not
            $user_exists = self::readRecordByEmail($user->getEmail());
            if (!empty($user_exists)){
                $this->redirectToRegistration($user->getEmail());
            } else {

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
                if ($last_inserted_user_id == 0) {
                    $_SESSION["ACTION_SUCCESS"] = "You have successfully registered on the Edusogno platform. ";

                    // send email
                    $email_msg = Helper::getEmailTemplateWithMessage($user->getFirstName(), Helper::$EMAIL_TYPE_REGISTER, "Account registration successful", '');
                    $is_email_sent = Helper::sendEmail($user->getEmail(), "Account Registration", $email_msg);

                    // check if email was sent
                    if ($is_email_sent) {
                        $_SESSION["ACTION_SUCCESS"] .= "A confirmation email is on its way into your box.";
                    } else {
                        $_SESSION["ACTION_FAILED"] .= "We were unable to send a confirmation email due to error";
                    }

                    // get all records
                    $user_records = $this->readRecord();
                    $_SESSION["USER_RECORDS"] = $user_records;

                    // redirect to success page
                    Helper::redirectToSuccessFailurePath();

                    exit();
                } else {
                    $this->redirectToRegistration($user->getEmail());
                }
            }
        }

        public function createRecordSuccess() {
            include_once("view/action_success.php");
        }

        public function readRecord(): array
        {
            // sql query or statement to insert the record
            $this->sql_query = "SELECT * FROM users";

            // execute the statement or sql query using the PDO query() method
            $this->pdo_statement = $this->dbConnect()->query($this->sql_query);

            // retrieve the query results into a variable
            return $this->pdo_statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public function readRecordById($_id) {
            // sql query or statement to insert the record
            $this->sql_query = "SELECT DISTINCT * FROM users WHERE id = :id LIMIT 1";

            // execute the statement or sql query using the PDO query() method
            $this->pdo_statement = $this->dbConnect()->prepare($this->sql_query);

            // bind the values
            $this->pdo_statement->bindParam(":id", $_id);

            // execute the statement
            $this->pdo_statement->execute();

            // retrieve the query results into a variable
            return $this->pdo_statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public function readRecordByEmail($_email): array
        {
            // sql query or statement to insert the record
            $this->sql_query = "SELECT DISTINCT * FROM users WHERE email = :email";

            // execute the statement or sql query using the PDO query() method
            $this->pdo_statement = $this->dbConnect()->prepare($this->sql_query);

            // bind the values
            $this->pdo_statement->bindParam(":email", $_email);

            // execute the statement
            $this->pdo_statement->execute();

            // retrieve the query results into a variable
            return $this->pdo_statement->fetchAll(PDO::FETCH_ASSOC);
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

        public function deleteRecord()
        {
            if (isset($_SESSION["key"])) {
                $user_id = $_SESSION["key"];

                // sql query or statement to insert the record
                $this->sql_query = "DELETE FROM users WHERE id = ".$user_id;

                // execute the statement or sql query using the PDO query() method
                $this->pdo_statement = $this->dbConnect()->query($this->sql_query);

                // execute the statement
                $is_success = $this->pdo_statement->execute();

                if ($is_success){
                    $_SESSION["ACTION_SUCCESS"] = "Event record deleted successfully";
                } else {
                    $_SESSION["ACTION_FAILED"] = "Event record failed to delete due to error";
                }

                header("Location: ".Route::getUsersPath());
                exit();
            }
        }

        public function register() {
            include_once("view/user/register.php");
        }

        public function authenticateLogin(){

            $user = new User();

            $user->setEmail(htmlspecialchars($_POST['email']));
            $user->setPassword(htmlspecialchars($_POST['password']));

            $_users = $this->readRecordByEmail($user->getEmail());

            if ($_users){
                foreach ($_users as $_user){
                    if (strcmp($user->getPassword(), $_user["password"]) === 0){
                        $_SESSION["CURRENT_USER"] = $_user;
                        header("Location: ".Route::getProfilePath());

                        exit();
                    } else {
                        $this->redirectToLogin();
                    }
                }
            } else {
                $this->redirectToLogin();
            }
        }

        public function logout(){
            $_SESSION["CURRENT_USER"] = null;
            $_SESSION["ACTION_FAILED"] = null;
            $_SESSION['ACTION_SUCCESS'] = null;
            $_SESSION['FAILED_LOGIN_MSG'] = null;

            $this->redirectToLogin();
        }

        public function showProfile(){
            if (isset($_SESSION["CURRENT_USER"])){
                $user = $_SESSION["CURRENT_USER"];

                $event = new EventsController();

                $_SESSION["REGISTERED_EVENTS"] = $event->readRecordByAttendee($user["email"]);
                $_SESSION["UNREGISTERED_EVENTS"] = $event->readRecordByAttendee($user["email"], false);

                include_once "view/user/profile.php";
            }
        }

        public function passwordReset () {
            include_once("view/user/password_reset.php");
        }

        /**
         * Sends an email to a user requesting for password reset. If an email is found the message is sent else
         * an error message is sent back to the user. If the user is found the email is not sent, a message is sent back to the user about it.
         * @return void
         */
        public function sendPasswordResetInstructions() {
            global $user;

            if (isset($_POST["email"])){
                $user->setEmail(trim($_POST["email"]));

                // call for a method to retrieve the user from the dbase
               $_user = $this->readRecordByEmail($user->getEmail());

               // check if a user exist for the email address
               if (empty($_user)){

                   $_SESSION["FAILED_PASSWORD_MSG"] = "No record found matching the email ". $user->getEmail();
                   header("Location: ".Route::getPasswordResetPath());

               } else {
                   //print_r($_user[0]['first_name']);
                   $user->setFirstName($_user[0]["first_name"]);
                   $user->setUserId($_user[0]["id"]);

                   // send the email
                   $param="SET_PASS=".$user->getUserId();
                   $email_msg = Helper::getEmailTemplateWithMessage($user->getFirstName(), Helper::$EMAIL_TYPE_RESET_PASSWORD, "Password Reset Request", $param);
                   $_status = Helper::sendEmail($user->getEmail(), "Password Reset Instructions", $email_msg);

                   // check if the message was sent
                   if ($_status){
                       // redirect to success page
                       $_SESSION["ACTION_SUCCESS"] = "You have successfully requested for a password reset instructions. Check your email for further actions";

                   } else {
                       // show an error message
                       $_SESSION["FAILED_PASSWORD_MSG"] = "Password reset instructions not sent due to error.";

                   }
                   Helper::redirectToSuccessFailurePath();
               }
            }
        }

        public function editPassword() {
            include_once("view/user/password_edit.php");
        }

        public function updatePassword() {
            global $user;

            if (isset($_POST["reset_id"])){
                $user_id = trim($_POST["reset_id"]);

                $found_user = $this->readRecordById($user_id);

                if (!empty($found_user)){

                    $user->setUserId($found_user[0]["id"]);
                    $user->setPassword($_POST["password"]);
                    $user->setEmail($found_user[0]["email"]);
                    $user->setFirstName($found_user[0]["first_name"]);

                    // sql query or statement to insert the record
                    $this->sql_query = "UPDATE users SET password = :password WHERE id=:id";

                    // create a prepared statement to return an instance of PDOStatement
                    $this->pdo_statement = $this->dbConnect()->prepare($this->sql_query);

                    // bind the parameters
                    $this->pdo_statement->bindValue(":id",$user->getUserId(), PDO::PARAM_INT);
                    $this->pdo_statement->bindValue(":password", $user->getPassword());

                    // execute the pdo statement
                    $update_success = $this->pdo_statement->execute();
                    if ($update_success === true) {
                        $message = Helper::getEmailTemplateWithMessage($user->getFirstName(), Helper::$EMAIL_TYPE_CHANGE_PASSWORD, "Password Changed", '');
                        Helper::sendEmail($user->getEmail(), "Password Change Confirmation", $message);

                        $_SESSION["ACTION_SUCCESS"] = "You have successfully changed your account password.<br>A confirmation email is on its way to your inbox. You may login with your new password";
                    } else {
                        $_SESSION["ACTION_FAILED"] = "Change of password not successful due to error";
                    }
                    Helper::redirectToSuccessFailurePath();
                }
            }

            $_SESSION["ACTION_FAILED"] = "Change of password not successful as no record found matching your email";
            Helper::redirectToSuccessFailurePath();
        }

        // private methods
        private function redirectToLogin() {
            $_SESSION['FAILED_LOGIN_MSG'] = "Invalid username or password";

            header("LOCATION: ".Route::getLoginPath());
            exit();
        }

        private function redirectToRegistration(string $email_address) {
            if (!empty($email_address)) {
                $_SESSION['REGISTER_FAILED_MSG'] = "The e-mail address <b>" . $email_address . "</b> is already registered.";
            } else {
                $_SESSION['REGISTER_FAILED_MSG'] = "An error occurred while creating/updating your account.";
            }

            header("Location: ".Route::getRegistrationPath());
            exit();
        }


    }