<?php
session_start();
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
            <li class="breadcrumb-item">Notifications</li>
            <li class="breadcrumb-item active">Send Notification</li>
        </ol>
        <div class="card-body">
            <div class="form-group">
                <label>Send To : </label>
                <input type="text" class="form-control input-lg " id="send_notification_send_to" spellcheck="false">
                <label>Message : </label>
                <textarea id="notification-message" cols="30" rows="10" class="form-control mb-3"></textarea>
                <button class="btn btn-primary mt-3" id="button_send_notification" onclick="BtnSendNotificationClicked();">Send</button>
            </div>
            
        </div>
    </div><!-- .container-fluid -->
</div><!-- .content-wrapper -->
<?php require_once('UIElements/footer.php');?>
</body>
</html>