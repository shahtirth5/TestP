<?php
require_once ("../classes/database.php");
class Test {
    private $connection;
    public function __construct(){
        global $database;
        $this->connection = $database->getConnection();
    }

    public function getListOfQuestionPapers(){
        $query = "SELECT question_paper_name FROM question_paper GROUP BY created_at DESC";
        $result_set = $this->connection->query($query);
        if($this->connection->error){
            die($this->connection->error);
        }
        return $result_set;
    }
}
?>