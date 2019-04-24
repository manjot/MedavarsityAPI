<?php
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

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
        $course['hours_remaining'] = $arrOrder['hours_remaining'];
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
       
      public function privacypolicy() {
	     $this->load->view('privacypolicy');
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
		if(count($data['arrSubscription']) > 0)
		{
			foreach($data['arrSubscription'] as $subs)
			{ if($subs['hours_remaining'] > 0){
				$arrsubsc[]=$subs['subject_id'];
				$arrSubject=$this->Home_model->getCourseById($subs['subject_id']);
        } if(!empty($arrSubject)){
			    $subejctName .=$arrSubject['subject_name'].', ';
        }
				
			}
		}
		$data['arrCourses']=$this->Home_model->get_unsubscribecourses($arrsubsc);
		$data['courseName']= $subejctName;
		
       $this->load->view('profile',$data);
        }else{ 
        redirect('login');
       }
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
	   $mname=ucfirst($name);
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
      //Welcome Email
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
      $message = '<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding: 20px; border: 1px solid #000; position: relative;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" style="background: #fff; padding: 15px 0px;" bgcolor="#120001"><img src="'.SITEURL.'assets/img/home2/logo-white.png" width="100px;" height="100px;"  alt="" /></td>
      </tr>
      <tr>
        <td height="50"><hr style="width: 100%;" color="#000" size="1" /></td>
      </tr> 
      <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;">Dear '.$mname.',</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	   <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;">Thank you for registering with Medivarsity.
       </td>
      </tr>
	   <tr>
        <td>&nbsp;</td>
      </tr>
        <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;">We are happy to launch our app. “ Medivarsity - Epitome of Inspiration ” where you will get best video lectures by the best faculties of India for NEET PG/AIIMS/PGI/JIPMER/NIMHANS/FMGE and other competitive exams.
</td>
      </tr>
	   <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;">Medivarsity is creating illustrative video lectures equipped with knowledge enriching diagrams, flow charts, and relevant clinical scenarios which will be as good as live lectures with the comfort of anytime/anywhere access .</td>
      </tr>
        <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;">Q- banks, TnDs, Test series and other innovative educational projects will be launched later.</td>
      </tr>
        <tr>
        <td>&nbsp;</td>
      </tr>
        <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;">Advance booking is open to avail the early bird offer for the Pathology app. by Dr. Devesh Mishra. </td>
      </tr>
	  
	   <tr>
        <td>&nbsp;</td>
      </tr>
	   <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;">For any queries please write to us on info@medivarsity.com.</td>
      </tr>
  
   <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;">Warm Regards,</td>
      </tr>
      <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;">Team Medivarsity.</td>
      </tr>
       <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;">Phone: +91 8527981551,+91 1147034800</td>
      </tr>
      <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;;"></td>
      </tr>
     
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
     </td>
      </tr>
    </table>
    </td>
  </tr>
