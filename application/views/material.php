<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="xampp/htdocs/htdocs/assets/css/main.css">
	<title>Material</title>
	<style type="text/css">.modal-body { max-height: calc(100vh - 100px);overflow-y: auto;}</style>
</head>
<body>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<?php if($this->session->flashdata('error') === 'true') {
	$this->session->set_flashdata('error', 'false');
	echo '<script type="text/javascript"> 

	$(document).ready(function() {'; ?>
		
		<?php echo 'var materialName = '.'"'.$materialError->materialName.'";'; ?>
		<?php echo 'var price = '.'"'.$materialError->price.'";'; ?>		

		console.log(materialName);

        $("#materialName").val(materialName);
        $("#price").val(price);
        
	  
	  $("#addMaterial").modal("show");
	 })
	 </script>
<?php } ?>

<?php if($this->session->flashdata('editError') === 'true') {
	$this->session->set_flashdata('editError', 'false');
	echo '<script type="text/javascript"> 

	$(document).ready(function() {'; ?>
		
		<?php echo 'var materialName = '.'"'.$materialEditError->materialName.'";'; ?>
		<?php echo 'var price = '.'"'.$materialEditError->price.'";'; ?>		
		<?php echo 'var materialID = '.'"'.$materialEditError->materialID.'";'; ?>	

		console.log(materialName);

        $("#materialNameJson").val(materialName);
        $("#priceJson").val(price);
        $("#materialIdJson").val(materialID);
        
	  
	  $("#editMaterial").modal("show");
	 })
	 </script>
<?php } ?>

<script type="text/javascript">
	/*
	* Function to get material values 
	* and add them to material edit modal
	*/
	function getMaterialsEdit(materialsID) {
	console.log(materialsID);

	$.ajax({
		url: "http://[::1]/htdocs/index.php/User/getMaterialEditJson",
		type: "POST",
		dataType: "json",
		data: { 'q' : materialsID },
		 success: function(data) {
		 		console.log(data);
                $("#materialIdJson").val(data[0].materialsID);
                $("#materialNameJson").val(data[0].materialName);
                $("#priceJson").val(data[0].price);                
              }
	});
}
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
						<?php echo form_error('materialName'); ?>
						<label for="materialNameInput">Material Name</label>
						<input type="text" name="materialName" id="materialName" placeholder="Screw"><br>
					</div>
					<div class="form-group">
						<?php echo form_error('price'); ?>
						<label for="priceInput">Price</label>
						<input type="number" name="price" id="price" step="any" placeholder="£5.00"><br>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary mdl">Add Material</button>
					</div>
				</form>
			</div>
		</div>
	</div>	
</div>

<div class="modal fade" id="editMaterial" tabindex="-1" role="dialog" aria-labelledby="editMaterial" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edit Material</h4>
			</div>
			<div class="modal-body">
				<?php echo form_open('User/editMaterial');?>
					<input type="hidden" name="materialIdJson" id="materialIdJson">	
					<div class="form-group">
						<?php echo form_error('materialIdJson'); ?>
						<?php echo form_error('materialNameJson'); ?>
						<label for="forenameInput">Material Name</label>
						<input type="text" name="materialNameJson" id="materialNameJson"><br>
					</div>
					<div class="form-group">
						<?php echo form_error('priceJson'); ?>
						<label for="surnameInput">Price</label>
						<input type="number" name="priceJson" step="any" id="priceJson"><br>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary mdl">Edit Material</button>
					</div>
				</form>
			</div>
		</div>
	</div>	
</div>

<div class="container">
	<div class="row">
		<h1>Welcome to the Material page</h1>
		<?php echo form_open('User/searchMaterial');?>
			<div class="form-inline">
				<?php echo form_error('search');?>
				<div class="form-group">
					<input type="text" name="search" placeholder="Item"><br>
				</div>
				<button type="submit" class="btn btn-default inline">Search</button>
			</div>
					
		</form>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<td><strong>Material Name</strong></td>
					<td><strong>Price</strong></td>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach ($material as $materials) { ?>
					<tr>
						<td><?php echo $materials->materialName; ?></td>
						<td><?php echo '£'.$materials->price; ?></td>
						<td><a class="btn btn-secondary" data-toggle="modal" data-target="#editMaterial" <?php echo'id="'.$materials->materialsID . '"' ?> role="button" onclick="getMaterialsEdit(this.id);">Edit</a></td>
					</tr>
				<?php } ?>
			</tbody>
		</table> 
		<?php
		echo $links;
		if ($this->session->flashdata('search')) { //Use Font Awesome?>
			<a href="http://[::1]/htdocs/index.php/User/materialPage">Back</a>
	    <?php } ?>
	</div>
</div>

</body>
</html>