<?php

include "includes/DBConnection.php";
include "includes/layouts/header.php";

if($_SESSION['role'] != 1)
{
	header('location:login.php');
}

$message = '';

if(isset($_POST["register"]))
{
	$username = trim($_POST["username"]);
	$password = trim($_POST["password"]);
	$check_query = "
	SELECT * FROM users 
	WHERE userName = :username
	";
	$statement = $connect->prepare($check_query);
	$check_data = array(
		':username'		=>	$username
	);
	if($statement->execute($check_data))	
	{
		if($statement->rowCount() > 0)
		{
			$message .= '<p><label>Username already taken</label></p>';
		}
		else
		{
			if(empty($username))
			{
				$message .= '<p><label>Username is required</label></p>';
			}
			if(empty($password))
			{
				$message .= '<p><label>Password is required</label></p>';
			}
			else
			{
				if($password != $_POST['confirm_password'])
				{
					$message .= '<p><label>Password not match</label></p>';
				}
			}
			if($message == '')
			{
				$data = array(
					':username'		=>	$username,
					':password'		=>	password_hash($password, PASSWORD_DEFAULT),
					':email'		=> $_POST['email'],
					':phone'		=> $_POST['phone'],
					':role'			=> $_POST['role'],
				);

				$query = "
				INSERT INTO users 
				(userName, password,email,phone,role) 
				VALUES (:username, :password,:email,:phone,:role)
				";
				$statement = $connect->prepare($query);
				if($statement->execute($data))
				{
					header('location:users.php');
				}
			}
		}
	}
}

?>

<div class="nav">
	<a href="index.php"><button type="button col" class="btn btn-secondary">Products List</button></a>
	<a href="users.php"><button type="button col" class="btn btn-secondary">Users List</button></a>
	<a href="chart.php"><button type="button col" class="btn btn-secondary">View Charts</button></a>
	<a href="logout.php"><button type="button col" style="float:right" class="btn btn-secondary">Logout</button></a>
</div>
<h3 align="center" style="margin-top:28px;margin-bottom:28px"><strong>Register new user</strong></h3>
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading"><strong>Register new user</strong></div>
		<div class="panel-body">
			<form method="post">
				<span class="text-danger"><?php echo $message; ?></span>
				<div class="form-group">
					<label>Enter Username</label>
					<input type="text" name="username" required class="form-control" />
				</div>
				<div class="form-group">
					<label>Enter Email</label>
					<input type="email" name="email" required class="form-control" />
				</div>
				<div class="form-group">
					<label>Enter Phone number</label>
					<input type="text" name="phone" required class="form-control" />
				</div>
				<div class="form-group">
					<label>Enter Password</label>
					<input type="password" name="password" required class="form-control" />
				</div>
				<div class="form-group">
					<label>Re-enter Password</label>
					<input type="password" name="confirm_password" required class="form-control" />
				</div>
				<div class="form-group">
					<label>Role</label>
					<select name="role" class="form-control">
						<option value="0">User</option>
						<option value="1">Admin</option>
					</select>
				</div>
				<div class="form-group">
					<input type="submit" name="register" class="btn btn-info" style="background-color:#1f4b64" value="Register" />
				</div>
			</form>
		</div>
	</div>
</div>

<?php
include "includes/layouts/footer.php";
?>
