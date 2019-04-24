<?php
defined('BASEPATH') OR exit('No direct script access allowed');

   
 class Superadmin extends CI_Controller 
	{
	  var $loginUser;
	  function __construct(){
	  parent::__construct();
	  $this->load->library('session');
	  $this->load->model('All_model');
	  $this->load->model('All_model', 'export');
	  $loginId='';
	  if($this->session->userdata('admin_id'))
	  {
		  $loginId=$this->session->userdata('admin_id');
	  }else{
		  $loginId=$this->session->userdata('faculty_id');
	  } 
	  $this->loginUser = $loginId;

	}

	function index()
	{ 

		// echo 'this is done';
		// exit;
	
		$result['page'] = 'superadmin_dash'; 
		$id             = $this->loginUser;
		if(!empty($id))
		{
			$this->All_model->userId($id);
			$result['getadmindetail'] = $this->All_model->getadmindetail($id);
			$result['totvideo'] = $this->All_model->totvideo();
			
			$result['totfaculty'] = $this->All_model->totfaculty();
		
			$result['totsubscriber'] = $this->All_model->totsubscriber();
			$result['totsubject'] = $this->All_model->totsubject();
			$this->load->view('admin/index',array('result' =>$result));
		}else
		{
		    redirect('loginpanel');
		}
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
			$data = array(
			'id'                     => $login->user_id,
			'name'                   => $login->name,
			'email'                  => $login->email,
			'isAuthentication_type'  => $login->user_type
			);

			if($data['isAuthentication_type'] == 1){
			$this->session->set_userdata(array('id'=>$data['id'],'data'=>$data));

			redirect('Medivarsity/index');
			}else if($data['isAuthentication_type'] == 0){
			$this->session->set_userdata(array('id'=>$data['id'],'data'=>$data));
			redirect('Medivarsity_faculty/index');
			}
		}else{
			$this->session->set_flashdata('login_error', 'Invalid User Name or Password. Please try again');
			redirect('Medivarsity/login_pg?sid=1');
		}
	}

	function login_pg()
	{
		if(!empty($this->input->get('sid') && ($this->input->get('sid')==1)))
		{
		$this->session->set_flashdata('login_error', 'Invalid User Name or Password. Please try again'); 
		}
		
		$this->load->view('login/login');
	}

	function admin()
	{
		$id = $this->loginUser;
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		//echo "<pre>";print_r($result['getadmindetail']);die;
		$this->load->view('admin/index',array('result' =>$result));
	}

	function logout()
	{
		$this->session->unset_userdata('id');
		$this->session->sess_destroy();
		//redirect('MedivarsityLogin');
		redirect('Superadmin');
	}

	function user()
	{
	   $this->load->view('user/index');
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
		$pass = $checkexistemail->password;
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
		$ci->email->from('ajathtesting@gmail.com', 'BattleSkin');
		$list = array('ajathtesting@gmail.com');
		$ci->email->to($list);
		$this->email->reply_to('ajathtesting@gmail.com', 'Explendid Videos');
		$ci->email->subject('Dashboard Password');
		$ci->email->message($pass);
		$ci->email->send();

		redirect('Medivarsity/forgetpassword?sid=2');
		}else{
		redirect('Medivarsity/forgetpassword?sid=3');
		}
	}

	function addFaculty_pg($facultyId=false)
	{
		$result          = array();
		$result['page'] ='add_faculty';	
		$id             = $this->loginUser;
		
		$result['id']            ='';
		$result['name']          ='';
		$result['email']         ='';
		$result['contact_no']    ='';
		$result['subject_id']    ='';
		$result['address']       ='';
		$result['about']         ='';
		$result['image']         ='';
		$result['bank_name']     ='';
		$result['account_no']    ='';
		$result['ifsc_code']     ='';
		$result['location']      ='';
		$result['subject_name']  ='';
		
		if($facultyId)
		{
			
			$faculty=$this->All_model->facultyDetail($facultyId);
			
			if($faculty)
			{
				$result['id']            =$facultyId;
				$result['name']          =$faculty['name'];
				$result['email']         =$faculty['email'];
				$result['contact_no']    =$faculty['contact_no'];
				$result['subject_id']    =$faculty['subject_id'];
				$result['address']       =$faculty['address'];
				$result['about']         =$faculty['about'];
				$result['image']         =$faculty['profile_image_url'];
				$result['bank_name']     =$faculty['bank_name'];
				$result['account_no']    =$faculty['account_no'];
				$result['ifsc_code']     =$faculty['ifsc_code'];
				$result['location']      =$faculty['location'];
				$result['subject_name']  =$faculty['subject_name'];
			}
			
		}
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		//echo"<pre>";
		//print_r($result['getadmindetail']);
		//die();
		
		if(!empty($this->input->get('lig') && ($this->input->get('lig')==1)))
		{
		    $this->session->set_flashdata('add_faculty_sussess', '<span class="notifq" style="color:green;    font-family: cursive">Faculty Added Successfully</span>');
		}
		$getsubjectdetail = $this->All_model->getsubjectdetail();
		
		//echo "<pre>";print_r($getsubjectdetail);die();
		$getfacultydetail2 = $this->All_model->getfacultydetail2();
		//echo "<pre>";print_r($getfacultydetail2);exit;
		if(!empty($getfacultydetail2))
		{
			
			foreach($getfacultydetail2 as $val)
			{
			   $subjectId[] = $val['subject_id'];
			  
			}
		}
		else{
		    $subjectId[] = '';
		}
		foreach($getsubjectdetail as $val)
		{
			
			if(!in_array($val['id'],$subjectId))
			{
			    $result1[]=$val;
				
				
			}
		}
	
		$this->load->view('admin/add_faculty.php',array('result'=>$result,'data' => $result1));
	}

	function addFaculty()
	{ 
	  
	    $config['upload_path']      = 'assets/images/faculty';
        $config['allowed_types']    = 'gif|jpg|png';
        $config['encrypt_name']     = true;
        $this->load->library('upload', $config);
		$this->upload->initialize($config);
		$uploaded   = $this->upload->do_upload('image');
		
		$facultyId  = $this->input->post('facultyId');
		$image_name = $this->input->post('image_name');
		if ($facultyId)
        {
            //delete the original file if another is uploaded
			if($uploaded)
			{
 
				if($image_name != '')
				{
				 
					$file = 'assets/images/faculty/'.$result['image'];
						//delete the existing file if needed
						if(file_exists($file))
						{
							unlink($file);
						}
					
				}
			}
                
        }
		if(!$uploaded)
		{
		  
			if($_FILES['image']['error'] != 4)
			{
				
				$result['error']  .= $this->upload->display_errors();
				$this->load->view('admin/add_faculty',$result);
				return;
			}
		}
		else
		{
			$image          = $this->upload->data();
			$image_name    =$image['file_name'];
			  
		}
		
		$id = $this->loginUser;
		$name = $this->input->post('name');
		$sub = $this->input->post('sub');
		$email = $this->input->post('email');
		$password = $this->input->post('pass');
		$confpass = $this->input->post('cpass');
		$mobile = $this->input->post('mobile');
		$altmob = $this->input->post('amobile');
		$bday = $this->input->post('bday');
		$add = $this->input->post('add');
		$aboutsub = $this->input->post('asub');
		$bankname = $this->input->post('bname');
		$accountnum = $this->input->post('anum');
		$ifsc = $this->input->post('icode');
		$pannum = $this->input->post('pnum');
		$gstinnum = $this->input->post('gnum');
		$bmobnum = $this->input->post('bmnum');
		$vidurl = $this->input->post('field_name');
		
		//echo SALT.$password;
		$pass = md5(SALT.$password);
		
		//echo "<pre>";print_r($vidurl);die;
		if($facultyId)
		{
			$userdetail = array(
					'user_id'           => $facultyId,
					'name'              => $name,
					'subject_id'        => $sub,
					'email'             => $email,
					'contact_no'        => $mobile,
					'address'           => $add,
					'about'             => $aboutsub,
					'user_type'         => 0,
					'profile_image_url' => $image_name,
					'time_stamp' => date('Y-m-d')
					);
		}else{
			$userdetail = array(
					'user_id' => $facultyId,
					'name' => $name,
					'subject_id' => $sub,
					'email' => $email,
					'password' => $pass,
					'contact_no' => $mobile,
					'address' => $add,
					'about' => $aboutsub,
					'user_type' => 0,
					'profile_image_url' => $image_name,
					'time_stamp' => date('Y-m-d')
					);
		}
		
		
		$faculty_id = $this->All_model->save_faculty($userdetail);
		
		$faculty=$this->All_model->facultyDetail($faculty_id);
		$bank_detail_id='';
		if(count($faculty)>0)
		{
			$bank_detail_id=$faculty['bank_detail_id'];
		}
	
		$bankdetail = array(
		'name_as_per_bank_account' => $name,
		'account_no' => $accountnum,
		'ifsc_code' => $ifsc,
		'bank_name' => $bankname,
		'location' => $add,
		'user_id' => $faculty_id,
		'id' => $bank_detail_id 
		);
		$this->All_model->save_bank_details($bankdetail);

		$this->session->set_flashdata('add_faculty_sussess', '<span class="notifq" style="color:green;    font-family: cursive">Faculty Added Successfully</span>');
		return redirect('Superadmin/facultyList');
	}

	function checkEmail()
	{
		$json = array();
		$email = $this->input->post('email');
		if(!empty($email))
		{
		$checkExistEma = $this->All_model->checkExistEma($email);
		if(!empty($checkExistEma))
		{
		$json['success'] = 1;
		}else{
		$json['success'] = 101;
		}
		}
		echo json_encode($json);
	}

	function checkMobile()
	{
		$json = array();
		$mobile = $this->input->post('mobile');
		if(!empty($mobile))
		{
		$checkExistMob = $this->All_model->checkExistMob($mobile);
		if(!empty($checkExistMob))
		{
		$json['success'] = 1;
		}else{
		$json['success'] = 101;
		}
		}
		echo json_encode($json);
	}

	function facultyList()
	{
		$result['page'] ='faculties';	
		if(!empty($this->input->get('nfy') && ($this->input->get('nfy')==1))){
		$this->session->set_flashdata('add_url_sussess', '<span style="color:green;    font-family: cursive">Url Added Successfully</span>');
		}
		$id = $this->loginUser;
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		$getfacultydetail = $this->All_model->getfacultydetail();
		foreach($getfacultydetail as $element){
		$totstudents = $this->All_model->getfacultydetailSub($element['subject_id']); 
		$totfacultyvidio = $this->All_model->gettotalfacultyvidio($element['subject_id']); 
		$facultydetail[] = array(
		'user_id' => $element['user_id'],
		'name' => $element['name'],
		'email' => $element['email'],
		'contact_no' => $element['contact_no'],
		'subject_id' => $element['subject_id'], 
		'about' => $element['about'],
		'time_stamp' => $element['time_stamp'],
		'subject_name' => $element['subject_name'],
		'totstudents' => $totstudents,
		'totfacultyvidio' => $totfacultyvidio,
		'image' => $element['profile_image_url'],
		);
		}
		$result['facultydetail'] = $facultydetail;
		
		$this->load->view('admin/faculty_list.php',array('result' => $result));
	}

	function facultyArrList()
	{

		$json = array();
		$id = $this->loginUser;
		$result = $this->All_model->getfacultydetail();
		//echo "<pre>";print_r($result);die;

		foreach ($result as &$value) 
		{
		$subId = $value['subject_id'];
		$arrSubs = $this->All_model->getfacultydetailSub($subId); 

		$value['num_students']=count($arrSubs);
		}
		// echo "<pre>";
		// print_r($result);
		if(!empty($result))
		{
		$json['getfacultydetail'] = $result;
		}
		$this->load->view('include/facultyArraylist.php',$json);
	}

	function deleteFaculty()
	{
		$json = array();
		$userId = $this->input->post('facultyid');
		
		$deleteFaculty = $this->All_model->deleteFaculty($userId);
	
		if(!empty($deleteFaculty))
		{
		$json['success'] = 1;
		}
		echo json_encode($json);
	}

	function studentlist()
	{
		
		$result['page'] ='students';	
		$id = $this->loginUser;
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		$result['getstudentdetail'] = $this->All_model->getstudentdetail();
		$result['getsubjectdetail'] = $this->All_model->getsubjectdetail();
		$this->load->view('admin/student_list.php',array('result' => $result));
	}

		function filter_Subject()
	{
		  $subId = $this->input->post('subid');
		  if($subId == 111)
		  {
			  
		  $resultAll = $this->All_model->getstudentdetail();
		
		  if(!empty($resultAll))
		  {
		  $output = '';
		  $output .= '<div class="table-container filterSubject" id="dvData">
					  <table class="table table-striped table-bordered table-hover" >
					  <thead>
					  <tr role="row" class="heading">
					  <th width="5%">Sr.No.</th>
					  <th width="15%">Full Name</th>
					  <th width="15%">Faculty Name</th>
					   <th width="15%">Remaining Hours</th>
					  <th width="15%">Subject</th>
					  <th width="15%">Year Of MBBS</th>
					  <th width="15%">College Of MBBS</th>
					  <th width="15%">Phone Number</th>
					  <th width="15%">Address</th>
					  <th width="15%">Email</th>
					  <th width="20%">Join Date</th>
					   <th width="20%">Action</th>
					  </tr>';
					 $i=1; foreach($resultAll as $value){
						 $colid=$value['college_id'];
						$colresult=$this->All_model->getcol($colid);
						
						
						
		  $output .= '<tr><th width="5%">'.$i++.'</th>';
		  $output .= '<th width="15%"><a href="'.base_url().'Superadmin/StudentWiseDetail/'.$value['student_id'].'">'.$value['name'].'</a></th>';
		  $output .= '<th width="15%"><a href="'.base_url().'Superadmin/facultyDetail/'.$value['faculty_id'].'">'.$value['faculty_name'].'</a></th>';
		   $output .= '<th width="15%"><a href="#">'.@$value['hours_remaining'].'</a></th>';
		  $output .= '<th width="10%">'.$value['subject_name'].'</th>';
		  $output .= '<th width="10%">'.$value['mbbs_year'].'</th>';
		  $output .= '<th width="10%">'.$colresult[0]->college_name.'</th>';
		  $output .= '<th width="10%">'.$value['contact_no'].'</th>';
		  $output .= '<th width="10%">'.$value['address'].'</th>';
		  $output .= '<th width="10%">'.$value['email'].'</th>';
		  $output .= '<th width="10%">'.date('d/m/Y', $value['created_date']).'</th>';
		  $output .= '<th width="10%">
						   <a class="btn btn-danger" style="height:30px;" onclick="deletestud('.$value['student_id'].');">Delete</a>
										</th></tr>';
						  };
						  
		  $output .= '</thead>
					  <tbody>
					  </tbody>
					  </table>
					  </div>';
		  }else { 
		  $output = "<h3>No Record Found</h3>";
		  }
		  }else if($subId == 112){
			  $students = $this->All_model->getsubscribedstudentdetail();
			  foreach($students as $element){
			  $student_id[] = $element['student_id'];	  
			  }
			  $result = $this->All_model->getstudentFilterSubscrib($student_id);
			  //echo"<pre>";
			  //print_r($result);
			  //die();
			 
			    if(!empty($result)){
		  
		  $output = '';
		  $output .= '<div class="table-container filterSubject">
					  <table class="table table-striped table-bordered table-hover" >
					  <thead>
					  <tr role="row" class="heading">
					  <th width="5%">Sr.No.</th>
					  <th width="15%">Full Name</th>
					   <th width="15%">Remaining Hours</th>
					  <th width="15%">Year Of MBBS</th>
					  <th width="15%">Phone Number</th>
					  <th width="15%">Address</th>
					  <th width="15%">Email</th>
					  <th width="20%">Join Date</th>
					  <th width="20%">Action</th>
					  </tr>';
					 $i=1; foreach($result as $value){
		  $output .= '<tr><th width="5%">'.$i++.'</th>';
		  $output .= '<th width="15%"><a href="'.base_url().'Superadmin/StudentWiseDetail/'.$value['student_id'].'">'.$value['name'].'</a></th>';
		  $output .= '<th width="10%">'.@$value['hours_remaining'].'</th>';
		  $output .= '<th width="10%">'.$value['mbbs_year'].'</th>';
		  $output .= '<th width="10%">'.$value['contact_no'].'</th>';
		  $output .= '<th width="10%">'.$value['address'].'</th>';
		  $output .= '<th width="10%">'.$value['email'].'</th>';
		  $output .= '<th width="10%">'.date('d/m/Y', $value['created_date']).'</th>';
		  $output .= '<th width="10%">
						   <a class="btn btn-danger" style="height:30px;" onclick="deletestud('.$value['student_id'].');">Delete</a>
										</th></tr>';
						  };
						  
		  $output .= '</thead>
					  <tbody>
					  </tbody>
					  </table>
					  </div>';
		  }else { 
		  $output = "<h3>No Record Found</h3>";
		  }
			
			 
		  }else {
			 
		  $result = $this->All_model->getstudentFilterSubject($subId);
		  if(!empty($result))
		  {
		  $output = '';
		  $output .= '<div class="table-container filterSubject">
					  <table class="table table-striped table-bordered table-hover" >
					  <thead>
					  <tr role="row" class="heading">
					  <th width="5%">Sr.No.</th>
					  <th width="15%">Full Name</th>
					  <th width="15%">Faculty Name</th>
					   <th width="15%">Remaining Hours</th>
					  <th width="15%">Subject</th>
					  <th width="15%">Year Of MBBS</th>
					  <th width="15%">College Of MBBS</th>
					  <th width="15%">Phone Number</th>
					  <th width="15%">Address</th>
					  <th width="15%">Email</th>
					  <th width="20%">Join Date</th>
					  <th width="20%">Action</th>
					  </tr>';
					 $i=1; foreach($result as $value){
			  $output .=  '<tr>
						<th width="5%">'.$i++.'</th>';
			  $output .=  '<th width="15%"><a href="'.base_url().'Superadmin/StudentWiseDetail/'.$value['student_id'].'">'.$value['name'].'</a></th>';
			  $output .= '<th width="15%"><a href="'.base_url().'Superadmin/facultyDetail/'.$value['faculty_id'].'">'.$value['facname'].'</a></th>';
			   $output .= '<th width="15%"><a href="#">'.$value['hours_remaining'].'</a></th>';
			  $output .= '<th width="10%">'.$value['subject_name'].'</th>';
			  $output .= '<th width="10%">'.$value['mbbs_year'].'</th>';
			  $output .= '<th width="10%">'.$value['college_name'].'</th>';
			  $output .= '<th width="10%">'.$value['contact_no'].'</th>';
			  $output .= '<th width="10%">'.$value['address'].'</th>';
			  $output .= '<th width="10%">'.$value['email'].'</th>';
			  $output .= '<th width="10%">'.date('d/m/Y', $value['created_date']).'</th>';
			  $output .= '<th width="10%">
						   <a class="btn btn-danger" style="height:30px;" onclick="deletestud('.$value['student_id'].');">Delete</a>
										</th></tr>';
						  };
						  
			  $output .= '</thead>
						  <tbody>
						 </tbody>
						 </table>
						 </div>';
			  }else { 
			  $output = "<h3>No Record Found</h3>";
			  }        
			  }
			  echo $output;
	}
	function filter_Invoice()
	{
		  $subId = $this->input->post('subid');
		  if($subId == 111)
		  {
		  $result = $this->All_model->allStudentInvoice();
		 // echo "<pre>";print_r($result);die;
		  if(!empty($result))
		  {
			$iny = 111;
		 $output = '';
		  $output .= '<div class="filterInvoice">
					<table class="table table-striped table-hover table-bordered"><thead><tr>
					<th>Date</th><th>Invoice No.</th> <th>Faculty Name</th><th>Order No.</th>
					<th>Student Name</th><th>Address Of Student</th><th>Gross Total</th>
					<th>Taxable Amount</th><th>CGST</th><th>SGST</th><th>Print Out</th></tr></thead><tbody>';
					foreach ($result as  $value){
					  $netamt = $value['net_amount'];
					  $cqgst = (($value['net_amount']*9)/100)+(($value['net_amount']*9)/100);
					$cgst = ($value['net_amount']*9)/100;
		  $output .= '<tr><td>'.$value['data_added'].'</td><td>
					  <a href="#">'.$value['invoice_no'].'</a>
					  </td><td><a href="#">'.$value['name'].'</a></td>
					  <td><a href="#">'.$value['order_id'].'</a></td>
					  <td><a href="#">'.$value['first_name'].$value['last_name'].'</a></td>
					  <td>'.$value['address'].'</td>
					  <td class="center">'.$netamt.'</td>
					  <td>'.$cqgst.'</td>
					  <td>'.$cgst.'</td>
					  <td>'.$cgst.'</td><td><div class="btn-group">
					  <a href="'.site_url('Superadmin/createXLS/'.$iny).'">
					  <button  class="btn green">Print </button></a></div></td></tr>';
					}
	   $output .=   '</tbody>
					</table>
					</div>';        
		  }else { 
		  $output = "<h3>No Record Found</h3>";
		  }
		  }else{
		  $result = $this->All_model->allStudentInvoice2($subId);
		//  echo "<pre>";print_r($result);die;
		  if(!empty($result))
		  {
		  $output = '';
		  $output .= '<div class="filterInvoice">
					<table class="table table-striped table-hover table-bordered"><thead><tr>
					<th>Date</th><th>Invoice No.</th> <th>Faculty Name</th><th>Order No.</th>
					<th>Student Name</th><th>Address Of Student</th><th>Gross Total</th>
					<th>Taxable Amount</th><th>CGST</th><th>SGST</th><th>Print Out</th></tr></thead><tbody>';
					foreach ($result as  $value){
					  $netamt = $value['net_amount'];
					  $cqgst = (($value['net_amount']*9)/100)+(($value['net_amount']*9)/100);
					$cgst = ($value['net_amount']*9)/100;
		  $output .= '<tr><td>'.$value['data_added'].'</td><td>
					  <a href="#">'.$value['invoice_no'].'</a>
					  </td><td><a href="#">'.$value['name'].'</a></td>
					  <td><a href="#">'.$value['order_id'].'</a></td>
					  <td><a href="#">'.$value['first_name'].$value['last_name'].'</a></td>
					  <td>'.$value['address'].'</td>
					  <td class="center">'.$netamt.'</td>
					  <td>'.$cqgst.'</td>
					  <td>'.$cgst.'</td>
					  <td>'.$cgst.'</td><td><div class="btn-group">
					  <a href="'.site_url('Superadmin/createXLS/'.$value['student_id']).'">
					  <button  class="btn green">Print </button></a></div></td></tr>';
					}
	   $output .=   '</tbody>
					</table>
					</div>';            
			  }else { 
			  $output = "<h3>No Record Found</h3>";
			  }        
			  }
			  echo $output;
	}
	function AllSubject()
	{
		if(!empty($this->input->get('nis') && ($this->input->get('nis')==1)))
		{
		$this->session->set_flashdata('sub_sussess', '<span class="notifq" style="color:green; font-family: cursive">Subject Update Successfully</span>');
		}
		
		$id=$this->loginUser;
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		
		$this->load->view('admin/allSubject.php',array('result' => $result));
	}

	function SubjectArraylist()
	{
		$json = array();
		$result = $this->All_model->subjectwithFaculty();
		if(!empty($result))
		{
		$json['getAllsubject'] = $result;
		}
		$this->load->view('include/SubjectArraylist.php',$json);
	}

	function deleteSubject()
	{
		$json = array();
		$subId = $this->input->post('subid');
		$deleteFaculty = $this->All_model->deleteSubject($subId);
		if(!empty($deleteFaculty))
		{
		$json['success'] = 1;
		}
		echo json_encode($json);
	}

	function invoice111()
	{
		$id = $this->loginUser;
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		$this->load->view('include/invoice.php',array('result' => $result));
	}

	function addVideo($userId)
	{

		$id = $this->loginUser;
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		$result['getfaculty'] = $this->All_model->getfaculty($userId);
	    $result['catfaculty'] = $this->All_model->categoriesFaculty($userId);
		$this->load->view('admin/addVideo.php',array('result' => $result));
	}

	function addVideoUrl()
	{
		
		$videotype =array();
		$SubId     = $this->input->post('subid');
		$UserId    = $this->input->post('facid');
		$VidUrl    = $this->input->post('field_name');
		$VidCat    = $this->input->post('category');
		if(!empty($this->input->post('videotype')))
		{
			$videotype = $this->input->post('videotype');
		}
		
		

		$id                       = $this->loginUser;
		
		$catid = $this->uri->segment(3);
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		$result['getfaculty']     = $this->All_model->getfaculty($UserId);
		if($VidUrl)
		{
		$var = sizeof($VidUrl);
		
		for ($i = 0; $i < $var; $i++)
		{
			$youtube_id    = $this->getYouTubeIdFromURL($VidUrl[$i]);
			$videodetails  = $this->get_youtube_title($VidUrl[$i]);
			if(!empty($videodetails['title'])){
			$videotitle    = $videodetails['title'];
		    }else{
		    $videotitle = 'newvideo'.time();	
		    }
		    if(!empty($videodetails['thumbnail_url'])){
			$videoimageurl = $videodetails['thumbnail_url'];
		    }else{
		    $videoimageurl = 'https://i.ytimg.com/vi/zx5TyxrO0vc/hqdefault.jpg';	
		    }
			$type = 0; 
			
			if (in_array($i, $videotype)) 
			{
				$type = 1;
			}
			 $data = array(
			'video_category' => $VidCat,
			'video_url' => $VidUrl[$i],
			'subject_id' => $SubId,
			'status' => 1,
			'date'  => date('Y-m-d'),
			'video_title' => $videotitle,
			'video_image_url' => $videoimageurl,
			'video_type' => $type
			);
			
			//echo "<pre>";print_r($data);
			//die();
			$this->db->insert('lecture_videos',$data);
			//echo $this->All_model->save_lactureVideos($data);
		}
		//exit;
		}

		redirect('Superadmin/facultyList?nfy=1');
	}

	function getYouTubeIdFromURL($url)
	{
		$url_string = parse_url($url, PHP_URL_QUERY);
		parse_str($url_string, $args);
		return isset($args['v']) ? $args['v'] : false;
	}

	function get_youtube_title($url){

		$youtube = "http://www.youtube.com/oembed?url=". $url ."&format=json";
		$curl = curl_init($youtube);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$return = curl_exec($curl);
		curl_close($curl);
		return json_decode($return, true);
	}

	function facultyDetail($userId)
	{
		
		$id =$this->loginUser;
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		
		$result['facultyDetail'] = $this->All_model->facultyDetail($userId);
		// echo "<pre>";print_r($result['facultyDetail']);die;
		$result1 = $this->All_model->getfacultyurl($userId);
		//echo"<pre>";
		 //print_r($result1);
		 //die();
		$this->load->view('admin/facultyDetail.php',array('result' => $result,'result1' => $result1));
	}
	function changepassword()
	{
	
if($this->input->post('change_pass'))
		{
			$old_pass=$this->input->post('old_pass');
			$new_pass=$this->input->post('new_pass');
			$confirm_pass=$this->input->post('confirm_pass');
			$session_id=$this->session->userdata('user_id');
			$que=$this->db->query("select * from medi_login_users where user_id='$session_id'");
			$row=$que->row();
			if((!strcmp($old_pass, $pass))&& (!strcmp($new_pass, $confirm_pass))){
				$this->All_model->changepassword($session_id,$new_pass);
				echo "Password changed successfully !";
				}
			    else{
					echo "Invalid";
				}
		}
		$this->load->view('admin/changepassword');	
	}
	function StudentDetail($userId)
	{
		$id = $this->loginUser;
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		$result['StudentDetail'] = $this->All_model->StudentDetail($userId);
		$this->load->view('admin/StudentDetail.php',array('result' => $result));
	}
	
	
	function deleteStudent()
	{
		
		$json = array();
		$userId = $this->input->post('studid');
		$deleteStudent = $this->All_model->deleteStudent($userId);
		if(!empty($deleteStudent))
		{
		$json['success'] = 1;
		}
		echo json_encode($json);
	}
	
	

	function StudentWiseDetail($userId)
	{
		
		$id = $this->loginUser;
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		$result['StudentWiseDetail'] = $this->All_model->StudentWiseDetail($userId);
		//echo "<pre>";print_r($result['StudentWiseDetail']);die;
		$this->load->view('admin/StudentWiseDetail.php',array('result' => $result));
	}

	function facultyVideoList()
	{
		
		if(!empty($this->input->get('ni') && ($this->input->get('ni')==1))){
		$this->session->set_flashdata('url_sussess', '<span class="notifq" style="color:green;    font-family: cursive">Url Update Successfully</span>');
		}
		$id = $this->loginUser;
		
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		//echo "<pre>";print_r($result['getadmindetail']);die;
		$result = $this->All_model->facultyVideoList();
		//echo"<pre>";
		//print_r($result);
		//die();
	    $this->load->view('admin/facultyVideoList.php',array('result' => $result));
	}

	function videoArrList()
	{
		$json = array();
		$id = $this->loginUser;
		$result = $this->All_model->facultyVideoList();
	
		if(!empty($result))
		{
		$json['facultyVideoList'] = $result;
		}
		$this->load->view('include/VideoArraylist.php',$json);
	}

	function sub()
	{
		$result = $this->All_model->getfacultydetail();
		echo "<pre>";print_r($result);die;
	}

	function deleteVideo()
	{
		$json = array();
		$videoId = $this->input->post('videoid');
		$deleteVideo = $this->All_model->deleteVideo($videoId);
		if(!empty($deleteVideo))
		{
		$json['success'] = 1;
		}
		echo json_encode($json);
	}

	function deleteCat()
	{
		$json = array();
	    $catId = $this->input->post('catId');
		$deleteCat = $this->All_model->deleteCategory($catId);
		if(!empty($deleteCat))
		{
			$json['success'] = 1;
		}else{
		
		    $json['success'] = 0;

		}
		echo json_encode($json);
	}

	function editVideo($vidId)
	{  
		$id =$this->loginUser;
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		$result['editVideo'] = $this->All_model->editVideo($vidId);
		$this->load->view('include/editVideo.php',array('result' => $result));
	}

	function updateVideo()
	{  
		$vId = $this->input->post('vid');
		$vidUrl = $this->input->post('vurl');
		$id = $this->loginUser;
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		$result['updateVideo'] = $this->All_model->updateVideo($vId,$vidUrl);
		redirect('Medivarsity/facultyVideoList?ni=1');
	}

	function editSubject($subId)
	{  
		$id = $this->loginUser;
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		$result['editSubject'] = $this->All_model->editSubject($subId);
		$this->load->view('include/editSubject.php',array('result' => $result));
	}

	function updateSubject()
	{  
		$subid = $this->input->post('subid');
		$sub = $this->input->post('sub');
		$id = $this->loginUser;
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		$result['updateSubject'] = $this->All_model->updateSubject($subid,$sub);
		redirect('Medivarsity/AllSubject?nis=1');
	}

	function facultyDetails()
	{  
		$id = $this->loginUser;
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		$this->load->view('include/facultyDetails.php',array('result' => $result));
	}

	function postAdmin($postId=false)
	{
		$id                = $this->loginUser;
		
		$result['page']    = 'post_admin';
		$result['postId']  = $postId;
		
		$result['title']       ='';
		$result['content']     ='';
		//$result['attachment']  ='';
		if($postId)
		{
			$post=$this->All_model->get_postById($postId);
			if($post)
			{
				$result['title']      =$post['title'];
				$result['content']    =$post['content'];
				//$result['attachment'] =$post['attachment'];
			}
		}
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		// $result['subjectFacultyPost'] = $this->All_model->subjectFacultyPost();
		$result['getsubjectdetail'] = $this->All_model->getsubjectdetail();
		//echo "<pre>";print_r($result['subjectFacultyPost']);die;
		$this->load->view('admin/addPost.php',$result); 
	}

	function addPost()
	{
		$json = array();
		$id        = $this->loginUser;
		$subid     = $this->input->post('subid');
		$title     = $this->input->post('tit');
		$content   = $this->input->post('con');
		$postId    = $this->input->post('postId');
        
         $postData = array(
         'user_id' => $id,
         'title' => $title,
         'content' => $content,
         'user_type' => 1
         );
        $res = $this->db->insert('post', $postData);
        $getstudentdetail = $this->All_model->getstudentdetailwithdevice();
		
          foreach($getstudentdetail as $element){
                     $arrapVal = array(
                    'site_url' => site_url(),
                    'name' => $element['name'],
                    'title' => $title,
                    'description' => $content,
                    "icon" => 'app_icon',
                    "priority"=>"HIGH",
                ); 
	
         if(!empty($element['device_id']) && $element['device_type'] == 0){
		 $ap_fields = array(
		 	  'registration_ids' => array($element['device_id']),
                    "data"=>$arrapVal,
                ); 
		  
		  $result=$this->pushNotification($ap_fields);
		  }elseif(!empty($element['device_id']) && $element['device_type'] == 1){
		  $result = $this->iOS($arrapVal, $element['device_id']); 	
		  }		
	
	       $this->All_model->insertnotification($element['name'],$element['student_id'],$title,$content,$element['device_type'],time());  
		   $json['success'] = 1;
		
	}
		echo json_encode($json);
	}

		function sendnotification()
	{   
		$postid = $this->uri->segment(3);
		$subject_id = $this->uri->segment(4);
	    $postdetails = $this->All_model->getpostdetails($postid);
        $getstudentdetail = $this->All_model->getstudentdetailwithdevicesubject($subject_id);
          foreach($getstudentdetail as $element){
			
                     $arrapVal = array(
                    'site_url' => site_url(),
                    'name' => $element['name'],
                    'title' => $postdetails['title'],
                    'description' => $postdetails['content'],
                    "icon" => 'app_icon',
                    "priority"=>"HIGH",
                ); 
	
         if(!empty($element['device_id']) && $element['device_type'] == 0){
		 $ap_fields = array(
		 	  'registration_ids' => array($element['device_id']),
                    "data"=>$arrapVal,
                ); 
		  
		$result=$this->pushNotification($ap_fields);
		}elseif(!empty($element['device_id']) && $element['device_type'] == 1){
		$result = $this->iOS($arrapVal, $element['device_id']); 	
		}		
		
	}
		 $qry = $this->db->where('id', $postid);
         $this->db->update('post', array('status'=> 1));
         $this->session->set_flashdata('success','<span style="color:green;">Notification sent successfully.</span>');
         redirect('Superadmin/postList');
	}
	
	
	         // FCM Push Notification
   public function pushNotification($fields) {
        $url = 'https://fcm.googleapis.com/fcm/send';
     
		$headers = array(
            "Authorization: key=" . 'AAAAXgXyLwk:APA91bFQ_dPgT1OhKmh_IeCWVI5TELQUBFHiIRX09KpDbyIbG3TSgyNge3s8S28uElR8UoVz-eL8f9KUT-a_GPxhfGhbZjWbNGddvaThDu_5l4l0nwWsilI6QZygwlFjPdXt92KWi3_L',
            "Content-Type: application/json"
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }


    // Sends Push notification for iOS users
    public function iOS($data, $devicetoken) {
    /*	$devicetoken = "4B0BB8C33CA42DF7D78A25C86D0A6A00F8A8CFF9AF74D3AB0036438AB7AE6A8B";
        $data = array('mtitle'=>'Notification', 'mdesc'=>'First Notification');*/
        $deviceToken = $devicetoken;
        $ctx = stream_context_create();
        // ck.pem is your certificate file
        stream_context_set_option($ctx, 'ssl', 'local_cert', '/var/www/html/PrductionPushcert.pem');
        stream_context_set_option($ctx, 'ssl', 'verify_peer', false);

        // Open a connection to the APNS server
        $fp = stream_socket_client(
            'ssl://gateway.sandbox.push.apple.com:2195', $err,
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
        if (!$result){
            return 'Message not delivered' . PHP_EOL;
        }
        else{
            return 'Message successfully delivered' . PHP_EOL;
        }
    }
       


	function postList()
	{ 
		$result['page'] ='posts';
		
		if($this->session->userdata('id'))
		{
			$id = $this->session->userdata('id');
		}else{
			$id = $this->session->userdata('admin_id');
		}
		$id = $this->loginUser;
		//$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		$result['arrPosts'] = $this->All_model->get_adminPost($id);
		$this->load->view('admin/postList.php', $result);
	}

	function postArrayList()
	{

		$json = array();
		$id = $this->session->userdata('id');
		$result = $this->All_model->Postlistall();
		// echo "<pre>";print_r($result);die;
		if(!empty($result))
		{
		$json['postallList'] = $result;
		}
		$this->load->view('include/postArrayList.php',$json);
	}

	function deletepost()
	{
		$json = array();
		$postId = $this->input->post('postId');
		$deletePost = $this->All_model->deletepost($postId);
		if(!empty($deletePost))
		{
		  $json['success'] = 1;
		}else{
		    $json['success'] = 0;

		}
		echo json_encode($json);
	}

	function approveunapprovepost()
	{
		$json = array(); 
		$stat = $this->input->post('status'); 
		$id = $this->input->post('id');
		if($stat == 0)
		{
		$status = 1;
		}
		else if($stat == 1)
		{
		$status = 0;
		}
		$result = $this->All_model->approveunapprovepost($id,$status);
		if($result)
		{
		if($stat == 0)
		{
		$json['exist'] = 1;
		}else
		{
		$json['exist'] = 0;
		}
		}
		echo json_encode($json);
	}

	function postDetail($postid)
	{
		$id = $this->loginUser;
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		$result['postDetail'] = $this->All_model->postDetail($postid);
		//echo "<pre>";print_r($result['postDetail']);die;
		$this->load->view('include/postDetail.php',array('result' => $result)); 
	}

	function faq()
	{
	  $id = $this->loginUser;
	  $result['getadmindetail'] = $this->All_model->getadmindetail($id);
	  $this->load->view('include/faq.php',array('result' => $result)); 
	}

	function invoice_bill() //////// invoice bill download to pdf
	{
		// $result = $this->item_model->invoice_bill();
		//echo "<pre>";print_r($result);die;
		$this->load->view('include/invoice.php');
		// $data['name'] = 'nisar ahamad'; 
		//   $this->load->view('test',$data);
		// Get output html
		$html = $this->output->get_output();
		// Load library
		$this->load->library('dompdf_gen');
		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("invoice.pdf");
	}

	function invoiceb(){

		$this->load->library('fpdf_master');

		$this->fpdf->SetFont('Arial','B',18);

		$this->fpdf->Cell(50,10,'Hello World!');
		//All text which have to print should be goes here
		//also you can go for calling view over here and put the same type of code inside the view

		echo $this->fpdf->Output('hello_world.pdf','D');// Name of PDF file
	}

	public function invoice() {
		$result['page']  = 'export-excel';
		$data['title']   = 'Export Excel data | TechArise';
		$data['empInfo'] = $this->export->allStudentInvoice();
		$id = $this->loginUser;
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		$result['getsubjectdetail'] = $this->All_model->getsubjectdetail();
		$empInfo = $this->export->allStudentInvoice();
		// echo "<pre>";print_r($empInfo);die;
		// load view file for output
		$this->load->view('admin/invoice.php',array('result' => $result,'data'=>$data));
	}

    // create xlsx
      public function createXLS($stuid) {
		 
     $fileName = 'data-' . time() . '.xlsx';
        // load excel library
        $this->load->library('excel');
        if($stuid == 111)
        {
          $empInfo = $this->export->allStudentInvoice();
        	  
        }else
		{
          $empInfo = $this->export->allStudentInvoiceExcel($stuid);
        }
        //echo "<pre>";print_r($empInfo);die;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'First Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Last Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Invoice No.');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Order Id');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Address');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Net Amount');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'CGST');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'SGST');
		
        // set Row
        $rowCount = 2;
        foreach ($empInfo as $element) {  
		          
                  $netamt = $element['net_amount']-$element['tax_rate'];
                  $cqgst = (($element['net_amount']*9)/100)+(($element['net_amount']*9)/100);
                  $cgst = ($element['net_amount']*9)/100; 
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['data_added']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['invoice_no']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['email']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['invoice_no']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['first_name'].$element['last_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['order_id']);
           
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['address']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $netamt);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $cqgst);
             $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $cqgst);
            $rowCount++;
        }
		// echo "<pre>";
		// print_r($objPHPExcel);
		// echo HTTP_UPLOAD_IMPORT_PATH . $fileName;
        // echo ROOT_UPLOAD_IMPORT_PATH.$fileName;exit;
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save(ROOT_UPLOAD_IMPORT_PATH . $fileName);
        // download file

        header("Content-Type: application/vnd.ms-excel");
        redirect(HTTP_UPLOAD_IMPORT_PATH . $fileName);
    }

    function getSubcatByCatId(){
		$cat_id = $this->input->post('cat_id');
	
		$subcat = $this->db->get_where('categories', array('parent_id'=>$cat_id))->result();

		$html = '';
			foreach($subcat as $sub){
		$html .='<option value='.$sub->id.'>'.$sub->name.'</option>';	
			}

		echo $html;
	}
	function addSubject($id = false)
	{

		$config['upload_path']      = 'assets/images/subjects';
        $config['allowed_types']    = 'gif|jpg|png';
        $config['encrypt_name']     = true;
        $this->load->library('upload', $config);
		$this->upload->initialize($config);
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$result['image']					= array();
	
		$this->form_validation->set_rules('name', 'Subject Name', 'trim|required');
		$this->form_validation->set_rules('price', 'Subject Price', 'trim|required');
		$this->form_validation->set_rules('feature', 'Subject Feature', 'trim|required');
		$this->form_validation->set_rules('description', 'Subject Description', 'trim|required');
		
		$result['id']                         ='';
		$result['name']                       ='';
		$result['price']                      ='';
		$result['hour']                       ='';
		$result['feature']                    ='';
		$result['disciption']                 ='';
		$result['image']                      ='';
		$result['subject_details_id']         ='';
		if ($id){	
		
			$subject					= $this->All_model->get_subject_by_id($id);
			if (!$subject)
			{
				$this->session->set_flashdata('error','Subject not found.');
				redirect('Superadmin/addSubject');
			}
			$result['id']                      =$subject['id'];
			$result['name']                    =$subject['subject_name'];
			$result['price']                   =$subject['price'];
		    $result['hour']                    =$subject['hours'];
			$result['feature']                 =$subject['subject_features'];
			$result['disciption']              =$subject['subject_description'];
			$result['image']                   =$subject['image'];
			$result['subject_details_id']      =$subject['subject_detail_id'];
			
		}
		if ($this->form_validation->run() == FALSE){
			$this->load->view('admin/add_subject',$result); 
		}else
		{
			$uploaded   = $this->upload->do_upload('image');
			if ($id)
            {
                //delete the original file if another is uploaded
                if($uploaded)
                {
         
                    if($result['image'] != '')
                    {
                     
                        $file = 'assets/images/subjects/'.$result['image'];
                            //delete the existing file if needed
                            if(file_exists($file))
                            {
                                unlink($file);
                            }
                        
                    }
                }
                
            }
            if(!$uploaded)
            {
              
                if($_FILES['image']['error'] != 4)
                {
					
                    $result['error']  .= $this->upload->display_errors();
					$this->load->view('admin/add_subject',$result); 
                    return;
                }
            }
            else
            {
                $image          = $this->upload->data();
                $saveDetail['image']  = $image['file_name'];
                  
            }
		
			$save['id']					= $id;
			$save['subject_name']	    = $this->input->post('name');
			$save['price']	            = $this->input->post('price');
			$save['hours']	            = $this->input->post('hour');
			// echo "<pre>";
			// print_r($save);	
			// exit;	
			$subject_id	     = $this->All_model->save_subject($save);
			
			
			$saveDetail['id']                   = $result['subject_details_id'];	
			$saveDetail['subject_id']           = $subject_id;	 
			$saveDetail['subject_description']  = $this->input->post('description');		 
			$saveDetail['subject_features']     = $this->input->post('feature');
          	$this->All_model->save_subjectDetails($saveDetail);	
            $this->session->set_flashdata('message', '<span class="notifq" style="color:green;    font-family: cursive">Subject Added Successfully</span>');			
			$this->session->set_flashdata('message','Subject has been saved.');

			//go back to the product list
			redirect('Superadmin/subjectList');
		}
	
	}
	function subjectList()
	{
		if(!empty($this->input->get('nis') && ($this->input->get('nis')==1)))
		{
		$this->session->set_flashdata('sub_sussess', '<span class="notifq" style="color:green; font-family: cursive">Subject Update Successfully</span>');
		}
		
		$id = $this->loginUser;
		$result['arrSubject'] = $this->All_model->getAllSubject();
		$this->load->view('admin/subject_list.php',$result);
	}
	function delete_subject($id){
		if($id)
		{
		     $this->All_model->delete_subject($id);
			$this->session->set_flashdata('message','Subject has been deleted.');
				redirect('Superadmin/subjectList/');
		}else{
			$this->session->set_flashdata('error', 'Requested subject could not be found.');
			redirect('Superadmin/subjectList/');
		}
	}
	function querylist()
	{
		$result['page'] ='query_list';	
		$id = $this->loginUser;
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		$result['arrQuery'] = $this->All_model->getQueryList();
		$this->load->view('admin/query_list.php',$result);
	}


	function category()
	{
		$data['qryList'] = $this->All_model->getCatList();
		$this->load->view('admin/category_list', $data);	
	}

	function categoryAdded(){

		$data['faculty_name'] = $this->All_model->getFacultyList();
		$this->load->view('admin/categoryAdded', $data);	

	 }

	function addCategoryList(){
		
		$fname = explode(',', $this->input->post('faculty'));
		$data = array('faculty' => $fname[0],
					  'faculty_id' => $fname[1],	
					  'cat_name' => $this->input->post('cat_name'),
					  'added_on' => date('Y-m-d H:s:i')
					 );

		$result = $this->All_model->addCategory($data);
		
		if($result)
		{
			$catResult = $this->session->set_flashdata('add_category', '<span class="notifq" style="color:green;font-family:cursive">Category Added Successfully</span>');
			redirect(base_url().'Superadmin/category', $catResult);	
		
		}else{

			$catResult = $this->session->set_flashdata('add_category', '<span class="notifq" style="color:red;font-family:cursive">Something went Wrong, Please Try Again.</span>');
			redirect(base_url().'Superadmin/category', $catResult);	
		
		}
	}

	function editCategory(){

		$id = $this->uri->segment(3);
		$result['faculty_name'] = $this->All_model->getFacultyList();
		$result['edit_category'] = $this->All_model->editCat($id);
		if($result){

			$this->load->view('admin/editCategory', $result);	

		}	
	}

	function updateCategoryList(){
		$data = array('faculty' => $this->input->post('faculty'),
					'cat_name' => $this->input->post('cat_name'),
					'updated_on' => date('Y-m-d H:s:i')
					 );
		$id = $this->uri->segment(3);
		$result = $this->All_model->updateCatList($id, $data);
		if($result){

			$catResult = $this->session->set_flashdata('add_category', '<span class="notifq" style="color:green;font-family:cursive">Category Updated Successfully.</span>');
			redirect(base_url().'Superadmin/category', $catResult);	

		}else{

			$catResult = $this->session->set_flashdata('add_category', '<span class="notifq" style="color:red;font-family:cursive">Not Updated, Please try Again.</span>');
			redirect(base_url().'Superadmin/category', $catResult);	

		}		

	}
	
	function deleteQuery()
	{
		$json = array();
	    $queryId = $this->input->post('queryId');
		$deletePost = $this->All_model->delete_query($queryId);
		if(!empty($deletePost))
		{
		  $json['success'] = 1;
		}else{
		    $json['success'] = 0;

		}
		echo json_encode($json);
	}
	
	function deletelacvidio()
	{
		$json = array();
		$v_id = $this->input->post('v_id');
		$deletevidio = $this->All_model->deletevidio($v_id);
		if(!empty($deletevidio))
		{
		$json['success'] = 1;
		}
		echo json_encode($json);
	}
	
	function addoriantVideo(){
		
		 $this->load->view('admin/oriantation.php');
	}

	function addoriantVideoUrl(){
		
		$videotype =array();
		$VidUrl    = $this->input->post('field_name');
		$id                       = $this->loginUser;
		
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		
		if($VidUrl)
		{
			
		$var = sizeof($VidUrl);
		
		
		for ($i = 0; $i < $var; $i++)
		{
			
			$videodetails  = $this->get_youtube_title($VidUrl[$i]);
			
		    $videotitle    = $videodetails['title'];
			$videoimageurl = $videodetails['thumbnail_url'];
			
			
			$type = 0; 
			
			if (in_array($i, $videotype)) 
			{
				$type = 1;
			}
			
			
			$data = array(
			'url' => $VidUrl[$i],
		    'status' => 1,
			'title' => $videotitle,
			'image_url' => $videoimageurl,
			'status' => $type
			);
			
			//echo "<pre>";print_r($data); 
			//die();
			$this->db->insert('daily_updates',$data);
			
			
			
			//echo $this->All_model->save_lactureVideos($data);
		}
		//exit;
		}

		redirect('Superadmin/oriantvidioList?nfy=1');
	}
	function oriantvidioList()
	{
	   	
		$result['page'] ='orvidio';	
		if(!empty($this->input->get('nfy') && ($this->input->get('nfy')==1))){
		$this->session->set_flashdata('add_url_sussess', '<span style="color:green;    font-family: cursive">Url Added Successfully</span>');
		}
		$id = $this->loginUser;
		$result['getadmindetail'] = $this->All_model->getadmindetail($id);
		$result['getoriantvidio'] = $this->All_model->getoriantvidio();
		$this->load->view('admin/oriantvidioList.php',array('result' => $result));
	}
	 
		
	/* end */
	/* delete oriant vidio */
		function deleteoriantVideo()
	{
		$json = array();
		$videoId = $this->input->post('videoid');
		$deleteVideo = $this->All_model->deleteoriantVideo($videoId);
		if(!empty($deleteVideo))
		{
		$json['success'] = 1;
		}
		echo json_encode($json);
	}
}