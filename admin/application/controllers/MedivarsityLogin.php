<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MedivarsityLogin extends CI_Controller {
  function __construct(){
  parent::__construct();
  $this->load->library('session');
  $this->load->model('All_model');
}

  function index()
	{  
  $this->load->view('login/login');
	}

  function login()
 {
  $name = $this->input->post('name');
  $password = $this->input->post('pass');
  $pass = md5(SALT . $password);
  $this->All_model->userName($name);
  $this->All_model->userPass($pass);
  $login = $this->All_model->login();

  if(!empty($login))
  {
  
  if($login->user_type == 1){
  $data = array(
  'admin_id'               => $login->user_id,
  'name'                   => $login->name,
  'email'                  => $login->email,
  'isAuthentication_type'  => $login->user_type
  );
  $this->session->set_userdata($data);
  redirect('Superadmin');
  }else if($login->user_type == 0){

  $data = array(
  'faculty_id'             => $login->user_id,
  'name'                   => $login->name,
  'email'                  => $login->email,
  'isAuthentication_type'  => $login->user_type
  );
  $this->session->set_userdata($data);
  redirect('Faculty');
  }
  }else{
  $this->session->set_flashdata('login_error', '<span style="color:red">Invalid User Name or Password. Please try again</span>');
  redirect('loginpanel');
  }
}

  function forgetpassword()
 {
  if(!empty($this->input->get('sid') && ($this->input->get('sid')==2))){
  $this->session->set_flashdata('email_success', 'Successfully Send Password In Your Email Id');
  }
  if(!empty($this->input->get('sid') && ($this->input->get('sid')==3))){
  $this->session->set_flashdata('email_error', 'Envalid Email Id!');
  }
  $this->load->view('login/forgetpassword');
 }

 function send_password()
 {
  $email = $this->input->post('useremail');
  $this->All_model->userEmail($email);

  $checkexistemail = $this->All_model->checkexistemail();
  if(!empty($checkexistemail)){
  $password = uniqid();
  $pass = md5(SALT.$password);
  $this->All_model->updatepassword($pass,$checkexistemail->user_id);
  $from_email = "info@medivarsity.com";
  $to_email = $checkexistemail->email;
        //Load email library
      $ci = get_instance();
      $ci->load->library('email');
      $config['protocol'] = "smtp";
      $config['smtp_host'] = "ssl://smtp.gmail.com";
      $config['smtp_port'] = "465";
      $config['smtp_user'] = "ajathtesting@gmail.com"; 
      $config['smtp_pass'] = "nisar@12345";
      $config['charset'] = "utf-8";
      $config['mailtype'] = "html";
      $config['newline'] = "\r\n";

      $ci->email->initialize($config);

      $ci->email->from($from_email, 'Medivarsity');
      $ci->email->to($to_email);
      $ci->email->subject('Forgot Password');
      $ci->email->message('Dear '.$checkexistemail->name. 'Password for your account is '.$password);
      $send=$ci->email->send();
  $this->session->set_flashdata('email_success', '<span style="color:green">Successfully Send Password In Your Email Id</span>');
  redirect('forgotpassword');
  }else{
  $this->session->set_flashdata('email_error', '<span style="color:red">Invalid Email Id!</span>');
  redirect('forgotpassword');
  }
}

}
