<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>SB Admin - Start Bootstrap Template</title>
  <!-- Bootstrap core CSS-->
  <link href="Assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template-->
  <link href="Assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  <!--  Toastr -->
  <link href="Assets/vendor/toastr/css/toastr.min.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="Assets/css/layout.css" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Register an Account</div>
      <div class="card-body">
        <form>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="register_first_name">First name</label>
                <input class="form-control" id="register_first_name" type="text" aria-describedby="nameHelp" placeholder="Enter first name">
                <div id="register_first_name_div"></div>
              </div>
              <div class="col-md-6">
                <label for="register_last_name">Last name</label>
                <input class="form-control" id="register_last_name" type="text" aria-describedby="nameHelp" placeholder="Enter last name">
                <div id="register_last_name_div"></div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="register_email">Email address</label>
            <input class="form-control" id="register_email" type="email" aria-describedby="emailHelp" placeholder="Enter email">
            <div id="register_email_div"></div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="register_password">Password</label>
                <input class="form-control" id="register_password" type="password" placeholder="Password">
                <div id="register_password_div"></div>
              </div>
              <div class="col-md-6">
                <label for="register_confirm_password">Confirm password</label>
                <input class="form-control" id="register_confirm_password" type="password" placeholder="Confirm password">
                <div id="register_confirm_password_div"></div>
              </div>
            </div>
          </div>
          <a class="btn btn-primary btn-block text-white" onclick="btnRegisterClicked(event);">Register</a>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="login.php">Login Page</a>
          <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="Assets/vendor/jquery/jquery.min.js"></script>

  <script src="Assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Toastr -->
  <script src="Assets/vendor/toastr/js/toastr.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="Assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!--  My Script -->
  <script src="Assets/js/my_js/script.js"></script>

</body>

</html>