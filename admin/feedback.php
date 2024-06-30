<?php
  include "navbar.php";
  include "connection.php";
  
?>

<!DOCTYPE html>
<html>
<head>
  <title>Feedback</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
  <style type="text/css">
    body {
      background-image: url("images/4.jpg");
    }
    .wrapper {
      padding: 10px;
      margin: -20px auto;
      width: 900px;
      height: 600px;
      background-color: black;
      opacity: .9;
      color: white;
    }
    .form-control {
      height: 70px;
      width: 60%;
    }
    .scroll {
      width: 100%;
      height: 350px;
      overflow: auto;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <h4>If you have any suggestions or questions, please comment below.</h4>
    
    <?php
      if(isset($_SESSION['admin_user'])) {
        // User is logged in, show comment form and comments
        echo '
        <form action="" method="post">
          <input class="form-control" type="text" name="comment" placeholder="Write something..."><br>  
          <input class="btn btn-default" type="submit" name="submit" value="Comment" style="width: 100px; height: 35px;">    
        </form>
        ';
        echo '<br><br>';
        echo '<div class="scroll">';
        
        if(isset($_POST['submit'])) {
          $username = $_SESSION['admin_user'];
          $comment = mysqli_real_escape_string($db, $_POST['comment']);
          $sql = "INSERT INTO `comments` (username, comment) VALUES ('$username', '$comment')";
          
          if(mysqli_query($db, $sql)) {
            $q = "SELECT * FROM `comments` ORDER BY `id` DESC";
            $res = mysqli_query($db, $q);

            echo "<table class='table table-bordered'>";
            while ($row = mysqli_fetch_assoc($res)) {
              echo "<tr>";
              echo "<td>"; echo $row['username']; echo "</td>";
              echo "<td>"; echo $row['comment']; echo "</td>";
              echo "</tr>";
            }
            echo "</table>";
          }
        } else {
          $q = "SELECT * FROM `comments` ORDER BY `id` DESC";
          $res = mysqli_query($db, $q);

          echo "<table class='table table-bordered'>";
          while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>";
            echo "<td>"; echo $row['username']; echo "</td>";
            echo "<td>"; echo $row['comment']; echo "</td>";
            echo "</tr>";
          }
          echo "</table>";
        }
        
        echo '</div>';
      } else {
        // User is not logged in, show a message
        echo '<p><h2>Please <a href="admin_login.php">login</a> to comment and view comments.</h2></p>';
      }
    ?>
  </div>
</body>
</html>
