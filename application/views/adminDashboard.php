<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="xampp/htdocs/htdocs/assets/css/main.css">
	<title>Admin Dashboard</title>
	<style type="text/css">.modal-body { max-height: calc(100vh - 100px);overflow-y: auto;}</style>
</head>
<body>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<?php if($this->session->flashdata('editError') === 'true') {
	$this->session->set_flashdata('editError', 'false');
	echo '<script type="text/javascript"> 

	$(document).ready(function() {'; ?>
		
		<?php echo 'var username = '.'"'.$userError->username.'";'; ?>
		<?php echo 'var email = '.'"'.$userError->email.'";'; ?>
		<?php echo 'var userID = '.'"'.$userError->userID.'";'; ?>	

		$("#userIDJson").val(userID);
        $("#usernameJson").val(username);
        $("#emailJson").val(email);
        <?php if ($userError->group == 2) { ?>
            	$('#memberRadioJson').prop('checked', true);
        <?php    } ?>
	  
	  $("#editUser").modal("show");
	 })
	 </script>
<?php } ?>

<?php if($this->session->flashdata('error') === 'true') {
	$this->session->set_flashdata('error', 'false');
	echo '<script type="text/javascript"> 

	$(document).ready(function() {'; ?>
		
		<?php echo 'var username = '.'"'.$userError->username.'";'; ?>
		<?php echo 'var email = '.'"'.$userError->email.'";'; ?>	

        $("#username").val(username);
        $("#email").val(email);
        <?php if ($userError->group == 2) { ?>
            	$('#memberRadio').prop('checked', true);
        <?php    } ?>
	  
	  $("#addUser").modal("show");
	 })
	 </script>
<?php } ?>

<script type="text/javascript">
	//Populate modal with user data
	function getUsersEdit(userID) {
	console.log(userID);

	//AJAX call to getUserEditJson function
	$.ajax({
		url: "http://[::1]/htdocs/index.php/User/getUserEditJson",
		type: "POST",
		dataType: "json",
		data: { 'q' : userID },
		 success: function(data) {
		 		console.log(data);
		 		//Populate modal with data
		 		$("#userIDJson").val(data[0].id);
                $("#usernameJson").val(data[0].username);
                $("#emailJson").val(data[0].email);
                if (data[0].group_id == 2) {
            	$('#memberRadioJson').prop('checked', true);
            }
              }
	});
}


</script>

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">M J Harris Electrical</a>
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
				<?php if($this->session->flashdata('message') != NULL) { ?>
				<?php echo $this->session->flashdata('message'); ?>
				<?php } ?>
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
								<td><a class="btn btn-secondary" data-toggle="modal" data-target="#editUser" <?php echo'id="'.$users->id . '"' ?> role="button" onclick="getUsersEdit(this.id);">Edit</a></td>
								<td><a class="btn btn-danger" <?php echo'href="http://[::1]/htdocs/index.php/User/deleteUser/'.$users->id . '"' ?> role="button">Delete</a></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<button class="btn btn-primary" data-toggle="modal" data-target=".addUserLg">Add User</button>

				<div class="modal fade addUserLg" tabindex="-1" role="dialog" id="addUser">
					<div class="modal-dialog modal-lg" role="document">	
							<div class="modal-content">
								<div class="modal-header">
							 		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							 		<h4 class="modal-title">Add User</h4>
								</div>
								<div class="modal-body">
									<?php echo form_open('User/addUser'); ?>
										<div class="form-group">
											<?php echo form_error('username'); ?>
											<label for="usernameInput">Username</label>
											<input type="text" name="username" placeholder="Username"><br>
										</div>
										<div class="form-group">
											<?php echo form_error('password'); ?>
											<label for="passwordInput">Password</label>
											<input type="password" name="password" placeholder="Password"><br>
										</div>
										<div class="form-group">
											<?php echo form_error('retypepassword'); ?>
											<label for="passwordInput">Re-type Password</label>
											<input type="password" name="retypepassword" placeholder="Password"><br>
										</div>
										<div class="form-group">
											<?php echo form_error('email'); ?>
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
				<div class="modal fade editUserLg" tabindex="-1" role="dialog" id="editUser">
					<div class="modal-dialog modal-lg" role="document">	
							<div class="modal-content">
								<div class="modal-header">
							 		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							 		<h4 class="modal-title">Edit User</h4>
								</div>
								<div class="modal-body">
									<?php echo form_open('User/editUser'); ?>
										<input type="hidden" name="userIDJson" id="userIDJson">	
										<div class="form-group">
											<?php echo form_error('userIDJson'); ?>
											<?php echo form_error('usernameJson'); ?>
											<label for="usernameInput">Username</label>
											<input type="text" name="usernameJson" id="usernameJson" placeholder="Username"><br>
										</div>
										<div class="form-group">
											<?php echo form_error('passwordJson'); ?>
											<label for="passwordInput">Password</label>
											<input type="password" name="passwordJson" id="passwordJson" placeholder="Password"><br>
										</div>
										<div class="form-group">
											<?php echo form_error('retypepasswordJson'); ?>
											<label for="passwordInput">Re-type Password</label>
											<input type="password" name="retypepasswordJson" id="retypepasswordJson" placeholder="Password"><br>
										</div>
										<div class="form-group">
											<?php echo form_error('emailJson'); ?>
											<label for="emailInput">Email</label>
											<input type="text" name="emailJson" id="emailJson" placeholder="example@example.com"><br>
										</div>
										<div class="form-group">
											<div class="form-check">
										      <label class="form-check-label">
										        <input type="radio" class="form-check-input" name="groupJson" id="adminRadioJson" value="1" checked>
										        Admin
										      </label>
										    </div>
										    <div class="form-check">
										    <label class="form-check-label">
										        <input type="radio" class="form-check-input" name="groupJson" id="memberRadioJson" value="2">
										        Member
										    </label>
										    </div>
										</div>
											<button type="submit" class="btn btn-primary mdl">Edit</button>
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