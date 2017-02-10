<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class User extends CI_Controller{


	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
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

	public function index(){
		$this->load->view('welcome_message');
	}

	public function login(){
		$this->form_validation->set_rules('username', 'Username', 'required|max_length[100]');
		$this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
		if(!$this->form_validation->run()){
			$this->load->view('welcome_message');
			echo "Error, incorrect username or password";
		} else if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'))) {
			if (!$this->ion_auth->is_admin()) {
				redirect('User/dashboard');
			} else {
				redirect('User/adminPage');
			}
		} else {
			//Fix session DO NOT USE $_SESSION refer to ci manuals
			$_SESSION['auth_message'] = $this->ion_auth->errors();
            $this->session->mark_as_flash('auth_message');
            $this->load->view('welcome_message');

		}
		
	}

	public function dashboard(){
		if (!$this->ion_auth->logged_in()) {
			redirect('User/index');
		} else {
			$this->load->view('dashboard');
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

	public function getMaterialJson(){
		//TODO Add validation
		$name = $this->input->post('q');
		$data = $this->Table->materialSearch($name);

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

	}

	public function deleteUser($userId){
		
	}

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
			//TODO Add for for total cost and move below to between the two inserts.
			for ($i=0; $i < sizeof($materialID); $i++) { 
				$invoiceTotalCost = $invoiceTotalCost + $materialTotalPrice[$i];
			}

			//Invoice Data
			$customerID = $this->input->post('customerSelect');
			$hoursWorked = $this->input->post('hoursWorked');
			$totalPrice = $this->input->post('totalPrice');
			$jobDescription = $this->input->post('jobDescription');
			$dateCompleted = $this->input->post('dateCompleted');
			$paid = $this->input->post('paidOptions');
			$dateCreated = date("d-m-Y");

			$invoiceData = array(
				'hoursWorked' => $hoursWorked,
				'jobDescription' => $jobDescription,
				'totalCost' => $invoiceTotalCost,
				'totalPrice' => $totalPrice,
				'dateCompleted' => $dateCompleted,
				'paid' => $paid,
				'customersID' => $customerID,
				'invoiceCreated' => $dateCreated
			);

			//Insert Invoice to db
			$this->Table->addInvoice($invoiceData);

			//Get next id of invoices assign it to $nextID
			$nextID = $this->Table->getNextInvoiceId();

			for ($j=0;$j<sizeof($materialID); $j++) { 
				$jobMaterialData[$j] = array(
					'invoiceID' => $nextID,
					'materialsID' => $materialID[$j],
					'quantity' => $materialQty[$j],
					'totalCost' => $materialTotalPrice[$j]
				);
				//Insert $jobMaterials array to db
				$this->Table->addJobMaterials($jobMaterialData);
			}

			$this->session->set_flashdata('nextID', $nextID);
			$this->session->set_flashdata('customerID', $customerID);
			$this->session->set_flashdata('totalCost', $invoicetotalCost);

			//Redirect to invoicePage 
			redirect('User/createPdf');
		}
	}

	public function invoiceCustomerSearch(){
		//add ajax - until then use dropdown
	}

	public function addUser(){
		$this->form_validation->set_rules('username', 'Username', 'required|max_length[100]');
		$this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
		$this->form_validation->set_rules('retypepassword', 'Retypepassword', 'required|max_length[20]', 'callback_passwordsMatch');
		$this->form_validation->set_rules('email', 'Email', 'required|max_length[45]');
		$this->form_validation->set_rules('group[]', 'Group', 'required', 'integer');

		if (!$this->form_validation->run()) {
			$error = validation_errors();
			redirect('User/adminPage');
		} else {
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

	public function addCustomer(){
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
			$error = validation_errors();
		} else {

			$forename = $this->input->post('forename');
			$surname = $this->input->post('surname');
			$addressLine1 = $this->input->post('addressLine1');
			$addressLine2 = $this->input->post('addressLine2');
			$addressLine3 = $this->input->post('addressLine3');
			$city = $this->input->post('city');
			$postcode = $this->input->post('postcode');
		    $telephoneNumber = $this->input->post('telephoneNumber');
			$email = $this->input->post('email');

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
			$currentPage = $this->uri->uri_string();

			$this->Table->addCustomer($data);

			echo '<script>alert("Customer successfully added!");</script>';
			//TODO Add code to determine users page so they are not redirected to an incorrect page
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
			
			$data = array(
				'materialName' => $this->input->post('materialName'),
				'price' => $this->input->post('price')
			);

			$this->Table->addMaterial($data);

			redirect('User/materialPage', 'refresh');

			echo '<script>alert("Material successfully added!");</script>';
		}
	}

	/*
	* function to create pdf file of invoice
	* TODO invLink value ID & edit & delete val id or hidden input
	*/
	public function createPdf(){
		$pdf = new Pdf();
    	$pdf->AddPage();
    	$pdf->SetFont('Arial','B',12);
    	//Remove bold
    	$pdf->SetFont('');

    	$date = date("Y/m/d");

    	$nextID = $this->session->flashdata('nextID');
    	$customerID = $this->session->flashdata('customerID');
    	$totalCost = $this->session->flashdata('totalCost');

    	//Get Customer info
    	$cdata = $this->Table->customerSearchID($customerID);

    	$pdf->Cell(40,10,'Date: '.$date,0,1);
	   	$pdf->Cell(40,10,'Invoice ID: MJH'.$nextID,0,1);
	   	$pdf->Cell(40,10,'Send to: ');
    	
    	//Main Body
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
   		

   		$pdf->Ln(15);

   		$header = array('Item Name', 'Qty', 'Cost', 'Hours Worked', 'Total');
   		$mdata = $this->Table->jMaterialSearchID($nextID);

   		foreach($header as $col)
	        $pdf->Cell(40,7,$col,1);
	    $pdf->Ln();

	    foreach($mdata as $row)
	    {
	        foreach($row as $col)
	            $pdf->Cell(40,6,$col,1);
	        $pdf->Ln();
	    }

   		//Output as pdf and save to /pdf folder
    	$pdf->Output();
	}

	public function logout(){
		$this->ion_auth->logout();
		$this->load->helper('form');
		$this->load->view('welcome_message');
	}

}



