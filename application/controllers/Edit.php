<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends CI_Controller {

	public function __construct()
	{

		parent::__construct();
		$this->load->model('edit_model');
		
    }

	// function insertAdditionalDateTime()
	// {
		
		
	// 	$formated_startTime = date("H:i:s", strtotime($this->input->post('begin')));
	// 	$formated_endTime = date("H:i:s", strtotime($this->input->post('end')));
	// 	$formated_date = date("Y-m-d", strtotime($this->input->post('workoutDate')));

	// 	$start_date = date('Y-m-d H:i:s', strtotime("$formated_date $formated_startTime"));
	// 	$end_date = date('Y-m-d H:i:s', strtotime("$formated_date $formated_endTime"));

	// 	$data = array(
	// 		'roomID' => $this->input->post('roomID'),
	// 		'startTime' => $start_date,
	// 		'endTime' => $end_date,
	// 		'bookingID' =>$this ->input->post('id'),
	// 	);
	// 	print_r($data);

	// 	$this->edit_model->insert($data, $this->input->post('id'));


	// 	$MyVariable=$_POST['timesIdArray'];
	// 	$this->session->set_flashdata('timesIdArray', $MyVariable);

	// 	$this->session->set_userdata('referred_from', current_url());
	// 	$referred_from = $this->session->userdata('referred_from');
	// //	redirect($referred_from, 'refresh');
	
	// 		}
	



	




	function load($bookingID)
	{
		if($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){


			$this->form_validation->set_rules('e-mail', 'Email', 'trim|required|valid_email');
		
	//	$this->input->get('saal', TRUE);
		$event_data = $this->edit_model->fetch_all_event();
		foreach($event_data->result_array() as $row)
		if(	$row['bookingID']==$bookingID){
			
		{
			$data[] = array(
				'id'	=>	$row['bookingID'],
				'roomID'	=>	$row['roomID'],
				'timeID'=>	$row['timeID'],
				'title'	=>	$row['public_info'],
				'start'	=>	$row['startTime'],
				'end'	=>	$row['endTime'],
				'event_in'	=>	$row['event_in'],
				'event_out'	=>	$row['event_out'],
				'clubname'	=>	$row['c_name'],
				'phone'	=>	$row['c_phone'],
				'email'	=>	$row['c_email'],
				'workout'	=>	$row['workout'],
				'created_at'	=>	$row['created_at'],
				 'comment'	=>	$row['comment'],
				 'building'	=>	$row['name'],
				 'roomName'	=>	$row['roomName'],
				 'bookingID'	=>	$row['bookingID'],
				 'takesPlace'	=>	$row['takes_place'],
				 'approved'	=>	$row['approved'],
				 'organizer'	=>	$row['organizer'],

				);
			}
		}
			
			echo json_encode($data);
	}else{redirect('');}
	}
	
	function loadAllRoomBookingTimes($roomId)
	{
		if($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){
		$this->input->get('saal', TRUE);
		$event_data = $this->edit_model->fetch_all_Booking_times();
		foreach($event_data->result_array() as $row)
		if(	$row['roomID']==$roomId &&	$row['endTime']> date("Y-m-d")){
			
		{
			$data[] = array(
				'id'	=>	$row['bookingID'],
				//'building'=>	$row['building'],
				'timeID'=>	$row['timeID'],
				'title'	=>	$row['public_info'],
				'start'	=>	$row['startTime'],
				'end'	=>	$row['endTime'],
				);
		}
	}
		
		echo json_encode($data);
	}else{redirect('');}
	}
    

	function updateprevtodelete()
	{
		if($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){
		if($this->input->post('id'))
		{
			$data = array(
				'title'			=>	$this->input->post('title'),
				'startTime'	=>	$this->input->post('start'),
				'endTime'		=>	$this->input->post('end')
			);

			$this->edit_model->update_event($data, $this->input->post('id'));
		}
	}else{redirect('');}
	}


	public function update()
	{	
		$data['title'] = 'Sign Up';
		if($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){

			$this->form_validation->set_rules('publicInfo', 'Klubi nimi', 'required');
			$this->form_validation->set_rules('contactPerson', 'Kontaktisik', 'required');

			if($this->form_validation->run() === FALSE){

				// $this->load->view('templates/header');
				// $this->load->view('pages/edit', $data);
                // $this->load->view('templates/footer');

				// redirect(base_url('fullcalendar/edit'  ,$_POST));

			

				$this->load->view('templates/header');
				$this->load->view('pages/edit');//see leht laeb vajalikku vaadet. ehk saab teha controllerit ka mujale, mis laeb õiget lehte
				print_r($_POST);
				$this->load->view('templates/footer');

			} 
else{

			$data1 = array(
				'public_info'=>$this->input->post('publicInfo'),
				'c_name' => $this ->input->post('contactPerson'),
				'organizer' => $this ->input->post('organizer'),
				'c_phone' => $this ->input->post('phone'),
				'c_email' => $this ->input->post('email'),
				'comment' => $this ->input->post('additionalComment'),
				
				//'building' => $this ->input->post('building'), //pole seda formis
				
				'workout' => $this ->input->post('workoutType'),
				// 'event_in' => $this ->input->post('eventIn'),
				// 'event_out' => $this ->input->post('phone')
			);
			
	
	
				$this->edit_model->update_booking($data1, $this->input->post('BookingID'));
				
			
	
					$insert_data = array();
					$start_data = $this->input->post('bookingtimesFrom');
					$end_data = $this->input->post('bookingtimesTo');
					
					

	
			
					for($i = 0; $i < count($start_data); $i++)
					{

						$formated_startTime = date("H:i:s", strtotime($this->input->post('timeStart')[$i]));
						$formated_endTime = date("H:i:s", strtotime($this->input->post('timeEnd')[$i]));
						$formated_date = date("Y-m-d", strtotime($this->input->post('bookingtimesFrom')[$i]));
				
						$start_date = date('Y-m-d H:i:s', strtotime("$formated_date $formated_startTime"));
						$end_date = date('Y-m-d H:i:s', strtotime("$formated_date $formated_endTime"));
				
						$insert_data[] = array(
							//'roomID' => $this->input->post('sportrooms'),
							'startTime' => $start_date, 
							'endTime' => $end_date,
							
							);
							$this->edit_model->update_bookingTimes($insert_data[$i], $this->input->post('timesIdArray')[$i]);
						
				
				}
				//var_dump($insert_data);
			//	$this->edit_model->update_bookingTimes($insert_data, $this->input->post('timesIdArray'));
						//$this->booking_model->create_bookingTimes($insert_data);
					//	$this->load->view('booking/success');
					//	redirect('fullcalendar?roomId=1');
				
					//var_dump($data1);

		// }
		


	
			
			$addtimes = array();
			for($t = 0; $t <= count($this->input->post('additionalBookingDate')); $t++) {
			

				if(isset($this->input->post('additionalBookingDate')[$t])){
				$formated_startTime = date("H:i:s", strtotime($this->input->post('additionalBookingtimeStart')[$t]));
				$formated_endTime = date("H:i:s", strtotime($this->input->post('additionalBookingtimeEnd')[$t]));
				$formated_date = date("Y-m-d", strtotime($this->input->post('additionalBookingDate')[$t]));
		
				$start_date = date('Y-m-d H:i:s', strtotime("$formated_date $formated_startTime"));
				$end_date = date('Y-m-d H:i:s', strtotime("$formated_date $formated_endTime"));
		
				$addtimes[] = array(
					'roomID' => $this->input->post('roomID'),
					'startTime' => $start_date,
					'endTime' => $end_date,
					'bookingID' =>$this ->input->post('id'),
				);
				print_r($addtimes);
				$id=$this->edit_model->insert($addtimes[$t], $this->input->post('id'));
			
			
				
			
				
		
			//	redirect(base_url('fullcalendar/edit'  ,$_POST));
			
			
	//print_r($addtimes);
		
			
		
				// $timesIdArray=$this->input->post('');
				// $this->session->set_flashdata('timesIdArray', $timesIdArray);
		
				// $this->session->set_userdata('referred_from', current_url());
				// $referred_from = $this->session->userdata('referred_from');
				
				// $this->load->view('templates/header');
				// $this->load->view('pages/edit' ,$_POST);//see leht laeb vajalikku vaadet. ehk saab teha controllerit ka mujale, mis laeb õiget lehte
				// echo "success!";
				// $this->load->view('templates/footer');

				//redirect($referred_from, 'refresh');

			}else{




					redirect(base_url('fullcalendar?roomId='.$this->input->post('roomID')));
					$this->load->view('templates/header');
					$this->load->view('pages/fullcalendar?roomId='.$this->input->post('roomID'));//see leht laeb vajalikku vaadet. ehk saab teha controllerit ka mujale, mis laeb õiget lehte
					echo "success!";
					$this->load->view('templates/footer');

				}
				//redirect(base_url('fullcalendar?roomId='.$this->input->post('roomID')));
			}

		}

	}else{
		//Kui pole juht ega haldur, siis viib avalehele
		redirect('');}
	
	}

	






}

?>
