<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medivarsity extends CI_Controller {
  function __construct(){
  parent::__construct();
  $this->load->library('session');
  $this->load->model('All_model');
   $this->load->model('All_model', 'export');
 /*  $id = $this->session->userdata('id');
   if(empty($id))
   {
    redirect('MedivarsityLogin');
   }*/
}

  function index()
  {  
  $id = $this->session->userdata('id');
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
  if(!empty($this->input->get('sid') && ($this->input->get('sid')==1))){
  $this->session->set_flashdata('login_error', 'Invalid User Name or Password. Please try again'); 
  }
  $this->load->view('login/login');
}

 function admin()
 {
 $id = $this->session->userdata('id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 //echo "<pre>";print_r($result['getadmindetail']);die;
 $this->load->view('admin/index',array('result' =>$result));
 }

 function logout()
 {
 $this->session->unset_userdata('id');
 redirect('MedivarsityLogin');
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



function addFaculty_pg()
{
  $result = array();
  $id = $this->session->userdata('id');
  $result['getadmindetail'] = $this->All_model->getadmindetail($id);
  if(!empty($this->input->get('lig') && ($this->input->get('lig')==1))){
  $this->session->set_flashdata('add_faculty_sussess', '<span class="notifq" style="color:green;    font-family: cursive">Faculty Added Successfully</span>');
  }
  $getsubjectdetail = $this->All_model->getsubjectdetail();
  $getfacultydetail2 = $this->All_model->getfacultydetail2();
  //echo "<pre>";print_r($getfacultydetail2);
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
  foreach($getsubjectdetail as $val) {
  if(!in_array($val['id'],$subjectId))
  {
  $result1[]=$val;
  }
  }
 // echo "<pre>";print_r($result1);die;
  $this->load->view('include/add_faculty.php',array('result'=>$result,'data' => $result1));
  }

function addFaculty()
{ 
  $id = $this->session->userdata('id');
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
  $pass = md5(SALT . $password);
  //echo "<pre>";print_r($vidurl);die;
  $userdetail = array(
      'name' => $name,
      'subject_id' => $sub,
      'email' => $email,
      'password' => $pass,
      'contact_no' => $mobile,
      'address' => $add,
      'about' => $aboutsub,
      'user_type' => 0
      );
   $this->db->insert('medi_login_users',$userdetail);
   $getFacultyid = $this->All_model->getFacultyid($email);
   $userid = $getFacultyid->user_id;
  
  $bankdetail = array(
      'name_as_per_bank_account' => $name,
      'account_no' => $accountnum,
      'ifsc_code' => $ifsc,
      'bank_name' => $bankname,
      'location' => $add,
      'user_id' => $userid 
      );
  $this->db->insert('user_bank_details',$bankdetail);
  return redirect('Medivarsity/addFaculty_pg?lig=1');
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
  if(!empty($this->input->get('nfy') && ($this->input->get('nfy')==1))){
  $this->session->set_flashdata('add_url_sussess', '<span style="color:green;    font-family: cursive">Url Added Successfully</span>');
  }
  $id = $this->session->userdata('id');
  $result['getadmindetail'] = $this->All_model->getadmindetail($id);
  $this->load->view('include/faculty_list.php',array('result' => $result));
}

function facultyArrList()
{

  $json = array();
  $id = $this->session->userdata('id');
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
  $id = $this->session->userdata('id');
  $result['getadmindetail'] = $this->All_model->getadmindetail($id);
  $result['getstudentdetail'] = $this->All_model->getstudentdetail();
  $result['getsubjectdetail'] = $this->All_model->getsubjectdetail();
  $this->load->view('include/student_list.php',array('result' => $result));
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
      $output .= '<div class="table-container filterSubject">
                  <table class="table table-striped table-bordered table-hover" >
                  <thead>
                  <tr role="row" class="heading">
                  <th width="5%">Sr.No.</th>
                  <th width="15%">Full Name</th>
                  <th width="15%">Faculty Name</th>
                  <th width="15%">Subject</th>
                  <th width="15%">Year Of MBBS</th>
                  <th width="15%">College Of MBBS</th>
                  <th width="15%">Phone Number</th>
                  <th width="15%">Address</th>
                  <th width="15%">Email</th>
                  <th width="20%">Join Date</th>
                  </tr>';
                 $i=1; foreach($resultAll as $value){
      $output .= '<tr><th width="5%">'.$i++.'</th>';
      $output .= '<th width="15%"><a href="#">'.$value['name'].'</a></th>';
      $output .= '<th width="15%"><a href="#">'.$value['facname'].'</a></th>';
      $output .= '<th width="10%">'.$value['subject_name'].'</th>';
      $output .= '<th width="10%">'.$value['mbbs_year'].'</th>';
      $output .= '<th width="10%">'.$value['college_name'].'</th>';
      $output .= '<th width="10%">'.$value['contact_no'].'</th>';
      $output .= '<th width="10%">'.$value['address'].'</th>';
      $output .= '<th width="10%">'.$value['email'].'</th>';
      $output .= '<th width="10%">'.date('d/m/Y', $value['created_date']).'</th></tr>';
                      };
                      
      $output .= '</thead>
                  <tbody>
                  </tbody>
                  </table>
                  </div>';
      }else { 
      $output = "<h3>No Record Found</h3>";
      }
      }else{
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
                  <th width="15%">Subject</th>
                  <th width="15%">Year Of MBBS</th>
                  <th width="15%">College Of MBBS</th>
                  <th width="15%">Phone Number</th>
                  <th width="15%">Address</th>
                  <th width="15%">Email</th>
                  <th width="20%">Join Date</th>
                  </tr>';
                 $i=1; foreach($result as $value){
          $output .=  '<tr>
                    <th width="5%">'.$i++.'</th>';
          $output .=  '<th width="15%"><a href="#">'.$value['name'].'</a></th>';
          $output .= '<th width="15%"><a href="#">'.$value['facname'].'</a></th>';
          $output .= '<th width="10%">'.$value['subject_name'].'</th>';
          $output .= '<th width="10%">'.$value['mbbs_year'].'</th>';
          $output .= '<th width="10%">'.$value['college_name'].'</th>';
          $output .= '<th width="10%">'.$value['contact_no'].'</th>';
          $output .= '<th width="10%">'.$value['address'].'</th>';
          $output .= '<th width="10%">'.$value['email'].'</th>';
          $output .= '<th width="10%">'.date('d/m/Y', $value['created_date']).'</th></tr>';
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
                  <a href="'.site_url('Medivarsity/createXLS/'.$iny).'">
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
                  <a href="'.site_url('Medivarsity/createXLS/'.$value['student_id']).'">
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
  if(!empty($this->input->get('nis') && ($this->input->get('nis')==1))){
  $this->session->set_flashdata('sub_sussess', '<span class="notifq" style="color:green; font-family: cursive">Subject Update Successfully</span>');
  }
 $id = $this->session->userdata('id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 $this->load->view('include/allSubject.php',array('result' => $result));
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
 $id = $this->session->userdata('id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 $this->load->view('include/invoice.php',array('result' => $result));
 }

 function addVideo($userId)
 {
// echo "<pre>";print_r($userId);die;
 $id = $this->session->userdata('id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 $result['getfaculty'] = $this->All_model->getfaculty($userId);
 $this->load->view('include/addVideo.php',array('result' => $result));
 }

  function addVideoUrl()
 {
 $SubId = $this->input->post('subid');
 $UserId = $this->input->post('facid');
 $VidUrl = $this->input->post('field_name');
 $id = $this->session->userdata('id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 $result['getfaculty'] = $this->All_model->getfaculty($userId);
 if($VidUrl)
 {
 $var = sizeof($VidUrl);
 for ($i = 0; $i < $var; $i++)
 {
 $data = array(
  'video_url' => $VidUrl[$i],
  'subject_id' => $SubId,
  'status' => 1,
  'date'  => date('d/m/Y')
  );
 $this->db->insert('lecture_videos',$data);
 }
 }
 redirect('Medivarsity/facultyList?nfy=1');
 }


 function facultyDetail($userId)
 {
 $id = $this->session->userdata('id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 $result['facultyDetail'] = $this->All_model->facultyDetail($userId);
// echo "<pre>";print_r($result['facultyDetail']);die;
 $result1 = $this->All_model->getfacultyurl($userId);
 $this->load->view('include/facultyDetail.php',array('result' => $result,'result1' => $result1));
 }

 function StudentDetail($userId)
 {
 $id = $this->session->userdata('id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 $result['StudentDetail'] = $this->All_model->StudentDetail($userId);
 $this->load->view('include/StudentDetail.php',array('result' => $result));
 }

function StudentWiseDetail($userId)
 {
 $id = $this->session->userdata('id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 $result['StudentWiseDetail'] = $this->All_model->StudentWiseDetail($userId);
 //echo "<pre>";print_r($result['StudentWiseDetail']);die;
 $this->load->view('include/StudentWiseDetail.php',array('result' => $result));
 }

 function facultyVideoList()
 {
  if(!empty($this->input->get('ni') && ($this->input->get('ni')==1))){
  $this->session->set_flashdata('url_sussess', '<span class="notifq" style="color:green;    font-family: cursive">Url Update Successfully</span>');
  }
 $id = $this->session->userdata('id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 //echo "<pre>";print_r($result['getadmindetail']);die;
 $this->load->view('include/facultyVideoList.php',array('result' => $result));
 }

function videoArrList()
{

  $json = array();
  $id = $this->session->userdata('id');
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

function editVideo($vidId)
{  
 $id = $this->session->userdata('id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 $result['editVideo'] = $this->All_model->editVideo($vidId);
 $this->load->view('include/editVideo.php',array('result' => $result));
}

function updateVideo()
{  
 $vId = $this->input->post('vid');
 $vidUrl = $this->input->post('vurl');
 $id = $this->session->userdata('id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 $result['updateVideo'] = $this->All_model->updateVideo($vId,$vidUrl);
 redirect('Medivarsity/facultyVideoList?ni=1');
}

function editSubject($subId)
{  
 $id = $this->session->userdata('id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 $result['editSubject'] = $this->All_model->editSubject($subId);
 $this->load->view('include/editSubject.php',array('result' => $result));
}

function updateSubject()
{  
 $subid = $this->input->post('subid');
 $sub = $this->input->post('sub');
 $id = $this->session->userdata('id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 $result['updateSubject'] = $this->All_model->updateSubject($subid,$sub);
 redirect('Medivarsity/AllSubject?nis=1');
}

function facultyDetails()
{  
 $id = $this->session->userdata('id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 $this->load->view('include/facultyDetails.php',array('result' => $result));
}

// function addPost()
// {  
//  $id = $this->session->userdata('id');
//  $result['getadmindetail'] = $this->All_model->getadmindetail($id);
//  $this->load->view('include/addPost.php',array('result' => $result));
// }

function postAdmin()
{
 $id = $this->session->userdata('id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
// $result['subjectFacultyPost'] = $this->All_model->subjectFacultyPost();
 $result['getsubjectdetail'] = $this->All_model->getsubjectdetail();
 //echo "<pre>";print_r($result['subjectFacultyPost']);die;
 $this->load->view('include/addPost.php',array('result' => $result)); 
}

function addPost()
{
  $json = array();
  $id = $this->session->userdata('id');
  $subid = $this->input->post('subid');
  $title = $this->input->post('tit');
  $content = $this->input->post('con');
  $att = $this->input->post('att');

  $postData = array(
  'user_id' => $id,
  'title' => $title,
  'content' => $content,
  'attachment' =>$att,
  'user_type' => 1
  );
  //echo "<pre>";print_r($postData);die;
  $result = $this->db->insert('post',$postData);
  if($result)
  {
   $json['success'] = 0;
  }
  echo json_encode($json);
}


function postList()
{  
 $id = $this->session->userdata('id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 // $result[] = $this->All_model->getfacultydetail();
 //echo "<pre>";print_r($result['subjectFacultyPost']);die;
 $this->load->view('include/postList.php',array('result' => $result));

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
  $postid = $this->input->post('postid');
  $deletePost = $this->All_model->deletepost($postid);
  if(!empty($deletePost))
  {
    $json['success'] = 1;
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
  $id = $this->session->userdata('id');
  $result['getadmindetail'] = $this->All_model->getadmindetail($id);
  $result['postDetail'] = $this->All_model->postDetail($postid);
  //echo "<pre>";print_r($result['postDetail']);die;
  $this->load->view('include/postDetail.php',array('result' => $result)); 
}

function faq()
{
  $id = $this->session->userdata('id');
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
        $data['page'] = 'export-excel';
        $data['title'] = 'Export Excel data | TechArise';
        $data['empInfo'] = $this->export->allStudentInvoice();
        $id = $this->session->userdata('id');
        $result['getadmindetail'] = $this->All_model->getadmindetail($id);
        $result['getsubjectdetail'] = $this->All_model->getsubjectdetail();
        $empInfo = $this->export->allStudentInvoice();
        // echo "<pre>";print_r($empInfo);die;
        // load view file for output
        $this->load->view('include/invoice.php',array('result' => $result,'data'=>$data));
    }

    // create xlsx
    public function createXLS($stuid) {

        $fileName = 'data-' . time() . '.xlsx';
        // load excel library
        $this->load->library('excel');
        if($stuid == 111)
        {
        $empInfo = $this->export->allStudentInvoice();  
        }else{
        $empInfo = $this->export->allStudentInvoiceExcel($stuid);
      }
       // echo "<pre>";print_r($empInfo);die;
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
       // echo ROOT_UPLOAD_IMPORT_PATH;exit;
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save(ROOT_UPLOAD_IMPORT_PATH . $fileName);
        // download file
        header("Content-Type: application/vnd.ms-excel");
        redirect(HTTP_UPLOAD_IMPORT_PATH . $fileName);
    }


}