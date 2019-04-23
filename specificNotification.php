<?php
require_once ("classes/Notifications_Class.php");
session_start();
if(isset($_GET['notification_id'])){
    $notification_id = $_GET['notification_id'];
}
$notifications = new Notifications();
$notifications->setNotificationSeen($notification_id);
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
            <li class="breadcrumb-item active">Notifications</li>
        </ol>
        <div class="card-body">
            <?php

                $result_set = $notifications->getDataFromNotificationId($notification_id);
                $row = mysqli_fetch_assoc($result_set);
                extract($row);
                $rs = $notifications->getSenderDetails($notification_sender_id);
                $row_temp = mysqli_fetch_assoc($rs);
                extract($row_temp);
            ?>
            <div>
                <p><strong><?php echo $user_name;?></strong></p>
                <span class="small text-muted">11:21 AM</span>
                <p><?php echo $notification_message ?></p>
            </div>
        </div><!--.card-body-->
</div><!-- .container-fluid -->
</div><!-- .content-wrapper -->
<?php require_once('UIElements/footer.php');?>
</body>
</html>