<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class User extends CI_Controller{


	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->model('Table');
		$this->load->library('pdf');
		define('FPDF_FONTPATH', '\xampp\htdocs\htdocs\font');
		//TODO Fix
		
		/*if (!$this->ion_auth->logged_in()) {
			redirect('User/index');
		}
		*/
		
	}

	/*
	* Function to load login page
	*/
	public function index(){
		$this->load->view('welcome_message');
	}

	public function login(){
		$this->form_validation->set_rules('username', 'Username', 'required|max_length[100]');
		$this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
		if(!$this->form_validation->run()){
			$this->load->view('welcome_message');
			//echo "Error, incorrect username or password";
		} else if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'))) {
			if (!$this->ion_auth->is_admin()) {
				redirect('User/dashboard');
			} else {
				redirect('User/adminPage');
			}
		} else {
			$this->session->set_flashdata('auth_message', $this->ion_auth->errors());
            $this->load->view('welcome_message');

		}
		
	}

	public function dashboard(){
		if (!$this->ion_auth->logged_in()) {
			redirect('User/index');
		} else {
			$data['invoice'] = $this->Table->getInvoicesDashboard();
			$this->load->view('dashboard', $data);
		}
	}

	public function adminPage() {	
		if (!$this->ion_auth->is_admin() || !$this->ion_auth->logged_in()) {
			redirect('User/index');
		} else {
			$data['user'] = $this->Table->getUsers();
			$this->load->view('adminDashboard', $data);
		}
	}

	public function customerPage(){
		if (!$this->ion_auth->logged_in()) {
			redirect('User/index');
		} else {
			$data['customer'] = $this->Table->getCustomers();
			$this->load->view('customer', $data);	
		}		
	}

	public function materialPage(){
		if (!$this->ion_auth->logged_in()) {
			redirect('User/index');
		} else {
			$data['material'] = $this->Table->getMaterials();
			$this->load->view('material', $data);
		}	
	}

	public function invoicePage(){
		if (!$this->ion_auth->logged_in()) {
			redirect('User/index');
		} else {
			//write function in table
			$data['invoice'] = $this->Table->getInvoices();
			$this->load->view('invoice', $data);
		}
	}

	public function getCustomerJson(){
		//TODO Add validation xxs_clean & No results found
		$address = $this->input->post('q');
		$data = $this->Table->customerSearch($address);

		echo json_encode($data);
		die();
	}

	public function getCustomerEditJson(){
		//TODO Add validation xxs_clean & No results found
		$id = $this->input->post('q');
		$data = $this->Table->customerJsonSearch($id);

		echo json_encode($data);
		die();
	}

	public function getInvoiceEditJson(){
		//TODO Add validation xxs_clean & No results found
		$id = $this->input->post('q');
		$data = $this->Table->invoiceEditJsonSearch($id);
		

		echo json_encode($data);
		die();
	}

	public function jobMaterialsEditJson(){
		$id = $this->input->post('q');
		$data = $this->Table->getJobmaterials($id);

		echo json_encode($data);
		die();
	}

	public function getMaterialJson(){
		//TODO Add validation
		$name = $this->input->post('q');
		$data = $this->Table->materialSearch($name);

		echo json_encode($data);
		die();
	}

	public function getMaterialEditJson(){
		//TODO Add validation
		$id = $this->input->post('q');
		$data = $this->Table->getMaterialsJson($id);

		echo json_encode($data);
		die();
	}

	public function getMaterialPriceJson(){
		//TODO Add validation
		$materialID = $this->input->post('q');
		$data = $this->Table->materialPriceSearch($materialID);

		echo json_encode($data);
		die();
	}
	/*
	* Function to edit user 
	*/
	public function editUser($userId){
		$this->form_validation->set_rules('username', 'Username', 'required|max_length[100]');
		$this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
		$this->form_validation->set_rules('retypepassword', 'Retypepassword', 'required|max_length[20]', 'callback_passwordsMatch');
		$this->form_validation->set_rules('email', 'Email', 'required|max_length[45]');
		$this->form_validation->set_rules('group[]', 'Group', 'required', 'integer');
	}

	/*
	* Function to edit customer
	*/
	public function editCustomer(){
		//Validation rules
		$this->form_validation->set_rules('forenameJson', 'Forename', 'required|max_length[45]');
		$this->form_validation->set_rules('surnameJson', 'Surname', 'required|max_length[45]');
		$this->form_validation->set_rules('addressLine1Json', 'AddressLine1', 'required|max_length[75]');
		$this->form_validation->set_rules('addressLine2Json', 'AddressLine2', 'max_length[75]');
		$this->form_validation->set_rules('addressLine3Json', 'AddressLine3', 'max_length[75]');
		$this->form_validation->set_rules('cityJson', 'City', 'required|max_length[45]');
		$this->form_validation->set_rules('postcodeJson', 'Postcode', 'required|max_length[8]');
		$this->form_validation->set_rules('telephoneNumberJson', 'TelephoneNumber', 'required|max_length[11]');
		$this->form_validation->set_rules('emailJson', 'Email', 'required|max_length[75]');

		if (!$this->form_validation->run()){
			$this->session->set_flashdata('editError', 'true');

			$customerID = $this->input->post('customerIdJson');
			$forename = $this->input->post('forenameJson');
			$surname = $this->input->post('surnameJson');
			$addressLine1 = $this->input->post('addressLine1Json');
			$addressLine2 = $this->input->post('addressLine2Json');
			$addressLine3 = $this->input->post('addressLine3Json');
			$city = $this->input->post('cityJson');
			$postcode = $this->input->post('postcodeJson');
		    $telephoneNumber = $this->input->post('telephoneNumberJson');
			$email = $this->input->post('emailJson');

			$editCustomerData = (object) array(
				'customerID' => $customerID,
				'forename' => $forename,
				'surname' => $surname,
				'addressLine1' => $addressLine1,
				'addressLine2' => $addressLine2,
				'addressLine3' => $addressLine3,
				'city' => $city,
				'postcode' => $postcode,
				'telephoneNumber' => $telephoneNumber,
				'email' => $email
			);

			$data['customerEdit'] = $editCustomerData;

			$data['customer'] = $this->Table->getCustomers();

			$this->load->view('customer', $data);
		} else {
			$customerID = $this->input->post('customerIdJson');
			$forename = $this->input->post('forenameJson');
			$surname = $this->input->post('surnameJson');
			$addressLine1 = $this->input->post('addressLine1Json');
			$addressLine2 = $this->input->post('addressLine2Json');
			$addressLine3 = $this->input->post('addressLine3Json');
			$city = $this->input->post('cityJson');
			$postcode = $this->input->post('postcodeJson');
		    $telephoneNumber = $this->input->post('telephoneNumberJson');
			$email = $this->input->post('emailJson');

			$data = array(
				'forename' => $forename,
				'surname' => $surname,
				'addressLine1' => $addressLine1,
				'addressLine2' => $addressLine2,
				'addressLine3' => $addressLine3,
				'city' => $city,
				'postcode' => $postcode,
				'telephoneNumber' => $telephoneNumber,
				'email' => $email
			);

			//get current page
			//$currentPage = $this->uri->uri_string();

			$this->Table->editCustomer($data, $customerID);

			echo '<script>alert("Customer successfully editted!");</script>';
			//TODO Add code to determine users page so they are not redirected to an incorrect page
			redirect('User/customerPage', 'refresh');
		}
	}

	public function editInvoice(){
		if (!$this->ion_auth->logged_in()) {
			redirect('User/index');
		} else {

			$this->form_validation->set_rules('invoiceIDJson', 'invoiceID', 'required|integer');
			$this->form_validation->set_rules('customerSelectJson', 'customerSelect', 'required|integer');
			$this->form_validation->set_rules('hoursWorkedJson', 'Hours Worked', 'required|integer');
			$this->form_validation->set_rules('totalPriceJson', 'Total Price', 'required|decimal');
			$this->form_validation->set_rules('jobDescriptionJson', 'Job Descripton', 'required|max_length[175]');
			$this->form_validation->set_rules('dateCompletedJson', 'Date Completed', 'required');
			$this->form_validation->set_rules('paidOptionsJson', 'Paid Option', 'required|integer');
			$this->form_validation->set_rules('materialIdDataJson[]', 'Material ID', 'required|integer');
			$this->form_validation->set_rules('materialQtyDataJson[]', 'Material Qty', 'required|integer');
			$this->form_validation->set_rules('materialTotalPriceJson[]', 'Material Price', 'required|decimal');

			if (!$this->form_validation->run()) {
				$error = validation_errors();
				echo $error;
				//LOOK AT HOW CUSTOMERS WORKS
			} else {
				$invoiceID = $this->input->post('invoiceIDJson');					
				$invoiceTotalCost = 0.00;

				//Data for JobMaterials Table
				$materialID = $this->input->post('materialIdDataJson');
				$materialQty = $this->input->post('materialQtyDataJson');
				$materialTotalPrice = $this->input->post('materialTotalPriceJson');

				//Assign values from material table to array
				for ($i=0; $i < count($materialID); $i++) { 
					$invoiceTotalCost = $invoiceTotalCost + $materialTotalPrice[$i];
				}

				//Invoice Data
				$customerID = $this->input->post('customerSelectJson');
				$hoursWorked = $this->input->post('hoursWorkedJson');
				$totalPrice = $this->input->post('totalPriceJson');
				$jobDescription = $this->input->post('jobDescriptionJson');
				$dateCompleted = $this->input->post('dateCompletedJson');
				$paid = $this->input->post('paidOptionsJson');
				$dateCreated = date("Y-m-d");
				$dateCreatedDB = date('Y-m-d', strtotime(str_replace('-', '/', $dateCreated)));

				$addressLine1 = $this->Table->getAddressLine1($customerID);
				$filename = 'MJH'.$addressLine1.$dateCreated.'.pdf';

				$invoiceData = array(
					'hoursWorked' => $hoursWorked,
					'jobDescription' => $jobDescription,
					'totalCost' => $invoiceTotalCost,
					'totalPrice' => $totalPrice,
					'dateCompleted' => $dateCompleted,
					'paid' => $paid,
					'invoiceLink' => $filename,
					'customersID' => $customerID,
					'invoiceCreated' => $dateCreatedDB
				);


				//Insert Invoice to db
				$this->Table->editInvoice($invoiceData, $invoiceID);

				//Declare array to store jobmaterials data to insert to db
				$jobMaterialData = [];

				for ($j=0; $j < sizeof($materialID); $j++) { 
					$jobMaterialData[] = array(
						'invoiceID' => $invoiceID,
						'materialsID' => $materialID[$j],
						'quantity' => $materialQty[$j],
						'totalCost' => $materialTotalPrice[$j]
					);	
				}
		
				//Remove old JobMaterials
				$this->Table->deleteJobMaterials($invoiceID);
				//Insert $jobMaterials array to db
				$this->Table->addJobMaterials($jobMaterialData);

				//Send data to createPdf controller
				$this->session->set_flashdata('nextID', $invoiceID);
				$this->session->set_flashdata('customerID', $customerID);
				$this->session->set_flashdata('totalCost', $invoiceTotalCost);
				$this->session->set_flashdata('filename', $filename);


				//Redirect to invoicePage 
				redirect('User/createPdf');
			}
		}
	}

	public function deleteUser($id){
		if (!$this->ion_auth->is_admin() || !$this->ion_auth->logged_in()) {
			redirect('User/index');
		} else {
			$this->ion_auth->delete_user($id);
			redirect('User/adminPage', 'refresh');
		}
	}

	public function editMaterial(){
		$this->form_validation->set_rules('materialIdJson', 'materialIdJson', 'required');
		$this->form_validation->set_rules('materialNameJson', 'MaterialNameJson', 'required|max_length[45]');
		$this->form_validation->set_rules('priceJson', 'PriceJson', 'required');

		if (!$this->form_validation->run()) {
			$error = validation_errors();
		} else {
			
			$data = array(
				'materialName' => $this->input->post('materialNameJson'),
				'price' => $this->input->post('priceJson')
			);

			$id = $this->input->post('materialIdJson');

			$this->Table->editMaterial($data, $id);

			echo '<script>alert("Material successfully edited!");</script>';

			redirect('User/materialPage', 'refresh');			
		}
	}

	public function deleteInvoice($id){
		if (!$this->ion_auth->logged_in()) {
			redirect('User/index');
		} else {
			$this->Table->deleteInvoice($id);
			echo '<script>alert("Invoice Deleted");</script>';
			redirect('User/invoicePage', 'refresh');
		}
	}

	/*
	public function deleteCustomer($id){
		if (!$this->ion_auth->logged_in()) {
			redirect('User/index');
		} else {
			$this->Table->deleteCustomer($id);
			redirect('User/customerPage', 'refresh');
		}
	}

	public function deleteMaterial($id){
		if (!$this->ion_auth->logged_in()) {
			redirect('User/index');
		} else {
			$this->Table->deleteMaterial($id);
			redirect('User/materialPage', 'refresh');
		}
	}
	*/
	

	/**
	* Function to get data from invoice form, check it is valid and send to model.
	* TODO Fix totalCost, dateCreated and add labour costs to totalCost CHANGE SIZE OF IT DOESNT ITERATE PROPERLY
	*/
	public function addInvoiceController(){
		if (!$this->ion_auth->logged_in()) {
			redirect('User/index');
		} else {
			$invoiceTotalCost = 0.00;

			//Data for JobMaterials Table
			$materialID = $this->input->post('materialIdData');
			$materialQty = $this->input->post('materialQtyData');
			$materialTotalPrice = $this->input->post('materialTotalPrice');

			//Assign values from material table to array
			for ($i=0; $i < count($materialID); $i++) { 
				$invoiceTotalCost = $invoiceTotalCost + $materialTotalPrice[$i];
			}

			//Invoice Data
			$customerID = $this->input->post('customerSelect');
			$hoursWorked = $this->input->post('hoursWorked');
			$totalPrice = $this->input->post('totalPrice');
			$jobDescription = $this->input->post('jobDescription');
			$dateCompleted = $this->input->post('dateCompleted');
			$paid = $this->input->post('paidOptions');
			$dateCreated = date("Y-m-d");
			$dateCreatedDB = date('Y-m-d', strtotime(str_replace('-', '/', $dateCreated)));

			$addressLine1 = $this->Table->getAddressLine1($customerID);
			$filename = 'MJH'.$addressLine1.$dateCreated.'.pdf';

			$invoiceData = array(
				'hoursWorked' => $hoursWorked,
				'jobDescription' => $jobDescription,
				'totalCost' => $invoiceTotalCost,
				'totalPrice' => $totalPrice,
				'dateCompleted' => $dateCompleted,
				'paid' => $paid,
				'invoiceLink' => $filename,
				'customersID' => $customerID,
				'invoiceCreated' => $dateCreatedDB
			);

			//Insert Invoice to db
			$this->Table->addInvoice($invoiceData);

			//Get next id of invoices assign it to $nextID
			$nextID = $this->Table->getNextInvoiceId();

			//Declare array to store jobmaterials data to insert to db
			$jobMaterialData = [];

			for ($j=0; $j < sizeof($materialID); $j++) { 
				$jobMaterialData[] = array(
					'invoiceID' => $nextID,
					'materialsID' => $materialID[$j],
					'quantity' => $materialQty[$j],
					'totalCost' => $materialTotalPrice[$j]
				);	
			}

			//Insert $jobMaterials array to db
			$this->Table->addJobMaterials($jobMaterialData);

			//Send data to createPdf controller
			$this->session->set_flashdata('nextID', $nextID);
			$this->session->set_flashdata('customerID', $customerID);
			$this->session->set_flashdata('totalCost', $invoiceTotalCost);
			$this->session->set_flashdata('filename', $filename);


			//Redirect to invoicePage 
			redirect('User/createPdf');
		}
	}

	public function markAsPaid($id){
		if (!$this->ion_auth->logged_in()) {
			redirect('User/index');
		} else {
			$this->Table->markAsPaid($id);
			redirect('User/dashboard', 'refresh');
		}
	}

	public function searchInvoice(){
		$this->form_validation->set_rules('search', 'Search', 'required|max_length[100]');

		if (!$this->form_validation->run()) {
			$error = validation_errors();
		} else {
			$search = $this->input->post('search');
			//get search results from model
			$data['invoice'] = $this->Table->invoiceSearch($search);
			$this->session->set_flashdata('search', 'TRUE');
			$this->load->view('invoice', $data);
			//TODO ADD MESSAGE IF NO RESULTS PRESENT 
		}
	}

	public function searchInvoiceDash(){
		$this->form_validation->set_rules('search', 'Search', 'required|max_length[100]');

		if (!$this->form_validation->run()) {
			$error = validation_errors();
		} else {
			$search = $this->input->post('search');
			//get search results from model
			$data['invoice'] = $this->Table->invoiceSearch($search);
			$this->session->set_flashdata('search', 'TRUE');
			$this->load->view('dashboard', $data);
			//TODO ADD MESSAGE IF NO RESULTS PRESENT 
		}
	}

	/*
	* This method adds a new user if the form inputs are valid
	*/
	public function addUser(){
		//Set form validation rules for every input
		$this->form_validation->set_rules('username', 'Username', 'required|max_length[100]');
		$this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
		$this->form_validation->set_rules('retypepassword', 'Retypepassword', 'required|max_length[20]', 'callback_passwordsMatch');
		$this->form_validation->set_rules('email', 'Email', 'required|max_length[45]');
		$this->form_validation->set_rules('group[]', 'Group', 'required', 'integer');

		if (!$this->form_validation->run()) {
			//Validation fail
			$error = validation_errors();
			$this->load->view('adminDashboard', $error);
		} else {
			//Validation success
			$this->ion_auth->register(
				$this->input->post('username'),
				$this->input->post('password'),
				$this->input->post('email'),
				$this->input->post('group')
			);
			
			$this->session->set_flashdata('message',$this->ion_auth->messages());
    		redirect('User/adminPage','refresh');
		}

	}

	/*
	* Add customer to database
	*/
	public function addCustomer(){
		//Validation rules
		$this->form_validation->set_rules('forename', 'Forename', 'required|max_length[45]');
		$this->form_validation->set_rules('surname', 'Surname', 'required|max_length[45]');
		$this->form_validation->set_rules('addressLine1', 'AddressLine1', 'required|max_length[75]');
		$this->form_validation->set_rules('addressLine2', 'AddressLine2', 'max_length[75]');
		$this->form_validation->set_rules('addressLine3', 'AddressLine3', 'max_length[75]');
		$this->form_validation->set_rules('city', 'City', 'required|max_length[45]');
		$this->form_validation->set_rules('postcode', 'Postcode', 'required|max_length[8]');
		$this->form_validation->set_rules('telephoneNumber', 'TelephoneNumber', 'required|max_length[11]');
		$this->form_validation->set_rules('email', 'Email', 'required|max_length[75]');

		if (!$this->form_validation->run()){
			//If input is invalid set error to true and return data
			$error = validation_errors();
			$this->session->set_flashdata('error', 'true');

			//Get get inputs
			$forename = $this->input->post('forename');
			$surname = $this->input->post('surname');
			$addressLine1 = $this->input->post('addressLine1');
			$addressLine2 = $this->input->post('addressLine2');
			$addressLine3 = $this->input->post('addressLine3');
			$city = $this->input->post('city');
			$postcode = $this->input->post('postcode');
		    $telephoneNumber = $this->input->post('telephoneNumber');
			$email = $this->input->post('email');

			//Store inputs as associative array of objects
			$customerData = (object) array(
				'forename' => $forename,
				'surname' => $surname,
				'addressLine1' => $addressLine1,
				'addressLine2' => $addressLine2,
				'addressLine3' => $addressLine3,
				'city' => $city,
				'postcode' => $postcode,
				'telephoneNumber' => $telephoneNumber,
				'email' => $email
			);

			$data['customerError'] = $customerData;

			$data['customer'] = $this->Table->getCustomers();
			//Load customer page and send data back
			$this->load->view('customer', $data);
		} else {
			//If data is valid store inputs
			$forename = $this->input->post('forename');
			$surname = $this->input->post('surname');
			$addressLine1 = $this->input->post('addressLine1');
			$addressLine2 = $this->input->post('addressLine2');
			$addressLine3 = $this->input->post('addressLine3');
			$city = $this->input->post('city');
			$postcode = $this->input->post('postcode');
		    $telephoneNumber = $this->input->post('telephoneNumber');
			$email = $this->input->post('email');
			//Add inputs to data array
			$data = array(
				'forename' => $forename,
				'surname' => $surname,
				'addressLine1' => $addressLine1,
				'addressLine2' => $addressLine2,
				'addressLine3' => $addressLine3,
				'city' => $city,
				'postcode' => $postcode,
				'telephoneNumber' => $telephoneNumber,
				'email' => $email
			);

			//Insert data array to customers table
			$this->Table->addCustomer($data);

			echo '<script>alert("Customer successfully added!");</script>';
			//redircet customers to customer page and refresh
			redirect('User/customerPage', 'refresh');
		}
	}

	public function passwordsMatch($password){
		$retypepassword = $this->input->post('retypepassword');

		if($password == $retypepassword) {
			return TRUE;
		} else {
			$this->form_validation->set_message('passwordsMatch', 'The passwords do not match');
			return FALSE;
		}
	}

	public function searchCustomer(){
		$this->form_validation->set_rules('search', 'Search', 'required|max_length[100]');

		if (!$this->form_validation->run()) {
			$error = validation_errors();
		} else {
			$search = $this->input->post('search');
			//get search results from model
			$data['customer'] = $this->Table->customerSearch($search);
			$this->session->set_flashdata('search', 'TRUE');
			$this->load->view('customer', $data);
			//TODO ADD MESSAGE IF NO RESULTS PRESENT 
		}
	}

	public function searchMaterial(){
		$this->form_validation->set_rules('search', 'Search', 'required|max_length[100]');

		if (!$this->form_validation->run()) {
			$error = validation_errors();
		} else {
			$search = $this->input->post('search');

			$data['material'] = $this->Table->materialSearch($search);
			$this->session->set_flashdata('search', 'TRUE');
			$this->load->view('material', $data);
		}
	}

	public function addMaterial(){
		$this->form_validation->set_rules('materialName', 'MaterialName', 'required|max_length[45]');
		$this->form_validation->set_rules('price', 'Price', 'required');

		if (!$this->form_validation->run()) {
			$error = validation_errors();
		} else {
			$materialName = $this->input->post('materialName');
			$materialName = $this->security->xss_clean($materialName);

			$data = array(
				'materialName' => $materialName,
				'price' => $this->input->post('price')
			);

			$this->Table->addMaterial($data);

			redirect('User/materialPage', 'refresh');

			echo '<script>alert("Material successfully added!");</script>';
		}
	}

	/*
	* function to create pdf file of invoice
	*/
	public function createPdf(){
		$gbp = utf8_decode("£");
		$pdf = new Pdf();
    	$pdf->AddPage();
    	$pdf->SetFont('Arial','B',12);
    	//Remove bold
    	$pdf->SetFont('');

    	$date = date("Y/m/d");

    	//Data from create invoice function
    	$nextID = $this->session->flashdata('nextID');
    	$customerID = $this->session->flashdata('customerID');
    	$totalCost = $this->session->flashdata('totalCost');
    	$filename = $this->session->flashdata('filename');

    	//Get Customer info
    	$cdata = $this->Table->customerSearchID($customerID);

    	//Print the date, invoice ID and "send to:" to pdf
    	$pdf->Cell(40,10,'Date: '.$date,0,1);
	   	$pdf->Cell(40,10,'Invoice ID: MJH'.$nextID,0,1);
	   	$pdf->Cell(40,10,'Send to: ');
    	
    	//Main Body - print customer details
    	foreach ($cdata as $res) {
	   		$pdf->Cell(112.5,10,$res->forename.' '.$res->surname,0,2,'C');
	   		$pdf->Cell(112.5,10,$res->addressLine1,0,2,'C');
	   		if ($res->addressLine2 != NULL) {
	   			$pdf->Cell(112.5,10,$res->addressLine2,0,2,'C');
	   		}

	   		if ($res->addressLine3 != NULL) {
	   			$pdf->Cell(112.5,10,$res->addressLine3,0,2,'C');
	   		}

	   		$pdf->Cell(112.5,10,$res->city,0,2,'C');
	   		$pdf->Cell(112.5,10,$res->postcode,0,2,'C');
	   		$pdf->Cell(112.5,10,$res->telephoneNumber,0,2,'C');

	   		if ($res->email != NULL) {
	   			$pdf->Cell(112.5,10,$res->email,0,1,'C');
	   		}
    	}
   		
    	//Add space
   		$pdf->Ln(15);

   		//Headings for table
   		$header = array('Item Name', 'Qty', 'Unit Cost', 'Hours Worked', 'Total');
   		//Get jobmaterials data
   		$mdata = $this->Table->jMaterialSearchID($nextID);

   		//Print headings
   		foreach($header as $col)
	        $pdf->Cell(37.5,7,$col,1);
	    $pdf->Ln();

	    //Print job data
	    foreach($mdata as $row)
	    {
	        foreach($row as $col)
	            $pdf->Cell(37.5,6,$col,1);
	        $pdf->Ln();
	    }
	    
	    //Print total cost 
	    $pdf->setX(122.5);
    	$pdf->Cell(37.5, 6, "Total", 1); 
    	$pdf->Cell(37.5, 6, $gbp . $totalCost, 1, 1);

   		//Output as pdf and save to /pdf folder
    	$pdf->Output('F', 'C:/xampp/htdocs/htdocs/assets/pdf/'.$filename);
    	$pdf->Output();
	}

	/*
	* Controller to pass JSON encoded data to view
	*
	*/
	public function getGraphData(){
		if (!$this->ion_auth->logged_in()) {
			redirect('User/index');
		} else {
			$this->load->model('Visualisation');
			$data = $this->Visualisation->getData();

			//Print data JSON encoded for AJAX 
			echo json_encode($data);
		}
	}

	public function logout(){
		$this->ion_auth->logout();
		$this->load->helper('form');
		$this->load->view('welcome_message');
	}

}



