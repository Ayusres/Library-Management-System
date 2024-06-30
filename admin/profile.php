<?php
 include "connection.php";
 include "navbar.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
<style type="text/css">
	.wrapper
	{
		width: 300px;
		height: 650px;
		margin:0 auto;

	}
</style>
</head>
<body style="background-color:#4699bc;">
	<div class="container">
		<form action="" method="post">
			<button class="btn btn-default" style="float:right; width:70px" name="submit1" type="submit">
				Edit
			</button>
		</form>
		<div class="wrapper" style="">
			<?php

			if (isset($_POST['submit1']))
			 {
				?>
					<script type="text/javascript">
						window.location="edit.php";
					</script>
				<?php
			}
			$q=mysqli_query($db,"SELECT * FROM admin WHERE username='$_SESSION[admin_user]'; ");
			?>
			<h2 style="text-align: center;">
				My Profile
			</h2>
			<?php
			$row=mysqli_fetch_assoc($q);
			// echo "<div style='text-align:center'>  </div>";
			?>
			<div style="text-align:center;"><b >Welcome, </b>
			<h4>
				<?php
				echo $_SESSION['admin_user'];
				?>
			</h4>
			</div>
			<?php
			echo "<b>";
				echo "<table class='table table-bordered'>";
				echo "<tr>";
					echo "<td>";
						echo "<b>First Name: </b>";
					echo "</td>";

					echo "<td>";
						echo $row['first'];
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td>";
						echo "<b>Last Name: </b>";
					echo "</td>";

					echo "<td>";
						echo $row['last'];
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td>";
						echo "<b>User Name: </b>";
					echo "</td>";

					echo "<td>";
						echo $row['username'];
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td>";
						echo "<b>Password: </b>";
					echo "</td>";

					echo "<td>";
						echo $row['password'];
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td>";
						echo "<b>Email: </b>";
					echo "</td>";

					echo "<td>";
						echo $row['email'];
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td>";
						echo "<b>Contact: </b>";
					echo "</td>";

					echo "<td>";
						echo $row['contact'];
					echo "</td>";
				echo "</tr>";
				echo "<table>";
				echo "</b>";
			?>
		</div>
	</div>

</body>
</html>