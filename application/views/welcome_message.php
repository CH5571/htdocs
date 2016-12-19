<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../../assets/css/main.css">
	<title>Login</title></head>
<body>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">Logo</a>
		</div>
	</div>
</nav>
<div class="container">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4 text-center">
				<?php echo form_open('User/login'); ?>
					<div class="form-group">
						<label for="usernameInput">Username</label>
						<input type="text" name="username" placeholder="Username"><br>
					</div>
					<div class="form-group">
						<label for="passwordInput">Password</label>
						<input type="password" name="password" placeholder="Password"><br>
					</div>
						<button type="submit" class="btn btn-primary">Login</button>
				</form>
				</div>
		</div>
		<div class="col-md-4"></div>
	</div>
</div>

</body>
</html>