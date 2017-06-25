<?php 
Class Table extends CI_Model {
	//Add customer to the database
	public function addCustomer($data){
		$this->db->insert('customers', $data);
	}

	//Update customer record in database
	public function editCustomer($data, $customerID){
		$this->db->where('customerID', $customerID);
		$this->db->update('customers', $data);
	}

	//Insert material to database
	public function addMaterial($data){
		$this->db->insert('materials', $data);
	}

	//Update material row
	public function editMaterial($data, $materialsID){
		$this->db->where('materialsID', $materialsID);
		$this->db->update('materials', $data);
	}
	/*
	public function deleteMaterial($id){
		$this->db->where('materialsID', $id);
		$this->db->delete('materials');
	}
	*/

	//Update invoice row
	public function editInvoice($data, $invoiceID){
		$this->db->where('invoiceID', $invoiceID);
		$this->db->update('invoices', $data);
	}

	/*
	* Remove job materials where invoice id = id
	*/
	public function deleteJobMaterials($id){
		$this->db->where('invoiceID', $id);
		$this->db->delete('jobmaterials');
	}

	//Delete invoice
	public function deleteInvoice($id){
		$tables = array('jobmaterials', 'invoices');
		$this->db->where('invoiceID', $id);
		$this->db->delete($tables);
	}

	//Set invoice as paid
	public function markAsPaid($id){
		$this->db->set('paid', 1);
		$this->db->where('invoiceID', $id);
		$this->db->update('invoices');
	}

	//Return data for invoice page
	public function getInvoices(){
		$this->db->select('hoursWorked, totalCost, totalPrice, dateCompleted, addressLine1, paid, invoiceLink, invoiceID');
		$this->db->from('invoices');
		$this->db->join('customers', 'customers.customerID = invoices.customersID');
		$query = $this->db->get();

		return $query->result();
	}

	public function invoiceJsonSearch($id){
		$this->db->select('hoursWorked, totalCost, totalPrice, dateCompleted, addressLine1, paid, invoiceLink');
		$this->db->from('invoices');
		$this->db->join('customers', 'customers.customerID = invoices.customersID');
		$query = $this->db->get();

		return $query->result();
	}

	//Get all unpaid invoices and order ascendingly
	public function getInvoicesDashboard(){
		$unpaid = 2;

		$this->db->select('hoursWorked, totalCost, totalPrice, dateCompleted, invoiceCreated, addressLine1, paid, invoiceLink, invoiceID');
		$this->db->from('invoices');
		$this->db->where('paid', $unpaid);
		$this->db->join('customers', 'customers.customerID = invoices.customersID');
		$this->db->order_by('invoiceCreated', 'ASC');
		$query = $this->db->get();

		return $query->result();
	}

	//Search for invoices by addressLine1
	public function invoiceSearch($search){
		$this->db->select('hoursWorked, totalCost, totalPrice, dateCompleted, invoiceCreated, addressLine1, paid, invoiceLink, invoiceID');
		$this->db->from('invoices');
		$this->db->like('addressLine1', $search);
		$this->db->join('customers', 'customers.customerID = invoices.customersID');
		$query = $this->db->get();

		return $query->result();
	}

	public function invoiceEditJsonSearch($id){
		$this->db->select('*');
		$this->db->from('invoices');
		$this->db->where('invoiceID', $id);
		$this->db->join('customers', 'customers.customerID = invoices.customersID');
		$query = $this->db->get();

		return $query->result();
	}

	public function getJobmaterials($id){
		$this->db->select('*');
		$this->db->from('jobmaterials');
		$this->db->where('invoiceID', $id);
		$this->db->join('materials', 'materials.materialsID = jobmaterials.materialsID');
		$query = $this->db->get();

		return $query->result();
	}

	public function customerJsonSearch($id){
		$this->db->select('*');
		$this->db->from('customers');
		$this->db->where('customerID', $id);
		$query = $this->db->get();

		return $query->result();
	}

	public function userJsonSearch($id){
		$this->db->select('users.id, users.username, users.email, users_groups.group_id');
		$this->db->from('users');
		$this->db->where('users.id', $id);
		$this->db->join('users_groups', 'users.id = users_groups.user_id');
		$query = $this->db->get();

		return $query->result();
	}

	//Return userame, created on, email and id for all users
	public function getUsers(){
		$this->db->select('username, email, created_on, id');
		$this->db->from('users');
		$query = $this->db->get();

		return $query->result();
	}

	//Get all customers
	public function getCustomers(){
		$this->db->select('*');
		$this->db->from('customers');
		$query = $this->db->get();

		return $query->result();
	}

	/*
	* Return all customers like given parameter
	*/
	public function customerSearch($search){
		$this->db->select('*');
		$this->db->from('customers');
		$this->db->like('addressLine1', $search);
		$query = $this->db->get();

		return $query->result();
	}

	/*
	* Return all columns where customerID column equals customerID variable
	*/
	public function customerSearchID($customerID){
		$this->db->select('*');
		$this->db->from('customers');
		$this->db->where('customerID', $customerID);
		$query = $this->db->get();

		return $query->result();
	}

	//Return all materials
	public function getMaterials(){
		$this->db->select('*');
		$this->db->from('materials');
		$query = $this->db->get();

		return $query->result();
	}

	public function getMaterialsJson($id){
		$this->db->select('*');
		$this->db->from('materials');
		$this->db->where('materialsID', $id);
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

	/*
	* Select items from jobmaterials and invoices table
	* join them and return
	*/
	public function jMaterialSearchID($nextID){
		$this->db->select('materialName, quantity, materials.price, hoursWorked, jobmaterials.totalCost');
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

	//Insert invoice into database
	public function addInvoice($invoiceData){
		$this->db->insert('invoices', $invoiceData);
	}

	//Insert data into jobmaterials table
	public function addJobMaterials($jobMaterialsData){
		$this->db->insert_batch('jobmaterials', $jobMaterialsData);
	}

	/*
	* Return addressLine1 for customerID
	*/
	public function getAddressLine1($customerID){
		$this->db->select('addressLine1');
		$this->db->from('customers');
		$this->db->where('customerID', $customerID);

		return $this->db->get()->row()->addressLine1;
	}

	public function recordCount($table){
		return $this->db->count_all($table);
	}

	public function fetch($limit, $start, $table) {
        $this->db->limit($limit, $start);
        $query = $this->db->get($table);

        return $query->result();
   }

   	public function fetchCustomerSearch($limit, $start, $search) {
        $this->db->limit($limit, $start);
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->like('addressLine1', $search);
        $query = $this->db->get();

        return $query->result();
   }

   	public function fetchInvoices($limit, $start){
		$this->db->select('hoursWorked, totalCost, totalPrice, dateCompleted, addressLine1, paid, invoiceLink, invoiceID');
		$this->db->from('invoices');
		$this->db->join('customers', 'customers.customerID = invoices.customersID');
		$this->db->limit($limit, $start);
		$query = $this->db->get();

		return $query->result();
	}

}
?>