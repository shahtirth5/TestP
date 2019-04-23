<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/TestP/classes/database.php");
class TestSession {
    private $connection;
    public function __construct(){
        global $database;
        $this->connection = $database->getConnection();
    }

    public function createSession($test_id , $timer){
        $query = "SELECT user_id FROM test_applicants WHERE test_id = $test_id";
        $result_set = $this->connection->query($query);
        if($this->connection->error){
            die($this->connection->error);
        }
        $date = date('Y-m-d H:i:s');
        $default_date = '0000-00-00 00:00:00';
        $is_deleted = 0;
        $session_status = 1;
        while($row = mysqli_fetch_assoc($result_set)){
            $query = "INSERT INTO test_session(user_id, test_id, session_status, session_timer, created_at, updated_at, deleted_at, is_deleted) VALUES ( ? , ? , ? , ? , ? , ? , ? , ?)";    
            $preparedStatement = $this->connection->prepare($query);
            $preparedStatement->bind_param('iiissssi' , $row['user_id'] , $test_id , $session_status , $timer , $date , $default_date , $default_date , $is_deleted);
            $preparedStatement->execute();
            if($preparedStatement->error){
                die($preparedStatement->error);
            }
        }
    }

    public function stopSession($test_id){
        $query = "UPDATE test_session SET session_status = 0 WHERE test_id = $test_id";
        $this->connection->query($query);
        if($this->connection->error){
            die($this->connection->error);
        }
    }

    public function shuffledTestJson($test_id){
        $query = "SELECT test_question_set FROM test WHERE test_id = $test_id";
        $result_set = $this->connection->query($query);
        if($row = mysqli_fetch_assoc($result_set)){
            $question_set_id = $row['test_question_set'];
        }

        $query = "SELECT * FROM questions WHERE question_id IN (SELECT question_id FROM questionsinquestion_paper WHERE question_paper_id = $question_set_id)";
        $result_set = $this->connection->query($query);
        $question = array();
        while($row = mysqli_fetch_assoc($result_set)){
            $sql = "SELECT option_id,option_text,is_correct FROM options WHERE question_id = " . $row['question_id'];
            $rs = $this->connection->query($sql);
            $i = 1;
            $option = array();
            while($r = mysqli_fetch_assoc($rs)){
                extract($r);
                if($is_correct == 1){
                    $x = array("option_id" => $option_id , "option" => $option_text , "is_correct" => "1");
                } else{
                    $x = array("option_id" => $option_id , "option" => $option_text , "is_correct" => "0");
                }
                $i++;
                array_push($option , $x);
            }
            array_push($question , array("Question_id" => $row['question_id'] , "Question" => $row['question_text'] , "Options" => $option , "Selected_Option" => -1));
        }
        shuffle($question);
        $json = json_encode($question);
        return $json;
    }

    public function getCurrentTestStatus($test_id , $user_id){
        $query = "SELECT session_status FROM test_session WHERE test_id = $test_id AND user_id = $user_id";
        $result_set = $this->connection->query($query);
        if($this->connection->error){
            die($this->connection->error);
        }
        return $result_set;
    }

    public function getTimeLeft($test_id , $id){
        $query = "SELECT session_timer FROM test_session WHERE test_id = $test_id AND user_id = $id";
        $result_set = $this->connection->query($query);
        if($this->connection->error){
            die($this->connection->error);
        }
        if($row = mysqli_fetch_assoc($result_set)){
            $time_left = $row['session_timer'];
        }
        return $time_left;
    }

    public function updateTimer($test_id , $id , $current_time){
        $query = "UPDATE test_session SET session_timer = $current_time WHERE test_id = $test_id AND user_id = $id";
        $result_set = $this->connection->query($query);
        if($this->connection->error){
            die($this->connection->error);
        }
    }

    public function getTestSessions($test_id){
        $query = "SELECT session_id FROM test_session WHERE test_id = $test_id"; //AND user_id = $user_id";
        $result_set = $this->connection->query($query);
        if($this->connection->error){
            die($this->connection->error);
        }
        return $result_set;
    }

    public function getTestSession($user_id , $test_id){
        $query = "SELECT session_id FROM test_session WHERE test_id = $test_id AND user_id = $user_id";
        $result_set = $this->connection->query($query);
        if($this->connection->error){
            die($this->connection->error);
        }
        if($row = mysqli_fetch_assoC($result_set)){
            return $row['session_id'];
        }
    }

    public function insertQuestionOrder($test_session_id , $json ){
        $query = "INSERT INTO student_test_question_order(test_session_id , test_json) VALUES (? , ?)";
        $preparedStatement = $this->connection->prepare($query);
        $preparedStatement->bind_param('is' , $test_session_id , $json);
        $preparedStatement->execute();
        if($preparedStatement->error){
            die($preparedStatement->error);
        }
    }
}
?>