<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="xampp/htdocs/htdocs/assets/css/main.css">
	<title>Invoices</title></head>
<body>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script type="text/javascript">

var count = 0;

function getInvoiceEdit(invoiceID) {
console.log(invoiceID);

$.ajax({
	url: "http://[::1]/htdocs/index.php/User/getInvoiceEditJson",
	type: "POST",
	dataType: "json",
	data: { 'q' : invoiceID },
	 success: function(data) {
	 		console.log(data);
            $("#invoiceIDJson").val(data[0].invoiceID);
            $("#invoiceCustomerJson").val(data[0].addressLine1);
            $("#hoursWorkedJson").val(data[0].hoursWorked);
            $("#totalPriceJson").val(data[0].totalPrice);
            $("#jobDescriptionJson").val(data[0].jobDescription);
            $("#dateCompletedJson").val(data[0].dateCompleted);
            if (data[0].paid == 1) {
            	$('#paidRadioJson').prop('checked', true);
            }
          }
});


}

function outputTable(invoiceID){
	$.ajax({
	url: "http://[::1]/htdocs/index.php/User/jobMaterialsEditJson",
	type: "POST",
	dataType: "json",
	data: { 'q' : invoiceID },
	 success: function(data) {
	 		console.log(data);           
            for (var i = 0; i < data.length; i++) {
                $('#materialTableJson > tbody:last-child').last().append('<tr class="materialRowJson" id="materialRow'+count+'"><td>'+data[i].materialName+'</td><td class="materialQtyJson">'+data[i].quantity+'</td><td>'+data[i].totalCost+'</td><input type="hidden" name="materialQtyDataJson[]" value="'+data[i].quantity+'"/><input type="hidden" name="materialTotalPriceJson[]" value="'+data[i].totalCost+'"/><input type="hidden" name="materialIdDataJson[]" value="'+data[i].materialsID+'"/><td><a class="btn btn-danger" id="'+count+'" role="button" onclick="removeRowEdit(this.id);">Remove</a></td></tr>');
                count++;
            }            
          }
});
}

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

