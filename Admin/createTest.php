<html lang="en">
<!-- HEADER -->
<?php require_once ("UIElements/header.php");?>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<?php require_once ("UIElements/navigation.php");?>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Notifications</li>
        </ol>
        <div class="card-body">
        <form>
            <div class="form-group">
                <label for="">Name Of Question Paper</label>
                <input class="form-control" type="text" id="nameOfQuestionPaper">
            </div>
            <div class="form-group">
                <label for="subjectName">Select Subject</label>
                <select name="" id="subjectName" class="form-control">
                    <option value="Java">Java</option>
                </select>
            </div>
    
            <label>Questions</label>
            <div class="d-none">
                <input type="number" id="noOfQuestions" value="1">
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-7">
                        <input type="number" id="addQuestions" class="form-control" value="1">        
                    </div>    
                    <div class="col-5">
                        <button class="btn btn-primary" onclick="addQuestionDiv(event);"><a><i class="fa fa-plus"></i></a></button>       
                    </div>
                </div>
            </div>
            <br><br><br>
            <div id="questions_input">
                <div class='form-group' id="question_1">
                    <div class="row">
                        <div class="col-1 pr-0">1 .</div>
                        <div class="col-11 pl-0">
                            <textarea class='form-control' id="question1" name="question1"></textarea>
                        </div>
                    </div>
                    <div class='row pt-3'>
                        <div class='col-md-6'>
                            <textarea class='form-control' id="option1_1" name="option1_1"></textarea>
                        </div>
                        <div class='col-md-6'>
                            <textarea class='form-control' id="option2_1" name="option2_1"></textarea>
                        </div>
                    </div>
                    <div class='row pt-3'>
                        <div class='col-md-6'>
                            <textarea class='form-control' id="option3_1" name="option3_1"></textarea>
                        </div>
                        <div class='col-md-6'>
                            <textarea class='form-control' id="option4_1" name="option4_1"></textarea>
                        </div>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="answer_radio_1" value="1">Option 1
                        </label>
                    </div>
                    <div class="form-check-inline">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="answer_radio_1" value="2">Option 2
                      </label>
                    </div>
                    <div class="form-check-inline">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="answer_radio_1" value="3">Option 3
                      </label>
                    </div>
                    <div class="form-check-inline">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="answer_radio_1" value="4">Option 4
                      </label>
                    </div>
                    <br><br>
                </div>
            </div>  
        </form>
        <div>
            <button class="btn btn-success" onclick="AddQuestionSetClicked(event);">Add Question Set</button>
        </div>

        </div><!--.card-body-->
</div><!-- .container-fluid -->
</div><!-- .content-wrapper -->
<?php require_once('UIElements/footer.php');?>
</body>
</html>