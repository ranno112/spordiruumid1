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
	
		$data['weekdays']=array('Pühapäev','Esmaspäev','Teisipäev','Kolmapäev','Neljapäev','Reede' ,'Laupäev');
		$data['rooms'] = $this->booking_model->getAllRooms();
		$data['buildings'] = $this->booking_model->getAllBuildings();
		$data['allBookingInfo'] = $this->booking_model->getAllBookings();
	
		$this->load->view('templates/header');
		$this->load->view('pages/booking', $data);//see leht laeb vajalikku vaadet. ehk saab teha controllerit ka mujale, mis laeb õiget lehte
		$this->load->view('templates/footer');


		}else{redirect('');}
	}


	public function clubname_check($str= '')
	{
			if ($str == '')
			{
					$this->session->set_flashdata('validationErrorMessage', "<small class='text-danger'>See väli on kohustuslik</small>");
					return FALSE;
			}
			else
			{
					return TRUE;
			}
	}
	public function weekDayMissing($str= '')
	{
			if ($str == '')
			{
					$this->session->set_flashdata('weekDayMissing', "<small class='text-danger'>See väli on kohustuslik</small>");
					return FALSE;
			}
			else
			{
					return TRUE;
			}
	}

	public function createClosed()
	{
		
		$postData = $_POST;
		$postData['error'] = validation_errors() ;
		if( $this->session->userdata('session_id')===TRUE){

			$data['rooms'] = $this->booking_model->getAllRooms();
			$data['buildings'] = $this->booking_model->getAllBuildings();
			$data['allBookingInfo'] = $this->booking_model->getAllBookings();
			
				$this->form_validation->set_rules('clubname', 'Klubi nimi', 'trim|required|callback_clubname_check');
				$this->form_validation->set_rules('startingFrom', 'Kuupäev alates', 'trim|required');
				$this->form_validation->set_rules('Ending', 'Kuupäev kuni', 'trim|required');
				$this->form_validation->set_rules('weekday[]', 'Nädalapäev puudu', 'trim|required|callback_weekDayMissing');

			

			if($this->form_validation->run() === FALSE ){
				$this->session->set_flashdata("message","eroor".form_error());
				$this->session->set_flashdata('data', $this->input->post());

				if($this->input->post('dontShow')!=1){
				$this->session->set_flashdata('access_deniedToUrl', 'Midagi on selle vormiga valesti. Palun vaata kõik väljad üle');
				$this->session->set_flashdata('errors', validation_errors());
				}
				
				$this->session->set_flashdata('key',$postData);
				redirect( $this ->input->post('current_url'));

			} 
			else{
			$event_in = strtotime($this ->input->post('startingFrom'));
			$event_out = strtotime($this ->input->post('Ending'));

		//	$this->form_validation->set_rules($event_in, 'Event In', $event_out);
			if ($event_in > $event_out)
			{
			  $this->session->set_flashdata('errors', 'Periood on valesti sisestatud');
			  $this->session->set_flashdata('key',$postData);
			  redirect( $this ->input->post('current_url'));
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
				'comment' => $this ->input->post('comment2'),
				'workout' => $this ->input->post('workoutType'),
				

			);

			
		//	$this->form_validation->set_rules('contactPerson', 'Kontaktisik', 'trim|required');

		
			$id= $this->booking_model->create_booking($data1);
					
			$insert_data2 = array();
			$insert_data3 = array();
			$startDate=$this ->input->post('startingFrom');
			$startDate = strtotime($startDate);
			$startDateToDb = strtotime($startDate);
			$endDate = $this ->input->post('Ending');
			$endDate = strtotime($endDate);
			$endDateToDb = strtotime($endDate);
			$weekday=$this->input->post('weekday');
			$days=array('Esmaspäev'=>'Monday','Teisipäev' => 'Tuesday','Kolmapäev' => 'Wednesday','Neljapäev'=>'Thursday','Reede' =>'Friday','Laupäev' => 'Saturday','Pühapäev'=>'Sunday');
			
		
			// var_dump(date("H:i", strtotime($this->input->post('timesStart')[1])));
			$dateToRedirect='';
			$counter=0;
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
				{  
					
					$dateToDb=date('Y-m-d', $i);
					
				//	var_dump(date('Y-m-d H:i:s', strtotime("$dateToDb $formated_timeToDb")));
					
					$start_data = date('Y-m-d H:i:s', strtotime("$dateToDb $formated_timeToDb"));
					$end_data = date('Y-m-d H:i:s', strtotime("$dateToDb $formated_EndtimeToDb"));
				
				
					//Kuni kuni aeg on minevikus, siis näita veateadet ning tee redirect
					if(strtotime("$dateToDb $formated_timeToDb")>strtotime("$dateToDb $formated_EndtimeToDb")){
							
						  $this->form_validation->set_message('validationErrorMessage', 'Kuupäevad ei ole õigesti sisestatud.');
						  $this->session->set_flashdata('validationErrorMessage', 'Kellaaeg on valesti sisestatud');
									 
						
						
						   $this->load->view('templates/header');
						   $this->load->view('pages/booking', $data);
						   $this->load->view('templates/footer');
					  
						}
						else
						{
							$counter++;
							if($counter==1){$dateToRedirect= $start_data;}
					$insert_data2[] = array(
						'roomID' => $this->input->post('sportrooms'),
						'startTime' => $start_data,
						'endTime' => $end_data,
						'approved' => $takesPlace,
						'bookingID' => $id,
						'bookingTimeColor' => $this->input->post('color')[$t]
						);
					}
				}
			}
				}}
			}
			if (empty($insert_data2)) {
				$this->session->set_flashdata('access_deniedToUrl', 'Perioodi jooksul pole ühtegi kuupäeva mida salvestada');
		   }


		   $allEventsForConflictCheck=$this->booking_model->get_conflictsDates($this->session->userdata('building'),$this->input->post('sportrooms'));
							
		   foreach($allEventsForConflictCheck as $key => $value){
			   $property1 = 'startTime'; 
			   $property2 = 'endTime'; 
			   $property3 = 'public_info'; 
			   foreach($insert_data2 as $key2 => $value2){
			
				   
				   if($value->$property1<$value2['endTime'] && $value->$property2>$value2['startTime']){
					   $insert_data3[] = array(
					   
						   'startTime' => $value->$property1,
						   'endTime' =>  $value->$property2,
						   'public_info' => $value->$property3
						   );

				   break;
				   }
			   
				   //$value['startTime'],$value['endTime']
			   
			   }

		   }
		  if(!empty($insert_data3)){
      
			$this->booking_model->create_bookingTimes('');

			   $this->session->set_flashdata('key',$postData);
			   $this->session->set_flashdata('conflictDates',$insert_data3);
			   
			   redirect( $this ->input->post('current_url'));

			}
			else{

		   
			$this->booking_model->create_bookingTimes($insert_data2);
				
					$this->session->set_flashdata('post_updated', 'Andmed salvestatud');
						redirect('fullcalendar?roomId='.$this->input->post('sportrooms').'&date='. date('d.m.Y', strtotime($dateToRedirect)));
		
					}


		

			}

		} 

	}else{
	
		redirect('');
	}
	}





	public function createOnce()
	{
		if( $this->session->userdata('session_id')===TRUE){

		$this->form_validation->set_rules('clubname', 'Klubi nimi', 'trim|required|callback_clubname_check');
			if($this->form_validation->run() === FALSE ){
				$postData = $_POST;
				$postData['error'] = validation_errors() ;
				$this->session->set_flashdata("message","eroor".form_error());
				$this->session->set_flashdata('data', $this->input->post());

				if($this->input->post('dontShow')!=1){
				$this->session->set_flashdata('access_deniedToUrl', 'Midagi on selle vormiga valesti. Palun vaata kõik väljad üle');
				$this->session->set_flashdata('errors', validation_errors());
				}
				
				$this->session->set_flashdata('key',$postData);
				redirect( $this ->input->post('current_url'));

			} 
		$data['rooms'] = $this->booking_model->getAllRooms();
		$data['buildings'] = $this->booking_model->getAllBuildings();
	

		$data1 = array(
			'public_info'=>$this->input->post('clubname'),
			'c_name' => $this ->input->post('contactPerson'),
			'c_phone' => $this ->input->post('phone'),
			'c_email' => $this ->input->post('email'),
			'typeID' => $this ->input->post('type'),
		//	'comment_inner' => $this ->input->post('additionalComment'),
			'comment' => $this ->input->post('comment2'),
			'workout' => $this ->input->post('workoutType'),
		
		);
	
		$id= $this->booking_model->create_booking($data1);
				
		$insert_data2 = array();
		$takesPlace = $this ->input->post('approveNow')==1 ? 1 : 0;
		for($t = 0; $t <= count($this->input->post('workoutDate')); $t++) {
			if(isset($this->input->post('workoutDate')[$t])){
			$formated_startTime = date("H:i:s", strtotime($this->input->post('timesStart')[$t]));
			$formated_endTime = date("H:i:s", strtotime($this->input->post('timeTo')[$t]));
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
				'bookingID' => $id,
				'bookingTimeColor' => $this->input->post('color')[$t]
			);
		}

		}	}
			
		$this->booking_model->create_bookingTimes($insert_data2);
		redirect('fullcalendar?roomId='.$this->input->post('sportrooms').'&date='.$this->input->post('workoutDate')[0]);

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
