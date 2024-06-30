<?php
include "connection.php";
include "navbar.php";
?>

<!DOCTYPE html>
<html>
<head>

  <title>Student Registration</title>
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
  <div class="reg_img">
    <div class="box2">
      <h1 style="text-align: center; font-size: 35px;font-family: Lucida Console;"> Library Management System</h1>
      <h1 style="text-align: center; font-size: 25px;">User Registration Form</h1>
      <form name="Registration" action="" method="post">
        <div class="login">
          <input class="form-control" type="text" name="first" placeholder="First Name" required=""> <br>
          <input class="form-control" type="text" name="last" placeholder="Last Name" required=""> <br>
          <input class="form-control" type="text" name="username" placeholder="Username" required=""> <br>
          <input class="form-control" type="password" name="password" placeholder="Password" required=""> <br>
          <input class="form-control" type="text" name="roll" placeholder="Roll No" required=""><br>
          <input class="form-control" type="text" name="email" placeholder="Email" required=""><br>
          <input class="form-control" type="text" name="contact" placeholder="Phone No" required="">
          <input class="btn btn-default" type="submit" name="submit" value="Sign Up" style="color: black; width: 70px; height: 30px; "> 
        </div>
      </form>
    </div>
  </div>
</section>

<?php
if(isset($_POST['submit']))
{
  $username = strtolower($_POST['username']);  // Convert input username to lowercase
  $sql = "SELECT username FROM student WHERE LOWER(username) = '$username'";
  $res = mysqli_query($db, $sql);

  if(mysqli_num_rows($res) == 0)
  {
    $first = $_POST['first'];
    $last = $_POST['last'];
    $password = $_POST['password'];
    $roll = $_POST['roll'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    $query = "INSERT INTO student (first, last, username, password, roll, email, contact) VALUES ('$first', '$last', '$username', '$password', '$roll', '$email', '$contact')";
    mysqli_query($db, $query);
    ?>
    <script type="text/javascript">
      alert("Registration Successful");
    </script>
    <?php
  }
  else
  {
    ?>
    <script type="text/javascript">
      alert("The username already exists");
    </script>
    <?php
  }
}
?>

<footer>
  <p style="color:black; text-align: center;">
    <br>
    <b>Email: Swarnimschool1981@gmail.com</b><br>
    <br>
    <b>Mobile: 977-1-5388919</b>
  </p>
</footer>
</body>
</html>
