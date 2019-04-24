<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty extends CI_Controller {
  function __construct(){
  parent::__construct();
  $this->load->library('session');
  $this->load->model('All_model');
}

  function index()
	{  
  $id = $this->session->userdata('faculty_id');
  if(!empty($id)){
  $this->All_model->userId($id);
  $result['getadmindetail'] = $this->All_model->getadmindetail($id);
  $subject_id = $result['getadmindetail']->subject_id;
  $result['totinvoices'] = $this->All_model->totinvoices($subject_id);
  $result['totvideo_fac'] = $this->All_model->totvideo_fac();
  $result['totsubscriber_fac'] = $this->All_model->totsubscriber_fac();
  $this->load->view('faculty/index',array('result' =>$result));
  }else{
  redirect('loginpanel');  
  }
  }

 function logout()
 {
 $this->session->unset_userdata('faculty_id');
 redirect('loginpanel');
 }

function suscribedStudent()
{
  $id = $this->session->userdata('faculty_id');
  $result['getadmindetail'] = $this->All_model->getadmindetail($id);
  $result['getstudentdetail_fac'] = $this->All_model->getstudentdetail_fac($id);
  $result['getsubjectdetail'] = $this->All_model->getsubjectdetail();
  $this->load->view('faculty/suscribeStudent.php',array('result' => $result));
}

function filter_Subject()
{
      $subId = $this->input->post('subid');
      if($subId == 111)
      {
      $resultAll = $this->All_model->getstudentdetail_fac();
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
      $result = $this->All_model->getstudentFilterSubject_fac($subId);
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

function StudentDetail($userId)
 {
 $id = $this->session->userdata('faculty_id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 $result['StudentWiseDetail'] = $this->All_model->StudentWiseDetail($userId);
 $this->load->view('faculty/StudentWiseDetail.php',array('result' => $result));
 }

function Lectures()
{
 $id = $this->session->userdata('faculty_id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 $result['allLecture_fac'] = $this->All_model->allLecture_fac($id);
 $this->load->view('faculty/allLecture.php',array('result' => $result)); 
}

function testquestions($vid)
{
 $id = $this->session->userdata('faculty_id');
 $result['getadmindetail']  = $this->All_model->getadmindetail($id);
 $result['getLectureVideo'] = $this->All_model->getLectureVideo($vid);
 $result['testQust']        = $this->All_model->testQust($vid);
 
 $this->load->view('faculty/testList.php',array('result' => $result)); 
}

function allAnswer()
{
  $questid = $this->input->post('questid');
  $result = $this->All_model->allAnswerquest($questid);
  $json['allAnswerquest'] = $result;
  $this->load->view('faculty/include/ArrayChooseAnswer.php',$json);
}

function allAnswer2()
{
  $questid = $this->input->post('questid');
   //$questid = 46;
 //  echo "<pre>";print_r($questid);die;
  $result = $this->All_model->allAnswerquest($questid);
 //echo "<pre>";print_r($result);die;
  if(!empty($result))
  {
     $json['allAnswerquest2'] = $result;
  }
  $this->load->view('faculty/ArrayChooseAnswer2.php',$json);
}

function addtest($vid)
{
 $id = $this->session->userdata('faculty_id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 $result['getLectureVideo'] = $this->All_model->getLectureVideo($vid);
 $this->load->view('faculty/addTest.php',array('result' => $result)); 
}

 



function addtestPage()
{ 
 $radio = $this->input->post('radiotxt');
 $option = $this->input->post('option');
 $radioimg = $this->input->post('radioimg');
 $file = $this->input->post('files');
 $inputtype = $this->input->post('input_num');
 $vid = $this->input->post('id');
 $qst = $this->input->post('question');
 $cr1 = $this->input->post('cr1');
 $img1 = $this->input->post('imgInp1');
 $cr2 = $this->input->post('cr2');
 $subid = $this->input->post('subid');
 $vidtitle = $this->input->post('vidtitle');


  $testdata = array(
 'video_id' => $vid,
 'subject_id' => $subid,
 'test_name' => $vidtitle,
 'status' => 1,
 'grand_test' => 0
  );

 
  $getTestId = $this->All_model->getTestId($vid);
  if(empty($getTestId))
  {
   $this->db->insert('test',$testdata); 
  }

  $gettestdata = $this->All_model->gettestdata($vid,$subid);
  $getTestId = $gettestdata->id;
  $testQues = array(
 'test_id' => $getTestId,
 'test_question' => $qst,
 'status' => 0,
 'answer_type' => $inputtype
  );
  
  $getquesQ = $this->All_model->getquestdata($getTestId,$qst);
  if(!empty($getquesQ))
  {
  $result['getLectureVideo'] = array(
 'video_id' => $vid,
 'subject_id' => $subid,
 'test_name' => $vidtitle,
  );
 $this->session->set_flashdata('url_sussess', '<span class="hideflash"  style="color:red;margin-left:40px;font-family: Helvetica">Question Already Post Try Another Question !</span>');
 return redirect('Faculty/testquestions/'.$vid,array('result'=>$result));
  }
  $this->db->insert('test_questions',$testQues);
  $getQuestId = $this->All_model->getquestdata($getTestId,$qst);
  $getQuestId = $getQuestId->id;

 if($inputtype == 0)
 {
foreach($option as $key=>$element){

if($key+1 == $radio){
$correct = 1;  
}else{
$correct = 0;  
}

  $insOpt1 = array(
  'question_id' => $getQuestId,
  'option_answer' => $element,
  'correct_answer' => $correct
  );
  $opt1 = $this->db->insert('answer_text',$insOpt1);

}
 }

else if($inputtype == 1)
{
 if(!empty($_FILES['files']['name']))
        {     
      $data = array();
      $countfiles = count($_FILES['files']['name']);
      for($i=0;$i<$countfiles;$i++){ 
 if($i+1 == $radioimg){
$correct = 1;  
}else{
$correct = 0;  
}
        if(!empty($_FILES['files']['name'][$i])){
 
        
          $_FILES['file']['name'] = $_FILES['files']['name'][$i];
          $_FILES['file']['type'] = $_FILES['files']['type'][$i];
          $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
          $_FILES['file']['error'] = $_FILES['files']['error'][$i];
          $_FILES['file']['size'] = $_FILES['files']['size'][$i];
          $config['upload_path'] = '/var/www/html/assets/test_img/'; 
          $config['allowed_types'] = 'jpg|jpeg|png|gif';
          $config['max_size'] = '5000'; // max_size in kb
          $config['file_name'] = $_FILES['files']['name'][$i];
          $this->load->library('upload',$config); 
          if($this->upload->do_upload('file')){
            $uploadData = $this->upload->data();
            $filename = $uploadData['file_name'];
              $insOpt1 = array(
  'question_id' => $getQuestId,
  'image_url' => $filename,
  'correct_answer' => $correct
  );
  $this->db->insert('answer_images',$insOpt1);
                }
            }
          }
        }
      
    }
$result['getLectureVideo'] = array(
 'video_id' => $vid,
 'subject_id' => $subid,
 'test_name' => $vidtitle,
);

$this->session->set_flashdata('url_sussess', '<span class="hideflash"  style="color:green;font-family: Helvetica">Question Added Successfully</span>');
 return redirect('Faculty/testquestions/'.$vid,array('result'=>$result));
}

function postFaculty()
{
 $id = $this->session->userdata('faculty_id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 $result['allLecture_fac'] = $this->All_model->allLecture_fac($id);
 $this->load->view('faculty/addPost.php',array('result' => $result)); 
}

function addPost()
{
  $json    = array();
  $id      = $this->session->userdata('faculty_id');
  $subid   = $this->input->post('subid');
  $title   = $this->input->post('tit');
  $content = $this->input->post('con');
  $att     = $this->input->post('att');

  $postData = array(
  'user_id' => $id,
  'title' => $title,
  'content' => $content,
  'attachment' => $att,
  'user_type' => 0
  );
   $result = $this->db->insert('post',$postData);
  if($result)
  {
   $json['success'] = 0;
  }
  echo json_encode($json);
}



 function facultyDetail($userId)
 {
 $id = $this->session->userdata('id');
 $result['getadmindetail'] = $this->All_model->getadmindetail($id);
 $result['facultyDetail'] = $this->All_model->facultyDetail($userId);
 $result1 = $this->All_model->getfacultyurl($userId);
 $this->load->view('faculty/facultyDetail.php',array('result' => $result,'result1' => $result1));
 }

 public function invoice() {
        $id = $this->session->userdata('faculty_id');
        $result['getadmindetail'] = $this->All_model->getadmindetail($id);
        $subid = $result['getadmindetail']->subject_id;
        $data['empInfo'] = $this->All_model->allStudentInvoice2($subid);
        $this->load->view('faculty/invoice.php',array('result' => $result,'data'=>$data));
    }

     public function createXLS($stuid) {

        $fileName = 'data-' . time() . '.xlsx';
        // load excel library
        $this->load->library('excel');
        $empInfo = $this->All_model->allStudentInvoiceExcel($stuid);
      
       // echo "<pre>";print_r($empInfo);die;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Invoice No.');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Faculty Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Order No.');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Student Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Address Of Student');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Gross Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Taxable Amount');
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
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['order_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['first_name'].$element['last_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['address']);
           
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['net_amount']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['tax_rate']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $cgst);
             $objPHPExcel->getActiveSheet()->SetCellValue('J'. $rowCount,$cgst);
            $rowCount++;
        }
      //  echo ROOT_UPLOAD_IMPORT_PATH;exit;
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save(ROOT_UPLOAD_IMPORT_PATH . $fileName);
        // download file
        header("Content-Type: application/vnd.ms-excel");
        redirect(HTTP_UPLOAD_IMPORT_PATH . $fileName);
    }

        public function deletetestquestion() {
        $json = array();
        $id = $this->input->post('id');
        $result = $this->All_model->deletetesquestion($id);
        if($result){
        $json['msg'] = 'success';  
        }
        header('Content-Type: application/json');
        echo json_encode($json);
    }

}