<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('home_model');
	}
	

	function menu(){
		$data['menu'] = 'home'; // Capitalize the first letter
		$data['unapprovedBookings'] = $this->home_model->getUnapprovedBookings($this->session->userdata('building'));
		return $data;
		}

	function view()
	{//	$data['title'] = "Hello Everyone!";
		$data=$this->menu();
		
		$this->load->view('templates/header',$data);
		$this->load->view('pages/fullcalendar',$data);
		$this->load->view('templates/footer',$data);
	}


}
