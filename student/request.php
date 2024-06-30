<?php
  include "connection.php";
  include "navbar.php";
?>

<!DOCTYPE html>
<html>
<head>
  <title>Book Request</title>
  <style type="text/css">
    .srch {
      padding-left: 1100px;
    }
    body {
      font-family: "Lato", sans-serif;
      transition: background-color .5s;
    }
    .sidenav {
      height: 100%;
      margin-top: 50px;
      width: 0;
      position: fixed;
      z-index: 1;
      top: 0;
      left: 0;
      background-color: #222;
      overflow-x: hidden;
      transition: 0.5s;
      padding-top: 60px;
    }
    .sidenav a {
      padding: 8px 8px 8px 32px;
      text-decoration: none;
      font-size: 25px;
      color: #818181;
      display: block;
      transition: 0.3s;
    }
    .sidenav a:hover {
      color: #f1f1f1;
    }
    .sidenav .closebtn {
      position: absolute;
      top: 0;
      right: 25px;
      font-size: 36px;
      margin-left: 50px;
    }
    #main {
      transition: margin-left .5s;
      padding: 16px;
    }
    @media screen and (max-height: 450px) {
      .sidenav {padding-top: 15px;}
      .sidenav a {font-size: 18px;}
    }
    th, td, input {
      width: 100px;
    }
  </style>
</head>
<body>
<!--_________________sidenav_______________-->
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div style="color: white; margin-left: 60px; font-size: 20px;">
    <?php
    if (isset($_SESSION['login_user'])) {
      echo $_SESSION['login_user'];
    }
    ?>
  </div><br><br>
  <div class="h"><a href="books.php">Books</a></div>
  <div class="h"><a href="request.php">Book Request</a></div>
  <div class="h"><a href="issue_info.php">Issue Information</a></div>
  <div class="h"><a href="expired.php">Expired Information</a></div>
</div>

<div id="main">
  <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>
  <script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "300px";
      document.getElementById("main").style.marginLeft = "300px";
      document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
    }

    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
      document.getElementById("main").style.marginLeft= "0";
      document.body.style.backgroundColor = "white";
    }
  </script>

  <?php
  if (isset($_SESSION['login_user'])) {
    $q = mysqli_query($db, "SELECT * FROM issue_book WHERE username='$_SESSION[login_user]' AND approve='';");
    if (mysqli_num_rows($q) == 0) {
      echo "<h1>There's no pending request.</h1>";
    } else {
      ?>
      <form method="post">
        <table class='table table-bordered table-hover'>
          <tr style='background-color: #73c1e1;'>
            <th>Select</th>
            <th>Book-ID</th>
            <th>Approve Status</th>
            <th>Request Date</th>
            <th>Return Date</th>
          </tr>
          <?php
          while ($row = mysqli_fetch_assoc($q)) {
            echo "<tr>";
            echo "<td><input type='checkbox' name='check[]' value='{$row['bid']}'></td>";
            echo "<td>{$row['bid']}</td>";
            echo "<td>{$row['approve']}</td>";
            echo "<td>{$row['issue']}</td>";
            echo "<td>{$row['restore']}</td>";
            echo "</tr>";
          }
          ?>
        </table>
        <p align="center"><button type="submit" name="delete" class="btn btn-success">Delete</button></p>
      </form>
      <?php
      if (isset($_POST['delete'])) {
        if (isset($_POST['check'])) {
          foreach ($_POST['check'] as $delete_id) {
            $query = "DELETE FROM issue_book WHERE bid= '$delete_id' AND username='$_SESSION[login_user]' LIMIT 1";
            $result = mysqli_query($db, $query);
            if (!$result) {
              die('Error: ' . mysqli_error($db));
            }
          }
          // Refresh the page to reflect the changes
          echo "<meta http-equiv='refresh' content='0'>";
        } else {
          echo "<script>alert('Please select at least one book to delete.');</script>";
        }
      }
    }
  } else {
    echo "</br></br></br>";
    echo "<h2><b>Please Login First to see the request information</b></h2>";
  }
  ?>
</div>
</body>
</html>