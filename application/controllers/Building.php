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

				$data['editBuildings'] = $this->building_model->get_building($slug);
				$this->load->view('templates/header');
				$this->load->view('pages/editBuilding', $data);
				$this->load->view('templates/footer');
			}

			else if ($this->session->userdata['building']!=$slug){

				redirect('building/view/'.$this->session->userdata['building']);
			}else{

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
		
			$data['editAllBuildings'] = $this->building_model->get_building();
			$data['editAllRooms'] = $this->building_model->get_rooms();
			$this->load->view('templates/header');
			$this->load->view('pages/viewBuilding', $data);
			$this->load->view('templates/footer');
		}	}

		public function delete($id){
			// Check login
		
			$this->building_model->delete_building($id);
			// Set message
			$this->session->set_flashdata('building_deleted', 'Your building has been deleted');
			redirect('building/view/'.$this->session->userdata['building']);
		}

	
		public function deleteRoom($id){
			// Check login
		
			$deletequery=$this->building_model->delete_room($id);
			// Set message
			if($deletequery===FALSE){
				$this->session->set_flashdata('building_deleted', 'Ei saa saali kustutada kuna selles on kehtivad broneeringud. Palun kustuta kõik broneeringud ära ja seejärel proovi uuesti.');	
				redirect('building/view/'.$this->session->userdata['building']);
			}
			$this->session->set_flashdata('building_deleted', 'Your building has been deleted');
			if ($this->session->userdata['building']==0){
				redirect('building/view/'.$this->session->userdata['building']);
			}else{
			redirect('building/edit/'.$this->session->userdata['building']);
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
		// 	$this->load->view('pages/editbuilding', $data);
		// 	$this->load->view('templates/footer');
			
		// }


		public function update(){
			//Check login
			// if(!$this->session->buildingdata('logged_in')){
			// 	redirect('buildings/login');
			// }
			$this->building_model->update_building();

			
			for($t = 0; $t <= count($this->input->post('additionalRoom')); $t++)
			{
				if( $this->input->post('additionalRoom')[$t]!==null){
				
				$data2[] = array(
						'roomName' => $this->input->post('additionalRoom')[$t],
						'buildingID' =>$this->input->post('id'),
						'activeRoom' => 1,
								
				);
				$this->building_model->createNewRoom($data2[$t]);
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