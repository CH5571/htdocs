<?php
 
class Visualisation extends CI_Model {

    public function getData(){
        $this->db->select('totalCost, totalPrice, invoiceCreated');
        $this->db->from('invoices');
        $query = $this->db->get();

        return $query->result();
    }
}
?>