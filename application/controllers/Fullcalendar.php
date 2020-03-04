<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Fullcalendar extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('fullcalendar_model');
	}

	function index()
	{//	$data['title'] = "Hello Everyone!";
		$roomid=$this->input->get('roomID');
		$data['rooms'] = $this->fullcalendar_model->getAllRooms($roomid);
	
		
		$this->load->view('templates/header',$data);
		$this->load->view('pages/kalender',$data);
		$this->load->view('templates/footer',$data);
	}


	function edit()
	{
		print_r($_POST);
		$this->load->view('templates/header');
		$this->load->view('pages/edit' ,$_POST);
		$this->load->view('templates/footer');
	}


	function load($roomId)
	{
		$this->input->get('saal', TRUE);
		$event_data = $this->fullcalendar_model->fetch_all_event();
		foreach($event_data->result_array() as $row)
		if(	$row['roomID']==$roomId){
			
		{
			$data[] = array(
				'id'	=>	$row['bookingID'],
				'roomID'	=>	$row['roomID'],
				'timeID'=>	$row['timeID'],
				'title'	=>	$row['public_info'],
				'description'	=>	$row['workout'],
				'comment' => $row['comment'],
				'start'	=>	$row['startTime'],
				'end'	=>	$row['endTime'],
				'event_in'	=>	$row['event_in'],
				'event_out'	=>	$row['event_out'],
				'clubname'	=>	$row['c_name'],
				'phone'	=>	$row['c_phone'],
				'email'	=>	$row['c_email'],
				'workout'	=>	$row['workout'],
				'created_at'	=>	$row['created_at'],
				 'selectedroom'	=>	$row['name'],
				 'building'	=>	$row['name'],
				 'roomName'	=>	$row['roomName'],
				 'bookingID'	=>	$row['bookingID'],
				 'takesPlace'	=>	$row['takes_place'],
				 'approved'	=>	$row['approved'],
				 'organizer'	=>	$row['organizer'],
				 'typeID'	=>	$row['typeID'],
				 'color'	=>	$row['bookingTimeColor'],

			);
		}
	}
		
		echo json_encode($data);
	}

	function insert()
	{
		if($this->input->post('title'))
		{
			$data = array(
				'title'		=>	$this->input->post('title'),
				'roomID'	=> 	$this->input->post('roomID'),
				'startTime'=>	$this->input->post('start'),
				'endTime'	=>	$this->input->post('end')
			);
			$this->fullcalendar_model->insert_event($data);
		}
	
	}

//seda enam ei ole vaja, kuna selekteerides kalendrist tuleb lahti broneerimisvorm
	// public function createfromcalendar()
	// {
	// 	if($this->session->userdata('roleID')==='2'||$this->session->userdata('roleID')==='3'){
	// 	if($this->input->post('public_info'))
	// 	{
	// 			$data1 = array(
	// 				'typeID'		=>	$this->input->post('typeID'),
	// 				'public_info'		=>	$this->input->post('public_info')					
	// 			);
		
	// 			$id= $this->fullcalendar_model->create_booking($data1);


	// 			$insert_data = array();
				
	// 			$insert_data[] = array(
	// 			'roomID'	=> 	$this->input->post('roomID'),
	// 			'startTime'=>	$this->input->post('start'),
	// 			'endTime'	=>	$this->input->post('end'),
	// 			'bookingID' => $id
	// 			);
				

	// 				$this->fullcalendar_model->create_bookingTimes($insert_data);
				
	// 			}
	
	// }
	// }




	public function create()
	{
		$data['title']='Tee uus broneering';
		$this->load->view('templates/header');
		$this->load->view('pages/booking', $data);
		$this->load->view('templates/footer');
	
	}


	function update()
	{
		if($this->input->post('id'))
		{
			$data = array(
				'title'			=>	$this->input->post('title'),
				'startTime'	=>	$this->input->post('start'),
				'endTime'		=>	$this->input->post('end')
			);

			$this->fullcalendar_model->update_event($data, $this->input->post('id'));
		}
	}

	function delete()
	{
		if($this->input->post('timeID'))
		{
			$this->fullcalendar_model->delete_event($this->input->post('timeID'));
		}
	}

	function deleteAllConnectedBookings()
	{
		if($this->input->post('bookingID'))
		{
			$this->fullcalendar_model->deleteTImesAndBooking($this->input->post('bookingID'));
		}
	}


	function approveEvents()
	{
		if($this->input->post('timeID'))
		{
			$data = array(
				'approved'			=>	$this->input->post('approved'),
				);

			$this->fullcalendar_model->update_event($data, $this->input->post('timeID'));
		}
	}


	function takesPlace()
	{
		if($this->input->post('timeID'))
		{
			$data = array(
				'takes_place'			=>	$this->input->post('takesPlace'),
				);

			$this->fullcalendar_model->update_event($data, $this->input->post('timeID'));
		}
	}




	function fetch_city()
	{
	 if($this->input->post('country_id'))
	 {
	  echo $this->home_model->fetch_city($this->input->post('country_id'));
	 }
	}


	function fetch_building()
	{
	 if($this->input->post('state_id'))
	 {
	  echo $this->home_model->fetch_building($this->input->post('state_id'));
	 }
	}


}

?>
