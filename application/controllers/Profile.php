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
		$postData = $this->input->post();

		$this->form_validation->set_rules('name', 'Nimi', 'trim|htmlspecialchars|required|callback_clubname_check');
		$this->form_validation->set_rules('phone', 'Telefon', 'trim|htmlspecialchars|callback_PhoneNumber_check');

		if($this->form_validation->run() === FALSE ){

			$this->session->set_flashdata('key',$this->security->xss_clean($postData));
			redirect('profile/edit/'.$this->session->userdata['userID']);

		}



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
	

	public function clubname_check($str= '')
	{
			if ($str == '')
			{
				$this->session->set_flashdata('validationErrorMessageForName', "<small class='text-danger'>See väli on kohustuslik</small>");
				return FALSE;
			}
			else if(!preg_match("/^[A-Za-z0-9\x{00C0}-\x{00FF} ][A-Za-z0-9\x{00C0}-\x{00FF}\'\-\.\,]+([\ A-Za-z0-9\x{00C0}-\x{00FF}][A-Za-z0-9\x{00C0}-\x{00FF}\'\-]+)*/u", $str)){
				$this->session->set_flashdata('validationErrorMessageForName', "<small class='text-danger'>Sellised märgid ei ole lubatud</small>");
				return FALSE;
			}

			else
			{
					return TRUE;
			}
	}


	public function phoneNumber_check($str= '')
	{
		if ($str == '')
			{
				return TRUE;
			}
		else if(!preg_match('/^\+?[\d\s]+$/', $str))
			{
					$this->session->set_flashdata('phoneIsNotCorrect', "<small class='text-danger'>Numbri formaat ei sobi</small>");
					return FALSE;
			}
			else
			{
					return TRUE;
			}
	}


}
