<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Booking extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('booking_model');
	}

	public function create($slug)
	{
		
		if($this->session->userdata('session_id')===TRUE){
		$data['title']='Tee uus broneering';
		$data['selectedRoom'] = $this->booking_model->getTheRoom($slug);
		$data['rooms'] = $this->booking_model->getAllRooms();
		$data['buildings'] = $this->booking_model->getAllBuildings();
		$data['allBookingInfo'] = $this->booking_model->getAllBookings();
	

		$data1 = array(
			'public_info'=>$this->input->post('clubname'),
			//'slug'=>$slug,
			'c_name' => $this ->input->post('contactPerson'),
			'c_phone' => $this ->input->post('phone'),
			'c_email' => $this ->input->post('email'),
			'comment' => $this ->input->post('comment2'),
			'comment_inner' => $this ->input->post('additionalComment'),
			'workout' => $this ->input->post('workoutType'),
			'typeID' => $this ->input->post('type'),
			
			
			//'organizer' => $this ->input->post('phone'),
			//'event_it' => $this ->input->post('phone'),
			//'event_out' => $this ->input->post('phone')
		);
		
		$this->form_validation->set_rules('clubname', 'Klubi nimi', 'required');
		$this->form_validation->set_rules('contactPerson', 'Kontaktisik', 'required');

		if ($this->form_validation->run() != FALSE)
				{
					
				   $id= $this->booking_model->create_booking($data1);


				$insert_data = array();
				$takesPlace= $this ->input->post('approveNow')==1 ? 1 : 0;
				$start_data = $this->input->post('end');
				$end_data = $this->input->post('begin');

				

				for($i = 0; $i <= count($start_data); $i++)
				{

				if(isset($start_data[$i])){
				$insert_data[] = array(
				'roomID' => $this->input->post('sportrooms'),
				'startTime'=>isset($start_data[$i]) ? $start_data[$i] : '',
				'endTime'=>isset($end_data[$i]) ? $end_data[$i] : '',
				'approved' => $takesPlace,
				'bookingID' => $id
				);}
			
				}
				var_dump($insert_data);
					$this->booking_model->create_bookingTimes($insert_data);
					
				//	$this->load->view('booking/success');
				//	redirect('fullcalendar?roomId='.$this->input->post('sportrooms'));
		}



		if($this->form_validation->run()===FALSE){
			
					$this->load->view('templates/header');
					$this->load->view('pages/booking', $data);//see leht laeb vajalikku vaadet. ehk saab teha controllerit ka mujale, mis laeb õiget lehte
					$this->load->view('templates/footer');


		}
		// else{
		// 	$this->booking_model->create_booking();
		// 	$this->load->view('fullcalendar?roomId=1');//redirectib sinna peale väljade korrektselt sisestamist
		// }

		}else{redirect('');}
	}


	public function createClosed()
	{
		if( $this->session->userdata('session_id')===TRUE){
			$data['title'] = 'Sign Up';
			$event_in = strtotime($this ->input->post('startingFrom'));
			$event_out = strtotime($this ->input->post('Ending'));
			$this->form_validation->set_rules($event_in, 'Event In', $event_out);
			if ($event_in > $event_out)
			{
				
			  $this->form_validation->set_message('post_updated', 'Kuupäevad ei ole õigesti sisestatud.');
			  $this->session->set_flashdata('post_updated', 'Periood on valesti sisestatud');
			 			
			  if($this->form_validation->run() === FALSE){
				redirect( $this ->input->post('current_url'));
			
			} 

			   $this->load->view('templates/header');
			//   //$this->load->view('pages/booking/create/'.$this->input->get('roomId'));
			   $this->load->view('pages/booking', $data);
			   $this->load->view('templates/footer');
			//  redirect('booking/create/'.$this->input->post('sportrooms'));
			//  return false;       
			}
			else
			{
			 		
			$event_in = date('Y-m-d H:i:s', $event_in);
			$event_out = date('Y-m-d H:i:s', $event_out);
			$data1 = array(
				'public_info'=>$this->input->post('clubname'),
				'comment_inner' => $this ->input->post('comment2'),
				'event_in' => $event_in,
				'event_out' => $event_out,
				'typeID' => $this ->input->post('type'),
				'c_name' => $this ->input->post('contactPerson'),
				'c_phone' => $this ->input->post('phone'),
				'c_email' => $this ->input->post('email'),
				'comment' => $this ->input->post('additionalComment'),
				'workout' => $this ->input->post('workoutType'),
				

			);

			$this->form_validation->set_rules('clubname', 'Klubi nimi', 'required');
		//	$this->form_validation->set_rules('contactPerson', 'Kontaktisik', 'required');

		
				$id= $this->booking_model->create_booking($data1);
					
			$insert_data2 = array();
			$startDate=$this ->input->post('startingFrom');
			$startDate = strtotime($startDate);
			$startDateToDb = strtotime($startDate);
			$endDate = $this ->input->post('Ending');
			$endDate = strtotime($endDate);
			$endDateToDb = strtotime($endDate);
			$weekday=$this->input->post('weekday');
			$days=array('Esmaspäev'=>'Monday','Teisipäev' => 'Tuesday','Kolmapäev' => 'Wednesday','Neljapäev'=>'Thursday','Reede' =>'Friday','Laupäev' => 'Saturday','Pühapäev'=>'Sunday');
			
		
			// var_dump(date("H:i", strtotime($this->input->post('timesStart')[1])));
			
			$takesPlace= $this ->input->post('approveNow')==1 ? 1 : 0;
			for($t = 0; $t <= count($this->input->post('timesStart')); $t++)
				{
					if(isset($this->input->post('timesStart')[$t])){
				$formated_timeToDb = date("H:i", strtotime($this->input->post('timesStart')[$t]));
				$formated_EndtimeToDb = date("H:i", strtotime($this->input->post('timeTo')[$t]));
			
		
				foreach($days as $key => $value){

			if ($weekday[$t]==$key){
				//var_dump($this->input->post('Ending'));
			for($i = strtotime($value, $startDate); $i <= $endDate; $i = strtotime('+1 week', $i))
				{  echo $i;
					$dateToDb=date('Y-m-d', $i);
					
				//	var_dump(date('Y-m-d H:i:s', strtotime("$dateToDb $formated_timeToDb")));
					
					$start_data = date('Y-m-d H:i:s', strtotime("$dateToDb $formated_timeToDb"));
					$end_data = date('Y-m-d H:i:s', strtotime("$dateToDb $formated_EndtimeToDb"));
				
					

					if(strtotime("$dateToDb $formated_timeToDb")>strtotime("$dateToDb $formated_EndtimeToDb")){
							
						  $this->form_validation->set_message('validationErrorMessage', 'Kuupäevad ei ole õigesti sisestatud.');
						  $this->session->set_flashdata('validationErrorMessage', 'Kellaaeg on valesti sisestatud');
									 
						  if($this->form_validation->run() === FALSE){
							redirect( $this ->input->post('current_url'));
						
						} 
			
						   $this->load->view('templates/header');
					
						   $this->load->view('pages/booking', $data);
						   $this->load->view('templates/footer');
					  
						}
						else
						{

					$insert_data2[] = array(
						'roomID' => $this->input->post('sportrooms'),
						'startTime' => $start_data,
						'endTime' => $end_data,
						'approved' => $takesPlace,
						'bookingID' => $id
						);
					}
				}
			}
				}}
			}
			if (empty($insert_data2)) {
				$this->session->set_flashdata('access_deniedToUrl', 'Perioodi jooksul pole ühtegi kuupäeva mida salvestada');
		   }
			$this->booking_model->create_bookingTimes($insert_data2);
					//$this->load->view('booking/success');
					//echo('Nüüd tuleb redirect');
					$this->session->set_flashdata('post_updated', 'Andmed salvestatud');
						redirect('fullcalendar?roomId='.$this->input->post('sportrooms'));
		


					// $insert_data = array();
					// $start_data = $this->input->post('timeStart');
					// $end_data = $this->input->post('timeTo');

					// for($i = 1; $i <= count($start_data); $i++)
					// {
					// $insert_data[] = array(
					// 'roomID' => $this->input->post('sportrooms2'),
					// 'startTime' => $start_data[$i], 
					// 'endTime' => $end_data[$i],
					// //'bookingID' => $id
					// );
					// }

				
				
		

		

			if($this->form_validation->run()===FALSE){
			
		
						$this->load->view('templates/header');
						$this->load->view('pages/booking');//see leht laeb vajalikku vaadet. ehk saab teha controllerit ka mujale, mis laeb õiget lehte
						$this->load->view('templates/footer');


			}else{
				//$this->booking_model->create_booking();
				'fullcalendar?roomId='.$this->input->post('sportrooms');//redirectib sinna peale väljade korrektselt sisestamist
			//	var_dump($data1);
		//	echo('Nüüd tuleb redirect');

			}
			}

	

	}else{
	
		redirect('');
	}
	}





	public function createOnce()
	{
		if( $this->session->userdata('session_id')===TRUE){

		$data['rooms'] = $this->booking_model->getAllRooms();
		$data['buildings'] = $this->booking_model->getAllBuildings();
	

		$data1 = array(
			'public_info'=>$this->input->post('clubname'),
			'c_name' => $this ->input->post('contactPerson'),
			'c_phone' => $this ->input->post('phone'),
			'c_email' => $this ->input->post('email'),
			'typeID' => $this ->input->post('type'),
			'comment' => $this ->input->post('additionalComment'),
			'comment_inner' => $this ->input->post('comment2'),
			'workout' => $this ->input->post('workoutType'),
		
		);
	
		$id= $this->booking_model->create_booking($data1);
				
		$insert_data2 = array();
		$takesPlace = $this ->input->post('approveNow')==1 ? 1 : 0;
		for($t = 0; $t <= count($this->input->post('workoutDate')); $t++) {
			if(isset($this->input->post('workoutDate')[$t])){
			$formated_startTime = date("H:i:s", strtotime($this->input->post('begin')[$t]));
			$formated_endTime = date("H:i:s", strtotime($this->input->post('end')[$t]));
			$formated_date = date("Y-m-d", strtotime($this->input->post('workoutDate')[$t]));

			$start_date = date('Y-m-d H:i:s', strtotime("$formated_date $formated_startTime"));
			$end_date = date('Y-m-d H:i:s', strtotime("$formated_date $formated_endTime"));
		
			if(strtotime("$formated_date $formated_startTime")>strtotime("$formated_date $formated_endTime")){
							
				$this->form_validation->set_message('validationErrorMessage', 'Kuupäevad ei ole õigesti sisestatud.');
				$this->session->set_flashdata('validationErrorMessage', 'Kellaaeg on valesti sisestatud');
						   
				if($this->form_validation->run() === FALSE){
				  redirect( $this ->input->post('current_url'));
			  
			  } 
  
				 $this->load->view('templates/header');
		  
				 $this->load->view('pages/booking', $data);
				 $this->load->view('templates/footer');
			
			  }
			  else
			  {

			$insert_data2[] = array(
				'roomID' => $this->input->post('sportrooms'),
				'startTime' => $start_date,
				'endTime' => $end_date,
				'approved' => $takesPlace,
				'bookingID' => $id
			);
		}

		}	}
			
		$this->booking_model->create_bookingTimes($insert_data2);
		redirect('fullcalendar?roomId='.$this->input->post('sportrooms'));

		if($this->form_validation->run()===FALSE){
	
			$this->load->view('templates/header');
			$this->load->view('pages/booking');//see leht laeb vajalikku vaadet. ehk saab teha controllerit ka mujale, mis laeb õiget lehte
			$this->load->view('templates/footer');

		}else{
			$this->load->view('fullcalendar?roomId='.$this->input->post('sportrooms'));
		}
		

	}
	// else{
	// //	redirect('');
	// };
}
	}
	





?>
