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
            <li class="breadcrumb-item active">Announce Test</li>
        </ol>

        <form>
            <div class="form-group">
                <label for="test_name"> Test Name : </label>
                <input type="text" id="test_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="questionPaper">Select Question Set : </label>
                <select class="form-control" id="questionPaper">
                <!-- Fetching Question Paper List -->
                <?php
                    require_once ("classes/Test_class.php");
                    $test = new Test();
                    $result_set = $test->getListOfQuestionPapers();
                    while($row = mysqli_fetch_assoc($result_set)){
                        extract($row);
                ?>
                    <option><?php echo $question_paper_name;?></option>  
                <?php }?>
                </select>
            </div>
            <div class="form-group">
                <label for="test_description">Description : </label>
                <textarea id="test_description" cols="30" rows="5" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="test_notification">Announcement Message : </label>
                <textarea id="test_notification" cols="30" rows="5" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="test_groups">Groups (If Any) : </label>
                <input type="text" class="form-control input-lg " id="test_groups" spellcheck="false">
            </div>
            <div class="form-group">
                <label for="test_applicants">Members : </label>
                <input type="text" class="form-control input-lg " id="test_applicants" spellcheck="false">
            </div>
            <button class="btn btn-info mt-3" id="btnAnnounceTest" onclick="btnAnnounceTestClicked(event);"> Announce Test </button>    
        </form>
         
</div><!-- .container-fluid -->
</div><!-- .content-wrapper -->
<?php require_once('UIElements/footer.php');?>
</body>
</html>