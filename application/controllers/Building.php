<?php
	class Building extends CI_Controller{
        
        public function __construct()
        {
            parent::__construct();
            $this->load->model('building_model');
    
		}
		

		// public function createRoom(){
			
		// 	$this->building_model->createNewRoom();
		// }

		public function edit($slug){

			if ($this->session->userdata('roleID')==='1'){
				$data['regions'] = $this->building_model->getAllRegions();
				$data['editBuildings'] = $this->building_model->get_building($slug);
				$this->load->view('templates/header');
				$this->load->view('pages/editBuilding', $data);
				$this->load->view('templates/footer');
			}

			else if ($this->session->userdata['building']!=$slug){

				redirect('building/view/'.$this->session->userdata['building']);
			}else{
			$data['regions'] = $this->building_model->getAllRegions();
			$data['editBuildings'] = $this->building_model->get_building($slug);
			$this->load->view('templates/header');
			$this->load->view('pages/editBuilding', $data);
			$this->load->view('templates/footer');
		}	}


		
		public function view($slug=FALSE){
			if ($this->session->userdata['building']!=$slug){
				
				redirect('building/view/'.$this->session->userdata['building']);
			}else{
			$data['editBuildings'] = $this->building_model->get_building($slug);
			$data['regions'] = $this->building_model->getAllRegions();
			$data['editAllBuildings'] = $this->building_model->get_building();
			$data['editAllRooms'] = $this->building_model->get_rooms();
			$this->load->view('templates/header');
			$this->load->view('pages/viewBuilding', $data);
			$this->load->view('templates/footer');
		}	}

		public function delete(){
			// Check login
			
			$id=$this->input->post('buildingID');
			$this->building_model->delete_building($id);
			// Set message
			$this->session->set_flashdata('building_deleted', 'Your building has been deleted');
			redirect('building/view/'.$this->session->userdata['building']);
		}

	
		public function deleteRoom(){
			// Check login
			$id=$this->input->post('roomID');
			$deletequery=$this->building_model->delete_room($id);
			// Set message
			if($deletequery===FALSE){
			//	$this->session->set_flashdata('building_deleted', 'Ei saa ruumi kustutada kuna selles on kehtivad broneeringud. Palun kustuta kõik broneeringud ära ja seejärel proovi uuesti.');	
				echo json_encode('Ei saa ruumi kustutada kuna selles on kehtivad broneeringud. Palun kustuta kõik tulevased broneeringud ära ja seejärel proovi uuesti.',JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
			//	redirect('building/view/'.$this->session->userdata['building']);
			}
		
			
			else{
				echo json_encode('');
		//	redirect('building/edit/'.$this->session->userdata['building']);
			}
			
		}


		public function roomStatus(){
			// Check login
		

			$data = array(
			
					'roomActive' => $this->input->post('roomStatus')
				);
				$this->building_model->update_room($data, $this->input->post('roomID') );
			
			
		}



		// public function edit($slug){
		// 	// Check login
		// 	// if(!$this->session->buildingdata('logged_in')){
		// 	// 	redirect('buildings/login');
		// 	// }
		// 	$data['editBuildings'] = $this->building_model->get_building();
		// 	$data['post'] = $this->building_model->get_building($slug);
		// 	// Check building
		// 	// if($this->session->buildingdata('building_id') != $this->post_model->get_building($slug)['building_id']){
		// 	// 	redirect('posts');
		// 	// }
		// //	$data['categories'] = $this->building_model->get_categories();
		// 	if(empty($data['post'])){
		// 		show_404();
		// 	}
		// 	$data['title'] = 'Edit Post';
		// 	$this->load->view('templates/header');
		// 	$this->load->view('pages/editbuilding', $data);
		// 	$this->load->view('templates/footer');
			
		// }


		public function update(){
			//Check login
			// if(!$this->session->buildingdata('logged_in')){
			// 	redirect('buildings/login');
			// }
			$data = array(
				//	'name' => $this->input->post('building'),
					'contact_email' => $this->input->post('email'),
					'phone' => $this->input->post('phone'),
					'notify_email' => $this->input->post('notifyEmail'),
					'price_url' => $this->input->post('price_url'),
					'regionID' => $this->input->post('place'),
					
					
				);
			$this->building_model->update_building($data);

			for($i = 0; $i < count($this->input->post('room')); $i++)
			{
			
				if( $this->input->post('room')[$i]!==null){
				
				$data2[] = array(
						'roomName' => $this->input->post('room')[$i],
						 'roomColor' => $this->input->post('color')[$i],
						// 'activeRoom' => 1,
								
				);
			
				print_r($this->input->post('roomID')[$i]);
				
				$this->building_model->update_room($data2[$i], $this->input->post('roomID')[$i] );
			}
		}

			if(!empty($this->input->post('additionalRoom'))){

		
			for($t = 0; $t <= count($this->input->post('additionalRoom')); $t++)
			{
				if( $this->input->post('additionalRoom')[$t]!==null){
				
				$data3[] = array(
						'roomName' => $this->input->post('additionalRoom')[$t],
						'roomColor' => $this->input->post('colorForNewRoom')[$t],
						'buildingID' => $this->input->post('id'),
					//	'activeRoom' => 1,
								
				);
				$this->building_model->createNewRoom($data3[$t]);
			}
		}
	}
			// Set message
			$this->session->set_flashdata('post_updated', 'Uuendasid asutuse infot');
		
			redirect('building/view/'.$this->session->userdata['building']);
		}


		public function register(){
			
			$this->form_validation->set_rules('name', 'Name', 'required');
          //  $this->form_validation->set_rules('phone', 'Phone');
			//$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');
			$data['regions'] = $this->building_model->getAllRegions();
			if($this->form_validation->run() === FALSE){
              
				$this->load->view('templates/header');
				$this->load->view('pages/createBuilding');
                $this->load->view('templates/footer');
                
			} else {
				
				$this->building_model->registerBuilding();
				$this->session->set_flashdata('user_registered', 'Asutus lisatud');
				redirect('building/view/'.$this->session->userdata['building']);
			}
		}








	}