function getCustomersEdit() {
	console.log($('#invoiceCustomerJson').val());

	$.ajax({
		url: "http://[::1]/htdocs/index.php/User/getCustomerJson",
		type: "POST",
		dataType: "json",
		data: { 'q' : $("#invoiceCustomerJson").val() },
		 success: function(data) {
		 		console.log(data);
                $('select#customerSelectJson').html('');
                for(var i=0;i<data.length;i++)
                {
                    $("<option />").val(data[i].customerID).text(data[i].addressLine1).appendTo($('select#customerSelectJson'));
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
                $('#materialTable > tbody:last-child').last().append('<tr class="materialRow" id="materialRow'+count+'"><td>'+selectedName+'</td><td class="materialQty">'+selectedQty+'</td><td>'+totalCost+'</td><input type="hidden" name="materialQtyData[]" value="'+selectedQty+'"/><input type="hidden" name="materialTotalPrice[]" value="'+totalCost+'"/><input type="hidden" name="materialIdData[]" value="'+selectedID+'"/><td><a class="btn btn-danger" id="'+count+'" role="button" onclick="removeRowEdit(this.id);">Remove</a></td></tr>');
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

function addMaterialTblEdit() {
	var selectedName = $('#materialSelectJson option:selected').text();
	var selectedID = $('#materialSelectJson option:selected').val();
	var selectedQty = $('#materialQtyJson').val();
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
                $('#materialTableJson > tbody:last-child').last().append('<tr class="materialRowJson" id="materialRow'+count+'"><td>'+selectedName+'</td><td class="materialQtyJson">'+selectedQty+'</td><td>'+totalCost+'</td><input type="hidden" name="materialQtyDataJson[]" value="'+selectedQty+'"/><input type="hidden" name="materialTotalPriceJson[]" value="'+totalCost+'"/><input type="hidden" name="materialIdDataJson[]" value="'+selectedID+'"/><td><a class="btn btn-danger" id="'+count+'" role="button" onclick="removeRowEdit(this.id);">Remove</a></td></tr>');
                count++;
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

function getMaterialsEdit() {
	$.ajax({
		url: "http://[::1]/htdocs/index.php/User/getMaterialJson",
		type: "POST",
		dataType: "json",
		data: { 'q' : $("#materialInputJson").val() },
		 success: function(data) {
		 		console.log(data);
                $('select#materialSelectJson').html('');
                for(var i=0;i<data.length;i++)
                {
                    $("<option />").val(data[i].materialsID).text(data[i].materialName).appendTo($('select#materialSelectJson'));
                }

                if (data.length > 0) {
                	$('#materialUnitPriceJson').val(data[0].price);
                }
              }
	});
}

function removeRowEdit(rowid){ 
	var row = "#materialRow" + rowid;
	$(row).remove();
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
	            <li><a href="http://[::1]/htdocs/index.php/User/invoicePage">Manage Invoices</a></li>
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
				<?php echo form_open('User/addInvoiceController'); ?>
					<div class="form-group">
						<label for="customerInput">Customer</label>
						<input type="text" name="invoiceCustomer" id="invoiceCustomer" onkeyup="getCustomers();">
						<select id="customerSelect" name="customerSelect">
							<option> Select </option>
						</select><br>
					</div>
					<div class="form-group">
						<label for="hoursWorkedInput">Hours Worked</label>
						<input type="number" name="hoursWorked" placeholder="5"><br>
					</div>
					<div class="form-group">
						<label for="totalPriceInput">Total Price</label>
						<input type="number" step="0.01" name="totalPrice" placeholder="100.00"><br>
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
										<input type="disabled" name="materialPrice" step="0.01" id="materialUnitPrice" readonly>
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

<div class="modal fade" id="editInvoice" tabindex="-1" role="dialog" aria-labelledby="editInvoice" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edit Invoice</h4>
			</div>
			<div class="modal-body">
				<?php echo form_open('User/editInvoice'); ?>
					<input type="hidden" name="invoiceIDJson" id="invoiceIDJson">
					<div class="form-group">
						<label for="customerInput">Customer</label>
						<input type="text" name="invoiceCustomerJson" id="invoiceCustomerJson" onkeyup="getCustomersEdit();">
						<select id="customerSelectJson" name="customerSelectJson">
							<option> Select </option>
						</select><br>
					</div>
					<div class="form-group">
						<label for="hoursWorkedInput">Hours Worked</label>
						<input type="number" name="hoursWorkedJson" placeholder="5" id="hoursWorkedJson"><br>
					</div>
					<div class="form-group">
						<label for="totalPriceInput">Total Price</label>
						<input type="number" step="0.01" name="totalPriceJson" placeholder="100.00" id="totalPriceJson"><br>
					</div>
					<div class="form-group">
						<label for="jobDescriptionInput">Job Description</label>
						<input type="text" name="jobDescriptionJson" placeholder="Optional" id="jobDescriptionJson"><br>
					</div>
					<div class="form-group">
						<label for="dateCompletedInput">Date Completed</label>
						<input type="date" name="dateCompletedJson" id="dateCompletedJson"><br>
					</div>
					<div class="form-group">
						<div class="radio">
						  <label>
						    <input type="radio" name="paidOptionsJson" id="paidRadioJson" value="1">
						    Paid
						  </label>
						</div>
						<div class="radio">
						  <label>
						    <input type="radio" name="paidOptionsJson" id="unpaidRadioJson" value="2" checked>
						    Unpaid
						  </label>
						</div>
					</div>
					<div class="form-group">
						<label for="materialInput">Material</label>
						<input type="text" name="materialInputJson" id="materialInputJson" onkeyup="getMaterialsEdit();">
					</div>
					<div class="form-group">
						<table class="table table-striped table-bordered" id="materialTableJson">
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
									<td><select id="materialSelectJson" class="form-control">
											<option> Select </option>
										</select>
									</td>
									<td>
										<input type="number" name="materialQtyJson" id="materialQtyJson" placeholder="5">
									</td>
									<td>
										<input type="disabled" name="materialPriceJson" step="0.01" id="materialUnitPriceJson" readonly>
									</td>
									<td>
										<button type="button" class="btn btn-primary mdl" id="addMaterialRowJson" onclick="addMaterialTblEdit();">Add Material</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary mdl">Edit Invoice</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<h1>Welcome to the Invoice page</h1>
		<?php echo form_open('User/searchInvoice');?>
			<div class="form-inline">
				<div class="form-group">
					<input type="text" name="search" placeholder="Address Line 1"><br>
				</div>
				<button type="submit" class="btn btn-default inline">Search</button>
			</div>
					
		</form>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<td><strong>Hours Worked</strong></td>
					<td><strong>Total Cost</strong></td>
					<td><strong>Total Price</strong></td>
					<td><strong>Date Completed</strong></td>
					<td><strong>Address Line 1</strong></td>
					<td><strong>Paid</strong></td>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach ($invoice as $invoices) { ?>
					<tr>
						<td><?php echo $invoices->hoursWorked; ?></td>
						<td><?php echo '£'.$invoices->totalCost; ?></td>
						<td><?php echo '£'.$invoices->totalPrice; ?></td>
						<td><?php echo $invoices->dateCompleted; ?></td>
						<td><?php echo $invoices->addressLine1; ?></td>
						<td><?php if($invoices->paid == 1) {
							echo "Paid";
						} else {
							echo "Unpaid";
						} ?></td>
						<td><a <?php echo 'href="http://[::1]/htdocs/assets/pdf/'.$invoices->invoiceLink.'"';?> target="_blank">Invoice</a></td>
						<td><a class="btn btn-secondary" data-toggle="modal" data-target="#editInvoice" <?php echo'id="'.$invoices->invoiceID . '"' ?> role="button" onclick="getInvoiceEdit(this.id); outputTable(this.id);">Edit</a></td>
						<td><a class="btn btn-danger" <?php echo 'href="http://[::1]/htdocs/index.php/User/deleteInvoice/'.$invoices->invoiceID . '"' ?> role="button">Delete</a></td>
								
					</tr>
				<?php } ?>
			</tbody>
		</table> 
		<?php
		if ($this->session->flashdata('search')) { //Use Font Awesome?>
			<a href="http://[::1]/htdocs/index.php/User/invoicePage">Back</a>
	    <?php } ?>
	</div>
</div>

</body>
</html>