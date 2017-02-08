<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Doc extends CI_Controller {
  function __construct()
  {
    parent::__construct();
    $this->load->library('pdf'); // Load library
    define('FPDF_FONTPATH', '\xampp\htdocs\htdocs\font');   // Specify font folder
  }
  public function index()
  {
    // Generate PDF by saying hello to the world
    $pdf = new Pdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10,'Hello World!');
    $pdf->Output();
  }
  // More methods goes here
}
?>