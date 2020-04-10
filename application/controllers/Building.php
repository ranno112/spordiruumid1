<?php
	class Building extends CI_Controller{
        
        public function __construct()
        {
            parent::__construct();
            $this->load->model('building_model');
			if (empty($this->session->userdata('roleID'))  || $this->session->userdata('roleID')==='4'){
				$this->session->set_flashdata('errors', 'Sul ei ole õigusi');
				redirect('');
			}
			
		}
		

		// public function createRoom(){
			
		// 	$this->building_model->createNewRoom();
		// }

		public function edit($slug){
			if ($this->session->userdata('roleID')==='1'){
				$data['regions'] = $this->building_model->getAllRegions();
				$data['editBuildings'] = $this->building_model->get_building($slug);
				$this->load->view('templates/header');
				$this->load->view('pages/editBuilding', $this->security->xss_clean($data));
				$this->load->view('templates/footer');
			}

			else if ($this->session->userdata['building']!=$slug){

				redirect('building/view/'.$this->session->userdata['building']);
			}else if ($this->session->userdata('roleID')==='2'){
			$data['regions'] = $this->building_model->getAllRegions();
			$data['editBuildings'] = $this->building_model->get_building($slug);
			$this->load->view('templates/header');
			$this->load->view('pages/editBuilding', $this->security->xss_clean($data));
			$this->load->view('templates/footer');
			}else{
			$this->session->set_flashdata('errors', 'Sul ei ole õigusi');
			redirect('');
			}
		}


		
		public function view($slug=FALSE){
			if ($this->session->userdata['building']!=$slug){
			redirect('building/view/'.$this->session->userdata['building']);
			}else{
			$data['editBuildings'] = $this->building_model->get_building($slug);
			$data['regions'] = $this->building_model->getAllRegions();
			$data['editAllBuildings'] = $this->building_model->get_building();
			$data['editAllRooms'] = $this->building_model->get_rooms();
			$this->load->view('templates/header');
			$this->load->view('pages/viewBuilding', $this->security->xss_clean($data));
			$this->load->view('templates/footer');
			}	
		}

		public function delete(){
			// Check login
			if ($this->session->userdata('roleID')==='1'){
				$this->form_validation->set_rules('buildingID', 'Asutus', 'integer|required');
				if($this->form_validation->run() === FALSE ){
				$this->session->set_flashdata('errors', 'Ei tohi süsteemi kompromiteerida');
				redirect('');
				}
				$buildingID=$this->input->post('buildingID');
				$allRoomsID=$this->building_model->get_all_roomsID_from_one_building($buildingID);
				print_r($allRoomsID);
				if(empty($allRoomsID)){
					$this->building_model->delete_building($buildingID);
					$this->session->set_flashdata('building_deleted', 'Asutus kustutatud');
					redirect('building/view/'.$this->session->userdata['building']);
				}
				foreach ($allRoomsID as $id)
				{
					echo $this->building_model->check_if_room_has_reservations_only_in_past($id->id);
					if(!$this->building_model->check_if_room_has_reservations_only_in_past($id->id)){
					$this->session->set_flashdata('message', 'Kahjuks ei saa asutust kustutada, kuna selles on broneeringud alates eelmisest aastast');
					redirect('building/view/'.$this->session->userdata['building']);	
					};	
				}

				$this->building_model->delete_building($buildingID);
				$this->session->set_flashdata('building_deleted', 'Asutus kustutatud');
				redirect('building/view/'.$this->session->userdata['building']);
			}
			else{
				$this->session->set_flashdata('errors', 'Sul ei ole õigusi');
				redirect('');
			}
		}

	
		public function deleteRoom(){
			if($this->session->userdata('roleID')==='1' || $this->session->userdata('roleID')==='2'){
			$this->form_validation->set_rules('roomID', 'Ruum', 'integer|required');
			if($this->form_validation->run() === FALSE ){
			$this->session->set_flashdata('errors', 'Ei tohi süsteemi kompromiteerida');
			redirect('');
			}

			$id=$this->input->post('roomID');
			if($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){
			$isAllowedOrNot=$this->building_model->checkIfRoomIsBookable($id);
			if(empty($isAllowedOrNot)){
				echo json_encode('Sa ei saa kustutada võõraid ruume!',JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
			};
			}
			
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
		}


		public function roomStatus(){
			if($this->session->userdata('roleID')==='1' || $this->session->userdata('roleID')==='2'){
			$this->form_validation->set_rules('roomID', 'Ruum', 'integer|required');
			$this->form_validation->set_rules('roomStatus', 'Ruum', 'integer|required');
			if($this->form_validation->run() === FALSE ){
			$this->session->set_flashdata('errors', 'Ei tohi süsteemi kompromiteerida');
			redirect('');
			}
			$id=$this->input->post('roomID');
			if($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){
			$isAllowedOrNot=$this->building_model->checkIfRoomIsBookable($id);
			if(empty($isAllowedOrNot)){
					echo json_encode('Sa ei saa muuta teiste ruumide staatust. Andmeid ei salvestatud!',JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
			};
			}
			$data = array(
			
					'roomActive' => $this->input->post('roomStatus')
				);
				$this->building_model->update_room($data, $id);
			
			}
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
		// 	$this->load->view('pages/editbuilding', $this->security->xss_clean($data));
		// 	$this->load->view('templates/footer');
			
		// }

		public function check_color($input){
			if(preg_match('/^#[a-f0-9]{6}$/', $input)){
				return TRUE;
			}
		
		}

	
	

		public function update(){
			if($this->session->userdata('roleID')==='1' || $this->session->userdata('roleID')==='2'){
				$this->form_validation->set_rules('phone', 'Telefon', 'trim|htmlspecialchars');
				$this->form_validation->set_rules('email', 'E-mail', 'trim|htmlspecialchars|valid_email');
				$this->form_validation->set_rules('notifyEmail', 'Teavitamise E-mail', 'trim|htmlspecialchars|valid_email');
				$this->form_validation->set_rules('price_url', 'URL', 'valid_url');
				$this->form_validation->set_rules('place', 'Regiooni ID', 'integer');
				$this->form_validation->set_rules('room[]', 'Ruumi nimetus', 'trim|htmlspecialchars');
				$this->form_validation->set_rules('color[]', 'Ruumi värv', 'trim|htmlspecialchars|callback_check_color');
				$this->form_validation->set_rules('additionalRoom[]', 'Ruumi värv', 'trim|htmlspecialchars');
				$this->form_validation->set_rules('colorForNewRoom[]', 'Ruumi värv', 'trim|htmlspecialchars|callback_check_color');
				$this->form_validation->set_rules('id', 'Asutuse ID', 'integer');
				if($this->form_validation->run() === FALSE){
				
					$this->session->set_flashdata('errors','Sisestatud andmetega on midagi korrast ära. Palun proovi uuesti.');
					redirect('building/view/');
				}
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
				
				$this->session->set_flashdata('post_updated', 'Uuendasid asutuse infot');
				redirect('building/view/'.$this->session->userdata['building']);
			}	
		}


		public function register(){
			if($this->session->userdata('roleID')==='1'){
				$this->form_validation->set_rules('name', 'Name', 'required|trim|htmlspecialchars');
				$this->form_validation->set_rules('email', 'E-mail', 'trim|htmlspecialchars|valid_email');
				$this->form_validation->set_rules('phone', 'Telefon', 'trim|htmlspecialchars');
				//$this->form_validation->set_rules('notifyEmail', 'Teavitamise E-mail', 'trim|htmlspecialchars|valid_email');
				$this->form_validation->set_rules('place', 'Regiooni ID', 'integer');
				$this->form_validation->set_rules('price_url', 'URL', 'valid_url');
			
				$data['regions'] = $this->building_model->getAllRegions();
				if($this->form_validation->run() === FALSE){
				
					$this->load->view('templates/header');
					$this->load->view('pages/createBuilding');
					$this->load->view('templates/footer');
					
				} else {
					$data = array(
						'name' => $this->input->post('name'),
						'contact_email' => $this->input->post('email'),
						'phone' => $this->input->post('phone'),
					//	'notify_email' => $this->input->post('notifyEmail'),
						'regionID' => $this->input->post('place'),
						'price_url' => $this->input->post('price_url'),				
					);
					$this->building_model->registerBuilding($data);
					$this->session->set_flashdata('user_registered', 'Asutus lisatud');
					redirect('building/view/'.$this->session->userdata['building']);
				}
			}
		}

	}
