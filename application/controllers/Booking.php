<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Booking extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('roleID'))  || $this->session->userdata('roleID')==='4'  || $this->session->userdata('roleID')==='1'){
		//	$this->session->set_flashdata('errors', 'Sul ei ole õigusi');
		//	redirect('');
		}
	//	if ( $this->session->userdata('roleID')==='2'  || $this->session->userdata('roleID')==='3'){

			$this->load->model('booking_model');
	//	}
	}

	function menu(){
		$data['menu'] = 'calendar'; // Capitalize the first letter
		
		if ( $this->session->userdata('roleID')==='2'  || $this->session->userdata('roleID')==='3'){
			$data['unapprovedBookings'] = $this->booking_model->getUnapprovedBookings($this->session->userdata('building'));

		}
		
		return $data;
	}

	public function create()
	{	
		if( $this->session->userdata('roleID')==='2'  || $this->session->userdata('roleID')==='3'){
			$data=$this->menu();
			$data['weekdays']=array('', 'Esmaspäev','Teisipäev','Kolmapäev','Neljapäev','Reede' ,'Laupäev','Pühapäev');
			$data['rooms'] = $this->booking_model->getAllRooms();
			$data['buildings'] = $this->booking_model->getAllBuildings();
			$data['allBookingInfo'] = $this->booking_model->getAllBookings();
			$data['bookingformdata'] = $this->booking_model->getBookingformData($this->session->userdata('building'));
	
		$this->load->view('templates/header',$data);
		$this->load->view('pages/booking', $data);//see leht laeb vajalikku vaadet. ehk saab teha controllerit ka mujale, mis laeb õiget lehte
		$this->load->view('templates/footer');

		}else{redirect('');}
	}

	public function createquery($roomID)
	{	
		$data=$this->menu();
		$data['weekdays']=array('', 'Esmaspäev','Teisipäev','Kolmapäev','Neljapäev','Reede' ,'Laupäev','Pühapäev');
		$data['rooms'] = $this->booking_model->getOtherRooms($roomID);
		$data['selectedBuilding'] = $this->booking_model->getBuilding($roomID);
	//	$data['allBookingInfo'] = $this->booking_model->getAllBookings();
		$data['bookingformdata'] = $this->booking_model->getBookingformData($data['selectedBuilding']['id']);
		$data['bookingformdatadetails'] = $this->booking_model->getBookingformDataDetails($data['selectedBuilding']['id'] );
		print_r($data['bookingformdatadetails']);
	
		$this->load->view('templates/header',$data);
		$this->load->view('pages/bookingquery', $data);//see leht laeb vajalikku vaadet. ehk saab teha controllerit ka mujale, mis laeb õiget lehte
		$this->load->view('templates/footer');

	}


	public function clubname_check($str= '')
	{
			if ($str == '' && $this->input->post('type')!='4')
			{
				$data['bookingformdata'] = $this->booking_model->getBookingformData();
				if($data['bookingformdata']['clubname_admin']==0){
					return TRUE;
				}
				$this->session->set_flashdata('validationErrorMessageForClubname', "<small class='text-danger'>See väli on kohustuslik</small>");
				return FALSE;
			}
			else if(!preg_match("/^[A-Za-z0-9 \x{00C0}-\x{00FF} ][A-Za-z0-9 \x{00C0}-\x{00FF}\'\-\.\,]+([\ A-Za-z0-9\x{00C0}-\x{00FF}][A-Za-z0-9\x{00C0}-\x{00FF}\'\-]+)*/u", $str)){
				$this->session->set_flashdata('validationErrorMessageForClubname', "<small class='text-danger'>Sellised märgid ei ole lubatud</small>");
				return FALSE;
			}

			else
			{
				return TRUE;
			}
	}
	public function contactPerson_check($str= '')
	{
			if ($str == '' && $this->input->post('type')!='4'){
				$data['bookingformdata'] = $this->booking_model->getBookingformData();
				if($data['bookingformdata']['contactname_admin']==0){
					return TRUE;
				}
				$this->session->set_flashdata('validationErrorMessageContactPerson', "<small class='text-danger'>See väli on kohustuslik</small>");
				return FALSE;
			}
			else if(!preg_match("/^[A-Za-z0-9 \x{00C0}-\x{00FF} ][A-Za-z0-9 \x{00C0}-\x{00FF}\'\-\.\,]+([\ A-Za-z0-9\x{00C0}-\x{00FF}][A-Za-z0-9\x{00C0}-\x{00FF}\'\-]+)*/u", $str) && $this->input->post('type')!='4'){
				$this->session->set_flashdata('validationErrorMessageContactPerson', "<small class='text-danger'>Sellised märgid ei ole lubatud</small>");
				return FALSE;
			}

			else{
					return TRUE;
			}
	}
	public function weekDayMissing($str= '')
	{
			if ($str == '')
			{
					$this->session->set_flashdata('weekDayMissing', "<small class='text-danger'>Nädalapäev on kohustuslik</small>");
					return FALSE;
			}
			else
			{
					return TRUE;
			}
	}
	public function email_cant_be_empty($str= '')
	{
			if ($str == '' && $this->input->post('type')!='4')
			{
				$data['bookingformdata'] = $this->booking_model->getBookingformData();
				if($data['bookingformdata']['email_admin']==0){
					return TRUE;
				}
				$this->form_validation->set_message('email_cant_be_empty', 'Email on kohustuslik');
				return false;
			}
			return TRUE;
		
	}

	public function type_cant_be_empty($str= '')
	{
			if ($str == '' && $this->input->post('type')!='4')
			{
				$data['bookingformdata'] = $this->booking_model->getBookingformData();
				if($data['bookingformdata']['type_admin']==0){
					return TRUE;
				}
				$this->session->set_flashdata('type_flash', "<small class='text-danger'>Tüüp on kohustuslik</small>");
				return false;
			}
			return TRUE;
		
	}
	

	public function phoneNumber_check($str= '')
	{
		if ($str == '')
			{
				$data['bookingformdata'] = $this->booking_model->getBookingformData();
				if($data['bookingformdata']['phone_admin']==0 || $this->input->post('type')=='4'){
					return TRUE;
				}
				$this->session->set_flashdata('validationErrorMessageForPhone', "<small class='text-danger'>See väli on kohustuslik</small>");
				return FALSE;
			
			}
		else if(!preg_match('/^\+?[\d\s]+$/', $str))
			{
					$this->session->set_flashdata('phoneIsNotCorrect', "<small class='text-danger'>Numbri formaat ei sobi</small>");
					return FALSE;
			}
			else
			{
					return TRUE;
			}
	}
	public function sportroomMissing($str= '')
	{
			if ($str == '')
			{
					$this->session->set_flashdata('sportroomMissing', "<small class='text-danger'>Vali vähemalt üks ruum</small>");
					return FALSE;
			}
			else
			{
					return TRUE;
			}
	}


	public function createClosed()
	{
		if (empty($this->session->userdata('roleID'))  || $this->session->userdata('roleID')==='4'  || $this->session->userdata('roleID')==='1'){
				$this->session->set_flashdata('errors', 'Sul ei ole õigusi');
				redirect('');
			}
		$data['weekdays']=array('', 'Esmaspäev','Teisipäev','Kolmapäev','Neljapäev','Reede' ,'Laupäev','Pühapäev');
		$postData = $this->input->post();
	
		if( $this->session->userdata('session_id')===TRUE){
			$data=$this->menu();
			$data['rooms'] = $this->booking_model->getAllRooms();
			$data['buildings'] = $this->booking_model->getAllBuildings();
			$data['allBookingInfo'] = $this->booking_model->getAllBookings();
			
			$this->form_validation->set_rules('clubname', 'Klubi nimi', 'trim|htmlspecialchars|callback_clubname_check');

			$this->form_validation->set_rules('contactPerson', 'Kontaktisik', 'trim|htmlspecialchars|callback_contactPerson_check');

			$this->form_validation->set_rules('phone', 'Telefon', 'trim|htmlspecialchars|callback_PhoneNumber_check');
			$this->form_validation->set_rules('email', 'E-mail', 'trim|htmlspecialchars|valid_email|callback_email_cant_be_empty');
			$this->form_validation->set_rules('workoutType', 'Sündmus / Treeningu tüüp', 'trim|htmlspecialchars|callback_type_cant_be_empty');
			$this->form_validation->set_rules('comment2', 'Lisainfo', 'trim|htmlspecialchars');
			$this->form_validation->set_rules('type', 'Tüüp', 'integer');
			$this->form_validation->set_rules('weekday[]', 'Nädal', 'required|callback_weekDayMissing');
			$this->form_validation->set_rules('current_url', 'URL ei näita', 'required');	
			$this->form_validation->set_rules('sportrooms[]', 'Spordiruum', 'required|callback_sportroomMissing');

			//check if selected room exists and user has right to make a booking in this room $this->input->post('sportrooms') 
			foreach($this->input->post('sportrooms') as $room){
				$isAllowedOrNot=$this->booking_model->checkIfRoomIsBookable($room);
				
				if(empty($isAllowedOrNot[0]['id'])){
					$postData['thisIsWhatIm']=$isAllowedOrNot[0]['id'];
					$this->session->set_flashdata('key',$this->security->xss_clean($postData));
					$this->session->set_flashdata('errors', 'Ai ai ai nii küll teha ei tohi! '.$isAllowedOrNot->id);
					redirect('booking/create/'.$room);
				}
			}

			if($this->form_validation->run() === FALSE ){
				
			//	$this->session->set_flashdata('data', $this->input->post());
			$this->session->set_flashdata("emailIsNotCorrect", form_error('email', '<small class="text-danger">','</small>')); // tekst '{field} ei ole korrektselt sisestatud' tuleb failist form_validation_lang.php
		//	$this->session->set_flashdata("weekDayMissing",form_error('weekday[]', '<small class="text-danger">','</small>')); // tekst '{field} ei ole korrektselt sisestatud' tuleb failist form_validation_lang.php
			//	if($this->input->post('dontShow')!=1){
				$this->session->set_flashdata('errors', 'Midagi on selle vormiga valesti. Palun vaata kõik väljad üle');
				$this->session->set_flashdata("message", form_error('current_url', '<small class="text-danger">','</small>'.$this->input->post('current_url'))); // tekst '{field} ei ole korrektselt sisestatud' tuleb failist form_validation_lang.php
			//	$this->session->set_flashdata('message', 'Urliga on midagi mäda. See on:'. $this->input->post('current_url'));
				
			//	}
				
			$this->session->set_flashdata('key',$this->security->xss_clean($postData));
			redirect('booking/create/'.$this->input->post('sportrooms')[0]);
			} 
			else{
			$event_in = strtotime($this->input->post('startingFrom'));
			$event_out = strtotime($this->input->post('Ending'));

	
			if ($event_in > $event_out)
			{
			  $this->session->set_flashdata('errors', 'Periood on valesti sisestatud');
			  $this->session->set_flashdata('validationErrorMessageforPeriod', "<small class='text-danger'>Periood on valesti sisestatud</small>");
			  $this->session->set_flashdata('key',$this->security->xss_clean($postData));
			  redirect( $this->input->post('current_url'));
			}
			else
			{
			 		
			$event_in = date('Y-m-d H:i:s', $event_in);
			$event_out = date('Y-m-d H:i:s', $event_out);
		
			$this->booking_model->begin_trans();
			
		//	$this->form_validation->set_rules('contactPerson', 'Kontaktisik', 'trim|required');
			$this->form_validation->set_rules('contactPerson', 'Kontaktisik', 'trim');
		
		

					
			$insert_data2 = array();
			$insert_data3 = array();
			$startDate=$this->input->post('startingFrom');
			$startDate = strtotime($startDate);
			$startDateToDb = strtotime($startDate);
			$endDate = $this->input->post('Ending');
			$endDate = strtotime($endDate);
			$endDateToDb = strtotime($endDate);
			$weekday=$this->input->post('weekday');
			$days=array('Esmaspäev'=>'Monday','Teisipäev' => 'Tuesday','Kolmapäev' => 'Wednesday','Neljapäev'=>'Thursday','Reede' =>'Friday','Laupäev' => 'Saturday','Pühapäev'=>'Sunday');
			$checkHoManyWeekDays=array();
		
			// var_dump(date("H:i", strtotime($this->input->post('timesStart')[1])));
			$dateToRedirect='';
			$counter=0;
			$takesPlace= $this->input->post('approveNow')==1 ? 1 : 0;
			foreach($this->input->post('sportrooms') as $room){
				$data1 = array(
					'public_info'=>$this->input->post('clubname'),
				//	'comment_inner' => $this->input->post('comment2'),
					'event_in' => $event_in,
					'event_out' => $event_out,
					'typeID' => $this->input->post('type'),
					'c_name' => $this->input->post('contactPerson'),
					'c_phone' => $this->input->post('phone'),
					'c_email' => $this->input->post('email'),
					'comment' => $this->input->post('comment2'),
					'workout' => $this->input->post('workoutType'),
					
	
				);
				$id= $this->booking_model->create_booking($data1);
				for($t = 0; $t <= count($this->input->post('timesStart')); $t++)
					{
						if(isset($this->input->post('timesStart')[$t])){
					$formated_timeToDb = date("H:i", strtotime($this->input->post('timesStart')[$t]));
					$formated_EndtimeToDb = date("H:i", strtotime($this->input->post('timeTo')[$t]));
				
			
					foreach($days as $key => $value){
			
				if ($weekday[$t]==$key){
					$checkHoManyWeekDays[]=$key;
					$checkHoManyWeekDays=array_unique($checkHoManyWeekDays);
					if (count($checkHoManyWeekDays) > 1 && $startDate==$endDate){
						$this->session->set_flashdata('errors', 'Oled sisestanud mitu nädalapäeva, kuid perioodiks on ainult üks päev');
						$this->session->set_flashdata('validationErrorMessageforPeriod', "<small class='text-danger'>Vaata perioon üle või kustuta üleliigsed nädalapäevad</small>");
						$this->session->set_flashdata('key',$this->security->xss_clean($postData));
						redirect( $this->input->post('current_url'));
					}
					//var_dump($this->input->post('Ending'));
					for($i = strtotime($value, $startDate); $i <= $endDate; $i = strtotime('+1 week', $i))
						{  
							
						$dateToDb=date('Y-m-d', $i);
						
					//	var_dump(date('Y-m-d H:i:s', strtotime("$dateToDb $formated_timeToDb")));
						
						$start_data = date('Y-m-d H:i:s', strtotime("$dateToDb $formated_timeToDb"));
						$end_data = date('Y-m-d H:i:s', strtotime("$dateToDb $formated_EndtimeToDb"));
					
					
						//Kuni kuni aeg on minevikus, siis näita veateadet ning tee redirect
						if(strtotime("$dateToDb $formated_timeToDb")>=strtotime("$dateToDb $formated_EndtimeToDb")){
								
							$this->form_validation->set_message('validationErrorMessage', 'Kuupäevad ei ole õigesti sisestatud.');
							$this->session->set_flashdata('validationErrorMessage', 'Kellaaeg on valesti sisestatud');
							$this->session->set_flashdata('key',$this->security->xss_clean($postData));
							redirect( $this->input->post('current_url'));
						
						}
						else
						{
							$counter++;
							$colorToSave='';
							if($counter==1){
								$dateToRedirect= $start_data;
							}
							if(array_key_exists($t, $this->input->post('color'))){
								$colorToSave=$this->input->post('color')[$t];
							}
							else{
								$colorToSave='#ffffff';
							}
							
							
						
							$insert_data2[] = array(
								'roomID' => $room,
								'startTime' => $start_data,
								'endTime' => $end_data,
								'approved' => $takesPlace,
								'bookingID' => $id,
								'bookingTimeColor' => $colorToSave
							);
						}
						}
					}
					}}
				}
			}
			if (empty($insert_data2)) {
				$this->session->set_flashdata('weekDayMissing', '<small class="text-danger">Perioodi jooksul pole ühtegi kuupäeva mida salvestada</small>');
				
				$this->session->set_flashdata('key',$this->security->xss_clean($postData));
				redirect( $this->input->post('current_url'));
		   }

		   foreach($this->input->post('sportrooms') as $room){
			$allEventsForConflictCheck=$this->booking_model->get_conflictsDates($this->session->userdata('building'), $room);
								
			foreach($allEventsForConflictCheck as $key => $value){
				$property1 = 'startTime'; 
				$property2 = 'endTime'; 
				$property3 = 'public_info'; 
				$property4 = 'workout'; 
				$property5 = 'roomName'; 
				foreach($insert_data2 as $key2 => $value2){
				
					
					if($value->$property1<$value2['endTime'] && $value->$property2>$value2['startTime']){
						$insert_data3[] = array(
							
							'startTime' => $value->$property1,
							'endTime' =>  $value->$property2,
							'public_info' => $value->$property3,
							'workout' => $value->$property4,
							'room' => $value->$property5
							);

					break;
					}
				
					//$value['startTime'],$value['endTime']
				
				}

			}
		}
		  if(!empty($insert_data3)&&$this->input->post('allowSave')==0){
      
			$this->booking_model->create_bookingTimes('');

			$this->session->set_flashdata('key',$this->security->xss_clean($postData));
			   $this->session->set_flashdata('conflictDates',$insert_data3);
			   
			   $this->load->view('templates/header', $data);
			   $this->load->view('pages/booking', $data);
			   $this->load->view('templates/footer');

			}
			else{

		   
			$this->booking_model->create_bookingTimes($insert_data2);
				
					$this->session->set_flashdata('post_updated', 'Andmed salvestatud');
						redirect('fullcalendar?roomId='.$this->input->post('sportrooms')[0].'&date='. date('d.m.Y', strtotime($dateToRedirect)));
		
					}

			}

		} 

	}else{
	
		//redirect('');
	}
	}





	public function createOnce()
	{
		if (empty($this->session->userdata('roleID'))  || $this->session->userdata('roleID')==='4'  || $this->session->userdata('roleID')==='1'){
			$this->session->set_flashdata('errors', 'Sul ei ole õigusi');
			redirect('');
		}
		if( $this->session->userdata('session_id')===TRUE){
			$data=$this->menu();
			$postData = $this->input->post();
			$data['weekdays']=array('', 'Esmaspäev','Teisipäev','Kolmapäev','Neljapäev','Reede' ,'Laupäev','Pühapäev');
			$data['allBookingInfo'] = $this->booking_model->getAllBookings();
			$this->form_validation->set_rules('clubname', 'Klubi nimi', 'trim|htmlspecialchars|callback_clubname_check');
			$this->form_validation->set_rules('contactPerson', 'Kontaktisik', 'trim|htmlspecialchars|callback_contactPerson_check');
			$this->form_validation->set_rules('phone', 'Telefon', 'trim|htmlspecialchars|callback_PhoneNumber_check');
			$this->form_validation->set_rules('email', 'E-mail', 'trim|htmlspecialchars|valid_email|callback_email_cant_be_empty');
			$this->form_validation->set_rules('workoutType', 'Sündmus / Treeningu tüüp', 'trim|htmlspecialchars|callback_type_cant_be_empty');
			$this->form_validation->set_rules('comment2', 'Lisainfo', 'trim|htmlspecialchars');
			$this->form_validation->set_rules('type', 'Tüüp', 'integer');
			$this->form_validation->set_rules('sportrooms[]', 'Spordiruum', 'required|callback_sportroomMissing');
		
			//check if selected room exists and user has right to make a booking in this room $this->input->post('sportrooms') 
			foreach($this->input->post('sportrooms') as $room){
				$isAllowedOrNot=$this->booking_model->checkIfRoomIsBookable( $room);
				if(empty($isAllowedOrNot[0]['id'])){
					$postData['thisIsWhatIm']=$isAllowedOrNot[0]['id'];
					$this->session->set_flashdata('key',$this->security->xss_clean($postData));
					$this->session->set_flashdata('errors', 'Ai ai ai nii küll teha ei tohi! '.$isAllowedOrNot->id);
					redirect('booking/create/'.$room);
				}

			}	
			
			if($this->form_validation->run() === FALSE ){
				
				$this->form_validation->set_message('clubname', 'text dont match captcha'); 
				$postData['error'] = validation_errors() ;
				$this->session->set_flashdata("emailIsNotCorrect",form_error('email', '<small class="text-danger">','</small>')); // tekst '{field} ei ole korrektselt sisestatud' tuleb failist form_validation_lang.php
		
			//	if($this->input->post('dontShow')!=1){
				$this->session->set_flashdata('access_deniedToUrl', 'Midagi on selle vormiga valesti. Palun vaata kõik väljad üle');
			//	}
				
				$this->session->set_flashdata('key',$this->security->xss_clean($postData));
				redirect('booking/create/'.$this->input->post('sportrooms')[0]);

			} 
		$data['rooms'] = $this->booking_model->getAllRooms();
		$data['buildings'] = $this->booking_model->getAllBuildings();
	

		$this->booking_model->begin_trans();
				
		$insert_data2 = array();
		$insert_data3 = array();

		$takesPlace = $this->input->post('approveNow')==1 ? 1 : 0;
		foreach($this->input->post('sportrooms') as $room){
			$data1 = array(
				'public_info'=>$this->input->post('clubname'),
				'c_name' => $this->input->post('contactPerson'),
				'c_phone' => $this->input->post('phone'),
				'c_email' => $this->input->post('email'),
				'typeID' => $this->input->post('type'),
			//	'comment_inner' => $this->input->post('additionalComment'),
				'comment' => $this->input->post('comment2'),
				'workout' => $this->input->post('workoutType'),
			
			);
		
			$id= $this->booking_model->create_booking($data1);
			
			for($t = 0; $t <= count($this->input->post('workoutDate')); $t++) {
				if(isset($this->input->post('workoutDate')[$t])){
					$formated_startTime = date("H:i:s", strtotime($this->input->post('timesStart')[$t]));
					$formated_endTime = date("H:i:s", strtotime($this->input->post('timeTo')[$t]));
					$formated_date = date("Y-m-d", strtotime($this->input->post('workoutDate')[$t]));

					$start_date = date('Y-m-d H:i:s', strtotime("$formated_date $formated_startTime"));
					$end_date = date('Y-m-d H:i:s', strtotime("$formated_date $formated_endTime"));
				
					if(strtotime("$formated_date $formated_startTime")>=strtotime("$formated_date $formated_endTime")){
									
						$this->form_validation->set_message('validationErrorMessage', 'Kuupäevad ei ole õigesti sisestatud.');
						$this->session->set_flashdata('validationErrorMessage', 'Kellaaeg on valesti sisestatud');
						
						$this->session->set_flashdata('key',$this->security->xss_clean($postData));
						redirect( $this->input->post('current_url'));
					
					}
					else
					{

					$insert_data2[] = array(
						'roomID' => $room,
						'startTime' => $start_date,
						'endTime' => $end_date,
						'approved' => $takesPlace,
						'bookingID' => $id,
						'bookingTimeColor' => $this->input->post('color')[$t]
					);
					}

				}	
			}
		}
		
		foreach($this->input->post('sportrooms') as $room){
			$allEventsForConflictCheck=$this->booking_model->get_conflictsDates($this->session->userdata('building'),$room);
								
			foreach($allEventsForConflictCheck as $key => $value){
				$property1 = 'startTime'; 
				$property2 = 'endTime'; 
				$property3 = 'public_info'; 
				$property4 = 'workout'; 
				$property5 = 'roomName'; 
				foreach($insert_data2 as $key2 => $value2){
			
					
					if($value->$property1<$value2['endTime'] && $value->$property2>$value2['startTime']){
						//insert_data3 mean conflick days
						$insert_data3[] = array(
						
							'startTime' => $value->$property1,
							'endTime' =>  $value->$property2,
							'public_info' => $value->$property3,
							'workout' => $value->$property4,
							'room' => $value->$property5
							);

					break;
					}
				
					//$value['startTime'],$value['endTime']
				
				}

			}
		}
	
	   if(!empty($insert_data3)&&$this->input->post('allowSave')==0){
   
		 $this->booking_model->create_bookingTimes('');

			$this->session->set_flashdata('key',$this->security->xss_clean($postData));
			$this->session->set_flashdata('conflictDates', $this->security->xss_clean($insert_data3));
			
			$this->load->view('templates/header', $data);
			$this->load->view('pages/booking', $data);
			$this->load->view('templates/footer');

		 }
		 else{


		$this->booking_model->create_bookingTimes($insert_data2);

		$this->session->set_flashdata('post_updated', 'Andmed salvestatud');
		redirect('fullcalendar?roomId='.$this->input->post('sportrooms')[0].'&date='.$this->input->post('workoutDate')[0]);
		 }
	

	}
	
}
	}
	





?>
