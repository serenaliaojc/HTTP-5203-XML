<?php 

$users = simplexml_load_file('users.xml');
$alert = "";

if (isset($_POST['login_submit'])) {

	$username = $_POST['username'];
	$password = $_POST['password'];

	$r_uname = $users->xpath("/users/user/name[username='".$username."']/username/text()");
	$r_pword = $users->xpath("/users/user/name[username='".$username."']/../password/text()");

	if (!isset($r_uname[0])) {

		$alert = "Username not found.";

	} else {

		if ($r_pword[0]==$password) {

			$type = $users->xpath("/users/user/name[username='".$username."']/ancestor::user/@type");
			$uid = $users->xpath("/users/user/name[username='".$username."']/ancestor::user/@id");

			setcookie('type', $type[0]);
			setcookie('uid', $uid[0]);
			
			if ($type[0]=='admin') {
				header("Location:admin-list.php");
			} else {
				header("Location:client-list.php");
			}

		} else {
			$alert = "Invalid password.";
		}
	}
} else {
	setcookie('type','',time()-3600);
}

 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Login</title>
 	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 </head>
 <body>
 	<div class="container">
 		<h1>Login</h1>
	 	<form action="login.php" method="post">
	 		<div class="form-group row">
	 			<label for="username" class="col-sm-2 col-form-label">Username</label>
	 			<input type="text" name="username" id="username" class="form-control col-sm-3">
	 		</div>
	 		<div class="form-group row">
	 			<label for="password" class="col-sm-2 col-form-label">Password</label>
	 			<input type="password" name="password" id="password" class="form-control col-sm-3">
	 		</div>
	 		<input type="submit" name="login_submit" class="btn" value="Login">
	 	</form>
	 	<div class="text-danger">
		  <?php echo $alert; ?>
		</div>
 	</div>
 </body>
 </html>