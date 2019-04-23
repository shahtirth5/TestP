<?php
require_once ("database.php");
class Notifications{
    private $connection;
    public function __construct(){
        global $database;
        $this->connection = $database->getConnection();
    }

    /**
     * @param $searchString : This is the string of the bootstrap tokenfield
     * @return $result_set : Result set of the query
     */
    public function getNotificationSendTo($searchString){
        $query = "SELECT user_name , user_email FROM users WHERE user_name LIKE '%$searchString%' OR user_email LIKE '%$searchString%'";
        $result_set = $this->connection->query($query);
        return $result_set;
    }


    /**
     * @param $name : Name of the person you want to send notification to
     * @param $email : Email of the person you want to send notification to
     * @param $content : Content of the notification
     */
    public function insertNotifications($name , $email , $content){
        if(isset($_SESSION['user_id'])){
            $user_id = $_SESSION['user_id'];
        }
        $send_to_id = 0;
        $query = "SELECT id FROM users WHERE user_email = '$email'";
        $result_set = $this->connection->query($query);
        while($row = mysqli_fetch_assoc($result_set)){
            $send_to_id = $row['id'];
        }
        $date = date('Y-m-d H:i:s');
        $default_date = '0000-00-00 00:00:00';
        $is_deleted = 0;
        $is_seen = 0;
        $query = "INSERT INTO notifications(notification_sender_id, notification_receiver_id, notification_message, notification_seen, created_at, updated_at, deleted_at, is_deleted) VALUES (? , ? , ? , ? , ? , ? , ? , ? )";
        $preparedStatement = $this->connection->prepare($query);
        $preparedStatement->bind_param('iisisssi' ,$user_id ,  $send_to_id , $content , $is_seen , $date , $default_date , $default_date , $is_deleted);
        $preparedStatement->execute();
    }


    /**
     * @param $user_id : Current user id ($_SESSION['user_id'])
     * @return $result_set : Result Set of the query
     */
    public function viewUnseenNotifications($user_id){
        $query = "SELECT * FROM notifications WHERE notification_receiver_id = $user_id AND notification_seen = 0 AND is_deleted = 0
";
        $result_set = $this->connection->query($query);
        return $result_set;
    }



    public function getSenderDetails($id){
        $query = "SELECT id , user_name  , user_email FROM users WHERE id = $id AND is_deleted = 0";
        $result_set = $this->connection->query($query);
        return $result_set;
    }

    public function getDataFromNotificationId($notification_id){
        $query = "SELECT * FROM notifications WHERE notification_id = $notification_id";
        $result_set = $this->connection->query($query);
        echo $this->connection->error;
        return $result_set;
    }

    public function setNotificationSeen($notification_id){
        $query = "UPDATE notifications SET notification_seen = 1 WHERE notification_id = $notification_id";
        $result_set = $this->connection->query($query);
        return $result_set;
    }

    public function viewAllNotifications(){
        if(isset($_SESSION['user_id'])){
            $user_id = $_SESSION['user_id'];
        }
        $query = "SELECT * FROM notifications WHERE notification_receiver_id = $user_id AND is_deleted = 0 ORDER BY created_at DESC";
        $result_set = $this->connection->query($query);
        if($this->connection->error){
        	echo $this->connection->error;
        }
        return $result_set;
    }

    public function deleteNotification($notification_id){
    	$date = date('Y-m-d H:i:s');
    	$query = "UPDATE notifications SET deleted_at = '$date' , is_deleted = 1 WHERE notification_id = $notification_id";
    	$result_set = $this->connection->query($query);
    	if($this->connection->error){
        	echo $this->connection->error;
        }
    	return $result_set;
    }

}