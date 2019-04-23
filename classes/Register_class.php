<?php
require_once ("database.php");
class Register {
    private $connection;
    public function __construct(){
        global $database;
        $this->connection = $database->getConnection();
    }

    public function registerEntry( $first_name , $last_name , $email , $password){
        $date = date('Y-m-d H:i:s');
        $default_date = '0000-00-00 00:00:00';
        $is_deleted = 0;
        $name = $first_name." ".$last_name;
        $description = "";
        $role = "User";
        $query = "INSERT INTO users (user_name , user_description , user_email , user_password , user_role ,created_at , updated_at , deleted_at , is_deleted)  VALUES (? , ? , ? , ? , ? , ? , ? , ? , ?)";
        $preparedStatement = $this->connection->prepare($query);
        $preparedStatement->bind_param('ssssssssi' , $name , $description , $email , $password , $role , $date , $default_date , $default_date , $is_deleted);
        $preparedStatement->execute();
        if($preparedStatement->error){
            die("$preparedStatement->error");
        }    
    }
}
?>