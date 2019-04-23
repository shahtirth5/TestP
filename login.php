<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>TestP | Login</title>
  <!-- Bootstrap core CSS-->
  <link href="Assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="Assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="Assets/css/layout.css" rel="stylesheet">
    <!-- My Css -->
    <link rel="stylesheet" href="Assets/css/styles.css">


</head>

<body class="bg-dark">
  <div class="container">
	<div class="card card-login mx-auto mt-5">
	  <div class="card-header">Login</div>
	  <div class="card-body">
		<form id="login-form" method="post">
		  <div class="form-group">
			<label for="login-email">Email address</label>
			<input class="form-control" id="login-email" type="email" name="login-email" placeholder="Enter email">
			  <div id="login-email-div"></div>
		  </div>
		  <div class="form-group">
			<label for="login-password">Password</label>
			<input class="form-control" id="login-password" name="login-password" type="password" placeholder="Password">
			  <div id="login-password-div"></div>
		  </div>
		  <div class="form-group">
			<div class="form-check">
			  <label class="form-check-label">
				<input class="form-check-input" type="checkbox"> Remember Password</label>
			</div>
		  </div>
			<button class="btn btn-primary btn-block" name="login-button" onClick="LoginButtonClicked(event);">Login</button>
		</form>
		<div class="text-center">
		  <a class="d-block small mt-3" href="register.php">Register an Account</a>
		  <a class="d-block small" href="#">Forgot Password?</a>
		</div>
	  </div>
	</div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="Assets/vendor/jquery/jquery.min.js"></script>
  <script src="Assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="Assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <!--  My Script -->
  <script src="Assets/js/my_js/script.js"></script>
  <?php
  require_once ("classes/Login_class.php");
  if(isset($_POST['login-email'])){
        $email = $_POST['login-email'];
        $login = new Login();
        $result_set = $login->getCredentials($email);
        $row = mysqli_fetch_assoc($result_set);
        extract($row);
        session_start();
        $_SESSION['user_id'] = $id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $user_name;
        if($user_role === "Admin"){
            header("Location: Admin/index.php");
        } else {
            header("Location: index.php");
        }
  }
  ?>
</body>

</html>
