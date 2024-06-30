<?php
	include "connection.php";
	include "navbar.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Change Password</title>

	<style type="text/css">
		body
		{		
			height: 650px;	
			background-image: url("images/3.jpg");
			background-repeat: no-repeat;
		}
		.wrapper
		{
			width: 400px;
			height: 400px;
			margin: 50px auto;
			background-color: black;
			opacity: .8;
			color: white;
			padding: 27px 15px;
		}
		.form-control
		{
			width: 300px;
		}
	</style>
</head>
<body>
	<div class="wrapper">
		<div style="text-align:center;">
		   <h1 style="text-align: center; font-size: 35px;font-family: Lucida Console;">Change Your Password</h1>
		</div>
		<div style="padding-left: 30px;">
		<form action="" method="post">
			<input type="text" name="username" class="form-control" placeholder="Username" required=""><br>
			<input type="text" name="email" class="form-control" placeholder="Email" required=""><br>
			<input type="password" name="password" class="form-control" placeholder="New Password" required=""><br>
			<button class="btn btn-default" type="submit" name="submit">Update</button>
		</form>
	</div>
	</div>

	<?php
	if(isset($_POST['submit']))
	{
		$username = $_POST['username'];
		$email = $_POST['email'];
		$new_password = $_POST['password'];

		$query = "SELECT * FROM student WHERE username='$username' AND email='$email'";
		$result = mysqli_query($db, $query);

		if(mysqli_num_rows($result) > 0)
		{
			$update_query = "UPDATE student SET password='$new_password' WHERE username='$username' AND email='$email'";
			if(mysqli_query($db, $update_query))
			{
				echo "<script type='text/javascript'>alert('The Password Updated Successfully');</script>";
			}
		}
		else
		{
			echo "<script type='text/javascript'>alert('Credentials do not match');</script>";
		}
	}
	?>
</body>
</html>