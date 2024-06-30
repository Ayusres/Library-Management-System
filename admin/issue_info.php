<?php
  include "connection.php";
  include "navbar.php";
 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Issue Information</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style type="text/css">
		.srch {
			padding-left: 800px;
		}
		.form-control {
			width: 300px;
			height: 30px;
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
			color: white;
			width: 300px;
			height: 50px;
			background-color: #00544c;
		}
		.container {
			height: 580px;
			background-color: black;
			opacity: .8;
			color:  white;
		}
		.scroll {
			width: 100%;
			height: 500px;
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
	<div class="h"> <a href="books.php">Books</a></div>
	<div class="h"> <a href="request.php">Book Request</a></div>
	<div class="h"> <a href="issue_info.php">Issue Information</a></div>
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
		<h2 style="text-align:center;">Information of Borrowed Book</h2>
		<?php
		if (isset($_SESSION['admin_user'])) {
			$sql = "SELECT student.username, roll, books.bid, name, authors, edition, issue, restore 
					FROM student 
					INNER JOIN issue_book ON student.username = issue_book.username 
					INNER JOIN books ON issue_book.bid = books.bid 
					WHERE issue_book.approve = 'YES' 
					ORDER BY restore ASC";
			$res = mysqli_query($db, $sql);
			echo "<table class='table table-bordered'>";
			echo "<tr style='background-color: #6db6b9e6;'>
					<th>Username</th>
					<th>Roll No</th>
					<th>BID</th>
					<th>Book Name</th>
					<th>Authors Name</th>
					<th>Edition</th>
					<th>Issue Date</th>
					<th>Return Date</th>
				  </tr>";
			echo "</table>";
			echo "<div class='scroll'>";
			echo "<table class='table table-bordered'>";
			$c = 0; // Initialize the counter
			while ($row = mysqli_fetch_assoc($res)) {
				$d = date("Y-m-d");
				if ($d > $row['restore']) {
					$c++;
					$var = '<p style="color:yellow; background-color:red;"> EXPIRED</p>';
					mysqli_query($db, "UPDATE issue_book SET approve='$var' WHERE restore='$row[restore]' AND approve='YES' LIMIT $c;");
				}
				echo "<tr>
						<td>{$row['username']}</td>
						<td>{$row['roll']}</td>
						<td>{$row['bid']}</td>
						<td>{$row['name']}</td>
						<td>{$row['authors']}</td>
						<td>{$row['edition']}</td>
						<td>{$row['issue']}</td>
						<td>{$row['restore']}</td>
					  </tr>";
			}

			echo "</table>";
			echo "</div>";
		} else {
			echo "<h2 style='text-align:center;'>Login to see information of Borrowed Book</h2>";
		}
		?>
	</div>
</div>
</body>
</html>