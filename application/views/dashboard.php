<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../../assets/css/main.css">
	<title>Login</title></head>
<body>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


<script type="text/javascript">

function getCustomers() {
	console.log($('#invoiceCustomer').val());

	$.ajax({
		url: "http://[::1]/htdocs/index.php/User/getCustomerJson",
		type: "POST",
		dataType: "json",
		data: { 'q' : $("#invoiceCustomer").val() },
		 success: function(data) {
		 		console.log(data);
                $('select#customerSelect').html('');
                for(var i=0;i<data.length;i++)
                {
                    $("<option />").val(data[i].customerID).text(data[i].addressLine1).appendTo($('select#customerSelect'));
                }
              }
	});
}

function addMaterialTbl() {
	var selectedName = $('#materialSelect option:selected').text();
	var selectedID = $('#materialSelect option:selected').val();
	var selectedQty = $('#materialQty').val();
	var materialArray = {materialID:selectedID, materialName:selectedName, quantity:selectedQty}; //Add price

	$.ajax({
		url: "http://[::1]/htdocs/index.php/User/getMaterialPriceJson",
		type: "POST",
		dataType: "json",
		data: { 'q' : selectedID },
		 success: function(data) {
		 		console.log("Data: "+data);  
		 		var selectedPrice = data[0].price;
		 		var totalCost = selectedPrice * selectedQty;
                $('#materialTable > tbody:last-child').last().append('<tr class="materialRow"><td>'+selectedName+'</td><td>'+selectedQty+'</td><td>'+totalCost+'</td></tr>');
              }
	});

	//Tests vars output to console 
	console.log(selectedName);
	console.log(selectedID);
	console.log($('#materialQty').val());
	console.log(materialArray);
	//console.log("Price: " + $('#materialUnitPrice').val());
	//console.log("Total Cost: " + totalCost);


}

/*
* When materialSelected is changed, the new price is added to table. 
* Currently not working 

$('#materialSelect')
	.change(function() {
		var selectedID = $('#materialSelect option:selected').val();
		$( "materialSelect option:selected" ).each(function() {
			selectedID = $('#materialSelect option:selected').val();
		});
		$('#materialUnitPrice').text(selectedID);
	})
	.change();
*/

function getMaterials() {
	$.ajax({
		url: "http://[::1]/htdocs/index.php/User/getMaterialJson",
		type: "POST",
		dataType: "json",
		data: { 'q' : $("#materialInput").val() },
		 success: function(data) {
		 		console.log(data);
                $('select#materialSelect').html('');
                for(var i=0;i<data.length;i++)
                {
                    $("<option />").val(data[i].materialsID).text(data[i].materialName).appendTo($('select#materialSelect'));
                }

                if (data.length > 0) {
                	$('#materialUnitPrice').val(data[0].price);
                }
              }
	});
}


</script>

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
	            <li><a href="#" data-toggle="modal" data-target="#addInvoice">Quick Add</a></li>
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
				<?php echo form_open('User/addCustomer'); ?>
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
				<?php echo form_open('User/addMaterial'); ?>
					<div class="form-group">
						<label for="materialNameInput">Material Name</label>
						<input type="text" name="materialName" placeholder="Screw"><br>
					</div>
					<div class="form-group">
						<label for="priceInput">Price</label>
						<input type="text" name="price" placeholder="5.00"><br>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary mdl">Add Material</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="addInvoice" tabindex="-1" role="dialog" aria-labelledby="addInvoice" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add Invoice</h4>
			</div>
			<div class="modal-body">
				<?php echo form_open('User/addInvoice'); ?>
					<div class="form-group">
						<label for="customerInput">Customer</label>
						<input type="text" name="invoiceCustomer" id="invoiceCustomer" onkeyup="getCustomers();">
						<select id="customerSelect">
							<option> Select </option>
						</select><br>
					</div>
					<div class="form-group">
						<label for="hoursWorkedInput">Hours Worked</label>
						<input type="number" name="hoursWorked" placeholder="5"><br>
					</div>
					<div class="form-group">
						<label for="jobDescriptionInput">Job Description</label>
						<input type="text" name="jobDescription" placeholder="Optional"><br>
					</div>
					<div class="form-group">
						<label for="dateCompletedInput">Date Completed</label>
						<input type="date" name="dateCompleted"><br>
					</div>
					<div class="form-group">
						<div class="radio">
						  <label>
						    <input type="radio" name="paidOptions" id="paidRadio" value="1">
						    Paid
						  </label>
						</div>
						<div class="radio">
						  <label>
						    <input type="radio" name="paidOptions" id="unpaidRadio" value="2" checked>
						    Unpaid
						  </label>
						</div>
					</div>
					<div class="form-group">
						<label for="materialInput">Material</label>
						<input type="text" name="materialInput" id="materialInput" onkeyup="getMaterials();">
					</div>
					<div class="form-group">
						<table class="table table-striped table-bordered" id="materialTable">
						<!--
						TODO Add materials search ajax and add to array. Search result dropdown in td.
						-->
							<thead>
								<tr>
									<td>Material</td>
									<td>Qty</td>
									<td>Price</td>
								</tr>
							</thead>
							<tbody>
								<tr><!--  Add confirmed rows below -->
									<td><select id="materialSelect" class="form-control">
											<option> Select </option>
										</select>
									</td>
									<td>
										<input type="number" name="materialQty" id="materialQty" placeholder="5">
									</td>
									<td>
										<input type="disabled" name="materialPrice" id="materialUnitPrice" readonly>
									</td>
									<td>
										<button type="button" class="btn btn-primary mdl" id="addMaterialRow" onclick="addMaterialTbl();">Add Material</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary mdl">Add Invoice</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4 text-center">
				<h1>Welcome to the dashboard</h1>
		</div>
		<div class="col-md-4"></div>
	</div>
</div>

</body>
</html>