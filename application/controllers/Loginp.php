<?php
class Login extends CI_Controller{
    
  function __construct(){
    parent::__construct();
    $this->load->model('login_model');
  }
 
  function index(){
    $this->load->view('templates/header');
    $this->load->view('login_view');
    $this->load->view('templates/footer');
  }
 
  function auth(){
    $email    = $this->input->post('email',TRUE);
    //$password = md5($this->input->post('password',TRUE));
    $password = $this->input->post('password',TRUE);
    $validate = $this->login_model->validate($email,$password);
    if($validate->num_rows() > 0){
        $data  = $validate->row_array();
        $name  = $data['name'];
        $email = $data['email'];
        $roleID = $data['roleID'];
        $building = $data['buildingID'];
        $sesdata = array(
            'username'  => $name,
            'email'     => $email,
            'roleID'     => $roleID,
            'buildingID' => $building,
            'session_id' => TRUE
        );
        $this->session->set_userdata($sesdata);
        // access login for admin
        if($roleID === '1'){
            redirect('page');
 
        // access login for staff
        }elseif($roleID === '2'){
            redirect('page/staff');
 
        // access login for author
        }else{
            redirect('page/author');
        }
    }else{
        echo $this->session->set_flashdata('msg','Username or Password is Wrong');
        redirect('login');
    }
  }
 
  function logout(){
      $this->session->sess_destroy();
      redirect('login');
  }
 
}