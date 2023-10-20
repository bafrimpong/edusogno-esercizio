<?php 
    class DatabaseConnection {
        private string $db_username = "root";
        private string $db_password = "";
        private string $db_name = "edusogno2";
        private string $db_host = "localhost";

        /**
         * @return PDO|void
         */
        private function dbConnection(){
            // set the data source name
            $data_source_name = "mysql:host=".$this->db_host.";dbname=".$this->db_name;

            // return the connection but trap errors first
            try {

                // set pdo options
                $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

                // create a PDO object
                $pdo_connection = new PDO($data_source_name, $this->db_username, $this->db_password, $options);

            } catch (PDOException $exception){
                $_SESSION["no_db_connection"] = $exception->getMessage();
                die($exception->getMessage());
            }

            return $pdo_connection;
        }


        /**
         * @return PDO|null
         */
        protected function dbConnect(): ?PDO
        {
            return $this->dbConnection();
        }
    }
