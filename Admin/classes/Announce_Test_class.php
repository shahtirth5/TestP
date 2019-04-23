<?php
require_once ("classes/database.php");
class Announce_Test {
    private $connection;
    public function __construct(){
        global $database;
        $this->connection = $database->getConnection();
    }
    public function insertTest($test_name , $test_question_set , $test_description , $test_notification , $test_applicants){
        if(isset($_SESSION['user_id'])){
            $id = $_SESSION['user_id']; 
        }
        $test_applicant_id = 0;
        $query = "SELECT question_paper_id FROM question_paper WHERE question_paper_name='$test_question_set'";
        $result_set = $this->connection->query($query);
        if($this->connection->error){
            die($this->connection->error);
        }
        if($row = mysqli_fetch_assoc($result_set)){
            $question_paper_id = $row['question_paper_id'];
        }
        $date = date('Y-m-d H:i:s');
        $default_date = '0000-00-00 00:00:00';
        $is_deleted = 0;
        $query = "INSERT INTO test(test_name, test_description, test_question_set, test_creater_id, created_at, updated_at, deleted_at, is_deleted) VALUES( ? , ? , ? , ? , ? , ? , ? , ? )";
        $preparedStatement = $this->connection->prepare($query);
        $preparedStatement->bind_param('ssiisssi' , $test_name , $test_description , $question_paper_id , $id , $date , $default_date , $default_date , $is_deleted );
        $preparedStatement->execute();
        if($preparedStatement->error){
            die($preparedStatement->error);
        }
        $test_id = $preparedStatement->insert_id;
        $append_notification = "<p><a class='btn btn-primary' href='Test/index.php?test_id=".(string)$test_id."'>Give Test</a></p>";

        for($i = 0 ; $i < sizeof($test_applicants) ; $i++)
        {
            $name = $test_applicants[$i][0];
            $email = $test_applicants[$i][1];

            $query = "SELECT id FROM users WHERE user_email like '$email'";
            $result_set = $this->connection->query($query);
            print_r($result_set);
            if($this->connection->error)
            {
                die($this->connection->error);
            }

            if($row = mysqli_fetch_assoc($result_set))
            {
                $test_applicant_id = $row['id'];
            }

            $query = "INSERT INTO test_applicants(test_id, user_id) VALUES (? , ?)";
            $preparedStatement = $this->connection->prepare($query);
            $preparedStatement->bind_param('ii' , $test_id , $test_applicant_id);
            $preparedStatement->execute();
            if($preparedStatement->error){
                die($preparedStatement->error);
            }

            $date = date('Y-m-d H:i:s');
            $default_date = '0000-00-00 00:00:00';
            $is_deleted = 0;
            $is_seen = 0;
            $notification = $test_notification.$append_notification;
            $query = "INSERT INTO notifications(notification_sender_id, notification_receiver_id, notification_message, notification_seen, created_at, updated_at, deleted_at, is_deleted) VALUES ( ? ,  ? , ? , ? , ? , ? , ? , ?)";
            $preparedStatement = $this->connection->prepare($query);
            $preparedStatement->bind_param('iisisssi' , $id , $test_applicant_id , $notification , $is_seen , $date  , $default_date , $default_date , $is_deleted);
            $preparedStatement->execute();
            if($preparedStatement->error){
                die($preparedStatement->error);
            }
        }

    }
}

?>