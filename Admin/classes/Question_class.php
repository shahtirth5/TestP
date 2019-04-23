<?php
   require_once ("classes/database.php");
   class Question {
       private $connection;
       public function __construct(){
           global $database;
           $this->connection = $database->getConnection();
       }

       public function insertQuestionPaper($name , $subject){
            $date = date('Y-m-d H:i:s');
            $default_date = '0000-00-00 00:00:00';
            $is_deleted = 0;
            $query = "INSERT INTO question_paper(question_paper_name, question_paper_subject, created_at, updated_at, deleted_at, is_deleted) VALUES (? , ? , ? , ? , ? , ?)";
            $preparedStatement = $this->connection->prepare($query);
            $preparedStatement->bind_param('sssssi' , $name , $subject, $date, $default_date, $default_date, $is_deleted);
            $preparedStatement->execute();
            if($preparedStatement->error){
                die($preparedStatement->error);
            }
            return $preparedStatement->insert_id;
       }

        public function insertQuestionsAndLinkThemToQuestionPaper($question_paper_id , $question , $option1 , $option2 , $option3 , $option4 , $answer){
            $date = date('Y-m-d H:i:s');
            $default_date = '0000-00-00 00:00:00';
            $is_deleted = 0;
            /******************************* INSERTING QUESTION ******************************************************/
            $query = "INSERT INTO questions(question_text, created_at, updated_at, deleted_at, is_deleted) VALUES (? , ? , ? , ? , ?)";
            $preparedStatement = $this->connection->prepare($query);
            $preparedStatement->bind_param('ssssi' , $question , $date , $default_date , $default_date , $is_deleted);
            $preparedStatement->execute();
                if($preparedStatement->error){
                    die($preparedStatement->error);
                }
            $question_id = $preparedStatement->insert_id;
            /*********************************************************************************************************/
            /******************************* INSERTING OPTIONS ******************************************************/
            #region insertingOptions
            $query = "INSERT INTO options(question_id, option_text, is_correct, created_at, updated_at, deleted_at, is_deleted) VALUES ( ? , ? , ? , ? , ? , ? , ? )";
            $preparedStatement = $this->connection->prepare($query);
            /**/
            if($answer === "1"){
                /** Option 1 **/
                $isCorrect = 1;
                $preparedStatement->bind_param('isisssi' , $question_id , $option1 , $isCorrect , $date , $default_date , $default_date , $is_deleted);
                $preparedStatement->execute();
                    if($preparedStatement->error){
                        die($preparedStatement->error);
                    }
                /** Option 2 **/
                $isCorrect = 0;
                $preparedStatement->bind_param('isisssi' , $question_id , $option2 , $isCorrect , $date , $default_date , $default_date , $is_deleted);
                $preparedStatement->execute();
                    if($preparedStatement->error){
                        die($preparedStatement->error);
                    }
                /** Option 3 **/
                $preparedStatement->bind_param('isisssi' , $question_id , $option3 , $isCorrect , $date , $default_date , $default_date , $is_deleted);
                $preparedStatement->execute();
                    if($preparedStatement->error){
                        die($preparedStatement->error);
                    }
                /** Option 4 **/
                $preparedStatement->bind_param('isisssi' , $question_id , $option4 , $isCorrect , $date , $default_date , $default_date , $is_deleted);
                $preparedStatement->execute();
                    if($preparedStatement->error){
                        die($preparedStatement->error);
                    }
            } else if($answer == "2"){
                /** Option 1 **/
                $isCorrect = 0;
                $preparedStatement->bind_param('isisssi' , $question_id , $option1 , $isCorrect , $date , $default_date , $default_date , $is_deleted);
                $preparedStatement->execute();
                    if($preparedStatement->error){
                        die($preparedStatement->error);
                    }
                /** Option 2 **/
                $isCorrect = 1;
                $preparedStatement->bind_param('isisssi' , $question_id , $option2 , $isCorrect , $date , $default_date , $default_date , $is_deleted);
                $preparedStatement->execute();
                    if($preparedStatement->error){
                        die($preparedStatement->error);
                    }
                /** Option 3 **/
                $isCorrect = 0;
                $preparedStatement->bind_param('isisssi' , $question_id , $option3 , $isCorrect , $date , $default_date , $default_date , $is_deleted);
                $preparedStatement->execute();
                    if($preparedStatement->error){
                        die($preparedStatement->error);
                    }
                /** Option 4 **/
                $preparedStatement->bind_param('isisssi' , $question_id , $option4 , $isCorrect , $date , $default_date , $default_date , $is_deleted);
                $preparedStatement->execute();
                    if($preparedStatement->error){
                        die($preparedStatement->error);
                    }
            } else if($answer == "3"){
                /** Option 1 **/
                $isCorrect = 0;
                $preparedStatement->bind_param('isisssi' , $question_id , $option1 , $isCorrect , $date , $default_date , $default_date , $is_deleted);
                $preparedStatement->execute();
                    if($preparedStatement->error){
                        die($preparedStatement->error);
                    }
                /** Option 2 **/
                $isCorrect = 0;
                $preparedStatement->bind_param('isisssi' , $question_id , $option2 , $isCorrect , $date , $default_date , $default_date , $is_deleted);
                $preparedStatement->execute();
                    if($preparedStatement->error){
                        die($preparedStatement->error);
                    }
                /** Option 3 **/
                $isCorrect = 1;
                $preparedStatement->bind_param('isisssi' , $question_id , $option3 , $isCorrect , $date , $default_date , $default_date , $is_deleted);
                $preparedStatement->execute();
                    if($preparedStatement->error){
                        die($preparedStatement->error);
                    }
                /** Option 4 **/
                $isCorrect = 0;
                $preparedStatement->bind_param('isisssi' , $question_id , $option4 , $isCorrect , $date , $default_date , $default_date , $is_deleted);
                $preparedStatement->execute();
                    if($preparedStatement->error){
                        die($preparedStatement->error);
                    }
            } else if($answer == "4"){
                /** Option 1 **/
                $isCorrect = 0;
                $preparedStatement->bind_param('isisssi' , $question_id , $option1 , $isCorrect , $date , $default_date , $default_date , $is_deleted);
                $preparedStatement->execute();
                    if($preparedStatement->error){
                        die($preparedStatement->error);
                    }
                /** Option 2 **/
                $isCorrect = 0;
                $preparedStatement->bind_param('isisssi' , $question_id , $option2 , $isCorrect , $date , $default_date , $default_date , $is_deleted);
                $preparedStatement->execute();
                    if($preparedStatement->error){
                        die($preparedStatement->error);
                    }
                /** Option 3 **/
                $isCorrect = 0;
                $preparedStatement->bind_param('isisssi' , $question_id , $option3 , $isCorrect , $date , $default_date , $default_date , $is_deleted);
                $preparedStatement->execute();
                    if($preparedStatement->error){
                        die($preparedStatement->error);
                    }
                /** Option 4 **/
                $isCorrect = 1;
                $preparedStatement->bind_param('isisssi' , $question_id , $option4 , $isCorrect , $date , $default_date , $default_date , $is_deleted);
                $preparedStatement->execute();
                    if($preparedStatement->error){
                        die($preparedStatement->error);
                    }
            }
            #endregion
            /*********************************************************************************************************/

            $query = "INSERT INTO questionsinquestion_paper(question_paper_id, question_id) VALUES (? , ?)";
            $preparedStatement = $this->connection->prepare($query);
            $preparedStatement->bind_param('ii' , $question_paper_id , $question_id);
            $preparedStatement->execute();
            if($preparedStatement->error){
                die($preparedStatement->error);
            }
       }
    }
?>