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
	
	

	function load2($bookingID)
	{
		if($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){


		//	$this->form_validation->set_rules('e-mail', 'Email', 'trim|required|valid_email');
		
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
				'workout'	=>	$row['workout'],
				'created_at'	=>	$row['created_at'],
				 'comment'	=>	$row['comment'],
				 'building'	=>	$row['name'],
				 'roomName'	=>	$row['roomName'],
				 'bookingID'	=>	$row['bookingID'],
				 'takesPlace'	=>	$row['takes_place'],
				 'approved'	=>	$row['approved'],
				 'organizer'	=>	$row['organizer'],
				 'color'	=>	$row['bookingTimeColor'],

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



	public function clubname_check($str= '')
	{
			if ($str == '')
			{
				$this->session->set_flashdata('validationErrorMessageForClubname', "<small class='text-danger'>See väli on kohustuslik</small>");
				return FALSE;
			}
			else if(!preg_match("/^[A-Za-z0-9\x{00C0}-\x{00FF} ][A-Za-z0-9\x{00C0}-\x{00FF}\'\-\.\,]+([\ A-Za-z0-9\x{00C0}-\x{00FF}][A-Za-z0-9\x{00C0}-\x{00FF}\'\-]+)*/u", $str)){
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
			if ($str == '')
			{
				return TRUE;
			}
			else if(!preg_match("/^[A-Za-z0-9\x{00C0}-\x{00FF} ][A-Za-z0-9\x{00C0}-\x{00FF}\'\-\.\,]+([\ A-Za-z0-9\x{00C0}-\x{00FF}][A-Za-z0-9\x{00C0}-\x{00FF}\'\-]+)*/u", $str)){
				$this->session->set_flashdata('validationErrorMessageContactPerson', "<small class='text-danger'>Sellised märgid ei ole lubatud</small>");
				return FALSE;
			}

			else
			{
					return TRUE;
			}
	}


	public function phoneNumber_check($str= '')
	{
		if ($str == '')
			{
				return TRUE;
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


	public function checkIfIsAllowedToUpdate($id)
	{
		
		return $this->edit_model->can_update_or_not($this->session->userdata('building'),$id);

	}



	// The Main function
	public function update()
	{	
		if($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){
		$conflictTimes = array();
		$data['allPostData']=$this->input->post();
		foreach ($this->input->post('timesIdArray') as $id) {
		$bookingDataWhichUserWantsToChange[]=$this->edit_model->get_allbookingtimes($this->input->post('BookingID'),$id);
		if(!$this->checkIfIsAllowedToUpdate($id)){
			redirect('fullcalendar?roomId='.$this->input->post('roomID').'&date='. date('d.m.Y', strtotime($this->input->post('bookingtimesFrom')[0])));

		};
		}

	

	
	     $this->form_validation->set_rules('publicInfo', 'Klubi nimi', 'trim|htmlspecialchars|required|callback_clubname_check');
		 $this->form_validation->set_rules('contactPerson', 'Kontaktisik', 'trim|htmlspecialchars|callback_contactPerson_check');
		 $this->form_validation->set_rules('phone', 'Telefon', 'trim|htmlspecialchars|callback_PhoneNumber_check');
		 $this->form_validation->set_rules('email', 'E-mail', 'trim|htmlspecialchars|valid_email');
		 $this->form_validation->set_rules('workoutType', 'Sündmus / Treeningu tüüp', 'trim|htmlspecialchars');
		 $this->form_validation->set_rules('additionalComment', 'Lisainfo', 'trim|htmlspecialchars');

		$data['bookingData']=$bookingDataWhichUserWantsToChange[0][0];
		$data['allBookingData']=$bookingDataWhichUserWantsToChange;
	
		$roomWhereSearchForConflicts=$this->edit_model->get_room($this->input->post('BookingID'));
		$allEventsForConflictCheck=$this->edit_model->get_conflictsDates($roomWhereSearchForConflicts['roomID'], $this->input->post('BookingID'));


		if($this->input->post('isPeriodic')){
			$whichWeekDaynumberToSearch=date('N', strtotime($data['bookingData']['startTime']));
			print_r($whichWeekDaynumberToSearch);
			$startTime= $this->input->post('startTime');
			$startingTime= date("H:i:s", strtotime($data['bookingData']['startTime'])); //kell alates
			$endingTime= date("H:i:s", strtotime($data['bookingData']['endTime']));
		
			$getLasDateToCheck=$this->edit_model->get_lastDate($whichWeekDaynumberToSearch, $data['bookingData']['bookingID'],$data['bookingData']['startTime']);
			$retrieveDatesFromDataBase=$this->edit_model->get_allTimesThatMatch($whichWeekDaynumberToSearch, $data['bookingData']['bookingID'], $startingTime ,$endingTime,$roomWhereSearchForConflicts['roomID'], $data['bookingData']['startTime'] );
		}
		print_r($getLasDateToCheck);
		echo '<br>';
	   foreach($allEventsForConflictCheck as $key => $value){
			   $property1 = 'startTime'; 
			   $property2 = 'endTime'; 
			   $property3 = 'public_info'; 
			   $property4 = 'workout'; 
			   $property5 = 'timeID'; 
			   foreach($bookingDataWhichUserWantsToChange as $key2 => $value2){
			
			
				   if($value->$property1<$value2[0]['endTime'] && $value->$property2>$value2[0]['startTime']){
					   $conflictTimes[] = array(
						   'start' => $value->$property1,
						   'end' =>  $value->$property2,
						   'title' => $value->$property3,
						   'description' => $value->$property4,
						   'timeID' => $value->$property5
						   );

				   break;
				   }
			   
				   //$value['startTime'],$value['endTime']
			   
			   }

		   }	
		 
			  $data['conflictTimes']= json_encode($conflictTimes);
			
		//	$this->form_validation->set_rules('publicInfo', 'Klubi nimi', 'required');
		//	$this->form_validation->set_rules('contactPerson', 'Kontaktisik', 'required');

			if($this->form_validation->run() === FALSE ){

				if($this->input->post('dontShow')!=1){
				$this->form_validation->set_message('validationErrorMessage', 'Vormiga on midagi valesti');
				$this->session->set_flashdata('validationErrorMessage', 'Vormiga on midagi valesti');

				
				}
				// $this->load->view('templates/header');
				// $this->load->view('pages/edit', $data);
                // $this->load->view('templates/footer');
				// redirect(base_url('fullcalendar/edit'  ,$_POST));


				$this->load->view('templates/header');
				$this->load->view('pages/edit',$this->security->xss_clean($data));//see leht laeb vajalikku vaadet. ehk saab teha controllerit ka mujale, mis laeb õiget lehte
				print_r($conflictTimes);
				echo '<br>';
				print_r($data);
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
				
			);
			
				$this->edit_model->update_booking($data1, $this->input->post('BookingID'));
				
					$insert_data = array();
					$start_data = $this->input->post('bookingtimesFrom');
					$end_data = $this->input->post('bookingtimesTo');
					
					
					$RedirectToCalendar='';
					for($i = 0; $i < count($start_data); $i++)
					{
						

						$formated_startTime = date("H:i:s", strtotime($this->input->post('timeStart')[$i])); //kell alates
						$formated_endTime = date("H:i:s", strtotime($this->input->post('timeEnd')[$i])); //kell kuni
						$formated_date = date("Y-m-d", strtotime($this->input->post('bookingtimesFrom')[$i])); //kuupäev
				
						$start_date = date('Y-m-d H:i:s', strtotime("$formated_date $formated_startTime"));
						$end_date = date('Y-m-d H:i:s', strtotime("$formated_date $formated_endTime"));
				
						if(strtotime("$formated_date $formated_startTime")>=strtotime("$formated_date $formated_endTime")){

							$this->form_validation->set_message('validationErrorMessage', 'Kuupäevad ei ole õigesti sisestatud.');
							$this->session->set_flashdata('validationErrorMessage', 'Kellaaeg on valesti sisestatud');

							//	redirect('edit/update'  ,$_POST);
							$this->load->view('templates/header');
							$this->load->view('pages/edit');
							$this->load->view('templates/footer');
							$RedirectToCalendar=false;
						break;

						}
						else{
							$RedirectToCalendar=true;
						$insert_data[] = array(
							//'roomID' => $this->input->post('sportrooms'),
							'startTime' => $start_date, 
							'endTime' => $end_date,
							'bookingTimeColor' =>$this->input->post('color')[$i]
							
							);
							$this->edit_model->update_bookingTimes($insert_data[$i], $this->input->post('timesIdArray')[$i]);
						}
				
				}
				//var_dump($insert_data);
			//	$this->edit_model->update_bookingTimes($insert_data, $this->input->post('timesIdArray'));
						//$this->booking_model->create_bookingTimes($insert_data);
					//	$this->load->view('booking/success');
					//	redirect('fullcalendar?roomId=1');
				
					//var_dump($data1);

		// }
		

		if($this->input->post('additionalBookingDate')){
		
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
					'bookingTimeColor' =>$this->input->post('color')[$t]
				);
			
				$this->edit_model->insert($addtimes[$t], $this->input->post('id'));
			
		
			//	redirect(base_url('fullcalendar/edit'  ,$_POST));
				// $timesIdArray=$this->input->post('');
				// $this->session->set_flashdata('timesIdArray', $timesIdArray);
		
				// $this->session->set_userdata('referred_from', current_url());
				// $referred_from = $this->session->userdata('referred_from');
				
			}else{


					// redirect(base_url('fullcalendar?roomId='.$this->input->post('roomID')));
					// $this->load->view('templates/header');
					// $this->load->view('pages/fullcalendar?roomId='.$this->input->post('roomID'));//see leht laeb vajalikku vaadet. ehk saab teha controllerit ka mujale, mis laeb õiget lehte
					// echo "success!";
					// $this->load->view('templates/footer');

				}
				//redirect(base_url('fullcalendar?roomId='.$this->input->post('roomID')));
			}

		}	
		else{
			if($RedirectToCalendar){
				//print_r($_POST);
			
			//	redirect(base_url('fullcalendar?roomId='.$this->input->post('roomID')));
				redirect('fullcalendar?roomId='.$this->input->post('roomID').'&date='. date('d.m.Y', strtotime($this->input->post('bookingtimesFrom')[0])));
			// $this->load->view('templates/header');
			// $this->load->view('pages/edit');
			// $this->load->view('templates/footer');
			}
		
		}
	}

	}else{
		//Kui pole juht ega haldur, siis viib avalehele
		redirect('');}
	
	}

	



	public function updatePeriod()
	{	
	
		
		if($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){

			$this->form_validation->set_rules('publicInfoPeriod', 'Klubi nimi', 'required');
		//	$this->form_validation->set_rules('contactPersonPeriod', 'Kontaktisik', 'required');
			if($this->form_validation->run() === FALSE ){

				if($this->input->post('dontShow')!=1){
				$this->form_validation->set_message('validationErrorMessage', 'Klubi nimi puudu');
				$this->session->set_flashdata('validationErrorMessage', 'Klubi nimi puudu');
				}
			

				$this->load->view('templates/header');
				$this->load->view('pages/edit');//see leht laeb vajalikku vaadet. ehk saab teha controllerit ka mujale, mis laeb õiget lehte
				print_r($_POST);

				$this->load->view('templates/footer');

			} 
			else{

			$data1 = array(
				'public_info'=>$this->input->post('publicInfoPeriod'),
				'c_name' => $this ->input->post('contactPersonPeriod'),
				'organizer' => $this ->input->post('organizerPeriod'),
				'c_phone' => $this ->input->post('phonePeriod'),
				'c_email' => $this ->input->post('emailPeriod'),
				'comment' => $this ->input->post('additionalCommentPeriod'),
				//'building' => $this ->input->post('building'), //pole seda formis
				'workout' => $this ->input->post('workoutTypePeriod'),
				// 'event_in' => $this ->input->post('eventIn'),
				// 'event_out' => $this ->input->post('phone')
			);
			
				$this->edit_model->update_booking($data1, $this->input->post('BookingID'));
				
					$insert_data = array();
					$start_data = $this->input->post('bookingtimesFrom');
					
					$weekday=$this->input->post('weekendNumber');
					if ($weekday==0? $weekday=7:$weekday);
					$weekdayToChange=$this->input->post('weekday')[0];
					$days= array('Esmaspäev', 'Teisipäev', 'Kolmapäev', 'Neljapäev', 'Reede', 'Laupäev','Pühapäev');
					$key = array_search($weekdayToChange, $days);
					$difference=$key-$weekday+1;
					echo $difference;
					
					$RedirectToCalendar='';
					for($i = 0; $i < count($start_data); $i++)
					{
						$datestr=$this->input->post('bookingtimesFrom')[$i];
						$added_timestamp = 	strtotime($datestr. '  '.$difference.' days');
					
						$formated_startTime = date("H:i:s", strtotime($this->input->post('timesStart'))); //kell alates
						$formated_endTime = date("H:i:s", strtotime($this->input->post('timeTo'))); //kell kuni
						$formated_date = date("Y-m-d", $added_timestamp); //kuupäev
				
						$start_date = date('Y-m-d H:i:s', strtotime("$formated_date $formated_startTime"));
						$end_date = date('Y-m-d H:i:s', strtotime("$formated_date $formated_endTime"));
				
						if(strtotime("$formated_date $formated_startTime")>=strtotime("$formated_date $formated_endTime")){

							$this->form_validation->set_message('validationErrorMessage', 'Kuupäevad ei ole õigesti sisestatud.');
							$this->session->set_flashdata('validationErrorMessage', 'Kellaaeg on valesti sisestatud');

							//	redirect('edit/update'  ,$_POST);
							$this->load->view('templates/header');
							$this->load->view('pages/edit');
							$this->load->view('templates/footer');
							$RedirectToCalendar=false;
						break;

						}
						else{
							$RedirectToCalendar=true;
						$insert_data[] = array(
					
							'startTime' => $start_date, 
							'endTime' => $end_date,
							'bookingTimeColor' =>$this->input->post('color')
							
							);
							//print_r( $this->input->post('timesIdArray')[$i]) ;

							
							$this->edit_model->update_bookingTimes($insert_data[$i], $this->input->post('timesIdArray')[$i]);
						}
				
				}
		

		if($this->input->post('additionalBookingDate')){
		
			$addtimes = array();
			for($t = 0; $t <= count($this->input->post('additionalBookingDate')); $t++) {
		
			}

		}	
		else{
			if($RedirectToCalendar){
				redirect('fullcalendar?roomId='.$this->input->post('roomID').'&date='. date('d.m.Y', strtotime($this->input->post('bookingtimesFrom')[0])));
		
				// $this->load->view('templates/header');
				// $this->load->view('pages/edit');//see leht laeb vajalikku vaadet. ehk saab teha controllerit ka mujale, mis laeb õiget lehte
			

				// $this->load->view('templates/footer');
		
			}
		
		}
	}

	}else{
		//Kui pole juht ega haldur, siis viib avalehele
		redirect('');}
	
	}




}

?>
