<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="xampp/htdocs/htdocs/assets/css/main.css">
	<title>Customer</title>
	<style type="text/css">.modal-body { max-height: calc(100vh - 100px);overflow-y: auto;}</style>
</head>
<body>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<?php if($this->session->flashdata('editError') === 'true') {
	$this->session->set_flashdata('editError', 'false');
	print_r($customerEdit->surname);
	echo '<script type="text/javascript"> 

	$(document).ready(function() {'; ?>
		
	  	<?php echo 'var customerID = '.$customerEdit->customerID.';'; ?>
		<?php echo 'var forename = '.'"'.$customerEdit->forename.'";'; ?>
		<?php echo 'var surname = '.'"'.$customerEdit->surname.'";'; ?>
		<?php echo 'var addressLine1 = '.'"'.$customerEdit->addressLine1.'";'; ?>
		<?php echo 'var addressLine2 = '.'"'.$customerEdit->addressLine2.'";'; ?>
		<?php echo 'var addressLine3 = '.'"'.$customerEdit->addressLine3.'";'; ?>
		<?php echo 'var city = '.'"'.$customerEdit->city.'";'; ?>
		<?php echo 'var postcode = '.'"'.$customerEdit->postcode.'";'; ?>
		<?php echo 'var telephoneNumber = '.'"'.$customerEdit->telephoneNumber.'";'; ?>
		<?php echo 'var email = '.'"'.$customerEdit->email.'";'; ?>
		

		console.log(surname);

		$("#customerIdJson").val(customerID);
        $("#forenameJson").val(forename);
        $("#surnameJson").val(surname);
        $("#addressLine1Json").val(addressLine1);
        $("#addressLine2Json").val(addressLine2);
        $("#addressLine3Json").val(addressLine3);
        $("#cityJson").val(city);
        $("#postcodeJson").val(postcode);
        $("#telephoneNumberJson").val(telephoneNumber);
        $("#emailJson").val(email);
	  
	  $("#editCustomer").modal("show");
	 })
	 </script>';


	
<?php } ?>

<?php if($this->session->flashdata('error') === 'true') {
	$this->session->set_flashdata('error', 'false');
	print_r($customerError->forename);
	echo '<script type="text/javascript"> 

	$(document).ready(function() {'; ?>
		
		<?php echo 'var forename = '.'"'.$customerError->forename.'";'; ?>
		<?php echo 'var surname = '.'"'.$customerError->surname.'";'; ?>
		<?php echo 'var addressLine1 = '.'"'.$customerError->addressLine1.'";'; ?>
		<?php echo 'var addressLine2 = '.'"'.$customerError->addressLine2.'";'; ?>
		<?php echo 'var addressLine3 = '.'"'.$customerError->addressLine3.'";'; ?>
		<?php echo 'var city = '.'"'.$customerError->city.'";'; ?>
		<?php echo 'var postcode = '.'"'.$customerError->postcode.'";'; ?>
		<?php echo 'var telephoneNumber = '.'"'.$customerError->telephoneNumber.'";'; ?>
		<?php echo 'var email = '.'"'.$customerError->email.'";'; ?>
		

		console.log(surname);

        $("#forename").val(forename);
        $("#surname").val(surname);
        $("#addressLine1").val(addressLine1);
        $("#addressLine2").val(addressLine2);
        $("#addressLine3").val(addressLine3);
        $("#city").val(city);
        $("#postcode").val(postcode);
        $("#telephoneNumber").val(telephoneNumber);
        $("#email").val(email);
	  
	  $("#addCustomer").modal("show");
	 })
	 </script>
<?php } ?>

