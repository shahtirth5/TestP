<?php
require_once("../classes/database.php");
$connection = $database->getConnection();
session_start();
if(isset($_SESSION['user_id'])){
    $id = $_SESSION['user_id'];
}
$query = "SELECT test_id, test_name , test_description FROM test WHERE test_creater_id = $id GROUP BY created_at DESC";
$result_set = $connection->query($query);
if($connection->error){
    die("$connection->error");
}
?>
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
            <li class="breadcrumb-item active">Manage Tests</li>
        </ol>
            <div class="card-body">
                    <!-- List Tests -->
                    <h5>Tests</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                            <tr>
                                    <th class="pl-3">Id</th>
                                    <th class="pl-3">Test Name</th>
                                    <th class="pl-3">Description</th>
                                    <th class="pl-3">Time Duration</th>
                                    <th class="pl-5">Start Session</th>
                                    <th class="pl-5">Stop Session</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while($row = mysqli_fetch_assoc($result_set)){
                                $test_id = $row['test_id'];
                                $query = "SELECT session_status FROM test_session WHERE test_id = $test_id";
                                $result = $connection->query($query);
                                if($connection->error){
                                    die("$connection->error");
                                }
                                if($r = mysqli_fetch_assoc($result)){
                                    $session_status = $r['session_status'];
                                }
                            ?>
                            <tr>
                                <td><?php echo $row['test_id'];?></td>
                                <td><?php echo $row['test_name'];?></td>
                                <td><?php echo $row['test_description'];?></td>
                                <td class="form-group">
                                    <input type="text" class="form-control" id="time_<?php echo $row['test_id'];?>">
                                </td>
                                <td>
                                    <a class="btn btn-primary text-white mt-3 ml-3 <?php
                                        if($session_status == 1){
                                            echo "d-none";
                                        }?>" id="btnStartSession<?php echo $row['test_id']?>" onclick="btnStartSessionClicked(event, <?php echo $row['test_id']?>, this)" role="button">Start Test Session</a>
                                    <h5 class="text-success <?php
                                        if($session_status == 0){
                                            echo "d-none";
                                        }?>" id="lblSessionStarted<?php echo $row['test_id']?>">Session Started</h5>
                                </td>
                                <td>
                                    <a class="btn btn-danger text-white mt-3 ml-3"  onclick="btnStopSessionClicked(event, <?php echo $row['test_id']?>, this)" role="button">Stop Test Session</a>
                                </td>
                            </tr>
                            <?php };?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div><!-- .container-fluid -->
</div><!-- .content-wrapper -->
<?php require_once('UIElements/footer.php');?>
</body>
</html>