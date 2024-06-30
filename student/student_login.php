<?php
include "connection.php";
include "navbar.php";
?>
<!DOCTYPE html>
<html>
<head>

  <title>Student Login</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
  
  <style type="text/css">
    section
    {
      margin-top: -20px;
    }
  </style>   
</head>
<body>

   <!--  <nav class="navbar navbar-inverse">
      <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand active">ONLINE LIBRARY MANAGEMENT SYSTEM</a>
          </div>
          <ul class="nav navbar-nav">
            <li><a href="index.php">HOME</a></li>
            <li><a href="books.php">BOOKS</a></li>
            <li><a href="feedback.php">FEEDBACK</a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right">

            <li><a href="student_login.php"><span class="glyphicon glyphicon-log-in">LOGIN</span></a></li>
            <li><a href="student_login.php"><span class="glyphicon glyphicon-log-out">LOGOUT</span></a></li>
            <li><a href="registration.php"><span class="glyphicon glyphicon-user">SIGNUP</span></a></li>
          </ul>

      </div>
    </nav> -->

<section>
  <div class="log_img">
   <br>
    <div class="box1">
        <h1 style="text-align: center; font-size: 35px;font-family: Lucida Console;">Library Management System</h1>
        <h1 style="text-align: center; font-size: 25px;">User Login Form</h1><br>
      <form  name="login" action="" method="post">
        
        <div class="login">
          <input class="form-control" type="text" name="username" placeholder="Username" required=""> <br>
          <input class="form-control" type="password" name="password" placeholder="Password" required=""> <br>
          <input class="btn btn-default" type="submit" name="submit" value="Login" style="color: black; width: 70px; height: 30px"> 
        </div>
      
      <p style="color: white; padding-left: 15px;">
        <br><br>
        <a style="color:yellow; text-decoration: none;" href="update_password.php">Forgot password?</a> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
        New to this website?<a style="color: yellow;text-decoration: none;" href="registration.php">Sign Up</a>
      </p>
    </form>
    </div>
  </div>
</section>

<?php
  if(isset($_POST['submit']))
  {
    $count=0;
    $res=mysqli_query($db,"SELECT * FROM `student` WHERE username='$_POST[username]' && password='$_POST[password]';");
    $count=mysqli_num_rows($res);

    if($count==0)
    {
      ?>
      <!-- <script type="text/javascript">
          alert("The username and password doesn't match.");
      </script> -->

      <div class="alert alert-danger" style="width:700px; margin-left: 400px; background-color: red; color: white;">
        <strong style="margin-left: 175px;">
          The username and password doesn't match.
        </strong>
      </div>
      <?php
    }
    else
    {
      $_SESSION['login_user']=$_POST['username'];

      ?>
        <script type="text/javascript">
          window.location="index.php";
        </script>
      <?php
    }
  }

?>

</body>
</html>