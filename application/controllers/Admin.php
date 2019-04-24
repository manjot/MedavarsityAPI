<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->library('rssparser');
        $this->load->helper('text');
        $this->load->helper('share');
        $this->load->model('Admin_model');
       
      
    }
    
    public function index() {
       /* if ($this->session->userdata('is_authenticate_user') == TRUE) {
        $this->Home_model->setuserid($this->session->userdata('user_id'));
       $data['userdetails'] = $this->Home_model->getuserdetails();
       $data['risk'] = $this->Home_model->getrisk();
       }
      $data['feedbacklist'] = $this->Home_model->feedbacklist();*/
      $this->load->view('admin/login');
       }    

    public function doLogin() {
    if ($this->session->userdata('is_authenticate_admin') == TRUE) {
    redirect('admin/dashboard');
    }else{
    $data = array();
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    $enc_pass = md5(SALT . $password);
    $this->Admin_model->setstatus(1);
    $this->Admin_model->setuserName($username);
    $this->Admin_model->setpassword($enc_pass);
    $check = $this->Admin_model->doLogin();
    if(!empty($check)){

    $this->session->set_userdata(
    array(
        'admin_id' => $check['id'],
        'username' => $check['username'],
        'admin_email' => $check['email'],
        'is_authenticate_admin' => TRUE,
    )
    );    
    $data['admindetails'] =  $check;
    $data['totalregisteredusers'] =  $this->Admin_model->getregistereduserscount();
    $data['totalactiveusers'] =  $this->Admin_model->getactiveuserscount();
    $data['totalactivatesubscriptions'] =  $this->Admin_model->getactiveactionplanscount();
    $data['totalfeedbacks'] =  $this->Admin_model->getfeedbackscount();
    $this->load->view('admin/dashboard',$data);
    }else{
    $this->session->set_flashdata('login','<span style="color: red;
    font-size: 16px;">Email id or password not correct.</span>'); 
    redirect('admin');
    }
    }
       }   

    public function dashboard() {
    $data = array();
    $admin_id = $this->session->userdata('admin_id');
    $this->Admin_model->setuserid($admin_id);
    $data['totalregisteredusers'] =  $this->Admin_model->getregistereduserscount();
    $data['totalactiveusers'] =  $this->Admin_model->getactiveuserscount();
    $data['totalactivatesubscriptions'] =  $this->Admin_model->getactiveactionplanscount();
    $data['totalfeedbacks'] =  $this->Admin_model->getfeedbackscount();

    
    $data['admindetails'] =  $this->Admin_model->getadmindetails();
    $this->load->view('admin/dashboard',$data);
       }   

        public function forgotpassword() {
      $this->load->view('admin/forgotpassword');
       }         

        public function sendforgotpassword() {
        $email = $this->input->post('email');   
        $this->Admin_model->setemail($email);
        $checkmail = $this->Admin_model->getEmailID();
        if(!empty($checkmail)){
        $pass = $this->generate_random_password(6);
        $encriptPass = md5(SALT . $pass);
        $this->Admin_model->setpassword($encriptPass);
        $this->Admin_model->updatePasswordByForgotPassword();

        $from_email = "shahdeepak88@gmail.com";
        $to_email = $this->input->post('email');
        //Load email library
        $this->load->library('email');
        $this->email->from($from_email, 'Health Optim');
        $this->email->to($to_email);
        $this->email->subject('Forgot Password');
        $this->email->message('Dear '.$checkmail['name']. 'Password for your account is '.$encriptPass);
        $this->email->send();

        $this->session->set_flashdata('forgot','<span style="color: green;font-size: 16px;">Email sent to your email id.</span>'); 
        $this->load->view('admin/forgotpassword');
        }else{
        $this->session->set_flashdata('forgot','<span style="color: red;font-size: 16px;">Email id doesnt exist.</span>'); 
        $this->load->view('admin/forgotpassword');
        }
       }   

         public function generate_random_password($length = 10) {
        $alphabets = range('a', 'z');
        $numbers = range('0', '9');
        $final_array = array_merge($alphabets, $numbers);

        $password = '';

        while ($length--) {
            $key = array_rand($final_array);
            $password .= $final_array[$key];
        }

        return $password;
    }

    public function registereduser() {
    $data = array();
    $admin_id = $this->session->userdata('admin_id');
    $this->Admin_model->setuserid($admin_id);
    $data['admindetails'] =  $this->Admin_model->getadmindetails();
    $this->Admin_model->setstatus(1);
    $data['registeredusers'] =  $this->Admin_model->getregisteredusers();
    $data['actionplans'] =  $this->Admin_model->actionplanlist();
    //echo "<pre>";print_r($data);exit;
    $this->load->view('admin/reguser',$data);
       }

    public function feedbacks() {
    $data = array();
    $admin_id = $this->session->userdata('admin_id');
    $this->Admin_model->setuserid($admin_id);
    $data['admindetails'] =  $this->Admin_model->getadmindetails();
    $this->Admin_model->setstatus(1);
    $data['quotes'] =  $this->Admin_model->quotelist();
    $data['feedbacks'] =  $this->Admin_model->feedbacklist();
    $this->load->view('admin/feedback',$data);
       }   

    public function createnotification() {
    $data = array();
    $admin_id = $this->session->userdata('admin_id');
    $this->Admin_model->setuserid($admin_id);
    $data['admindetails'] =  $this->Admin_model->getadmindetails();
    $this->load->view('admin/notification',$data);
       }   

    public function userprofile() {
    $data = array();
    $admin_id = $this->session->userdata('admin_id');
    $this->Admin_model->setuserid($admin_id);
    $data['admindetails'] =  $this->Admin_model->getadmindetails();
    $user_id = $this->uri->segment(3);
    $this->Admin_model->setuserid($user_id);
    $this->Admin_model->setstatus(1);
    $data['userpersonalinformation'] =  $this->Admin_model->getuserpersonalinformation();
   // echo "<pre>";print_r($data);exit;
    $this->load->view('admin/user_profile',$data);
       }   

    public function filterfeedbacks() {
    $data = array();
    $quoteid = $this->input->post('quoteid');
    if($quoteid == 0){
    $quoteid = '';
    }else{
    $quoteid = $quoteid;
    }
    $this->Admin_model->setuserid($quoteid);
    $data['feedbacks'] =  $this->Admin_model->filterfeedbacklist();
    $this->load->view('admin/filterfeedback',$data);
       }      

    public function filterusers() {
    $data = array();
    $planid = $this->input->post('planid');
    if($planid == 0){
    $planid = '';
    }else{
    $planid = $planid;
    }
    $this->Admin_model->setuserid($planid);
    $this->Admin_model->setstatus(1);
    $data['registeredusers'] =  $this->Admin_model->filterreguserlist();
    $data['actionplans'] =  $this->Admin_model->actionplanlist();
    $data['planid'] = $planid;
    $this->load->view('admin/filteruser',$data);
       }      


    public function actionplans() {
    $data = array();
    $admin_id = $this->session->userdata('admin_id');
    $this->Admin_model->setuserid($admin_id);
    $data['admindetails'] =  $this->Admin_model->getadmindetails();
    $this->Admin_model->setstatus(1);
    $data['actionplans'] =  $this->Admin_model->actionplanlist();
   // echo "<pre>";print_r($data);exit;
    $this->load->view('admin/actionplans',$data);
       }  

    public function saveactionplan() {
    $plan = $this->input->post('plan');
    $plan_description = $this->input->post('plan_description');
    $plan_duration = $this->input->post('plan_duration');
    $price = $this->input->post('price');
    $result = $this->Admin_model->createactionplan($plan,$plan_description,$plan_duration,$price);
    if(!empty($result)){
    $this->session->set_flashdata('success','<span class="alert alert-success">Action plan created successfully</span>'); 
    }
    redirect('admin/actionplans');
       }  

    public function updateactionplan() {
    $id =   $this->input->post('id');
    $plan = $this->input->post('plan');
    $plan_description = $this->input->post('plan_description');
    $plan_duration = $this->input->post('plan_duration');
    $price = $this->input->post('price');
    $result = $this->Admin_model->updateplan($id,$plan,$plan_description,$plan_duration,$price);
    if(!empty($result)){
    $this->session->set_flashdata('success','<span class="alert alert-success">Action plan updated successfully</span>'); 
    }
    redirect('admin/actionplans');
       }     



        

    public function createplan() {
    $data = array();
    $admin_id = $this->session->userdata('admin_id');
    $this->Admin_model->setuserid($admin_id);
    $data['admindetails'] =  $this->Admin_model->getadmindetails();
    $this->load->view('admin/createplan',$data);
       }   

    public function deleteuser() {
    $json = array();
    $user_id = $this->input->post('user_id');
    $this->Admin_model->setuserid($user_id);
    $this->Admin_model->deleteuser();
    $json['msg'] = 'success';
    echo json_encode($json);
   // $data['registeredusers'] =  $this->Admin_model->getregisteredusers();
  //  $this->load->view('admin/reguser',$data);
       }   

    public function deletefeedback() {
    $json = array();
    $id = $this->input->post('id');
    $this->Admin_model->setuserid($id);
    $this->Admin_model->deletefeedback();
    $json['msg'] = 'success';
    echo json_encode($json);
       }   

    public function deleteactionplan() {
    $json = array();
    $id = $this->input->post('id');
    $this->Admin_model->setuserid($id);
    $this->Admin_model->deleteactionplan();
    $json['msg'] = 'success';
    echo json_encode($json);
       }  


 public function editactionplan() {
    $json = array();
    $admin_id = $this->session->userdata('admin_id');
    $this->Admin_model->setuserid($admin_id);
    $data['admindetails'] =  $this->Admin_model->getadmindetails();
    $id = $this->uri->segment(3);
    $this->Admin_model->setuserid($id);
    $data['plandetails'] = $this->Admin_model->getplandetails();
    $this->load->view('admin/editplan',$data);
       }  
        
    public function sendnotification() {
    $data = array();
    $title = $this->input->post('title');
    $description = $this->input->post('description');
    $this->Admin_model->setstatus(1);
    $users =  $this->Admin_model->getallnotificationsusers();
    foreach($users as $element){
                     $arrapVal = array(
                    'site_url' => site_url(),
                    'name' => $element['name'],
                    'title' => $title,
                    'description' => $description,
                    "icon" => 'app_icon',
                    "priority"=>"HIGH",
                ); 
                $ap_fields = array(
                    'registration_ids' => array($element['device_id']),
                    "data"=>$arrapVal,
                );        
                if($element['device_type'] == 0){
                $result = $this->pushNotification($ap_fields);
                }else{
                $result = $this->iOS($arrapVal, $element['device_id']); 
                }  
                if($result){
                $this->Admin_model->insertnotification($element['name'],$element['user_id'],$title,$description,$element['device_type'],CREATED_DATE);    
                }

    }
    $this->session->set_flashdata('success','<span style="color: red;
    font-size: 16px;">Notification successfully sent</span>'); 
    redirect('admin/createnotification');
       }   

    public function usernotification() {
    $data = array();
    $ids = $this->input->post('ids');
    $title = $this->input->post('title');
    $description = $this->input->post('description');
    $this->Admin_model->setstatus(1);
    $this->Admin_model->setuserid($ids);
    $users =  $this->Admin_model->getallnotificationsusers();
    foreach($users as $element){
                     $arrapVal = array(
                    'site_url' => site_url(),
                    'name' => $element['name'],
                    'title' => $title,
                    'description' => $description,
                    "icon" => 'app_icon',
                    "priority"=>"HIGH",
                ); 
                $ap_fields = array(
                    'registration_ids' => array($element['device_id']),
                    "data"=>$arrapVal,
                );        
                if($element['device_type'] == 0){
                $result = $this->pushNotification($ap_fields);
                }else{
                $result = $this->iOS($arrapVal, $element['device_id']); 
                }  
                if($result){
                $this->Admin_model->insertnotification($element['name'],$element['user_id'],$title,$description,$element['device_type'],CREATED_DATE);    
                }

    }
    $json['msg'] = 'success';
    echo json_encode($json);
       }   
         // FCM Push Notification
    public function pushNotification($fields) {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            "Authorization: key=" . 'AAAA3FssIlk:APA91bEaLJ-2U2bRYIqPBpSHlnUjQ-pQu3puc3FfZe6s0Zyr2LAizjxM8HgE8x7tQ2xsCZ9nMXXtR_UqAPs8lMVys_fBDW8jst-WHEqaw5IUFCVJIwoQCc7w96pWR_VBe-uAEUYqk4qp',
            "Content-Type: application/json"
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       // echo "<pre>";print_r($fields);exit;
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

     // Sends Push notification for iOS users
    public function iOS($data, $devicetoken) {
        $deviceToken = $devicetoken;
        $ctx = stream_context_create();
        // ck.pem is your certificate file
        stream_context_set_option($ctx, 'ssl', 'local_cert', 'slegal.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', 'SOOLGL@123#kINDRA@#2');
        // Open a connection to the APNS server
        $fp = stream_socket_client(
            'ssl://gateway.push.apple.com:2195', $err,
            $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        // Create the payload body
        $body['aps'] = array(
            'alert' => array(
                'title' => $data['title'],
                'body' => $data['description'],
             ),
            'sound' => 'default'
        );
        // Encode the payload as JSON
        $payload = json_encode($body);
        
        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));
        
        // Close the connection to the server
        fclose($fp);
        if (!$result)
            return 'Message not delivered' . PHP_EOL;
        else
            return 'Message successfully delivered' . PHP_EOL;
    }
       


        public function logout() {
        $this->session->unset_userdata('admin_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('admin_email');
        $this->session->unset_userdata('is_authenticate_admin');
        $this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        redirect('admin');
    } 
}
