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
		<ul class="nav navbar-nav navbar-right">
			<li><a href="http://[::1]/htdocs/index.php/User/logout">Logout</a></li>
		</ul>
	</div>
</nav>
<div class="container">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4 text-center">
				<h1>Welcome to the admin page</h1>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<td>Username</td>
							<td>Email</td>
							<td>Created On</td>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach ($user as $users) { ?>
							<tr>
								<td><?php echo $users->username; ?></td>
								<td><?php echo $users->email; ?></td>
								<td><?php echo $users->created_on; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<button class="btn btn-primary" data-toggle="modal" data-target=".addUserLg">Add User</button>

				<div class="modal fade addUserLg" tabindex="-1" role="dialog">
					<div class="modal-dialog modal-lg" role="document">	
							<div class="modal-content">
								<div class="modal-header">
							 		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							 		<h4 class="modal-title">Add User</h4>
								</div>
								<div class="modal-body">
									<?php echo form_open('User/addUser'); ?>
										<div class="form-group">
											<label for="usernameInput">Username</label>
											<input type="text" name="username" placeholder="Username"><br>
										</div>
										<div class="form-group">
											<label for="passwordInput">Password</label>
											<input type="password" name="password" placeholder="Password"><br>
										</div>
										<div class="form-group">
											<label for="passwordInput">Re-type Password</label>
											<input type="password" name="retypepassword" placeholder="Password"><br>
										</div>
										<div class="form-group">
											<label for="emailInput">Email</label>
											<input type="text" name="email" placeholder="example@example.com"><br>
										</div>
										<div class="form-group">
											<div class="form-check">
										      <label class="form-check-label">
										        <input type="radio" class="form-check-input" name="group" id="adminRadio" value="1" checked>
										        Admin
										      </label>
										    </div>
										    <div class="form-check">
										    <label class="form-check-label">
										        <input type="radio" class="form-check-input" name="group" id="memberRadio" value="2">
										        Member
										    </label>
										    </div>
										</div>
											<button type="submit" class="btn btn-primary mdl">Signup</button>
									</form>
								</div>
								</div>
							</div>
					</div>
				</div>
		</div>
		<div class="col-md-4"></div>
	</div>
</div>

</body>
</html>