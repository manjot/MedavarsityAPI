<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->library('rssparser');
        $this->load->helper('text');
        $this->load->helper('share');
        $this->load->model('Home_model');
       
      
    }
    
    public function index() {
	
	   $data['facultylist'] = $this->Home_model->facultieslist();
	   $data['courseslist'] = $this->Home_model->courseslist();
      if ($this->session->userdata('is_authenticate_user') == TRUE){
      $this->Home_model->setuserid($this->session->userdata('student_id'));
      $data['studentdetails'] = $this->Home_model->getstudentdetails();
	   if(count($data['courseslist'])>0)
		  {
			  foreach($data['courseslist'] as &$course)
			  {
				  
				$arrOrder=$this->Home_model->check_orderBySubjectId($course['id']);
				if(count($arrOrder)>0)
				{
					$course['subscription_status']=1;
				}else{
					$course['subscription_status']=0;
				}
			  }
		  }
      }
      
     

	 
	  
      $this->load->view('index',$data);
       }    

    public function login() {
      $this->load->view('login');
       }    

    public function forgotpassword() {
      $this->load->view('forgotpassword');
       }    

    public function registration() {
      $data['statelist'] = $this->Home_model->statelist();
      $this->load->view('registration',$data);
       }    

     public function getcolleges()
    {
    echo "<option value=''>--Please Select College--</option>";
    $state = $this->input->post('state');
    $this->Home_model->setstate($state);
    $colleges = $this->Home_model->collegelist();
      foreach($colleges as $element)
      {
        echo "<option value=".$element['id'].">".$element['college_name']."</option>";
        }
    
    }

    public function disclaimer() {
      $this->load->view('home/disclaimer');
       }    

      public function blog() {
      $this->load->view('home/blog');
       }    

      public function blog1() {
      $this->load->view('home/blog1');
       }    

         public function terms() {
      $this->load->view('home/termscondition');
       }    

          public function privacypolicy() {
      $this->load->view('home/privacypolicy');
       }   

        public function error() {
      $this->load->view('home/error');
       }    

    public function profile() {
     if ($this->session->userdata('is_authenticate_user') == TRUE) {
        $this->Home_model->setuserid($this->session->userdata('student_id'));
        $data['studentdetails'] = $this->Home_model->getstudentdetails();
	    $data['arrSubscription']= $this->Home_model->get_subsDetailsByStudentId();
	    $subejctName='';
		$arrsubsc=array();
		if(count($data['arrSubscription'])>0)
		{
			foreach($data['arrSubscription'] as $subs)
			{
				$arrsubsc[]=$subs['subject_id'];
				$arrSubject=$this->Home_model->getCourseById($subs['subject_id']);
			    $subejctName .=$arrSubject['subject_name'].', ';
				
			}
		}
		$data['arrCourses']=$this->Home_model->get_unsubscribecourses($arrsubsc);
		$data['courseName']= $subejctName;
		
       $this->load->view('profile',$data);
        }else{ 
        redirect('login');
       }
    }   

    public function healthform() {

    if ($this->session->userdata('is_authenticate_user') == TRUE) {
    $this->Home_model->setuserid($this->session->userdata('user_id'));
    $data['userdetails'] = $this->Home_model->getuserdetails();
   
    }
      $data['ethnicitylist'] = $this->Home_model->getethnicitylist();
      $data['agerange'] = $this->Home_model->getagerange();
      $this->load->view('home/healthform',$data);
       }    

    public function doLogin() {
    $data = array();
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    $enc_pass = md5(SALT . $password);
    $this->Home_model->setstatus(1);
    $this->Home_model->setuserName($username);
    $this->Home_model->setpassword($enc_pass);
    $check = $this->Home_model->doLogin();
    if(!empty($check)){

    $this->session->set_userdata(
    array(
        'student_id' => $check['student_id'],
        'name' => $check['name'],
        'email' => $check['email'],
        'is_authenticate_user' => TRUE,
    )
    );  
    redirect('profile');  
    }else{
    $this->session->set_flashdata('login','<span style="color: red;
    font-size: 16px;">Username or password not correct.</span>'); 
    redirect('login');
    }
       }       

     public function logout() {
        $this->session->unset_userdata('student_id');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('is_authenticate_user');
        $this->session->unset_userdata('reward_point');
        $this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        redirect('/');
    }

  public function saveregistration() {

    
     $name = $this->input->post('name');
     $email = $this->input->post('email');
     $contact_num = $this->input->post('contact_num');
     $password = $this->input->post('password');
     $cpassword = $this->input->post('cpassword');
     $year = $this->input->post('year');
     $state_id = $this->input->post('State');
     $college_id = $this->input->post('college');
     $address = $this->input->post('address');
     $password = md5(SALT . $password);
     $created_date = CREATED_DATE;
     $status = 1;
    
     $this->Home_model->setname($name);
     $this->Home_model->setpassword($password);
     $this->Home_model->setemail($email);
     $this->Home_model->setcontactNum($contact_num);
     $this->Home_model->setyear($year);
     $this->Home_model->setstate($state_id);
     $this->Home_model->setcollege($college_id);
     $this->Home_model->setaddress($address);
     $this->Home_model->settimestamp($created_date);
     $this->Home_model->setstatus($status);

      $result = $this->Home_model->insertstudent();
      if(!empty($result)){
        $this->session->set_userdata(
        array(
        'student_id' => $result,
        'name' => $name,
        'email' => $email,
        'is_authenticate_user' => TRUE,
    )
    );  
      $this->session->set_flashdata('success','<span style="font-size:16px;color: green;
      font-size: 16px;">Welcome to Medivarsity. Hurry up Choose your course and book them</span>'); 
      redirect('profile');  
      }else{
      $this->session->set_flashdata('login','<span style="color: red;
      font-size: 16px;">Username or password not correct.</span>'); 
      redirect('login');
      }
    
      

       }    

     public function bookcourse() {
     $student_id = $this->session->userdata('student_id');
     $this->Home_model->setuserid($student_id);
     $data['studentdetails'] = $this->Home_model->getstudentdetails();

     // Merchant id provided by CCAvenue
    $data['Merchant_Id'] = "165562";
    // Item amount for which transaction perform
   $data['Amount'] = "100";
    // Unique OrderId that should be passed to payment gateway
   $data['Order_Id'] = "006789";
    // Unique Key provided by CCAvenue
   $data['WorkingKey']= "575AC60E0F406452DD90A002D7ECDBBF";
    // Success page URL
   $data['Redirect_Url']= base_url();

   $data['acess_code']='AVTW76FB06AN60WTNA';
    $data['Checksum'] = $this->getCheckSum($data['Merchant_Id'],$data['Amount'],$data['Order_Id'] ,$data['Redirect_Url'],$data['WorkingKey']);
   // echo "<pre>";print_r($data);exit;
    $this->load->view('bookform',$data);
       }  

    function getchecksum($MerchantId,$Amount,$OrderId ,$URL,$WorkingKey) 
{ 
    $str ="$MerchantId|$OrderId|$Amount|$URL|$WorkingKey"; 
    $adler = 1;
    $adler = $this->adler32($adler,$str); 
    return $adler; 
}

function adler32($adler , $str) 
{ 
    $BASE = 65521 ;   
    $s1 = $adler & 0xffff ; 
    $s2 = ($adler >> 16) & 0xffff; 
    for($i = 0 ; $i < strlen($str) ; $i++) 
    { 
        $s1 = ($s1 + Ord($str[$i])) % $BASE ; 
        $s2 = ($s2 + $s1) % $BASE ; 
    } 
    return $this->leftshift($s2 , 16) + $s1; 
}  



function leftshift($str , $num) 
{   
    $str = DecBin($str);   
    for( $i = 0 ; $i < (64 - strlen($str)) ; $i++) 
        $str = "0".$str ;   
    for($i = 0 ; $i < $num ; $i++) 
        $str = $str."0"; $str = substr($str , 1 ) ;  
    return $this->cdec($str) ; 
}   


function cdec($num) 
{   $dec=0;
    for ($n = 0 ; $n < strlen($num) ; $n++) 
    { 
        $temp = $num[$n] ; 
        $dec = $dec + $temp*pow(2 , strlen($num) - $n - 1); 
    }   
    return $dec; 
}   

       

     public function sendquery() {
  
     $name = $this->input->post('name');
     $email = $this->input->post('email');
     $contact_num = $this->input->post('contact_num');
     $address = $this->input->post('address');
     $message = $this->input->post('message');
    
     $this->Home_model->setname($name);
     $this->Home_model->setemail($email);
     $this->Home_model->setcontactNum($contact_num);
     $this->Home_model->setaddress($address);
     $this->Home_model->setmessage($message);

     $result = $this->Home_model->insertquery();
      if(!empty($result)){

      $from_email = "info@medivarsity.com";
      $to_email = $this->input->post('email');
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
      $ci->email->subject('Query Mail');
      $ci->email->message('Dear '.$name. 'Thankyou ! We have received your query . Our Team will contact you soon');
      $ci->email->send();
  
      //Admin mail
      $from_email = $this->input->post('email');
      $to_email = 'info@medivarsity.com';
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
      $ci->email->subject('Query Through Medivarsity');
      $ci->email->message('Dear admin, <br>You have received a query through medivarsity . Please visit Admin Panel');
      $ci->email->send();

      $this->session->set_flashdata('success','Your Query has been sent. Our Team will Contact you soon.'); 
      $this->load->view('thankyou'); 
      }else{
      $this->session->set_flashdata('fail','<span style="color: red;
      font-size: 16px;">Some error occured Please try again later.</span>'); 
      $this->load->view('thankyou'); 
      }
    
      

       }    
  /*   public function savehealthform() {

     if ($this->session->userdata('is_authenticate_user') == FALSE) {
     $this->session->set_userdata(
     array(
        'ethnicity' => $this->input->post('ethnicity'),
        'countries' => $this->input->post('countries'),
        'gender' => $this->input->post('gender'),
        'heightfeet' => $this->input->post('heightfeet'),
        'heightinches' => $this->input->post('heightinches'),
        'waist' => $this->input->post('waist'),
        'weight' => $this->input->post('weight'),
        'weightunit' => $this->input->post('weightunit'),
        'age' => $this->input->post('age'),
        'antihypertensives' => $this->input->post('antihypertensives'),
        'diabetes' => $this->input->post('diabetes'),
        'smoking' => $this->input->post('smoking'),
        'stroke' => $this->input->post('stroke'),
        'diabeticparent' => $this->input->post('diabeticparent'),
        'is_health_form_data' => TRUE,
    )
    );    

    $this->session->set_flashdata('login','<span style="color: green;
    font-size: 16px;">Please login as a user and submit form.</span>'); 
    redirect('home/login');
        } else {
     $this->Home_model->setuserid(1);
     $ethnicity = $this->input->post('ethnicity');
     $countries = $this->input->post('countries');
     if(!empty($countries)){
     $countries = $countries;
     }else{
     $countries = null;
     }
     $gender = $this->input->post('gender');
     $heightfeet = $this->input->post('heightfeet');
     $heightinches = $this->input->post('heightinches');
     $waist = $this->input->post('waist');
     $weight = $this->input->post('weight');
     $weightunit =  $this->input->post('weightunit');
     if($weightunit == 'kg'){
     $weight = $weight; 
     }else if($weightunit == 'lbs'){
     $weight = ($weight * 0.453592);
     }
     
     $age = $this->input->post('age');
     $antihypertensives = $this->input->post('antihypertensives');
     $diabetes = $this->input->post('diabetes');
     $smoking = $this->input->post('smoking');
     $stroke = $this->input->post('stroke');
     $diabeticparent = $this->input->post('diabeticparent');
     $this->Home_model->setage($age);
     $this->Home_model->setgender($gender);
     $this->Home_model->setcountry($countries);
     $this->Home_model->setweight($weight);
     $this->Home_model->setantihypertensives($antihypertensives);
     $this->Home_model->setdiabetes($diabetes);
     $this->Home_model->setsmoking($smoking);
     $this->Home_model->setstroke($stroke);
     $this->Home_model->setdiabeticparent($diabeticparent);

     $height = ((($heightfeet * 12) + $heightinches) * 0.0254);
     $this->Home_model->setheight($height);
    
     $bmi = round($weight/($height*$height));
     $agescore = $this->Home_model->getagescore();
     $agescore = $agescore['score'];
     $this->Home_model->setbmi($bmi);
     $bmiscore = $this->Home_model->getbmiscore();
     $bmiscore = $bmiscore['score'];

     $this->Home_model->setwaist($waist);
     $waistscore = $this->Home_model->getwaistscore();
     $waistscore = $waistscore['score'];

     $this->Home_model->setethnicity($ethnicity);
     if($ethnicity == 2){
     if($gender == 0){
     $ethnicityscore = ethnicityconstantmales;
     }else{
     $ethnicityscore = ethnicityconstantfemales;
     }
     }else{
     $this->Home_model->setcountry($countries);
     $ethnicityscore = $this->Home_model->getethnicityscore();
     if($gender == 0){
     $ethnicityscore = $ethnicityscore['males'];
     }else{
     $ethnicityscore = $ethnicityscore['females'];
     }
     }
   


      if($gender == 0){
       if($antihypertensives == 1){
       $hypertensivesscore = hypertensives_male;
       }else{
       $hypertensivesscore = 0; 
       }
       if($smoking == 1){
       $smokingscore = smoking_male;
       }else{
       $smokingscore = 0;   
       }
       if($stroke == 1){
       $strokescore = stroke_male;
       }else{
       $strokescore = 0;    
       }
       if($diabeticparent == 1){
       $diabitiesscore = diabetes_male;
       }else{
       $diabitiesscore = 0; 
       }

       }else{
       

       if($antihypertensives == 1){
       $hypertensivesscore = hypertensives_female;
       }else{
       $hypertensivesscore = 0; 
       }
       if($smoking == 1){
       $smokingscore = smoking_female;
       }else{
       $smokingscore = 0;   
       }
       if($stroke == 1){
       $strokescore = stroke_female;
       }else{
       $strokescore = 0;    
       }
       if($diabeticparent == 1){
       $diabitiesscore = diabetes_female;
       }else{
       $diabitiesscore = 0; 
       }


       }


     $healthscore = ($agescore + $bmiscore + $waistscore + $hypertensivesscore + $smokingscore + $strokescore + $diabitiesscore +
        $ethnicityscore);

     $checkhealthdata = $this->Home_model->checkhealthdata();
     if(!empty($checkhealthdata)){
     $this->Home_model->updatehealthformdata();   
     }else{
     $this->Home_model->inserthealthformdata();   
     }
     $this->Home_model->setriskscore($healthscore);
     $manipulation = $this->Home_model->checkscorerange();
       $compositeriskscore = $manipulation['Composite'];
        $cvdriskscore = $manipulation['CVD'];
        $t2driskscore = $manipulation['T2D'];
        $ckdriskscore = $manipulation['CKD'];

        //composite risk score level
        if(!empty($compositeriskscore)){
        if($compositeriskscore < 20){
        $compositerisklevel = 'Low Risk';
        }else if($compositeriskscore >= 20 && $compositeriskscore < 35){
        $compositerisklevel = 'Moderate Risk';
        }
        else if($compositeriskscore >= 35 && $compositeriskscore < 50){
        $compositerisklevel = 'High Risk';
        }else if($compositeriskscore >= 50){
        $compositerisklevel = 'Very High Risk'; 
        }
        }
       
        if(!empty($cvdriskscore)){
        if($cvdriskscore < 15){
        $cvdrisklevel = 'Low Risk';
        }else if($cvdriskscore >= 15 && $cvdriskscore < 25){
        $cvdrisklevel = 'Moderate Risk';
        }
        else if($cvdriskscore >= 25 && $cvdriskscore < 35){
        $cvdrisklevel = 'High Risk';
        }else if($cvdriskscore >= 35){
        $cvdrisklevel = 'Very High Risk';   
        }
        }
    
         if(!empty($t2driskscore)){
        if($t2driskscore < 15){
        $t2drisklevel = 'Low Risk';
        }else if($t2driskscore >= 15 && $t2driskscore < 25){
        $t2drisklevel = 'Moderate Risk';
        }
        else if($t2driskscore >= 25 && $t2driskscore < 40){
        $t2drisklevel = 'High Risk';
        }else if($t2driskscore >= 40){
        $t2drisklevel = 'Very High Risk';   
        }
        }

         if(!empty($ckdriskscore)){
        if($ckdriskscore < 10){
        $ckdrisklevel = 'Low Risk';
        }else if($ckdriskscore >= 10 && $ckdriskscore < 20){
        $ckdrisklevel = 'Moderate Risk';
        }
        else if($ckdriskscore >= 20 && $ckdriskscore < 35){
        $ckdrisklevel = 'High Risk';
        }else if($ckdriskscore >= 35){
        $ckdrisklevel = 'Very High Risk';   
        }
        }
        $riskanalysis = $this->Home_model->getrisk();
        $this->Home_model->setcomposite($compositeriskscore);
        $this->Home_model->setcompositelevel($compositerisklevel);
        $this->Home_model->setcvd($cvdriskscore);
        $this->Home_model->setcvdlevel($cvdrisklevel);
        $this->Home_model->sett2d($t2driskscore);
        $this->Home_model->sett2dlevel($t2drisklevel);
        $this->Home_model->setckd($ckdriskscore);
        $this->Home_model->setckdlevel($ckdrisklevel);
        if(!empty($riskanalysis)){
        $result =   $this->Home_model->updaterisk();   
        }else{
        $result =  $this->Home_model->insertrisk();   
        }
      $this->Home_model->updatehealthformdatastatus();
      $data['userdetails'] = $this->Home_model->getuserdetails();
      $data['risk'] = $this->Home_model->getrisk();
     // echo "<pre>";print_r($data['risk']);exit;
      $this->load->view('home/samplepage',$data);
     

       }    */

        public function checkemail() {
        $json = array(); 
        $email = $this->input->post('email');
                $this->Home_model->setemail($email);
                    $contact_email = $this->Home_model->checkemail();
                    if($contact_email > 0){
                        $json['contact_email_valid'] = 0;
                        $json['contact_email'] = '<small>This email ID is already registered with us . Please try another one.</small>';
                    }else{
                            $json['contact_email_valid'] = 1;
                            $json['contact_email'] = '<small>This email address is available.</small>';
                        }
                   
               
                header('Content-Type: application/json');
                echo json_encode($json);
    }

     public function checkContactNum() {
        $json = array();
        $contactNo = $this->input->post('contactNo');
                $this->Home_model->setcontactNum($contactNo);
                $json['contact_count'] = $this->Home_model->checkContactNo();
                header('Content-Type: application/json');
                echo json_encode($json);
            } 


        public function registeruser() {
         
         $name = $this->input->post('name');
         $email = $this->input->post('email');
         $contact_num = $this->input->post('contact_num');
         $password = $this->input->post('password');
         $password = md5(SALT . $password);
         $created_date = CREATED_DATE;
         $status = 1;

         $this->Home_model->setstatus($status);
         $this->Home_model->setname($name);
         $this->Home_model->setpassword($password);
         $this->Home_model->setemail($email);
         $this->Home_model->setcontactNum($contact_num);
         $this->Home_model->settimestamp($created_date);
         $this->Home_model->setregistertype(0);
         $result = $this->Home_model->createuser();
         if(!empty($result)){
           $this->session->set_userdata(array(
          'user_id' => $result,
          'name' => $name,
          'email' => $email,
          'is_authenticate_user' => TRUE,
    )
    );    
        $this->Home_model->setuserid($result);
        $this->Home_model->setstatus($status);
        $this->Home_model->settimestamp($created_date);
        $expireddate = strtotime("+1 month", $created_date);
        $this->Home_model->setplanid(1);
        $this->Home_model->setexpiredtimestamp($expireddate);
        $this->Home_model->createsubscription();
//after registration
    if ($this->session->userdata('is_health_form_data') == TRUE) {
     $ethnicity = $this->session->userdata('ethnicity');
     $countries = $this->session->userdata('countries');
     if(!empty($countries)){
     $countries = $countries;
     }else{
     $countries = null;
     }
     $gender = $this->session->userdata('gender');
     $heightfeet = $this->session->userdata('heightfeet');
     $heightinches = $this->session->userdata('heightinches');
     $waist = $this->session->userdata('waist');
     $weight = $this->session->userdata('weight');
     $weightunit =  $this->session->userdata('weightunit');
     if($weightunit == 'kg'){
     $weight = $weight; 
     }else if($weightunit == 'lbs'){
     $weight = ($weight * 0.453592);
     }
     $age = $this->session->userdata('age');
     $antihypertensives = $this->session->userdata('antihypertensives');
     $diabetes = $this->session->userdata('diabetes');
     $smoking = $this->session->userdata('smoking');
     $stroke = $this->session->userdata('stroke');
     $diabeticparent = $this->session->userdata('diabeticparent');
     $this->Home_model->setage($age);
     $this->Home_model->setgender($gender);
     $this->Home_model->setweight($weight);
     $this->Home_model->setantihypertensives($antihypertensives);
     $this->Home_model->setdiabetes($diabetes);
     $this->Home_model->setsmoking($smoking);
     $this->Home_model->setstroke($stroke);
     $this->Home_model->setdiabeticparent($diabeticparent);
     $height = ((($heightfeet * 12) + $heightinches) * 0.0254);
     $this->Home_model->setheight($height);
     $bmi = round($weight/($height*$height));
     $agescore = $this->Home_model->getagescore();
     $agescore = $agescore['score'];
     $this->Home_model->setbmi($bmi);
     $bmiscore = $this->Home_model->getbmiscore();
     $bmiscore = $bmiscore['score'];
     $this->Home_model->setwaist($waist);
     $waistscore = $this->Home_model->getwaistscore();
     $waistscore = $waistscore['score'];

     $this->Home_model->setethnicity($ethnicity);
     $this->Home_model->setcountry($countries);
     if($ethnicity == 2){
     if($gender == 0){
     $ethnicityscore = ethnicityconstantmales;
     }else{
     $ethnicityscore = ethnicityconstantfemales;
     }
     }else{
     $ethnicityscore = $this->Home_model->getethnicityscore();
     if($gender == 0){
     $ethnicityscore = $ethnicityscore['males'];
     }else{
     $ethnicityscore = $ethnicityscore['females'];
     }
     }
   
   

      if($gender == 0){
       if($antihypertensives == 1){
       $hypertensivesscore = hypertensives_male;
       }else{
       $hypertensivesscore = 0; 
       }
       if($smoking == 1){
       $smokingscore = smoking_male;
       }else{
       $smokingscore = 0;   
       }
       if($stroke == 1){
       $strokescore = stroke_male;
       }else{
       $strokescore = 0;    
       }
       if($diabeticparent == 1){
       $diabitiesscore = diabetes_male;
       }else{
       $diabitiesscore = 0; 
       }
       }else{
       if($antihypertensives == 1){
       $hypertensivesscore = hypertensives_female;
       }else{
       $hypertensivesscore = 0; 
       }
       if($smoking == 1){
       $smokingscore = smoking_female;
       }else{
       $smokingscore = 0;   
       }
       if($stroke == 1){
       $strokescore = stroke_female;
       }else{
       $strokescore = 0;    
       }
       if($diabeticparent == 1){
       $diabitiesscore = diabetes_female;
       }else{
       $diabitiesscore = 0; 
       }
       }

     $healthscore = ($agescore + $bmiscore + $waistscore + $hypertensivesscore + $smokingscore + $strokescore + $diabitiesscore +
        $ethnicityscore);
  
     $checkhealthdata = $this->Home_model->checkhealthdata();
      if(!empty($checkhealthdata)){
     $current_date = CREATED_DATE;
     $createdate = $checkhealthdata['created_on'];
     $effectiveDate = strtotime("+3 months", $createdate); // returns timestamp
     //echo date('Y-m-d',$effectiveDate);exit;
     if($effectiveDate > $current_date){
     $data['lastupdate'] = date('Y-m-d',$createdate);
     $data['comingupdate'] = date('Y-m-d',$effectiveDate);
     $scoreupdate = 0;
     }else{
     $this->Home_model->updatehealthformdata(); 
     $data['lastupdate'] = date('Y-m-d',$current_date);
     $effectiveDate = strtotime("+3 months", $data['lastupdate']);
     $data['comingupdate'] = date('Y-m-d',$effectiveDate);
     $scoreupdate = 1;
     } 
     }else{
     $this->Home_model->inserthealthformdata();  
     $current_date = CREATED_DATE; 
     $data['lastupdate'] = date('Y-m-d',$current_date);
     $effectiveDate = strtotime("+3 months", $data['lastupdate']);
     $data['comingupdate'] = date('Y-m-d',$effectiveDate);
     $scoreupdate = 1;
     }
     if($scoreupdate == 1){
     $this->Home_model->setriskscore($healthscore);
     $manipulation = $this->Home_model->checkscorerange();
       $compositeriskscore = $manipulation['Composite'];
        $cvdriskscore = $manipulation['CVD'];
        $t2driskscore = $manipulation['T2D'];
        $ckdriskscore = $manipulation['CKD'];

        //composite risk score level
        if(!empty($compositeriskscore)){
        if($compositeriskscore < 20){
        $compositerisklevel = 'Low Risk';
        }else if($compositeriskscore >= 20 && $compositeriskscore < 35){
        $compositerisklevel = 'Moderate Risk';
        }
        else if($compositeriskscore >= 35 && $compositeriskscore < 50){
        $compositerisklevel = 'High Risk';
        }else if($compositeriskscore >= 50){
        $compositerisklevel = 'Very High Risk'; 
        }
        }
       
        if(!empty($cvdriskscore)){
        if($cvdriskscore < 15){
        $cvdrisklevel = 'Low Risk';
        }else if($cvdriskscore >= 15 && $cvdriskscore < 25){
        $cvdrisklevel = 'Moderate Risk';
        }
        else if($cvdriskscore >= 25 && $cvdriskscore < 35){
        $cvdrisklevel = 'High Risk';
        }else if($cvdriskscore >= 35){
        $cvdrisklevel = 'Very High Risk';   
        }
        }
    
         if(!empty($t2driskscore)){
        if($t2driskscore < 15){
        $t2drisklevel = 'Low Risk';
        }else if($t2driskscore >= 15 && $t2driskscore < 25){
        $t2drisklevel = 'Moderate Risk';
        }
        else if($t2driskscore >= 25 && $t2driskscore < 40){
        $t2drisklevel = 'High Risk';
        }else if($t2driskscore >= 40){
        $t2drisklevel = 'Very High Risk';   
        }
        }

         if(!empty($ckdriskscore)){
        if($ckdriskscore < 10){
        $ckdrisklevel = 'Low Risk';
        }else if($ckdriskscore >= 10 && $ckdriskscore < 20){
        $ckdrisklevel = 'Moderate Risk';
        }
        else if($ckdriskscore >= 20 && $ckdriskscore < 35){
        $ckdrisklevel = 'High Risk';
        }else if($ckdriskscore >= 35){
        $ckdrisklevel = 'Very High Risk';   
        }
        }
        $riskanalysis = $this->Home_model->getrisk();
        $this->Home_model->setcomposite($compositeriskscore);
        $this->Home_model->setcompositelevel($compositerisklevel);
        $this->Home_model->setcvd($cvdriskscore);
        $this->Home_model->setcvdlevel($cvdrisklevel);
        $this->Home_model->sett2d($t2driskscore);
        $this->Home_model->sett2dlevel($t2drisklevel);
        $this->Home_model->setckd($ckdriskscore);
        $this->Home_model->setckdlevel($ckdrisklevel);
        if(!empty($riskanalysis)){
        $result =   $this->Home_model->updaterisk();   
        }else{
        $result =  $this->Home_model->insertrisk();   
        }
        }
        $this->Home_model->updatehealthformdatastatus();
        $this->session->unset_userdata('ethnicity');
        $this->session->unset_userdata('gender');
        $this->session->unset_userdata('heightfeet');
        $this->session->unset_userdata('heightinches');
        $this->session->unset_userdata('waist');
        $this->session->unset_userdata('weight');
        $this->session->unset_userdata('age');
        $this->session->unset_userdata('antihypertensives');
        $this->session->unset_userdata('diabetes');
        $this->session->unset_userdata('smoking');
        $this->session->unset_userdata('stroke');
        $this->session->unset_userdata('diabeticparent');
        $this->session->unset_userdata('is_health_form_data');
        $data['userdetails'] = $this->Home_model->getuserdetails();
        $data['risk'] = $this->Home_model->getrisk();
        redirect('home/profile');
        }else{
        redirect('home/healthform');
        } 
        }else{
        $this->session->set_flashdata('register','<span style="color: red;font-size: 16px;">Sorry user not registered please try again.</span>'); 
         redirect('home/register');   
         }

        } 

    public function sendforgotpassword() 
    {
         $email = $this->input->post('email');   
        $this->Home_model->setemail($email);
        $checkmail = $this->Home_model->getEmailID();
        if(!empty($checkmail)){
        $pass = $this->generate_random_password(6);
        $encriptPass = md5(SALT . $pass);
        $this->Home_model->setpassword($encriptPass);
        $this->Home_model->updatePasswordByForgotPassword();

        $from_email = "info@medivarsity.com";
        $to_email = $this->input->post('email');
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
      $ci->email->message('Dear '.$checkmail['name']. 'Password for your account is '.$encriptPass);
      $send=$ci->email->send();
	  
        $this->session->set_flashdata('forgot','<span style="color: green;font-size: 16px;">Email sent to your email id.</span>'); 
        redirect('forgotpassword');
        }else{
        $this->session->set_flashdata('forgot','<span style="color: red;font-size: 16px;">Email id doesnt exist.</span>'); 
        redirect('forgotpassword');
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

    
  public function getcountries()
  {
  echo "<option value=''>--Please Select Country--</option>";
  $ethnicity = $this->input->post('ethnicity');
    $countries = $this->Home_model->select_country($ethnicity);
      foreach($countries as $countries)
      {
        echo "<option value=".$countries->id.">".$countries->country."</option>";
        }
    
    }

  public function getagerange()
  {
  echo "<option value=''>--Select Age Range--</option>";
  $gender = $this->input->post('gender');
    $agerange = $this->Home_model->select_agerange($gender);
      foreach($agerange as $agerange)
      {
        echo "<option value=".$agerange->id.">".$agerange->age_range."</option>";
        }
    
    }

    public function deleteaccount() {
      $this->Home_model->setuserid($this->session->userdata('user_id'));
      $this->Home_model->deleteuser();
      $this->session->sess_destroy();
      
      redirect('/');
    }    
    function orders($id = false)
	{
		if ($this->session->userdata('is_authenticate_user') == TRUE){
			$this->Home_model->setuserid($this->session->userdata('student_id'));
			$data['studentdetails'] = $this->Home_model->getstudentdetails();
			$data['arrCourses']=$this->Home_model->getCourseById($id);
			// echo "<pre>";
			// print_r($data['studentdetails']);
			// print_r($data['arrCourses']);
			// exit;
			$this->Home_model->setuserid($data['studentdetails']['student_id']);
			$this->Home_model->setemail($data['studentdetails']['email']);
			$this->Home_model->setname($data['studentdetails']['name']);
			$this->Home_model->setcontactNum($data['studentdetails']['contact_no']);
			$this->Home_model->setaddress($data['studentdetails']['address']);
			$this->Home_model->settimestamp(CREATED_DATE);
			$this->Home_model->setstatus(0);
			$this->Home_model->setsubjectid($data['arrCourses']['id']);
			
			$discount           = ($data['arrCourses']['price'] * DISCOUNTPERCENTAGE)/100;
			$discountpercentage = $data['arrCourses']['price'] - $discount;
			$tax                = ($discountpercentage * 18)/100;
			$this->Home_model->setamount($discountpercentage);
			$this->Home_model->settax($tax);
			$order_id= $this->Home_model->save_order($discountpercentage);
		    redirect('Home/order_success/'.$order_id);
	
        }else{ 
        redirect('login');
       }
	}
    
    function order_success($id=false)
	{
		if ($this->session->userdata('is_authenticate_user') == TRUE){
		$this->Home_model->setuserid($this->session->userdata('student_id'));
		$data['arrOrders']  = $this->Home_model->getOrderById($id);
		$data['arrCourses'] = $this->Home_model->getCourseById($data['arrOrders']['subject_id']);
		
	    $this->Home_model->setuserid($data['arrOrders']['student_id']);
	    $this->Home_model->settimestamp($data['arrOrders']['data_added']);
		$this->Home_model->setsubjectid($data['arrOrders']['subject_id']);
		$this->Home_model->setstatus(1);
		// echo "<pre>";
		// print_r($data['arrOrders']);
		// exit;
		
		$this->Home_model->save_order_details();
		$this->load->view('order_success',$data); 
		}else{
			 redirect('login');
		}
	}

}
