<?php
	class AllBookings extends CI_Controller{
        
        public function __construct()
        {
            parent::__construct();
            $this->load->model('allbookings_model');
    
		}
		
		function fetch_allbookings(){  
			$weekdays=array('Pühapäev','Esmaspäev','Teisipäev','Kolmapäev','Neljapäev','Reede' ,'Laupäev');
			$this->load->model("allbookings_model");  
			$fetch_data = $this->allbookings_model->make_datatables();  
			$data = array(); 
			$ApprovedData=""; 
			$TakesPlacesData=""; 
			$phoneIsNotZero=""; 
			foreach($fetch_data as $row)  
			{  
				if ($row->c_phone!=0) { $phoneIsNotZero=$row->c_phone; }
				if( $row->approved==1){ $ApprovedData= "&#10003;";} else {$ApprovedData= "";}; 
				if( $row->takes_place==1){ $TakesPlacesData= "";} else {$TakesPlacesData= "&#10003;";}
				 $savedDate = date('d.m.Y', strtotime($row->startTime));  
				 
				 $sub_array = array();  
				 $sub_array[] = date('d.m.Y H:i', strtotime($row->created_at));  
				 $sub_array[] = $row->roomName;  
				 $sub_array[] = $weekdays[idate('w', strtotime($row->startTime))];  
				 $sub_array[] = '<a href="'.base_url().'fullcalendar?roomId='.$row->roomID.'&date='.$savedDate.'">'.date('d.m.Y', strtotime($row->startTime)).'</a>';  
				 $sub_array[] = date('H:i', strtotime($row->startTime));  
				 $sub_array[] =  date('H:i', strtotime($row->endTime)); 
				 $sub_array[] = round(abs( strtotime($row->endTime) -  strtotime($row->startTime)) / 60,2);
				 $sub_array[] = $ApprovedData;   
				 $sub_array[] = $row->public_info;  
				 $sub_array[] = $row->workout;  
				 $sub_array[] = $row->comment;  
				 $sub_array[] = $row->c_name;  
				 $sub_array[] = $phoneIsNotZero;  
				 $sub_array[] = $row->c_email;  
				 $sub_array[] = $TakesPlacesData;  
				 
				 $sub_array[] = '<a href="'.base_url().'fullcalendar?roomId='.$row->roomID.'&date='.$savedDate.'"><button type="button" name="update" id="'.$row->timeID.'" class="btn btn-info info btn-sm ">Kalendrist</button></a>';
			
		
				 $data[] = $sub_array;  
			}  
			$output = array(  
				 "draw"                    =>     intval($_POST["draw"]),  
				 "recordsTotal"          =>      $this->allbookings_model->get_all_data(),  
				 "recordsFiltered"     =>     $this->allbookings_model->get_filtered_data(),  
				 "data"                    =>     $data  
			);  
			echo json_encode($output);  
	   }  


		public function index(){
			$data['weekdays']=array('Pühapäev','Esmaspäev','Teisipäev','Kolmapäev','Neljapäev','Reede' ,'Laupäev');
			$data['manageUsers'] = $this->allbookings_model->get_bookings();
			if(null!==$this->session->userdata('building')){
				$data['unapprovedBookings'] = $this->allbookings_model->getUnapprovedBookings($this->session->userdata('building'), $this->session->userdata('room'));
				
				}
		
			$this->load->view('templates/header', $data);
			$this->load->view('pages/allbookings', $data);
			$this->load->view('templates/footer');

		
		}

		public function weekView(){
			$data['weekdays']=array('Pühapäev','Esmaspäev','Teisipäev','Kolmapäev','Neljapäev','Reede' ,'Laupäev');
			$data['manageUsers'] = $this->allbookings_model->get_bookings();

			$data['rooms']=$this->allbookings_model->fetch_all_rooms_for_checkbox($this->session->userdata('building'));
			
			$this->load->view('templates/header');
			$this->load->view('pages/allweekbookings', $data);
			$this->load->view('templates/footer');
		}


		function load($buildingID)
		{
			$event_data = $this->allbookings_model->fetch_all_event($buildingID);
			foreach($event_data->result_array() as $row)
				
			{
				$data[] = array(
					'id'	=>	$row['bookingID'],
					'resourceId'	=>	$row['roomID'],
					'timeID'=>	$row['timeID'],
					'title'	=>	$row['public_info'],
					'description'	=>	$row['workout'],
					'start'	=>	$row['startTime'],
					'end'	=>	$row['endTime'],
					'clubname'	=>	$row['c_name'],
				//	'color'	=>	$row['bookingTimeColor'],
					
					 'building'	=>	$row['name'],
					 'roomName'	=>	$row['roomName'],
					 'organizer'	=>	$row['organizer'],
					 'typeID'	=>	$row['typeID'],
	
				);
		
		}
			
			echo json_encode($data);
		}

		function loadRooms($buildingID)
		{
			$event_data = $this->allbookings_model->fetch_all_rooms($buildingID);
			foreach($event_data->result_array() as $row)
				
			{
				$data[] = array(
					'id'	=>	$row['id'],
					 'title'	=>	$row['roomName'],
					 'eventColor'	=>	$row['roomColor']
					
				);
		
		}
			
			echo json_encode($data);
		}

		


	}
