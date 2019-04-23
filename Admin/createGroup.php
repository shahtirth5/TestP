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

        <form>
            <div class="form-group">
                <label for="group_name">Name : </label>
                <input type="text" id="group_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="group_description">Description : </label>
                <textarea id="group_description" cols="30" rows="5" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="group_members">Members : </label>
                <input type="text" class="form-control input-lg " id="group_members" spellcheck="false">
            </div>
            <button class="btn btn-primary mt-3" id="button_add_group" onclick="BtnAddGroupClicked(event);"> Add Group </button>
            
        </form>
        
</div><!-- .container-fluid -->
</div><!-- .content-wrapper -->
<?php require_once('UIElements/footer.php');?>
</body>
</html>