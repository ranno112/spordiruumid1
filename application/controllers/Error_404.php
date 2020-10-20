<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error_404 extends CI_Controller {

  public function __construct() {

    parent::__construct();

  }

  public function index(){
 
		$this->output->set_status_header('404'); 
		$data['menu'] = '404'; // Capitalize the first letter
		$data['unapprovedBookings'] = "";
    $this->load->view('templates/header', $data);
    $this->load->view('pages/404', $data);
    $this->load->view('templates/footer');
 
  }

}
