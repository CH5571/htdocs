<?php 
Class Table extends CI_Model {

	public function addCustomer($data){
		$this->db->insert('customers', $data);
	}

	public function editCustomer(){

	}

	public function deleteCustomer(){

	}

	public function addMaterial(){

	}

	public function editMaterial(){

	}

	public function deleteMaterial(){

	}

	public function addJob(){

	}

	public function editJob(){

	}

	public function deleteJob(){

	}

	public function getUsers(){
		$this->db->select('username, email, created_on');
		$this->db->from('users');
		$query = $this->db->get();

		return $query->result();
	}

	public function getCustomers(){
		$this->db->select('*');
		$this->db->from('customers');
		$query = $this->db->get();

		return $query->result();
	}

	public function customerSearch($search){
		$this->db->select('*');
		$this->db->from('customers');
		$this->db->like('addressLine1', $search);
		$query = $this->db->get();

		return $query->result();
	}

}
?>