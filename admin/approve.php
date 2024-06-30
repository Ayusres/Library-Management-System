<?php
  include "connection.php";
  include "navbar.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Approve Request</title>
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
			background-color: lightgreen;
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
			height: 580px;
			background-color: black;
			opacity: .8;
			color: white;
		}
		.Approve {
			margin-left:400px;
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
		<div class="h"> <a href="issue_info">Issue Information</a></div>
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
			<br><h3 style="text-align: center;">Approve Request</h3><br><br>
			
			<form class="Approve" action="" method="post">
				<input type="hidden" name="action" id="action" value="">
				
				<div id="approve-fields">
					<input class="form-control" type="text" name="approve" placeholder="Yes"><br>
					<input type="date" name="issue" placeholder="Issue Date yyyy-mm-dd" class="form-control"><br>
					<input type="date" name="restore" placeholder="Return Date yyyy-mm-dd" class="form-control"><br>
				</div>
				
				<button class="btn btn-default" type="submit" name="submit" onclick="document.getElementById('action').value='approve';">Approve</button>
				<button class="btn btn-default" type="submit" name="reject" onclick="document.getElementById('action').value='reject';">Reject</button>
			</form>
		</div>
	</div>

	<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if ($_POST['action'] == 'approve' && isset($_POST['approve']) && isset($_POST['issue']) && isset($_POST['restore'])) {
			mysqli_query($db, "UPDATE `issue_book` SET `approve` = 'YES', `issue` = '$_POST[issue]', `restore` = '$_POST[restore]' WHERE username='$_SESSION[name]' and bid='$_SESSION[bid]';");

			mysqli_query($db, "UPDATE books SET quantity = quantity-1 where bid='$_SESSION[bid]';");

			$res = mysqli_query($db, "SELECT quantity from books where bid='$_SESSION[bid]';");

			while ($row = mysqli_fetch_assoc($res)) {
				if ($row['quantity'] == 0) {
					mysqli_query($db, "UPDATE books SET status='not-available' where bid='$_SESSION[bid]';");
				}
			}
			?>
			<script type="text/javascript">
				alert("Book Requested Approved.");
				window.location="request.php";
			</script>
			<?php
		}

		if ($_POST['action'] == 'reject') {
			mysqli_query($db, "UPDATE `issue_book` SET `approve` = 'NO' WHERE username='$_SESSION[name]' and bid='$_SESSION[bid]';");
			?>
			<script type="text/javascript">
				alert("Request Rejected.");
				window.location="request.php";
			</script>
			<?php
		}
	}
	?>
</body>
</html>
