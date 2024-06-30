<?php
	include "connection.php";
	include "navbar.php";
?>
<!DOCTYPE html>
<html>
<head>
	
	<title>Approve Request</title>
<style type="text/css">
		.srch
		{
			padding-left:1100px ;
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

	</style>


</head>
<body>
		<!--_________________sidenav_______________-->
	
	<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

  			<div style="color: white; margin-left: 60px; font-size: 20px;">

                <?php

                    if(isset($_SESSION['admin_user']))
                {

                    echo $_SESSION['admin_user']; 
                  }
                ?>
            </div>

  <a href="profile.php">Profile</a>
  <a href="books.php">Books</a>
  <a href="request.php">Book Request</a>
  <a href="issue_info.php">Issue Information</a>
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

	<!-----------____________________search bar_________________---->
	<h2 >Search one username at a time to approve the request</h2>
	<div class="srch">
		<form class="navbar-form" method="post" name="form1">
		
			<input class="form-control" type="text" name="search" placeholder="Admin request username" required="">
			<button style="background-color: #73c1e1; "type="submit" name="submit" class="btn btn-default">
				<span class="glyphicon glyphicon-search"></span>
			</button>
		</form>
	</div>
	<h2>New Request</h2>
	<?php
	$message = "";

	if(isset($_POST['submit']))
	{
		$q = mysqli_query($db, "SELECT first, last, username, email, contact FROM `admin` WHERE username LIKE '%$_POST[search]%' and status=''");
		if(mysqli_num_rows($q) == 0)
		{
			$message = "Sorry! No new request found with that username. Try searching again.";
		}
		else
		{
			echo "<table class='table table-bordered table-hover' >";
			echo "<tr style='background-color: #73c1e1;'>";
				//Table header
				echo "<th>First Name</th>";
				echo "<th>Last Name</th>";
				echo "<th>Username</th>";
				echo "<th>Email</th>";
				echo "<th>Contact</th>";
			echo "</tr>";	

			while($row = mysqli_fetch_assoc($q))
			{
				$_SESSION['test_name'] = $row['username'];
				echo "<tr>";
				echo "<td>{$row['first']}</td>";
				echo "<td>{$row['last']}</td>";
				echo "<td>{$row['username']}</td>";
				echo "<td>{$row['email']}</td>";
				echo "<td>{$row['contact']}</td>";
				echo "</tr>";
			}
			echo "</table>";
		?>
		<form method="post">
			<button type="submit" name="submit1" style="background-color: black; color:red; font-weight: 700; font-size:18px" class="btn btn-default">
				<span style="color:red;" class="glyphicon glyphicon-remove-sign"></span> &nbsp Remove
			</button>
			<button type="submit" name="submit2" style="background-color: black; color:green; font-weight: 700; font-size:18px" class="btn btn-default">
				<span style="color: green;" class="glyphicon glyphicon-ok-sign"></span>&nbsp Approve
			</button>
		</form>
		<?php
		}
	}
	else
	{
		$res = mysqli_query($db, "SELECT first, last, username, email, contact FROM `admin` WHERE status=''");
		echo "<table class='table table-bordered table-hover'>";
		echo "<tr style='background-color: #73c1e1;'>";
			//Table header
			echo "<th>First Name</th>";
			echo "<th>Last Name</th>";
			echo "<th>Username</th>";
			echo "<th>Email</th>";
			echo "<th>Contact</th>";
		echo "</tr>";	

		while($row = mysqli_fetch_assoc($res))
		{
			echo "<tr>";
			echo "<td>{$row['first']}</td>";
			echo "<td>{$row['last']}</td>";
			echo "<td>{$row['username']}</td>";
			echo "<td>{$row['email']}</td>";
			echo "<td>{$row['contact']}</td>";
			echo "</tr>";
		}
		echo "</table>";	
	}

	if(isset($_POST['submit1']))
	{
		mysqli_query($db, "DELETE FROM admin WHERE username='$_SESSION[test_name]' and status=''");
		$message = "Admin request removed.";
		unset($_SESSION['test_name']);
	?>
		 <script type="text/javascript">
        window.location = "admin_status.php";
      </script>
      <?php

	}

	if(isset($_POST['submit2']))
	{
		mysqli_query($db, "UPDATE admin set status='yes' WHERE username='$_SESSION[test_name]'");
		$message = "Admin request approved.";
		unset($_SESSION['test_name']);
		?>
		 <script type="text/javascript">
        window.location = "admin_status.php";
      </script>
      <?php
	}
	
	if ($message != "") {
		echo "<div style='color: green; font-weight: bold; margin-top: 20px;'>$message</div>";
	}
?>
		
</body>
</html>
