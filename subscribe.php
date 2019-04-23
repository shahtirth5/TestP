<?php
require_once ("classes/Subscriptions_class.php");
session_start();
$subscription = new Subscriptions();

if(isset($_GET['delete'])){
    $sub_admin_id = $_GET['delete'];
    $subscription->deleteSubscriptions($sub_admin_id);
    header("Location: subscribe.php");
}

if(isset($_GET['subscribe'])){
    $sub_admin_id = $_GET['subscribe'];
    $subscription->insertSubscription($sub_admin_id);
    header("Location: subscribe.php");
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
            <li class="breadcrumb-item active">Subscribe</li>
        </ol>
<!-- Table -->
<!--        <div class="card mb-3">-->
<!--            <div class="card-header">-->
<!--                <i class="fa fa-table"></i> Data Table Example</div>-->
            <div class="card-body">
                <!-- ALREADY SUBSCRIBED  -->
                <h5>Your Subscriptions</h5>
                <?php
                    $result_set = $subscription->getSubscribedAuthorities();
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                        <tr>
                            <th>Id</th>
                            <th>Authority</th>
                            <th>Description</th>
                            <th>UnSubscribe</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result_set)){
                            extract($row);
                        ?>
                            <tr>
                                <td><?php echo $id;?></td>
                                <td><?php echo $user_name;?></td>
                                <td><?php echo $user_description;?></td>
                                <td>
                                   <a class='btn btn-danger' href='subscribe.php?delete=<?php echo $id;?>'><span class = 'fa fa-times'></span></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>  

            <div class="card-body">
                    <!-- CAN SUBSCRIBE  -->
                    <h5>Also Subscribe</h5>
                    <?php
                    $result_set = $subscription->getSubscriptionSuggestion();
                    ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Authority</th>
                                <th>Description</th>
                                <th>Subscribe</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            while ($row = mysqli_fetch_assoc($result_set)){
                                extract($row);?>
                                <tr>
                                    <td><?php echo $id;?></td>
                                    <td><?php echo $user_name;?></td>
                                    <td><?php echo $user_description;?></td>
                                    <td>
                                       <a class='btn btn-success' href='subscribe.php?subscribe=<?php echo $id;?>'><span class = 'fa fa-check'></span></a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
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