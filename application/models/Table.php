<?php 
Class Table extends CI_Model {

	public function addCustomer($data){
		$this->db->insert('customers', $data);
	}

	public function editCustomer(){

	}

	public function deleteCustomer(){

	}

	public function addMaterial($data){
		$this->db->insert('materials', $data);
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

	public function getInvoices(){
		$this->db->select('hoursWorked, totalCost, totalPrice, dateCompleted, addressLine1, paid');
		$this->db->from('invoices');
		$this->db->join('customers', 'customers.customerID = invoices.customersID');
		$query = $this->db->get();

		return $query->result();
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

	public function customerSearchID($search){
		$this->db->select('*');
		$this->db->from('customers');
		$this->db->where('customerID', $search);
		$query = $this->db->get();

		/*foreach ($query->result() as $row){
            $cdata = [
                'forename' => $row->forename,
                'surname' => $row->surname,
                'addressLine1' => $row->addressLine1,
                'addressLine2' => $row->addressLine2,
                'addressLine3' => $row->addressLine3,
                'city' => $row->city,
                'postcode' => $row->postcode,
                'telephoneNumber' => $row->telephoneNumber,
                'email' => $row->email
            ];

        }
        */

		return $query->result();
	}

	public function getMaterials(){
		$this->db->select('*');
		$this->db->from('materials');
		$query = $this->db->get();

		return $query->result();
	}

	public function materialSearch($search){
		$this->db->select('*');
		$this->db->from('materials');
		$this->db->like('materialName', $search);
		$query = $this->db->get();

		return $query->result();
	}

	public function materialPriceSearch($materialID){
		$this->db->select('price');
		$this->db->from('materials');
		$this->db->where('materialsID', $materialID);
		$query = $this->db->get();

		return $query->result();
	}

	public function jMaterialSearchID($nextID){
		$this->db->select('materialName, quantity, jobmaterials.totalCost, hoursWorked');
		$this->db->from('jobmaterials');
		$this->db->where('jobmaterials.invoiceID', $nextID);
		$this->db->join('materials', 'materials.materialsID = jobmaterials.materialsID');
		$this->db->join('invoices', 'invoices.invoiceID = jobmaterials.invoiceID');
		$query = $this->db->get();

		return $query->result();
	}

	/*
	* Get next invoice id and return it as an int
	*/
	public function getNextInvoiceId(){
		//$query = $this->db->query("SELECT invoiceID FROM invoices ORDER BY invoiceID DESC LIMIT 1");
		$this->db->select('invoiceID');
		$this->db->from('invoices');
		$this->db->order_by("invoiceID", "desc");
		$this->db->limit(1);

		return $this->db->get()->row()->invoiceID;
		
	}

	public function addInvoice($invoiceData){
		$this->db->insert('invoices', $invoiceData);
	}

	public function addJobMaterials($jobMaterialsData){
		$this->db->insert_batch('jobmaterials', $jobMaterialsData);
	}

}
?>