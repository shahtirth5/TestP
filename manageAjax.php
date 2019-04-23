<?php
session_start();
require_once ("classes/Login_class.php");
require_once ("classes/Notifications_Class.php");
require_once ("Admin/classes/Question_class.php");
require_once ("classes/Register_class.php");
require_once ("Admin/classes/Groups_class.php");
// require_once ("Admin/Classes/Test_class.php");
require_once ("Admin/classes/Announce_Test_class.php");
require_once ("Admin/classes/TestSession_class.php");
require_once ("Test/classes/Test_class.php");
if(isset($_SESSION['user_id'])){
    $id = $_SESSION['user_id'];
}

if(isset($_POST['manage'])){
    if($_POST['manage'] === "login"){
        $email = $_POST['login-email'];
        $password = $_POST['login-password'];
        $login = new Login();
        $validation = $login->validate($email , $password);
        echo $validation;
    } 

    // register_first_name="+first_name+"&register_last_name="+last_name+"&register_email="+email+"&register_password="+password+"&manage=register
    elseif($_POST['manage'] === "register"){
        $first_name = $_POST['register_first_name'];
        $last_name = $_POST['register_last_name'];
        $email = $_POST['register_email'];
        $password = $_POST['register_password'];
        $register = new Register();
        $register->registerEntry($first_name , $last_name , $email , $password);
    }

    elseif($_POST['manage'] === 'send_notification_send_to'){
    	$searchString = $_POST['send_to'];
        $notification  = new Notification();
    	$result_set = $notification->getNotificationendTo($searchString);
    	$json = array();
        while($row = mysqli_fetch_assoc($result_set)) {
            extract($row);
            $send = $user_name . " <" . $user_email . ">";
            array_push($json, $send);
        }

        echo json_encode($json);
    }

    elseif($_POST['manage'] === 'notifications'){
        $temp = $_POST['notification_send_to'];
        $content = $_POST['notification_content'];
        $sendToArray = json_decode($temp);
        for($i = 0 ; $i < sizeof($sendToArray) ; $i++){
            $index_value = $sendToArray[$i]->value;
            $array = parseSendToString($index_value);
            $notification = new Notifications();
            $notification->insertNotification($array[0] , $array[1] , $content);
        }
    }

    // nameOfQuestionPaper="+questionPaperName+"questionPaperSubject"+subject+"&manage=insertQuestionPaper
    elseif($_POST['manage'] === "insertQuestionPaper"){
        $questionPaperName = $_POST['nameOfQuestionPaper'];
        $subject = $_POST['questionPaperSubject'];
        $question = new Question();
        $x = $question->insertQuestionPaper($questionPaperName , $subject);
        echo $x;
    }

    // question_paper_id="+questionPaperId+"&question="+question+"&option1="+option1+"&option2="+option2+"&option3="+option3+"&option4="+option4+"&answer="+answer+"&manage=insertQuestions
    elseif($_POST['manage'] === "insertQuestions"){
        $question_paper_id = $_POST['question_paper_id'];
        $question = $_POST['question'];
        $option1 = $_POST['option1'];
        $option2 = $_POST['option2'];
        $option3 = $_POST['option3'];
        $option4 = $_POST['option4'];
        $answer = $_POST['answer'];

        $question_object = new Question();
        $question_object->insertQuestionsAndLinkThemToQuestionPaper($question_paper_id , $question , $option1 , $option2 , $option3 , $option4 , $answer);
    }


    /******************* Logout ***************************/
    elseif($_POST['manage'] === "admin_logout"){
        session_destroy();
        echo "../login.php";
        // header("Location: login.php");
    }

    elseif($_POST['manage'] === "user_logout"){
        session_destroy();
        echo "login.php";
    }
    /****************************************************/

    /********** Groups **********************************/
    elseif($_POST['manage'] === "group_members"){
        // $_POST['group_members'] = request.term;
        // $_POST['manage'] = 'group_members';
        $searchString = $_POST['members'];
        $group = new Group();
        $result_set = $group->getSubscribedUsers($searchString);
        $json = array();
        while($row = mysqli_fetch_assoc($result_set)) {
            extract($row);
            $send = $user_name . " <" . $user_email . ">";
            array_push($json, $send);
        }
        echo json_encode($json);
    }

    elseif($_POST['manage'] === "add_group"){
        //"groupMembers=" + group_members + "&group_name=" + group_name + "&group_description=" + group_description +"&manage=add_group"
        $group_name = $_POST['group_name'];
        $group_description = $_POST['group_description'];
        $group_members = $_POST['groupMembers'];
        $groupMembers = json_decode($group_members); 
        $group = new Group();
        $group_id = $group->insertGroup($group_name , $group_description);
        for($i = 0 ; $i < sizeof($groupMembers) ; $i++){
            $index_value = $groupMembers[$i]->value;
            $array = parseSendToString($index_value);
            $group->insertGroupMember($array[0] , $array[1] , $group_id);
        }
    }
    /****************************************************************/

    /*************** Announce Test ***********************/
    // $_POST['group'] = request.term;
    // $_POST['manage'] = 'test_groups';
    elseif($_POST['manage'] === 'test_groups'){
        $group_search = $_POST['group'];
        $group = new Group();
        $result_set = $group->getGroupsFromSearch($group_search);
        $json = array();
        while($row = mysqli_fetch_assoc($result_set)){
            extract($row);
            array_push($json , $group_name);
        }
        echo json_encode($json);
    }

    // 'group_name='+$token_value+'&manage=addGroupMembers'
    elseif($_POST['manage'] === 'addGroupMembers'){
        $group_name = $_POST['group_name'];
        if($group_name === ""){
            echo "";
        }else{
            $group = new Group();
            $result_set = $group->getGroupIdFromGroupName($group_name);
            if(mysqli_num_rows($result_set) <= 0){
                die("");
            }
            if($row = mysqli_fetch_assoc($result_set)){
                $id = $row['group_id'];
            }
            $string = "";
            $result_set = $group->getUsernameEmailFromGroupId($id);
            while($row = mysqli_fetch_assoc($result_set)){
                extract($row);
                $string .= $user_name." <".$user_email.">,";
            }     
            echo $string;   
        }
    }
    /*********************INSERT TEST*******************************************/
    // "test_name="+test_name+"&test_question_set="+test_question_set+"&test_description="+test_description+"&test_applicants"+test_applicants+"&test_notification="+test_notification+"&manage=announce_test"
    else if($_POST['manage'] === 'announce_test')
    {
        $test_name = $_POST['test_name'];
        $test_question_set = $_POST['test_question_set'];
        $test_description = $_POST['test_description'];
        $temp  = $_POST['test_applicants'];
        $test_applicants_temp = preg_split("/,/" , $temp);
        $test_applicants = array();
        for($i = 0 ; $i < sizeof($test_applicants_temp) ; $i++){
            array_push($test_applicants , parseSendToString($test_applicants_temp[$i]));
        }
        $test_notification = $_POST['test_notification'];
        $test_announcement = new Announce_Test();
        $test_announcement->insertTest($test_name , $test_question_set , $test_description , $test_notification , $test_applicants);
    }

    //data : "test_id="+test_id+"&timer="+value+"&manage=test_session"
    else if($_POST['manage'] === 'test_session_start'){
        $test_id = $_POST['test_id'];
        $timer = $_POST['timer'];
        $test_session = new TestSession();
        $test_session->createSession($test_id , $timer);
        $result_set = $test_session->getTestSessions($test_id);
        while($row = mysqli_fetch_assoc($result_set)){
            $json = $test_session->shuffledTestJson($test_id);
            $test_session_id = $row['session_id'];
            $test_session->insertQuestionOrder($test_session_id , $json);
        }
        echo "DONE";
    }

    else if($_POST['manage'] === 'test_session_stop'){
        $test_id = $_POST['test_id'];
        $test_session = new TestSession();
        $test_session->stopSession($test_id);
    }
    /****************************************************************/

    /********************* For Test UI ********************/
    //"test_id="+test_id
    else if($_POST['manage'] === 'test_questions_json'){
        $test_id = $_POST['test_id'];
        $test = new Test();
        $question_array = $test->getQuestions($test_id);
        echo( $question_array );
    }
    //"test_id="+$test_id+"manage=test_time_left"
    else if($_POST['manage'] === 'test_time_left'){
        $test_id = $_POST['test_id'];
        $test_session = new TestSession();
        $time_left = $test_session->getTimeLeft($test_id , $id); 
        echo $time_left;
    }

    //"test_id="+test_id+"&current_time="+timeInSeconds+"&manage=test_update_timer"
    else if($_POST['manage'] === 'test_update_timer'){
        $test_id = $_POST['test_id'];
        $time = $_POST['current_time'];
        $test_session = new TestSession();
        $test_session->updateTimer($test_id , $id , $time); 
    }

    //"question_json="+json+"&test_id="+test_id+"&manage=question_answer_submitted"
    else if($_POST['manage'] === 'question_answer_submitted'){
        $test_id = $_POST['test_id'];
        $json = $_POST['question_json'];
        $test = new Test();
        $test->updateQuestions($test_id , $id , $json);
    }
    
    
    // "test_id="+test_id+"&marks_scored="+marks_scored+"&total_marks="+totalMarks+"&manage=store_marks",
    else if($_POST['manage'] === 'store_marks'){
        $test_id = $_POST['test_id'];
        $marks_scored = $_POST['marks_scored'];
        $total_marks = $_POST['total_marks'];
        $test = new Test();
        $test->storeMarks($test_id , $id , $marks_scored , $total_marks);
    }

    // "test_id="+test_id+"manage=end_test",
    else if($_POST['manage'] === 'end_test'){
        $test_id = $_POST['test_id'];
        $test = new Test();
        $test->endTest($test_id , $id);
    }
    /****************************************************************/
}

function parseSendToString($string){
    $a = preg_split("/</" , $string);
    $array = Array(rtrim($a[0] , " ") , rtrim($a[1] , ">"));
    return $array;
}

