<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct($slug=FALSE)
    {
        parent::__construct();
        $this->load->model('profile_model');
       
    }

	public function view($slug){
   
        if ($this->session->userdata['userID']!=$slug){

            redirect('profile');
        }else{

        $data['editProfile'] = $this->profile_model->get_profile($slug);
    //	var_dump($slug);
        $this->load->view('templates/header');
        $this->load->view('pages/profile', $data);
        $this->load->view('templates/footer');
    }	}



	public function edit($slug){
   
        if ($this->session->userdata['userID']!=$slug){

            redirect('profile');
        }else{

        $data['editProfile'] = $this->profile_model->get_profile($slug);
    //	var_dump($slug);
        $this->load->view('templates/header');
        $this->load->view('pages/editProfile', $data);
        $this->load->view('templates/footer');
    }	}



    public function updateProfile(){
        // Check login
        // if(!$this->session->buildingdata('logged_in')){
        // 	redirect('buildings/login');
        // }
        $this->profile_model->update_profile();
        // Set message
        $this->session->set_flashdata('post_updated', 'Uuendasid oma profiili');
        redirect('profile/view/'.$this->session->userdata['userID']);
    }


}