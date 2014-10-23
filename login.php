<?php
if (! empty ( $_POST )) {
	// keep track validation errors
	$nickname_error = null;
	$password_error = null;
	
	// keep track post values
	$nickname = $_POST['nickname'];
	$password = $_POST['password'];
	
	// validate input
	$valid = true;
	
	if (empty ( $nickname )) {
		$nickname_error = 'Please enter Nickname!';
		$valid = false;
	}
	
	if (empty ( $password )) {
		$password_error = 'Please enter Password!';
		$valid = false;
	}
}
?>

<?php 
if ($valid){
	$dbc = mysqli_connect("localhost","root","apple610","wedget_info")
		or die("cannot connect database：" . mysqli_error());
	$flag = false;

	$check_query_nickname = mysqli_query($dbc,"select uid from user where nickname='$nickname' limit 1");
	if(!mysqli_fetch_array($check_query_nickname)){
		$nickname_error = 'No such Nickname!';
	}
	else{
		$password_MD5 = MD5($_POST['password']);
		$check_query_password = mysqli_query($dbc,"select uid from user where nickname='$nickname' and password='$password_MD5' limit 1");
		if(mysqli_fetch_array($check_query_password)){
			//登录成功
			$flag = true;
		}
		else {
			$password_error = "Wrong Password!";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>WeDGeT-Login</title>
	<meta charset="utf-8">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container">

		<div class="span10 offset1">
			<div class="row">
				<h1>WeDGeT-Login</h1>
			</div>
			<form class="form-horizontal" method="post">
				
				<div
					class="control-group <?php echo !empty($nickname_error)?'error':'';?>">
					<label class="control-label">Nickname:</label>
					<div class="controls">
						<input name="nickname" type="text" placeholder="Nickname"
							value="<?php echo !empty($nickname)?$nickname:'';?>">
                            <?php if (!empty($nickname_error)): ?>
                                <span class="help-inline"><?php echo $nickname_error;?></span>
                            <?php endif;?>
                        </div>
				</div>
				
				<div 
					class="control-group <?php echo !empty($password_error)?'error':'';?>">
					<label class="control-label">Password:</label>
					<div class="controls">
						<input name="password" type="password" placeholder="Password"
							value="<?php echo !empty($password)?$password:'';?>">
                            <?php if (!empty($password_error)): ?>
                                <span class="help-inline"><?php echo $password_error;?></span>
                            <?php endif;?>
                        </div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-success">cnnect your account</button>
					<a class="btn" href="index.php">back home</a>
					<?php 
					if($flag){
						echo '<h3>connect sucessfully!</h3> <a class="btn btn-success" href="user_database.php">login</a>';
					}
					?>
				</div>
			</form>
		</div>

	</div>
</body>
</html>