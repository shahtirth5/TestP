<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root."/TestP/classes/database.php");
require_once($root."/TestP/Admin/classes/TestSession_class.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['user_id'])){
    $id = $_SESSION['user_id'];
}

class Test{
    private $connection;
    public function __construct(){
        global $database;
        $this->connection = $database->getConnection();
    }

    public function getQuestions($test_id){
        global $id;
        $test_session = new TestSession();
        $result_set = $test_session->getCurrentTestStatus($test_id , $id);
        if($row = mysqli_fetch_assoc($result_set)){
            $session_status = $row['session_status'];
        }
        if($session_status == 1){
            if(isset($_SESSION['user_id'])){
                $id = $_SESSION['user_id'];
            }
            $test_session_id = $test_session->getTestSession($id , $test_id);
            $query = "SELECT test_json FROM student_test_question_order WHERE test_session_id = $test_session_id";
            $result_set = $this->connection->query($query);
            if($row = mysqli_fetch_assoc($result_set)){
                $shuffled_questions = $row['test_json'];
            }
            return $shuffled_questions;
        } else{
            $temp = "NoSession";
            return $temp;
        }    
    }

    public function updateQuestions($test_id , $user_id , $json){
        $query = "SELECT session_id FROM test_session WHERE test_id = $test_id AND user_id = $user_id";
        $result_set = $this->connection->query($query);
        if($this->connection->error){
            die($this->connection->error);
        }
        while($row = mysqli_fetch_assoc($result_set)){
            $test_session_id = $row['session_id'];           
        }
        $query = "UPDATE student_test_question_order SET test_json = '$json' WHERE test_session_id = $test_session_id";
        $this->connection->query($query);
        if($this->connection->error){
            die($this->connection->error);
        }
        echo "UPDATED SUCCESSFULLY";
    }

    public function storeMarks($test_id , $user_id , $marks_scored , $total_marks){
        $date = date('Y-m-d H:i:s');
        $default_date = '0000-00-00 00:00:00';
        $is_deleted = 0;
        $query = "INSERT INTO marks(test_id, user_id, marks_scored, total_marks, created_at, updated_at, deleted_at, is_deleted) VALUES (? , ? , ? , ? , ? , ? , ? , ? )";
        $preparedStatement = $this->connection->prepare($query);
        $preparedStatement->bind_param('iiiisssi' , $test_id , $user_id, $marks_scored, $total_marks, $date , $default_date , $default_date , $is_deleted);
        $preparedStatement->execute();
        if($preparedStatement->error){
            die($preparedStatement->error);
        }
        echo "SUCCESSFULLY INSERTED";
    }

    public function endTest($test_id , $user_id){
        $query = "UPDATE test_session SET session_status = 0 WHERE test_id = $test_id AND user_id = $user_id";
        $this->connection->query($query);
        if($this->connection->error){
            die($this->connection->error);
        }
        echo "UPDATED SUCCESSFULLY";
    }
}
?>