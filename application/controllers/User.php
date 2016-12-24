<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class User extends CI_Controller{


	public function __construct(){
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->model('Table');
	}

	public function index(){
		$this->load->helper('form');
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

	public function isLoggedIn(){
		$sess_id = $this->session->userdata('user_id');
		if (empty($sess_id)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function dashboard(){
		if ($this->isLoggedIn() == TRUE){
			$this->load->view('dashboard');
		} else {
			$this->load->view('welcome_message');
		}
	}

	public function adminPage() {	
			$data['user'] = $this->Table->getUsers();
			if ($this->isLoggedIn() == TRUE && $this->ion_auth->is_admin() == TRUE){
				$this->load->view('adminDashboard', $data);
			} else {
				$this->load->view('welcome_message');
			}
	}

	public function customerPage(){
		$data['customer'] = $this->Table->getCustomers();
		if ($this->isLoggedIn() == TRUE){
			$this->load->view('customer', $data);
		} else {
			$this->load->view('welcome_message');
		}
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
			redirect(base_url().$currentPage, 'refresh');
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
			$this->load->view('customer', $data);
			//TODO ADD MESSAGE IF NO RESULTS PRESENT 
		}
	}

	public function addMaterial(){
		$this->form_validation->set_rules('materialName', 'MaterialName', 'required|max_length[45]');
		$this->form_validation->set_rules('price', 'Price', 'required');

		if (!$this->form_validation->run()) {

		} else {
			
			echo '<script>alert("Material successfully added!");</script>';
		}
	}

	public function logout(){
		$this->ion_auth->logout();
		$this->load->helper('form');
		$this->load->view('welcome_message');
	}

}



