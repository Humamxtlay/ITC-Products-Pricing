<?php
include "includes/DBConnection.php";
if(!isset($_SESSION)) {
    session_start();
}
$message = '';
if(isset($_SESSION['user_id']))
{
	header('location:index.php');
}
if(isset($_POST['login']))
{
	$query = "
		SELECT * FROM users 
  		WHERE userName = :username
	";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
			':username' => $_POST["username"]
		)
	);	
	$count = $statement->rowCount();
	if($count > 0)
	{
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			if(password_verify($_POST["password"], $row["password"]))
			{
				$_SESSION['user_id'] = $row['id'];
				$_SESSION['username'] = $row['userName'];
				$_SESSION['role'] = $row['role'];
				header('location:index.php');
			}
			else
			{
				$message = '<label style="color:red">Wrong Password</label>';
			}
		}
	}
	else
	{
		$message = '<label style="color:red">Wrong Username</labe>';
	}
}

?>

<html>  
    <head>  
        <title>Login</title>  
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<link href="css/login1.css" rel="stylesheet">
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>  
    <body>  

		<div class="wrapper fadeInDown">
		<div id="formContent">
		<?php echo $message ?>

			<form method="POST" action="">
				<input type="text" id="login" class="fadeIn second" name="username" placeholder="login">
				<input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
				<input type="submit" class="fadeIn fourth" name="login" value="Log In">
			</form>
		</div>
		</div>
    </body>  
</html>

