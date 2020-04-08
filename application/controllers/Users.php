<?php
	class Users extends CI_Controller{
        
        public function __construct()
        {
            parent::__construct();
            $this->load->model('user_model');
    
		}
		

		public function index(){
			if ($this->session->userdata('roleID')==='1' || $this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){
			
			$data['title'] = 'Users';
			$data['manageUsers'] = $this->user_model->get_users();
	
			$this->load->view('templates/header');
			$this->load->view('pages/manageUsers', $this->security->xss_clean($data));
			$this->load->view('templates/footer');
		
			}else{
				$this->session->set_flashdata('errors', 'Sul ei ole õigusi');
				redirect('');
			}
		}


		public function registerSelf(){
		
			$this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('phone', 'Phone');
			$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');
			$this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');
            
			if($this->form_validation->run() === FALSE){
              
				$this->load->view('templates/header');
				$this->load->view('pages/register');
                $this->load->view('templates/footer');
                
			} else {
				// Encrypt password
              //  $enc_password = md5($this->input->post('password'));
                $enc_password = $this->input->post('password');
				$this->user_model->registerSelfDB($enc_password);
				// Set message
				$this->session->set_flashdata('user_registered', 'You are now registered and can log in');
				redirect('fullcalendar?roomId=1');
			}
		}



	//seda vist pole vaja
		// public function register(){
		// 	$data['title'] = 'Sign Up';
		// 	$this->form_validation->set_rules('name', 'Name', 'required');
        //     $this->form_validation->set_rules('phone', 'Phone');
		// 	$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');
		// 	$this->form_validation->set_rules('password', 'Password', 'required');
        //     $this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');
            
		// 	if($this->form_validation->run() === FALSE){
              
		// 		$this->load->view('templates/header');
		// 		$this->load->view('pages/register', $data);
        //         $this->load->view('templates/footer');
                
		// 	} else {
		// 		// Encrypt password
        //       //  $enc_password = md5($this->input->post('password'));
        //         $enc_password = $this->input->post('password');
		// 		$this->user_model->register($enc_password);
		// 		// Set message
		// 		$this->session->set_flashdata('user_registered', 'You are now registered and can log in');
		// 		redirect('fullcalendar?roomId=1');
		// 	}
		// }

	// Register user by admin
		public function registerByAdmin(){
			if ($this->session->userdata('roleID')==='1' || $this->session->userdata('roleID')==='2'){
				$this->form_validation->set_rules('email', 'E-mail', 'trim|htmlspecialchars|valid_email');
				$this->form_validation->set_rules('buildingID', 'Asutuse ID', 'integer|required');
				$this->form_validation->set_rules('role', 'Roll', 'integer|required');
				$this->form_validation->set_rules('status', 'Staatus', 'integer|required');
			   
			   if($this->form_validation->run() === FALSE ){
				   $this->session->set_flashdata('errors', 'Sisetamisel läks midagi valesti. Palun proovi uuesti.');
				   $this->session->set_flashdata("emailIsNotCorrect", form_error('email', '<small class="text-danger">','</small>'));
				   $inputEmail= $this->input->post('email');
				   $this->session->set_flashdata('email', $inputEmail);
				   redirect('users/addRightsToUser');
				   
			   } else if($this->input->post('buildingID')=='0' && $this->input->post('role')!='1'){
				   $this->session->set_flashdata('errors', 'Asutus valimata!');
				   redirect('users/addRightsToUser');
			   }
			   else		
			   {
					$buildingID=$this->input->post('buildingID');
					$role=$this->input->post('role');
					if($this->session->userdata('roleID')==='2'){
						$buildingID=$this->session->userdata('building');
					}
					if($this->session->userdata('roleID')==='2' && $this->input->post('role')==='1'){
						$this->session->set_flashdata('errors', 'Saa ei saa määrata adminni õigusi');
						redirect('users/addRightsToUser');
					}
					$data = array(
					'email' => $this->input->post('email'),
					'buildingID' => $buildingID,
					'roleID' => $role,
					'status' => $this->input->post('status'),
					); 

				   $emailIsInDB=$this->user_model->check_email_exists($this->input->post('email'));
				   if(!$emailIsInDB){
					   //register username and rights
					   $this->user_model->insert_user_in_DB_and_give_rights($data);
					   $this->session->set_flashdata('success', 'Kasutajale lisati õigused, kuid see kasutaja pole veel süsteemi sisse loginud. Palun teavitage teda, et ta teeks endale konto sama e-mailiga või logiks sisse läbi G-maili või Facebooki konto');
				   }else if($emailIsInDB['roleID']=='1' || $emailIsInDB['roleID']=='2' || $emailIsInDB['roleID']=='3'){
					   $this->session->set_flashdata('errors', 'Kasutajal ei saa olla mitu ligipääsu erinevatele asutustele');
				   }
				   else if($emailIsInDB['roleID']=='4'){
					   $userID=$emailIsInDB['userID'];
					   $this->user_model->update_user($data,$userID);
					   $this->session->set_flashdata('user_registered', 'Kasutajale õigused lisatud');
					}
				 
				   redirect('manageUsers');
			   }

			}
			else{
				$this->session->set_flashdata('errors', 'Sul ei ole õigusi');
				redirect('');
			}
			
		}

		// Log in user
		public function login(){
			
			$this->form_validation->set_rules('email', 'E-mail', 'trim|htmlspecialchars|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            
			if($this->form_validation->run() === FALSE){
				$this->session->set_flashdata("emailIsNotCorrect", form_error('email', '<small class="text-danger">','</small>')); // tekst '{field} ei ole korrektselt sisestatud' tuleb failist form_validation_lang.php
				$inputEmail= $this->input->post('email');
				$this->session->set_flashdata('email', $inputEmail);
				$this->session->set_flashdata('errors', 'Proovi uuesti');
				redirect('login');
			} else {
             
			
				// Get and encrypt the password
               // $password = md5($this->input->post('password'));
                            	
				// Login user
				$email    = $this->input->post('email',TRUE);
				//$password = md5($this->input->post('password',TRUE));
				$password = $this->input->post('password',TRUE);

				$validate = $this->user_model->validate($email, $password);
				if($validate->num_rows() > 0){
					$data  = $validate->row_array();
					$name  = $data['userName'];
					$phone  = $data['userPhone'];
					$building  = $data['buildingID'];
					$email = $data['email'];
					$userID = $data['userID'];
					$roleID = $data['roleID'];
					$room = $data['id'];

					$sesdata = array(
						'userName'  => $name,
						'phone'  => $phone,
						'room'  => $room,
						'email'     => $email,
						'userID'  => $userID,
						'building'     => $building,
						'roleID'     => $roleID,
						'session_id' => TRUE
					);
					$this->session->set_userdata($sesdata);
					$this->session->set_flashdata('success', 'Oled edukalt sisse logitud');
					// access login for admin
					if($roleID === '1'){
						redirect('');
				
					// access login for staff
					}else if($roleID === '2'){
						redirect('');
				
					// access login for author
					}else{
						redirect('');
					}
					
				} else {
					// Set message
					$this->session->set_flashdata('login_failed', 'Login is invalid');
					redirect('login');
				}		
			}
		}
		// Log user out
		public function logout(){
			// Unset user data
			$this->session->unset_userdata('session_id');
			$this->session->unset_userdata('user_id');
			$this->session->unset_userdata('email');
			$this->session->sess_destroy();
			// Set message
			$this->session->set_flashdata('user_loggedout', 'You are now logged out');
		//	$this->session->sess_destroy();
			redirect('');
		}
		// Check if email exists
		
		// Check if email exists
		public function check_email_exists($email){
			$this->form_validation->set_message('check_email_exists', 'That email is taken. Please choose a different one');
			if($this->user_model->check_email_exists($email)){
				return true;
			} else {
				return false;
			}
		}



		public function addRightsToUser(){
			if ($this->session->userdata('roleID')==='1' || $this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){
			$data['buildings'] = $this->user_model->getAllBuildings();
			$this->load->view('templates/header');
			$this->load->view('pages/createUser',  $this->security->xss_clean($data));
			$this->load->view('templates/footer');
		
			}else{
				$this->session->set_flashdata('errors', 'Sul ei ole õigusi');
				redirect('');
			}
		}


		public function delete($id){
			// Only admins allowed to make changes
			if ( $this->session->userdata('roleID')==='1'){
				$this->user_model->delete_user($id);
			
				$this->session->set_flashdata('user_deleted', 'Your user has been deleted');
				redirect('manageUsers');
			}
		}





		public function edit($slug){
			if ($this->session->userdata('roleID')==='1' || $this->session->userdata('roleID')==='2'){
			
				$data['post'] = $this->user_model->get_users($slug);
				$data['buildings'] = $this->user_model->getAllBuildings();

				if ($this->session->userdata('roleID')==='2'){
					$data['buildings'] = $this->user_model->get_one_building_data($this->session->userdata('building'));
					if($data['post']['roleID']==="1" || $data['post']['buildingID']!=$this->session->userdata('building')){
						$this->session->set_flashdata('message', 'Sul ei ole õigusi muuta neid kasutajaid');
						redirect('manageUsers');
					}
				}
			
				if(empty($data['post'])){
					show_404();
				}
			
				$this->load->view('templates/header');
				$this->load->view('pages/editUser', $this->security->xss_clean($data));
				$this->load->view('templates/footer');
			}
			else{
				$this->session->set_flashdata('errors', 'Sul ei ole õigusi');
				redirect('');
			}
		}


		public function update(){
			if ($this->session->userdata('roleID')==='1' || $this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){
				$data = array(
					'userName' => $this->input->post('name'),
					'email' => $this->input->post('email'),
					'status' => $this->input->post('status'),
					'userPhone' => $this->input->post('phone'),
					'roleID' => $this->input->post('roleID'),
					'buildingID' => $this->input->post('buildingID'),
				);
				$userID=$this->input->post('id');
				$this->user_model->update_user($data,$userID);
				// Set message
				$this->session->set_flashdata('post_updated', 'Uuendasid kasutajat');
				redirect('manageUsers');
			}
		}

		//for DataTables
		function fetch_allbookingsInfo(){  
			if ($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'){
			$this->load->model("user_model");  
			$fetch_data = $this->user_model->make_datatables();  
			$data = array(); 
			$phoneIsNotZero=""; 
			foreach($fetch_data as $row)  
			{  
				if ($row->c_phone!=0) { $phoneIsNotZero=$row->c_phone; }
				 $sub_array = array();  
				 $sub_array[] = $this->security->xss_clean($row->public_info);  
				 $sub_array[] = $this->security->xss_clean($row->c_name);  
				 $sub_array[] = $this->security->xss_clean($phoneIsNotZero);  
				 $sub_array[] = $this->security->xss_clean($row->c_email);  
			
				 $data[] = $sub_array;  
			}  
			$output = array(  
				 "draw"                    =>     intval($_POST["draw"]),  
				 "recordsTotal"          =>      $this->user_model->get_all_data(),  
				 "recordsFiltered"     =>     $this->user_model->get_filtered_data(),  
				 "data"                    =>     $data  
			);  
			echo json_encode($output);  
		}  
	   }  
















	}
