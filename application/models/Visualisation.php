<?php
 
class Visualisation extends CI_Model {
	/*
	* Get totalCost, totalPrice and invoiceCreated for all invoices
	*/
    public function getData(){
        $this->db->select('totalCost, totalPrice, invoiceCreated');
        $this->db->from('invoices');
        $query = $this->db->get();

        return $query->result();
    }
}
?>