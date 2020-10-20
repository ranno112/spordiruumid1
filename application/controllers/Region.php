<?php
	class Region extends CI_Controller{
        
        public function __construct()
        {
            parent::__construct();
            $this->load->model('region_model');
			if (empty($this->session->userdata('roleID'))  || $this->session->userdata('roleID')!='1'){
				$this->session->set_flashdata('errors', 'Sul ei ole õigusi');
				redirect('');
			}
		}
	
		function menu(){
			$data['menu'] = 'region'; // Capitalize the first letter
			$data['unapprovedBookings'] = $this->region_model->getUnapprovedBookings($this->session->userdata('building'));
			return $data;
			}

		public function view($slug=FALSE){
			$data=$this->menu();
			$data['regions'] = $this->region_model->getAllRegions();
			$this->load->view('templates/header', $this->security->xss_clean($data));
			$this->load->view('pages/viewRegion', $this->security->xss_clean($data));
			$this->load->view('templates/footer');
		}	

		public function edit($slug){
			$data=$this->menu();
			$data['region'] = $this->region_model->get_region($slug);
			$this->load->view('templates/header', $this->security->xss_clean($data));
			$this->load->view('pages/editRegion', $this->security->xss_clean($data));
			$this->load->view('templates/footer');
		}

		public function delete(){
			$id=$this->input->post('regionID');
			$count =$this->region_model->check_if_region_has_buildings($id);
			if($count>0){
				$this->session->set_flashdata('errors', 'Ei saa kustutada, kuna piirkonnas on asutusi');
				redirect('region/view');
			}

			$this->region_model->delete_region($id);
			// Set message
			$this->session->set_flashdata('building_deleted', 'Piirkond on kustutatud');
			redirect('region/view');
		}

		public function update(){
		
			$data = array(
				'regionName' => $this->input->post('region'),
				'regionID' => $this->input->post('regionID'),
			);
			$this->region_model->update_region($data);

			// Set message
			$this->session->set_flashdata('post_updated', 'Uuendasid piirkonna infot');
		
			redirect('region/view');
		}

		public function register(){
			
			$this->form_validation->set_rules('region', 'Nimetus', 'required');
        
			if($this->form_validation->run() === FALSE){
           		$this->load->view('templates/header');
				$this->load->view('pages/createRegion');
                $this->load->view('templates/footer');
                
			} else {
				
				$this->region_model->registerRegion();
				$this->session->set_flashdata('user_registered', 'Piirkond lisatud');
				redirect('region/view/'.$this->session->userdata['building']);
			}
		}
	}
