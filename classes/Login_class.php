<?php
require_once ("database.php");
class Login {
    private $connection;
    public function __construct(){
        global $database;
        $this->connection = $database->getConnection();
    }

    public function validate($email , $password){
        $query = "SELECT * FROM users WHERE (user_email = '$email' AND user_password = '$password') AND is_deleted = 0";
        $result_set = $this->connection->query($query);
        $num_rows = mysqli_num_rows($result_set);
        if($num_rows > 0)
            return "true";
        else
            return "false";
    }

    public function getCredentials($email){
        $query = "SELECT * FROM users WHERE user_email = '$email' AND is_deleted = 0";
        $result_set = $this->connection->query($query);
        return $result_set;
   }
}