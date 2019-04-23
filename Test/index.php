<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once("classes/Test_class.php");
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_SESSION['user_id'])){
        $id = $_SESSION['user_id'];
    }

    if(isset($_GET['test_id'])){
        $test_id =  $_GET['test_id'];
    }

    // echo "Test Id => $test_id </br>";  

    // $test = new Test();
    // $question = $test->getQuestions($test_id);
    // echo "Question : </br>";
    // print_r($question);
    // echo "</br></br>";
    // $abc = json_encode($question);
    // echo $abc;

    // echo "</br> </br> Size of array : ".sizeof($question);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../Assets/vendor/bootstrap/css/bootstrap.min.css">
    <title>Test</title>
</head>
<body>
    <style>
        body{
            /* background : #777; */
        }

        .border-width-thick {
            border-width : thin !important;
            border-radius : 25% !important;
            border-color : #777 !important;
            margin-left : 1px !important;
            margin-right : 1.5px !important;
        }

    </style>
    <div class="container">
        <div class="d-none" id="test_id"><?php echo $test_id;?></div>
        <div class="m-auto" id="timer"></div>
        <div>
            <div id="test"></div>    
        </div>
            <div id=test_question_number>
                <div class="btn-group" data-toggle="buttons"></div>
                <div><button class="btn btn-success" onclick="btnSubmitTestClick(event);"> Submit Test </button></div>
            </div>
        </div>
    </div>
    

    <script src="../Assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="../Assets/vendor/jquery/jquery.min.js"></script>
    <script src="../Assets/vendor/easy-timer/easy-timer.min.js"></script>
    <script src="../Assets/js/my_js/test.js"></script>
</body>
</html>