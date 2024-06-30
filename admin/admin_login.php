<?php
 
  include "connection.php";
  include "navbar.php";
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
  
  <style type="text/css">
    section {
      margin-top: -20px;
    }
  </style>   
</head>
<body>

<section>
  <div class="log_img">
    <br>
    <div class="box1">
      <h1 style="text-align: center; font-size: 35px; font-family: Lucida Console;">Library Management System</h1>
      <h1 style="text-align: center; font-size: 25px;">Admin Login Form</h1><br>
      <form name="login" action="" method="post">
        <div class="login">
          <input class="form-control" type="text" name="username" placeholder="Username" required=""> <br>
          <input class="form-control" type="password" name="password" placeholder="Password" required=""> <br>
          <input class="btn btn-default" type="submit" name="submit" value="Login" style="color: black; width: 70px; height: 30px"> 
        </div>
        <p style="color: white; padding-left: 15px;">
          <br><br>
          <a style="color: yellow;" href="update_password.php">Forgot password?</a> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
          New to this website?<a style="color: yellow;" href="registration.php">Sign Up</a>
        </p>
      </form>
    </div>
  </div>
</section>

<?php
  if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $stmt = $db->prepare("SELECT * FROM admin WHERE username = ? AND password = ? AND status = 'yes'");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;

    if($count == 0) {
      ?>
      <div class="alert alert-danger" style="width:700px; margin-left: 400px; background-color: red; color: white;">
        <strong style="margin-left: 90px;">The username and password don't match or your account is not approved yet.</strong>
      </div>
      <?php
    } else {
      $_SESSION['admin_user'] = $username;
      ?>
      <script type="text/javascript">
        window.location = "index.php";
      </script>
      <?php
    }
    $stmt->close();
  }
?>

</body>
</html>
