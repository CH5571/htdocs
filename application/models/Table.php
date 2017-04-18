<?php 
Class Table extends CI_Model {

	public function addCustomer($data){
		$this->db->insert('customers', $data);
	}

	public function editCustomer($data, $customerID){
		$this->db->where('customerID', $customerID);
		$this->db->update('customers', $data);
	}

	/*
	public function deleteCustomer($id){
		$this->db->where('customerID', $id);
		$this->db->delete('customers');
	}
	*/

	public function addMaterial($data){
		$this->db->insert('materials', $data);
	}

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

	public function deleteInvoice($id){
		$tables = array('jobmaterials', 'invoices');
		$this->db->where('invoiceID', $id);
		$this->db->delete($tables);
	}

	public function markAsPaid($id){
		$this->db->set('paid', 1);
		$this->db->where('invoiceID', $id);
		$this->db->update('invoices');
	}

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

	public function getInvoicesDashboard(){
		$unpaid = 2;

		$this->db->select('hoursWorked, totalCost, totalPrice, dateCompleted, invoiceCreated, addressLine1, paid, invoiceLink, invoiceID');
		$this->db->from('invoices');
		$this->db->where('paid', $unpaid);
		$this->db->join('customers', 'customers.customerID = invoices.customersID');
		$this->db->order_by('invoiceCreated', 'ASC');
		//$this->db->limit(15);
		$query = $this->db->get();

		return $query->result();
	}

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

	public function getUsers(){
		$this->db->select('username, email, created_on, id');
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

	public function addInvoice($invoiceData){
		$this->db->insert('invoices', $invoiceData);
	}

	public function addJobMaterials($jobMaterialsData){
		$this->db->insert_batch('jobmaterials', $jobMaterialsData);
	}

	public function getAddressLine1($customerID){
		$this->db->select('addressLine1');
		$this->db->from('customers');
		$this->db->where('customerID', $customerID);

		return $this->db->get()->row()->addressLine1;
	}

}
?>