<?php
	class AllBookings extends CI_Controller{
        
        public function __construct()
        {
            parent::__construct();
            $this->load->model('allbookings_model');
    
		}
		
		function fetch_allbookings(){  
			$this->load->model("allbookings_model");  
			$fetch_data = $this->allbookings_model->make_datatables();  
			$data = array();  
			foreach($fetch_data as $row)  
			{  
				 $sub_array = array();  
				 $sub_array[] = '<a href="'.base_url().'fullcalendar?roomId='.$row->roomID.'">'.$row->roomID.'</a>';  
				 $sub_array[] = $row->startTime;  
				 $sub_array[] = $row->endTime;  
				 $sub_array[] = $row->public_info;  
				 $sub_array[] = $row->workout;  
				 $sub_array[] = '<button type="button" name="update" id="'.$row->timeID.'" class="btn btn-warning btn-xs">Update</button>';  
				 $sub_array[] = '<button type="button" name="delete" id="'.$row->timeID.'" class="btn btn-danger btn-xs">Delete</button>';  
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
			$this->load->view('templates/header');
			$this->load->view('pages/allbookings', $data);
			$this->load->view('templates/footer');
		}

		public function weekView(){
			$data['weekdays']=array('Pühapäev','Esmaspäev','Teisipäev','Kolmapäev','Neljapäev','Reede' ,'Laupäev');
			$data['manageUsers'] = $this->allbookings_model->get_bookings();
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
					'phone'	=>	$row['c_phone'],
					'email'	=>	$row['c_email'],
					 'building'	=>	$row['name'],
					 'roomName'	=>	$row['roomName'],
					 'organizer'	=>	$row['organizer'],
					 'typeID'	=>	$row['typeID'],
	
				);
		
		}
			
			echo json_encode($data);
		}

		


	}
