<?php
require_once ("database.php");
class Subscriptions{
    private $connection;
    public function __construct(){
        global $database;
        $this->connection = $database->getConnection();
    }

    public function getSubscribedAuthorities(){
        if(isset($_SESSION['user_id'])){
            $id = $_SESSION['user_id'];
        }
        //$query = "SELECT * FROM users WHERE id IN (SELECT sub_admin_id FROM subscriptions WHERE sub_user_id = $id AND is_deleted = 0)/*user_role = 'Admin'*/";
        $query = "SELECT * FROM users , subscriptions WHERE users.id = subscriptions.sub_admin_id AND subscriptions.sub_user_id = $id AND subscriptions.is_deleted = 0";
        $result_set = $this->connection->query($query);
        return $result_set;
    }

    public function getSubscriptionSuggestion(){
        if(isset($_SESSION['user_id'])){
            $id = $_SESSION['user_id'];
        }
        $query = "SELECT * FROM users WHERE user_role = 'Admin' AND id NOT IN (SELECT sub_admin_id FROM subscriptions WHERE sub_user_id = $id AND is_deleted = 0)";
        $result_set = $this->connection->query($query);
        return $result_set;

    }

    public function deleteSubscriptions($sub_admin_id){
        if(isset($_SESSION['user_id'])){
            $id = $_SESSION['user_id'];
        }
        $date = date('Y-m-d H:i:s');
        $query = "UPDATE subscriptions set deleted_at = '$date' ,is_deleted = 1  WHERE sub_admin_id = $sub_admin_id AND sub_user_id = $id";
        $result_set = $this->connection->query($query);
        return $result_set;
    }

    public function insertSubscription($sub_admin_id){
        if(isset($_SESSION['user_id'])){
            $id = $_SESSION['user_id'];
        }
        $date = date('Y-m-d H:i:s');
        $default_date = '0000-00-00 00:00:00';
        $is_deleted = 0;
        $query = "INSERT INTO subscriptions (sub_user_id , sub_admin_id , created_at , updated_at , deleted_at , is_deleted)  VALUES (?, ?, ? , ?, ?, ?)";
        $preparedStatement = $this->connection->prepare($query);
        $preparedStatement->bind_param('iisssi' , $id , $sub_admin_id , $date , $default_date , $default_date , $is_deleted);
        $preparedStatement->execute();
    }
}