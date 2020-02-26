<?php
	class AllBookings extends CI_Controller{
        
        public function __construct()
        {
            parent::__construct();
            $this->load->model('allbookings_model');
    
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
