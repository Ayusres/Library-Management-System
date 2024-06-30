<?php
include "connection.php";
include "navbar.php";
?>
<!DOCTYPE html>
<html>
<head>
  <title>Book Request</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style type="text/css">
    .srch {
      padding-left: 800px;
    }
    .form-control {
      width: 300px;
      height: 40px;
      background-color: black;
      color: white;
    }
    body {
      background-color: grey;
      background-repeat: no-repeat;
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
      color: white;
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
    .h:hover {
      color:white;
      width: 300px;
      height: 50px;
      background-color: #00544c;
    }
    .container {
      height: 600px;
      background-color: black;
      opacity: .8;
      color: white;
    }
    .scroll {
      width: 100%;
      height: 400px;
      overflow: auto;
    }
    th, td {
      width: 10%;
    }
  </style>
</head>
<body>
<!--_________________sidenav_______________-->
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div style="color: white; margin-left: 60px; font-size: 20px;">
    <?php
    if(isset($_SESSION['admin_user'])) {
      echo $_SESSION['admin_user'];
    }
    ?>
  </div><br><br>
  <div class="h"><a href="books.php">Books</a></div>
  <div class="h"><a href="request.php">Book Request</a></div>
  <div class="h"><a href="issue_info.php">Issue Information</a></div>
  <div class="h"><a href="expired.php">Expired List</a></div>
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
  <div class="container">
    <?php
    if(isset($_SESSION['admin_user'])) {
      ?>
      <div style="float:left; padding: 10px;">
        <form method="post" action="">
          <button name="submit2" type="submit" class="btn btn-default" style="background-color:#5daf63;">RETURNED</button>
          &nbsp &nbsp
          <button name="submit3" type="submit" class="btn btn-default" style="background-color:red;">EXPIRED</button>
        </form>
      </div>
      <div class="srch">
        <br>
        <form method="post" action="" name="form1">
          <input type="text" name="username" class="form-control" placeholder="Username" required=""><br>
          <input type="text" name="bid" class="form-control" placeholder="BID" required=""><br>
          <button class="btn btn-default" name="submit" type="submit">Submit</button><br>
        </form>
      </div>
      <?php
      if(isset($_POST['submit'])) {
        $res = mysqli_query($db, "SELECT * FROM `issue_book` WHERE username='$_POST[username]' AND bid='$_POST[bid]';");
        if (!$res) {
          die('Error: ' . mysqli_error($db));
        }

        $day = 0;
        $fine = 0;
        while($row = mysqli_fetch_assoc($res)) {
          $d = strtotime($row['restore']);
          $c = strtotime(date("Y-m-d"));
          $diff = $c - $d;
          if($diff >= 0) {
            $day = floor($diff / (60 * 60 * 24));
            $fine = $day * 5;
          }
        }
        $x = date("Y-m-d");
        $sql = "INSERT INTO `fines` (username, bid, returned, day, fine, status) VALUES ('$_POST[username]', '$_POST[bid]', '$x', '$day', '$fine', 'not paid')";
        $res = mysqli_query($db, $sql);
        if (!$res) {
          die('Error: ' . mysqli_error($db));
        }

        $var1 = '<p style="color:yellow; background-color:green;">RETURNED</p>';
        $sql = "UPDATE issue_book SET approve='$var1' WHERE username='$_POST[username]' AND bid='$_POST[bid]'";
        $res = mysqli_query($db, $sql);
        if (!$res) {
          die('Error: ' . mysqli_error($db));
        }

        $sql = "UPDATE books SET quantity = quantity + 1 WHERE bid='$_POST[bid]'";
        $res = mysqli_query($db, $sql);
        if (!$res) {
          die('Error: ' . mysqli_error($db));
        }
      }
    }
    $c = 0;
    if(isset($_SESSION['admin_user'])) {
      $ret = '<p style="color:yellow; background-color:green;">RETURNED</p>';
      $exp = '<p style="color:yellow; background-color:red;"> EXPIRED</p>';
      if (isset($_POST['submit2'])) {
        $sql = "SELECT student.username, roll, books.bid, name, authors, edition, approve, issue, restore FROM student INNER JOIN issue_book ON student.username=issue_book.username INNER JOIN books ON issue_book.bid=books.bid WHERE issue_book.approve ='$ret' ORDER BY restore DESC";
        $res = mysqli_query($db, $sql);
      } else if(isset($_POST['submit3'])) {
        $sql = "SELECT student.username, roll, books.bid, name, authors, edition, approve, issue, restore FROM student INNER JOIN issue_book ON student.username=issue_book.username INNER JOIN books ON issue_book.bid=books.bid WHERE issue_book.approve ='$exp' ORDER BY restore DESC";
        $res = mysqli_query($db, $sql);
      } else {
        $sql = "SELECT student.username, roll, books.bid, name, authors, edition, approve, issue, restore FROM student INNER JOIN issue_book ON student.username=issue_book.username INNER JOIN books ON issue_book.bid=books.bid WHERE issue_book.approve !='' AND issue_book.approve!='Yes' ORDER BY restore DESC";
        $res = mysqli_query($db, $sql);
      }

      if (!$res) {
        die('Error: ' . mysqli_error($db));
      }

      echo "<table class='table table-bordered' style='width:100%;' >";
      //Table header
      echo "<tr style='background-color: #6db6b9e6;'>";
      echo "<th>Username</th>";
      echo "<th>Roll No</th>";
      echo "<th>BID</th>";
      echo "<th>Book Name</th>";
      echo "<th>Authors Name</th>";
      echo "<th>Edition</th>";
      echo "<th>Status</th>";
      echo "<th>Issue Date</th>";
      echo "<th>Return Date</th>";
      echo "</tr>";
      echo "</table>";

      echo "<div class='scroll'>";
      echo "<table class='table table-bordered' >";
      while($row = mysqli_fetch_assoc($res)) {
        echo "<tr>";
        echo "<td>{$row['username']}</td>";
        echo "<td>{$row['roll']}</td>";
        echo "<td>{$row['bid']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['authors']}</td>";
        echo "<td>{$row['edition']}</td>";
        echo "<td>{$row['approve']}</td>";
        echo "<td>{$row['issue']}</td>";
        echo "<td>{$row['restore']}</td>";
        echo "</tr>";
      }
      echo "</table>";
      echo "</div>";
    } else {
      ?>
      <h3 style="text-align: center;">Login to see information of Borrowed Books</h3>
      <?php
    }
    ?>
  </div>
</div>
</body>
</html>
