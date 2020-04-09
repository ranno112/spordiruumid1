<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct($slug=FALSE)
    {
        parent::__construct();
		$this->load->model('profile_model');
		if (empty($this->session->userdata('roleID'))){
			$this->session->set_flashdata('errors', 'Sa pole sisse logitud');
			redirect('');
		}
       
    }

	public function view($slug=FALSE){
   
        if ($this->session->userdata['userID']!=$slug){

            redirect('profile/view/'.$this->session->userdata['userID']);
        }else{

        $data['editProfile'] = $this->profile_model->get_profile($slug);
    //	var_dump($slug);
        $this->load->view('templates/header');
        $this->load->view('pages/profile', $this->security->xss_clean($data));
        $this->load->view('templates/footer');
    }	}



	public function edit($slug=FALSE){
   
        if ($this->session->userdata['userID']!=$slug){

            redirect('profile/edit/'.$this->session->userdata['userID']);
        }else{

        $data['editProfile'] = $this->profile_model->get_profile($slug);
    //	var_dump($slug);
        $this->load->view('templates/header');
        $this->load->view('pages/editProfile', $this->security->xss_clean($data));
        $this->load->view('templates/footer');
    }	}



    public function updateProfile(){
	
        // Check login
        // if(!$this->session->buildingdata('logged_in')){
        // 	redirect('buildings/login');
		// }

		$data = array(
			'userName' => $this->input->post('name'),
			'userPhone' => $this->input->post('phone'),
		);
		
		$this->profile_model->update_profile($data);
        // Set message
        $this->session->set_flashdata('post_updated', 'Uuendasid oma profiili');
        redirect('profile/view/'.$this->session->userdata['userID']);
    }


}
