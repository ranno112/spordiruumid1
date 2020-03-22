<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Fullcalendar extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('fullcalendar_model');
	}

	function edit()
	{
		if($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){
		$this->load->view('templates/header');
		$this->load->view('pages/edit' ,$_POST);
		$this->load->view('templates/footer');
		}
	}


	function load($roomId)
	{
		$this->input->get('saal', TRUE);
		$event_data = $this->fullcalendar_model->fetch_all_event();
		if($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){
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
		} else {
			foreach($event_data->result_array() as $row)
				if(	$row['roomID']==$roomId){
					
				{
					$data[] = array(
					
						'roomID'	=>	$row['roomID'],
						'title'	=>	$row['public_info'],
						'description'	=>	$row['workout'],
						'start'	=>	$row['startTime'],
						'end'	=>	$row['endTime'],
						'building'	=>	$row['name'],
						'takesPlace'	=>	$row['takes_place'],
						'approved'	=>	$row['approved'],
						'typeID'	=>	$row['typeID'],
				
					);
				}
			}

		}
		
		echo json_encode($data);
	}


	public function create()
	{
		if($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){
			$this->load->view('templates/header');
			$this->load->view('pages/booking');
			$this->load->view('templates/footer');
		}
	}


	

	function delete()
	{
		if($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){
			if($this->input->post('timeID'))
			{
					$this->fullcalendar_model->delete_event($this->input->post('timeID'));
			}
		}
	}

	function deleteAllConnectedBookings()
	{
		if($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){
			if($this->input->post('bookingID'))
			{
				$this->fullcalendar_model->deleteTImesAndBooking($this->input->post('bookingID'));
			}
		}
	}


	function approveEvents()
	{
		if($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){
			if($this->input->post('timeID'))
			{
				$data = array(
					'approved'			=>	$this->input->post('approved'),
					);

				$this->fullcalendar_model->update_event($data, $this->input->post('timeID'));
			}	
		}
	}


	function takesPlace()
	{
		if($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){
			if($this->input->post('timeID'))
			{
				$data = array(
					'takes_place'			=>	$this->input->post('takesPlace'),
					);

				$this->fullcalendar_model->update_event($data, $this->input->post('timeID'));
			}
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