<script type="text/javascript">
	function getCustomersEdit(customerID) {
	console.log(customerID);

	$.ajax({
		url: "http://[::1]/htdocs/index.php/User/getCustomerEditJson",
		type: "POST",
		dataType: "json",
		data: { 'q' : customerID },
		 success: function(data) {
		 		console.log(data);
                $("#customerIdJson").val(data[0].customerID);
                $("#forenameJson").val(data[0].forename);
                $("#surnameJson").val(data[0].surname);
                $("#addressLine1Json").val(data[0].addressLine1);
                $("#addressLine2Json").val(data[0].addressLine2);
                $("#addressLine3Json").val(data[0].addressLine3);
                $("#cityJson").val(data[0].city);
                $("#postcodeJson").val(data[0].postcode);
                $("#telephoneNumberJson").val(data[0].telephoneNumber);
                $("#emailJson").val(data[0].email);
              }
	});
}

/*function editCustomer(){
	var customerID = $("#customerIdJson").val;
    var forename = $("#forenameJson").val;
    var surname = $("#surnameJson").val;
    var addressLine1 = $("#addressLine1Json").val;
    var addressLine2 = $("#addressLine2Json").val;
    var addressLine3 = $("#addressLine3Json").val;
    var city = $("#cityJson").val;
    var postcode = $("#postcodeJson").val;
    var telephoneNumber = $("#telephoneNumberJson").val;
    var email = $("#emailJson").val;

	$.ajax({
		url: "http://[::1]/htdocs/index.php/User/editCustomer",
		type: "POST",
		data: { 'customerIdJson' : customerID,
				'forenameJson' : forename,
				'surnameJson' : surname,
				'addressLine1Json' : addressLine1,
				'addressLine2Json' : addressLine2,
				'addressLine3Json' : addressLine3,
				'cityJson' : city,
				'postcodeJson' : postcode,
				'telephoneNumberJson' : telephoneNumber,
				'emailJson' : email
		 },
		 dataType: "html",
		 success: function(results) {
                alert('Customer edited');
         	}
	});
}
*/
</script>

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">M J Harris Electrical</a>
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
						<?php echo form_error('forename'); ?>
						<label for="forenameInput">Forename</label>
						<input type="text" name="forename" id="forename" placeholder="John"><br>
					</div>
					<div class="form-group">
						<?php echo form_error('surname'); ?>
						<label for="surnameInput">Surname</label>
						<input type="text" name="surname"  id="surname" placeholder="Smith"><br>
					</div>
					<div class="form-group">
						<?php echo form_error('addressLine1'); ?>
						<label for="addressLine1Input">Address Line 1</label>
						<input type="text" name="addressLine1" id="addressLine1" placeholder="10 Example Road"><br>
					</div>
					<div class="form-group">
						<?php echo form_error('addressLine2'); ?>
						<label for="addressLine2Input">Address Line 2</label>
						<input type="text" name="addressLine2" id="addressLine2" placeholder="Optional"><br>
					</div>
					<div class="form-group">
						<?php echo form_error('addressLine3'); ?>
						<label for="addressLine3Input">Address Line 3</label>
						<input type="text" name="addressLine3" id="addressLine3" placeholder="Optional"><br>
					</div>
					<div class="form-group">
						<?php echo form_error('city'); ?>
						<label for="cityInput">City</label>
						<input type="text" name="city" id="city" placeholder="Ipswich"><br>
					</div>
					<div class="form-group">
						<?php echo form_error('postcode'); ?>
						<label for="postcodeInput">Postcode</label>
						<input type="text" name="postcode" id="postcode" placeholder="IP11 0ST"><br>
					</div>
					<div class="form-group">
						<?php echo form_error('telephoneNumber'); ?>
						<label for="telephoneNumberInput">Telephone Number</label>
						<input type="text" name="telephoneNumber" id="telephoneNumber" placeholder="07950881070"><br>
					</div>
					<div class="form-group">
						<?php echo form_error('email'); ?>
						<label for="emailInput">Email</label>
						<input type="text" name="email" id="email" placeholder="example@example.com"><br>
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

