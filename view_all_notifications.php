<?php
require_once ("classes/Notifications_Class.php");
session_start();
$notifications = new Notifications();
if(isset($_GET['delete_notification'])){
    $delete_notification = $_GET['delete_notification'];
    $notifications->deleteNotification($delete_notification);
    header("Location: view_all_notifications.php");
}
$result_set = $notifications->viewAllNotifications();
function formatDate($oldDate){
    $date = new DateTime($oldDate);
    return $date->format('d F o, h:ia');
}
?>
<html lang="en">
<!-- HEADER -->
<?php require_once("UIElements/header.php"); ?>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<?php require_once("UIElements/navigation.php"); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item">Notifications</li>
            <li class="breadcrumb-item active">
                    <a href="view_all_notifications.php">View Notifications</a>
            </li>
        </ol>
        <div class="card-body">
            <h4>Your Notifications</h4>
        <?php
        $result_set = $notifications->viewAllNotifications();
        while($row = mysqli_fetch_assoc($result_set)){
            extract($row);
            $rs = $notifications->getSenderDetails($notification_sender_id);
            while($row_temp = mysqli_fetch_assoc($rs)) {
                extract($row_temp);
                ?>
                <div class="border-bottom-2 bg-light rounded border mt-3">
                    <div class="p-3">
                        <p><strong><?php echo $user_name; ?></strong></p>
                        <span class="small text-muted"><?php echo formatDate($created_at) ;?></span>
                        <p><a class="text-danger" href="view_all_notifications.php?delete_notification=<?php echo $notification_id;?>"><i class="fa fa-trash"></i> Delete</a></p>
                        <div>
                            <p><?php echo $notification_message ?></p>
                        </div>
                    </div>
                </div>
                <?php
                }
            }
            ?>
        </div><!--.card-body-->
    </div><!-- .container-fluid -->
</div><!-- .content-wrapper -->
<?php require_once('UIElements/footer.php');?>
</body>
</html>