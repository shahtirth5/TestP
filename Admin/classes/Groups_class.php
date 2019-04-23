<?php
    require_once ("classes/database.php");
    class Group {
        private $connection;
        public $group_id;
        public function __construct(){
           global $database;
           $this->connection = $database->getConnection();
        }

        public function getSubscribedUsers($searchString){
            if(isset($_SESSION['user_id'])){
                $id = $_SESSION['user_id'];
            }
            $query = "SELECT user_name , user_email FROM users WHERE (user_name like '%$searchString%' OR user_email LIKE '%$searchString%') AND (is_deleted = 0) AND (id IN (SELECT sub_user_id FROM subscriptions WHERE sub_admin_id = $id AND is_deleted = 0))";
            $result_set = $this->connection->query($query);
            if($this->connection->error){
                die($this->connection->error);
            }
            return $result_set;
        }

        public function insertGroup($group_name , $group_description){
            $date = date('Y-m-d H:i:s');
            $default_date = '0000-00-00 00:00:00';
            $is_deleted = 0;
            $query = "INSERT INTO groups(group_name, group_description, created_at, updated_at, deleted_at, is_deleted) VALUES (? , ? , ? , ? , ? , ? )";
            $preparedStatement = $this->connection->prepare($query);
            $preparedStatement->bind_param("sssssi" , $group_name , $group_description , $date , $default_date , $default_date , $is_deleted);
            $preparedStatement->execute();
            return $preparedStatement->insert_id;
        }

        public function insertGroupMember($name , $email , $group_id){
            $query = "SELECT id FROM users WHERE user_email = '$email'";
            $result_set = $this->connection->query($query);
            while($row = mysqli_fetch_assoc($result_set)){
                $id = $row['id'];
            }
            $query = "INSERT INTO users_in_groups(group_id, user_id) VALUES ( ? , ? )";
            $preparedStatement = $this->connection->prepare($query);
            $preparedStatement->bind_param('ii' , $group_id , $id );
            $preparedStatement->execute();
        }

        public function getGroupsFromSearch($searchString){
            $query = "SELECT group_name FROM groups WHERE group_name LIKE '%$searchString%'";
            $result_set = $this->connection->query($query);
            if($this->connection->error){
                die($this->connection->error);
            }
            return $result_set;
        }

        public function getGroupIdFromGroupName($group_name){
            $query = "SELECT group_id FROM groups WHERE group_name = '$group_name'";
            $result_set = $this->connection->query($query);
            if($this->connection->error){
                die($this->connection->error);
            }
            return $result_set;
        }

        public function getUsernameEmailFromGroupId($group_id){
            $query = "SELECT user_name , user_email FROM users WHERE id IN (SELECT user_id FROM  users_in_groups WHERE group_id = $group_id)";
            $result_set = $this->connection->query($query);
            if($this->connection->error){
                die($this->connection->error);
            }
            return $result_set;
        }

        
    }
?>