<div class="modal fade" id="editCustomer" tabindex="-1" role="dialog" aria-labelledby="editCustomer" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edit Customer</h4>
			</div>
			<div class="modal-body">
				<?php echo form_open('User/editCustomer'); ?>
					<input type="hidden" name="customerIdJson" id="customerIdJson">					
					<div class="form-group">
						<?php echo form_error('forenameJson'); ?>
						<label for="forenameInput">Forename</label>
						<input type="text" name="forenameJson" placeholder="John" id="forenameJson"><br>
					</div>
					<div class="form-group">
						<?php echo form_error('surnameJson'); ?>
						<label for="surnameInput">Surname</label>
						<input type="text" name="surnameJson" placeholder="Smith" id="surnameJson"><br>
					</div>
					<div class="form-group">
						<?php echo form_error('addressLine3Json'); ?>
						<label for="addressLine1Input">Address Line 1</label>
						<input type="text" name="addressLine1Json" placeholder="10 Example Road" id="addressLine1Json"><br>
					</div>
					<div class="form-group">
						<?php echo form_error('addressLine2Json'); ?>
						<label for="addressLine2Input">Address Line 2</label>
						<input type="text" name="addressLine2Json" placeholder="Optional" id="addressLine2Json"><br>
					</div>
					<div class="form-group">
						<?php echo form_error('addressLine3Json'); ?>
						<label for="addressLine3Input">Address Line 3</label>
						<input type="text" name="addressLine3Json" placeholder="Optional" id="addressLine3Json"><br>
					</div>
					<div class="form-group">
						<?php echo form_error('cityJson'); ?>
						<label for="cityInput">City</label>
						<input type="text" name="cityJson" placeholder="Ipswich" id="cityJson"><br>
					</div>
					<div class="form-group">
						<?php echo form_error('postcodeJson'); ?>
						<label for="postcodeInput">Postcode</label>
						<input type="text" name="postcodeJson" placeholder="IP11 0ST" id="postcodeJson"><br>
					</div>
					<div class="form-group">
						<?php echo form_error('telephoneNumberJson'); ?>
						<label for="telephoneNumberInput">Telephone Number</label>
						<input type="text" name="telephoneNumberJson" placeholder="07950881070" id="telephoneNumberJson"><br>
					</div>
					<div class="form-group">
						<?php echo form_error('emailJson'); ?>
						<label for="emailInput">Email</label>
						<input type="text" name="emailJson" placeholder="example@example.com" id="emailJson"><br>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary mdl">Edit Customer</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
				<h1>Welcome to the customer page</h1>
				<?php echo form_open('User/searchCustomer');?>
					<div class="form-inline">
						<div class="form-group">
							<input type="text" name="search" placeholder="14 Test Lane"><br>
						</div>
						<button type="submit" class="btn btn-default inline">Search</button>
					</div>
					
				</form>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<td><strong>Forename</strong></td>
							<td><strong>Surname</strong></td>
							<td><strong>Address Line 1</strong></td>
							<td><strong>Address Line 2</strong></td>
							<td><strong>Address line 3</strong></td>
							<td><strong>City</strong></td>
							<td><strong>Postcode</strong></td>
							<td><strong>Telephone Number</strong></td>
							<td><strong>Email</strong></td>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach ($customer as $customers) { ?>
							<tr>
								<td><?php echo $customers->forename; ?></td>
								<td><?php echo $customers->surname; ?></td>
								<td><?php echo $customers->addressLine1; ?></td>
								<td><?php echo $customers->addressLine2; ?></td>
								<td><?php echo $customers->addressLine3; ?></td>
								<td><?php echo $customers->city; ?></td>
								<td><?php echo $customers->postcode; ?></td>
								<td><?php echo $customers->telephoneNumber; ?></td>
								<td><?php echo $customers->email; ?></td>
								<td><a class="btn btn-secondary" data-toggle="modal" data-target="#editCustomer" <?php echo'id="'.$customers->customerID . '"' ?> role="button" onclick="getCustomersEdit(this.id);">Edit</a></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php
				if ($this->session->flashdata('search')) { //Use Font Awesome?>
				<a href="http://[::1]/htdocs/index.php/User/customerPage">Back</a>
			<?php } ?>
		</div>
	</div>
</div>

</body>
</html>