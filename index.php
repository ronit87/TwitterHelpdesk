<?php
require_once("library.php");
Core::init();
$dbInst = new Database();

if(isset($_POST) && !empty($_POST['frmType'])){
	
	if($_POST['frmType'] === "signin"){
		$validateFrm = false;
		if(!empty($_POST['username'])){
			$uname = trim($_POST['username']);
			$validUsername = true;
		} else {
			$validUsername = false;
		}
		
		if(!empty($_POST['password'])){
			$pwd = trim($_POST['password']);
			$validPwd = true;
		} else {
			$validPwd = false;
		}
		
		if($validUsername === true && $validPwd === true){
			$loginSql = "SELECT twitterid FROM `tbl_users` WHERE username = '{$uname}' AND password = md5('".$pwd."')";
			$response = $dbInst->query($loginSql);
			echo "<pre>";
			print_r($response);
			echo "</pre>";
		}
	}

	if($_POST['frmType'] === "signup"){
		
		$validateFrm = false;
		if(!empty($_POST['firstname'])){
			$fname = trim($_POST['firstname']);
			$validFname = true;
		} else {
			$validFname = false;
		}
		
		if(!empty($_POST['lastname'])){
			$lname = trim($_POST['lastname']);
			$validLname = true;
		} else {
			$validLname = false;
		}
		
		if(!empty($_POST['twitterid'])){
			$twitterId = trim($_POST['twitterid']);
			$validTwitterid = true;
		} else {
			$validTwitterid = false;
		}
		
		if(!empty($_POST['username'])){
			$uname = trim($_POST['username']);
			$validUsername = true;
		} else {
			$validUsername = false;
		}
		
		if(!empty($_POST['password'])){
			$pwd = trim($_POST['password']);
			$validPwd = true;
		} else {
			$validPwd = false;
		}
		
		if($validFname === true && $validLname === true && $validTwitterid === true && $validUsername === true && $validPwd === true){
			$loginSql = "INSERT INTO `tbl_users` (`username`, `password`, `firstname`, `lastname`, `twitterid`) VALUES ( '{$uname}', MD5('{$pwd}'), '{$validFname}', '{$lname}', '{$twitterId}');";
			$response = $dbInst->query($loginSql);
			echo "<pre>";
			print_r($response);
			echo "</pre>";
		}
	}
}
?>
<html>
	<head>
		<title>Login / Register</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="row">
			<div class="clearfix">&nbsp;</div>
			<div class="col-md-4 col-md-offset-2">
				<div class="row">
					<div class="col-md-12">
						<h4>Login</h4>
						<form name="signin" id="frmSignin" method="post" action="">
							<div class="form-group">
								<label for="login-username">Username</label>
								<input type="email" value="" name="username" class="form-control" id="login-username" placeholder="Email">
							</div>
							<div class="form-group">
								<label for="login-password">Password</label>
								<input type="password" name="password" class="form-control" id="login-password" placeholder="Password">
								<input type="hidden" name="frmType" id="login-frmType" value="signin">
							</div>
							<button type="submit" class="btn btn-primary">Submit</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-12">
						<h4>Register</h4>
						<form name="signup" id="frmSignup" method="post" action="">
							<div class="form-group">
								<label for="register-firstname">Firstname</label>
								<input type="text" name="firstname" class="form-control" id="register-firstname" placeholder="Firstname">
							</div>
							<div class="form-group">
								<label for="register-lastname">Lastname</label>
								<input type="text" name="lastname" class="form-control" id="register-lastname" placeholder="Lastname">
							</div>
							<div class="form-group">
								<label for="register-twitterid">Twitter ID</label>
								<input type="text" name="twitterid" class="form-control" id="register-twitterid" placeholder="Twitter ID">
							</div>
							<div class="form-group">
								<label for="register-username">Username</label>
								<input type="email" name="username" class="form-control" id="register-username" placeholder="Email">
							</div>
							<div class="form-group">
								<label for="register-password">Password</label>
								<input type="password" name="password" class="form-control" id="register-password" placeholder="Password">
								<input type="hidden" name="frmType" id="login-frmType" value="signup">
							</div>
							<button type="submit" class="btn btn-primary">Submit</button>
						</form>
					</div>
				</div>
			</div>
			<div class="clearfix">&nbsp;</div>
		</div>
	</body>
</html>