</table>';

      $ci->email->from($from_email, 'Medivarsity');
      $ci->email->to($to_email);
      $ci->email->subject('Welcome Mail');
      $ci->email->message($message);
      $ci->email->send();  
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
      $ci->email->message('Dear '.$checkmail['name']. 'Password for your account is '.$pass);
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



 
    function orders($id = false)
	{ 
    if(!empty($this->uri->segment(4))){
    $authtoken = $this->uri->segment(4);
    $student = $this->Home_model->getstudentdetailsbyauthtoken($authtoken);
    $student_id = $student['student_id'];
    $this->Home_model->setuserid($student_id);
    $data['studentdetails'] = $this->Home_model->getstudentdetails();
    $data['arrCourses']=$this->Home_model->getCourseById($id);
    $this->Home_model->setuserid($data['studentdetails']['student_id']);
    $this->Home_model->setemail($data['studentdetails']['email']);
    $this->Home_model->setname($data['studentdetails']['name']);
    $this->Home_model->setcontactNum($data['studentdetails']['contact_no']);
    $this->Home_model->setaddress($data['studentdetails']['address']);
    $this->Home_model->settimestamp(CREATED_DATE);
    $this->Home_model->setstatus(0);
    $this->Home_model->setsubjectid($data['arrCourses']['id']);
    $discountpercentage = $data['arrCourses']['price'] ;
    $tax                = ($discountpercentage * 18)/100;
    $this->Home_model->setamount($discountpercentage);
    $data['price'] = ($discountpercentage + $tax);
    $data['tax'] = $tax;
    $this->Home_model->settax($tax);
    $data['order_id']= $this->Home_model->save_order($discountpercentage);
    $this->session->set_userdata('order', $data);
    redirect('Home/payment');
    }else{
		if ($this->session->userdata('is_authenticate_user') == TRUE){

      $countsubscriptions = $this->Home_model->countsubscriptions();
      if($countsubscriptions > 500){
      $this->load->view('nobooking');
      }else{
			$this->Home_model->setuserid($this->session->userdata('student_id'));
			$data['studentdetails'] = $this->Home_model->getstudentdetails();
			$data['arrCourses']=$this->Home_model->getCourseById($id);
			
			$this->Home_model->setuserid($data['studentdetails']['student_id']);
			$this->Home_model->setemail($data['studentdetails']['email']);
			$this->Home_model->setname($data['studentdetails']['name']);
			$this->Home_model->setcontactNum($data['studentdetails']['contact_no']);
			$this->Home_model->setaddress($data['studentdetails']['address']);
			$this->Home_model->settimestamp(CREATED_DATE);
			$this->Home_model->setstatus(0);
			$this->Home_model->setsubjectid($data['arrCourses']['id']);
			
		//	$discount           = ($data['arrCourses']['price'] * DISCOUNTPERCENTAGE)/100;
			$discountpercentage = $data['arrCourses']['price'] ;
			$tax                = ($discountpercentage * 18)/100;
			$this->Home_model->setamount($discountpercentage);
      $data['price'] = ($discountpercentage + $tax);
      $data['tax'] = $tax;
			$this->Home_model->settax($tax);
   //   echo "<pre>";print_r($data);exit;
			$data['order_id']= $this->Home_model->save_order($discountpercentage);
      $this->session->set_userdata('order', $data);
		  redirect('Home/payment');
	    }
        }else{ 
        redirect('login');
       }
     }
	}
    

 function payment()
  { //echo "<pre>";print_r($_SESSION);exit;
    $order_id = $_SESSION['order']['order_id'];
    $transactionid = $this->Home_model->gettransactionid($order_id);
    $data['details'] = array(
    'tid' => $transactionid['transaction_id'],
    'merchant_id' => '206963',
    'order_id' => $_SESSION['order']['order_id'],
    'amount' => $_SESSION['order']['price'] ,
    'currency' => 'INR',
   'redirect_url' => base_url().'home/paymentreturn',
    'cancel_url' => base_url().'home/cancelreturn',
    'language' => 'EN',
    'billing_name' => $_SESSION['order']['studentdetails']['name'],
    'billing_address' => $_SESSION['order']['studentdetails']['address'],
    'billing_city' => 'Delhi',
    'billing_tel' => $_SESSION['order']['studentdetails']['contact_no'],
    'delivery_tel' => $_SESSION['order']['studentdetails']['contact_no'],
    'billing_email' => $_SESSION['order']['studentdetails']['email'],
  );
    $this->load->view('payment',$data);
  }

   function paymentreturn()
  { 
  $workingKey='E079BF65C6003492A2D0DEB811AAC817';    //Working Key should be provided here.
  $encResponse=$_POST["encResp"];     //This is the response sent by the CCAvenue Server
  $rcvdString=$this->decrypt($encResponse,$workingKey);    //Crypto Decryption used as per the specified working key.
  $order_status="";
  $decryptValues=explode('&', $rcvdString);
  $dataSize=sizeof($decryptValues);
  $information = array();
  for($i = 0; $i < $dataSize; $i++) 
  {
    $information[]=explode('=',$decryptValues[$i]);
   
  }
  $order_status = $information[3][1];
  $order_id = $information[0][1];
  if($order_status==="Success")
  {
  redirect('home/order_success/'.$order_id);
    
  }
  else if($order_status==="Aborted")
  {
  redirect('home/order_failure/'.$order_id);
  
  }
  else if($order_status==="Failure")
  {
  redirect('home/order_failure/'.$order_id);
  }
  else
  {
  redirect('home/order_failure/'.$order_id);
  }

  }

    function decrypt($encryptedText,$key)
  {
    $secretKey = $this->hextobin(md5($key));
    $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    $encryptedText=$this->hextobin($encryptedText);
      $openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
    mcrypt_generic_init($openMode, $secretKey, $initVector);
    $decryptedText = mdecrypt_generic($openMode, $encryptedText);
    $decryptedText = rtrim($decryptedText, "\0");
    mcrypt_generic_deinit($openMode);
    return $decryptedText;
    
  }

   function pkcs5_pad ($plainText, $blockSize)
  {
      $pad = $blockSize - (strlen($plainText) % $blockSize);
      return $plainText . str_repeat(chr($pad), $pad);
  }

  //********** Hexadecimal to Binary function for php 4.0 version ********

  function hextobin($hexString) 
     { 
          $length = strlen($hexString); 
          $binString="";   
          $count=0; 
          while($count<$length) 
          {       
              $subString =substr($hexString,$count,2);           
              $packedString = pack("H*",$subString); 
              if ($count==0)
        {
        $binString=$packedString;
        } 
              
        else 
        {
        $binString.=$packedString;
        } 
              
        $count+=2; 
          } 
            return $binString; 
        } 

    function order_success($id=false)
	{ 
		if ($this->session->userdata('is_authenticate_user') == TRUE){
		$this->Home_model->setuserid($this->session->userdata('student_id'));
		$data['arrOrders']  = $this->Home_model->getOrderById($id);
		$stateid  = $this->Home_model->studentstate($data['arrOrders']['student_id']);
		$state  = $this->Home_model->getstudentstate($stateid['state_id']);
	  $data['state'] = $state['state_id'];
		$data['arrCourses'] = $this->Home_model->getCourseById($data['arrOrders']['subject_id']);
    $total = $data['arrOrders']['net_amount'] + $data['arrOrders']['tax_rate'];
    $this->Home_model->setorderid($data['arrOrders']['order_id']);
	  $this->Home_model->setuserid($data['arrOrders']['student_id']);
	  $this->Home_model->settimestamp($data['arrOrders']['data_added']);
		$this->Home_model->setsubjectid($data['arrOrders']['subject_id']);
    $this->Home_model->sethours($data['arrCourses']['hours']);
		$this->Home_model->setstatus(1);
	$this->Home_model->update_save_order();
	$this->Home_model->save_order_details();


     $dompdf = new Dompdf();
   
  $cgst=$data['arrOrders']['tax_rate']/2;
$html1='<table style="width:100%;table-layout:fixed;text-align:center" border="0">
       <tr style="padding: 3mm;">
       	<td colspan="2" style="padding: 5mm;"><h3>Tax Invoice</h3></td>
       	<td colspan="2" style="padding: 5mm;"><img  src="https://www.medivarsity.com/assets/img/home2/logo-white.png" alt="logo" width="100mm" height="100mm"></img></td>
       </tr>
      <tr>
      	<td colspan="2" style="padding: 5mm;"><h3><span>From</span><br/>Medivarsity<br/></h3><span>info@medivarsity.com</span><br/><span>Office no 205 & 206 Second floor 9/2, East Patel Nagar <br/>New Delhi - 110008</span><br/>Phone : +91 8527981551</td>
      	<td colspan="2" style="padding: 5mm;"><h3><span>To</span><br/>'.$data['arrOrders']['first_name'].' </h3><br/><span>'.$data['arrOrders']['email'].'</span><br/><span>'.$data['arrOrders']['address'].'</span><br/>Phone : '.$data['arrOrders']['contact_no'].'</td>
      	
      </tr>
      <tr>
      	<td colspan="4" style="padding: 5mm;">
      		<p>Number:'.$data['arrOrders']['invoice_no'].'</p><br>
      		<p>Date  : '.date('d/m/y', time()).'</p><br>
          <!--<p>Terms  : Due On Receipt</p><br>-->
      	</td>
      </tr>
       
          <tr style="background-color: #000000;color: #ffffff;">
            <th class="desc"style="padding: 5mm;">DESCRIPTION</th>
            <th style="padding: 5mm;">Net Amount</th>
            <th style="padding: 5mm;">Qty</th>
            <th style="padding: 5mm;">Total</th>
          </tr>
       
       
          <tr>
           
            <td  style="padding: 5mm;">Pathalogy Video</td>
            <td  style="padding: 5mm;">Rs. '.$data['arrOrders']['net_amount'].'</td>
            <td style="padding: 5mm;">1</td>
            <td style="padding: 5mm;">Rs. '.$total.'</td>
          </tr>
         
         
          <tr>
            <td colspan="3" style="padding: 5mm;">SUBTOTAL</td>
            <td style="padding: 5mm;">Rs. '.$data['arrOrders']['net_amount'].'</td>
          </tr>';
          if($data['state'] == 7){
		      $html1 .=
            '<tr>
            <td style="padding: 5mm;" colspan="3">CGST  9%</td>
            <td style="padding: 5mm;">Rs. '.$cgst.'</td>
            </tr>
             <tr>
            <td style="padding: 5mm;" colspan="3">SGST 9%</td>
            <td style="padding: 5mm;">Rs. '.$cgst.'</td>
            </tr>
            <tr>
            <td style="padding: 5mm;" colspan="3">TOTAL TAX 18%</td>
            <td style="padding: 5mm;">Rs. '.$data['arrOrders']['tax_rate'].'</td>
            </tr>';
            }else if($data['state'] == 1 || $data['state'] == 5){
            $html1 .='<tr>
            <td style="padding: 5mm;" colspan="3">TAX (UTGST  18%)</td>
            <td style="padding: 5mm;">Rs. '.$data['arrOrders']['tax_rate'].'</td>
            </tr>';
            }else{
            $html1 .=
            '<tr>
            <td style="padding: 5mm;" colspan="3">TAX (IGST  18%)</td>
            <td style="padding: 5mm;">Rs. '.$data['arrOrders']['tax_rate'].'</td>
            </tr>';
            }
		  $html1 .='<tr>
            <td style="padding: 5mm;" colspan="3">GRAND TOTAL</td>
            <td style="padding: 5mm;">RS. '.$total.'</td>
          </tr>
        <tr>
        	<td colspan="4" style="padding: 10mm;">
			Notes<br><br>
	        Amount once paid will not be refunded in any case.<br>
			<!--Invoice was created on a computer and is valid without the signature and seal.<br>--!>
			For further details please refer our Terms and Conditions.<br><br>
			 This is a computer generated invoice, does not require any signature.
			
			
			</td>
        </tr>
		
      </table>
	 
	  
	  
	  ';        
	                   
    $dompdf->loadHtml($html1,'UTF-8'); 
    $dompdf->set_option('isHtml5ParserEnabled', true);
    $dompdf->set_option('isPhpEnabled', true);
    $dompdf->set_option('isRemoteEnabled', true);
    $dompdf->set_option('isJavascriptEnabled', true);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

//$dompdf->stream('saurabh',array('Attachment'=>'0'));
$output = $dompdf->output();

$link = '/var/www/html/assets/invoice/'.time().$data['arrOrders']['invoice_no'].'.pdf';
//echo $popdflink;exit;
file_put_contents($link, $output); 


   $from_email = "info@medivarsity.com";
      $to_email = $data['arrOrders']['email'];
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
      $message = '<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding: 20px; border: 1px solid #000; position: relative;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 18px; color: #000;">Dear '.$data['arrOrders']['first_name'].',</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
     
      <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 18px; color: #000;">You have been successfully subscribed for the '.$data['arrCourses']['subject_name'].' Video Lectures by Dr. Devesh Mishra.</td>
      </tr>
	  
	   <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 18px; color: #000;">You have been awarded one year validity for your subscription. Please visit the mobile application and start viewing you lecture.</td>
      </tr>
	  
	   <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 18px; color: #000;">The invoice for the subscription of the video lectures has been provided in the attachment.</td>
      </tr>
	  
	  <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 18px; color: #000;">For any queries please write to us on info@medivarsity.com</td>
      </tr>
	  
	 <tr>
        <td align="left" style="background: #fff; padding: 15px 0px;" bgcolor="#120001"><img src="'.SITEURL.'assets/img/home2/logo-white.png" width="100px;" height="100px;"  alt="" /></td>
      </tr>
    <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 18px; color: #000;">Warm Regards,</td>
      </tr>
      <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 18px; color: #000;">Team Medivarsity.</td>
      </tr>
      <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;">Phone: +91 8527981551,+911147034800</td>
      </tr>
      <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 18px; color: #000;;"></td>
      </tr>
     
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
     </td>
      </tr>
    </table>
    </td>
  </tr>
</table>';
      $ci->email->from($from_email, 'Medivarsity');
     $ci->email->to($to_email);
	 //$ci->email->to('dpksingh.kumar1991@gmail.com');
	
      $ci->email->subject('Order Confirmation - Medivarsity');
      $ci->email->message($message);
      $ci->email->attach($link);
      $ci->email->send(); 
  
//echo "<pre>";print_r($ci);exit;	  
		$this->load->view('order_success',$data); 
		}else{
			 redirect('login');
		}
	}

     function order_failure($id=false)
  { 
 
    $this->Home_model->setuserid($this->session->userdata('student_id'));
    $data['arrOrders']  = $this->Home_model->getOrderById($id);
    $data['arrCourses'] = $this->Home_model->getCourseById($data['arrOrders']['subject_id']);
    $this->load->view('order_failure',$data); 
  }

   function cancelreturn()
  { 
   redirect('profile');
  }

}
