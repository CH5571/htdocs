<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../../assets/css/main.css">
	<title>Customer</title></head>
<body>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">Logo</a>
		</div>
		<ul class="nav navbar-nav navbar-left">
			<li><a href="http://[::1]/htdocs/index.php/User/dashboard">Dashboard</a></li>
			<li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Customers <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="http://[::1]/htdocs/index.php/User/customerPage">Manage Customers</a></li>
	            <li><a href="#" data-toggle="modal" data-target="#addCustomer">Quick Add</a></li>
	          </ul>
	        </li>
			<li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Materials <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="http://[::1]/htdocs/index.php/User/materialPage">Manage Materials</a></li>
	            <li><a href="#" data-toggle="modal" data-target="#addMaterial">Quick Add</a></li>
	          </ul>
	        </li>
			<li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Invoice <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Manage Invoices</a></li>
	            <li><a href="#">Quick Add</a></li>
	          </ul>
	        </li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="http://[::1]/htdocs/index.php/User/logout">Logout</a></li>
		</ul>
	</div>
</nav>

<div class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="addCustomer" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add Customer</h4>
			</div>
			<div class="modal-body">
				<?php echo form_open('User/addCustomer');?>
					<div class="form-group">
						<label for="forenameInput">Forename</label>
						<input type="text" name="forename" placeholder="John"><br>
					</div>
					<div class="form-group">
						<label for="surnameInput">Surname</label>
						<input type="text" name="surname" placeholder="Smith"><br>
					</div>
					<div class="form-group">
						<label for="addressLine1Input">Address Line 1</label>
						<input type="text" name="addressLine1" placeholder="10 Example Road"><br>
					</div>
					<div class="form-group">
						<label for="addressLine2Input">Address Line 2</label>
						<input type="text" name="addressLine2" placeholder="Optional"><br>
					</div>
					<div class="form-group">
						<label for="addressLine3Input">Address Line 3</label>
						<input type="text" name="addressLine3" placeholder="Optional"><br>
					</div>
					<div class="form-group">
						<label for="cityInput">City</label>
						<input type="text" name="city" placeholder="Ipswich"><br>
					</div>
					<div class="form-group">
						<label for="postcodeInput">Postcode</label>
						<input type="text" name="postcode" placeholder="IP11 0ST"><br>
					</div>
					<div class="form-group">
						<label for="telephoneNumberInput">Telephone Number</label>
						<input type="text" name="telephoneNumber" placeholder="07950881070"><br>
					</div>
					<div class="form-group">
						<label for="emailInput">Email</label>
						<input type="text" name="email" placeholder="example@example.com"><br>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary mdl">Add Customer</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="addMaterial" tabindex="-1" role="dialog" aria-labelledby="addMaterial" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add Material</h4>
			</div>
			<div class="modal-body">
				<?php echo form_open('User/addMaterial');?>
					<div class="form-group">
						<label for="forenameInput">Material Name</label>
						<input type="text" name="materialName" placeholder="Screw"><br>
					</div>
					<div class="form-group">
						<label for="surnameInput">Price</label>
						<input type="number" name="price" step="any" placeholder="5.00"><br>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary mdl">Add Material</button>
					</div>
				</form>
			</div>
		</div>
	</div>	
</div>

<div class="container">
	<div class="row">
		<h1>Add Invoice</h1>
		<?php echo form_open('User/addInvoice'); ?>
			<div class="form-group">
				<label for="customerInput">Customer</label>
				<select class="form-control" id="customerSelect">
					<?php foreach($customer as $customers) { ?>
						<option value="<?php echo $customers->customerID; ?>"><?php echo $customers->addressLine1; ?></option>
				</select><br>
			</div>
			<div class="form-group">
				<label for="surnameInput">Surname</label>
				<input type="text" name="surname" placeholder="Smith"><br>
			</div>
			<div class="form-group">
				<label for="addressLine1Input">Address Line 1</label>
				<input type="text" name="addressLine1" placeholder="10 Example Road"><br>
			</div>
			<div class="form-group">
				<label for="addressLine2Input">Address Line 2</label>
				<input type="text" name="addressLine2" placeholder="Optional"><br>
			</div>
			<div class="form-group">
				<label for="addressLine3Input">Address Line 3</label>
				<input type="text" name="addressLine3" placeholder="Optional"><br>
			</div>
			<div class="form-group">
				<label for="cityInput">City</label>
				<input type="text" name="city" placeholder="Ipswich"><br>
			</div>
			<div class="form-group">
				<label for="postcodeInput">Postcode</label>
				<input type="text" name="postcode" placeholder="IP11 0ST"><br>
			</div>
			<div class="form-group">
				<label for="telephoneNumberInput">Telephone Number</label>
				<input type="text" name="telephoneNumber" placeholder="07950881070"><br>
			</div>
			<div class="form-group">
				<label for="emailInput">Email</label>
				<input type="text" name="email" placeholder="example@example.com"><br>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary mdl">Add Customer</button>
			</div>
		</form>
	</div>
</div>

</body>
</html>