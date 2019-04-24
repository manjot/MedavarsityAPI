<?php
class All_model extends CI_Model
{
  public function __construct()
    {
        parent:: __construct();
        $this->load->database();
    }

    public function userId($id) {
        $this->userId = $id;
    }

    public function userName($name) {
        $this->username = $name;
    }

    public function userPass($pass) {
        $this->password = $pass;
    }

    public function userEmail($email) {
        $this->email = $email;
    }

  function login()
   { 
        $query = $this->db->get_where('medi_login_users', array('email' => $this->username,'password'=> $this->password));
        return $query->row();

      //   echo 'this is done';
      // exit;

   }

  function checkexistemail() 
  {
   $sel=$this->db->select()
                 ->get_where('medi_login_users', array('email'=>$this->email));
                 return $sel->row();
  }

  function getadmindetail($id)
   {
      $qry = $this->db->select("medi_login_users.*,subject_master.subject_name")
         ->from('medi_login_users')
         ->where('medi_login_users.user_id',$id)
         ->join('subject_master', 'subject_master.id = medi_login_users.subject_id', 'left')
         ->get();
	
     return $qry->row();
	// $this->db->last_query();
   }

  function totvideo()
  {
    $this->db->select();
    $this->db->from('lecture_videos');
    $this->db->where('status', 1);
    $sel=$this->db->count_all_results();
    return $sel;
  }

    function totfaculty()
  {
    $this->db->select();
    $this->db->from('medi_login_users');
    $this->db->where('user_type',0);
    $sel=$this->db->count_all_results();
    return $sel;
  }

    function totsubscriber()
  {
      $this->db->select();
      $this->db->from('subscription_details');
      $sel=$this->db->count_all_results();
      return $sel;
   }

  function totsubject()
  {
    $this->db->select('id');
    $this->db->from('subject_master');
    $sel=$this->db->count_all_results();
    return $sel;
  }

    function getFacultyid($email)  
    {
     $sel=$this->db->select('*')
     ->get_where('medi_login_users',array('email' => $email));
     return $sel->row();
    }
	function get_faculty_by_id($id)  
    {
     $sel=$this->db->select('*')
     ->get_where('medi_login_users',array('user_id' => $id));
     return $sel->row();
    }

   function checkExistMob($mobile)  
   {
     $sel=$this->db->select('*')
     ->get_where('medi_login_users',array('contact_no' => $mobile));
     return $sel->row();
}

   function checkExistEma($email)  
   {
     $sel=$this->db->select('*')
     ->get_where('medi_login_users',array('email' => $email));
     return $sel->row();
}

function getfacultydetail_bck()
{
  $qry = $this->db->select('medi_login_users.*, COUNT(subscription_details.subject_id) as num_students')
         ->from('medi_login_users')
         ->where('user_type',0)
         ->join('subscription_details','subscription_details.subject_id = medi_login_users.subject_id','left')
         ->group_by('subscription_detail.subject_id')
         ->get();
     return $qry->result_array();
}

function getfacultydetailSub($SubId)
{
         $this->db->select('*');
         $this->db->from('subscription_details'); 
         $this->db->where('subject_id',$SubId);
         $sel=$this->db->count_all_results();
         return $sel;
}

function getfacultydetail()
{
  $qry = $this->db->select('medi_login_users.*,subject_master.subject_name')
         ->from('medi_login_users')
         ->join('subject_master','subject_master.id = medi_login_users.subject_id','left')
         ->where('user_type',0)
		 ->order_by('medi_login_users.user_id','DESc')
         ->get();
     return $qry->result_array();
}

function getfacultydetail2()
{
    $qry = $this->db->select('medi_login_users.*')
         ->from('medi_login_users')
         ->where('user_type',0)
         ->get();
     return $qry->result_array();
}

function getsubjectdetail()
   {
    $sel = $this->db->select()
      ->from('subject_master')
      ->get();         
      return $sel->result_array();
   }

function allStudentInvoiceQQQ()
   {
    $sel = $this->db->select()
      ->from('subscription_orders')
      ->join('subscription_details','subscription_details.subject_id = subscription_orders.student_id')
      ->join('medi_login_users','medi_login_users.subject_id = subscription_details.subject_id')
      ->get();         
      return $sel->result_array();
  }

  function allStudentInvoice()
   {
    $sel = $this->db->select('subscription_details.*,subscription_orders.*,medi_login_users.name')
      ->from('subscription_details')
      ->join('medi_login_users','medi_login_users.subject_id = subscription_details.subject_id','left')
      ->join('subscription_orders','subscription_orders.student_id = subscription_details.student_id')
      ->get();         
      return $sel->result_array();
   }

  function allStudentInvoice2($subid)
   {
    $sel = $this->db->select('subscription_details.*,subscription_orders.*,medi_login_users.name')
      ->from('subscription_details')
      ->where('subscription_details.subject_id',$subid)
      ->join('medi_login_users','medi_login_users.subject_id = subscription_details.subject_id','left')
      ->join('subscription_orders','subscription_orders.student_id = subscription_details.student_id')
      ->get();         
      return $sel->result_array();
   }

    function allStudentInvoiceExcel($stuid)
   {
    $sel = $this->db->select('subscription_details.*,subscription_orders.*,medi_login_users.name')
      ->from('subscription_details')
      ->where('subscription_details.student_id',$stuid)
      ->join('medi_login_users','medi_login_users.subject_id = subscription_details.subject_id','left')
      ->join('subscription_orders','subscription_orders.student_id = subscription_details.student_id')
      ->get();         
      return $sel->result_array();
   }

function subjectwithFaculty()
   {
    $sel = $this->db->select('medi_login_users.name,subject_master.*')
      ->from('subject_master')
      ->join('medi_login_users','medi_login_users.subject_id = subject_master.id','left')
      ->get();         
      return $sel->result_array();
   }

function subjectFacultyPost()
   {
    $sel = $this->db->select('medi_login_users.name,subject_master.*,post.*')
      ->from('subject_master')
      ->join('medi_login_users','medi_login_users.subject_id = subject_master.id')
      ->join('post','post.subject_id = subject_master.id')
      ->get();         
      return $sel->result_array();
   }

function Postlistall()
   {
    $sel = $this->db->select('medi_login_users.name,post.*')
      ->from('post')
      ->join('medi_login_users','medi_login_users.user_id = post.user_id','left')
      //->join('subject_master','subject_master.id = medi_login_users.subject_id')
      ->get();         
      return $sel->result_array();
   }

    function deletepost($postid)
    {
        $this->db->where('id',$postid);
        $this->db->delete('post');
        return TRUE;
    }
	
  function get_postById($postid)
    {
        $this->db->select('*');
        $this->db->from('post');
        $this->db->where('id',$postid);
		$query=$this->db->get();
      return $query->row_array();  
    }
	
  function save_post($data)
    {
       if ($data['id'])
		{
			$this->db->where('id', $data['id']);
			$this->db->update('post', $data);
			$id	= $data['id'];
		}
		else
		{
			$this->db->insert('post', $data);
			$id	= $this->db->insert_id();
		}

		return $id;  
    }

  function approveunapprovepost($id,$status)
   {
  //  echo "<pre>";print_r($stat);die;
     $qry = $this->db->where('id', $id);
     $this->db->update('post',array('status'=> $status));
          return $qry;
   }

function deleteFaculty($userid)
  {
	 
   $this->db
        ->where('user_id',$userid)
        ->delete('medi_login_users');
         return TRUE;
  }
  
   /* student delete */
  function deleteStudent($userid)
  {
   $this->db
        ->where('student_id',$userid)
        ->delete('medi_registered_students	');
   return TRUE;
  }

function deleteSubject($subid)
  {
   $this->db
        ->where('id',$subid)
        ->delete('subject_master');
   return TRUE;
  }


 /* function getstudentdetail()
  {
     $qry = $this->db->select('medi_registered_students.*,  subscription_details.subject_id,subscription_details.student_id,medi_login_users.name as facname,medi_login_users.user_id as facid,subject_master.subject_name,college_master.college_name')
         ->from('medi_registered_students')
         ->where('user_type',0)
         ->join('subscription_details','subscription_details.student_id = medi_registered_students.student_id')
         ->join('medi_login_users','medi_login_users.subject_id = subscription_details.subject_id')
         ->join('subject_master','subject_master.id = subscription_details.subject_id')
         ->join('college_master','college_master.id = medi_registered_students.college_id')
         ->get();
     return $qry->result_array(); 
  }*/

     public function getstudentdetail() {
        $this->db->select(array('m.*', 'sd.student_id as subscribed_student','sd.subject_id as subscribed_subject','sd.hours_remaining','sm.subject_name as subject_name','ml.name as faculty_name','ml.user_id as faculty_id' ));
        $this->db->from('medi_registered_students as m');
        $this->db->join('subscription_details as sd', 'm.student_id = sd.student_id', 'left');
        $this->db->join('subject_master as sm', 'sm.id = sd.subject_id', 'left');
        $this->db->join('medi_login_users as ml', 'ml.subject_id = sm.id', 'left');
        $this->db->where('m.status', 1);
        $query = $this->db->get();
        return $query->result_array();
      }


        public function getstudentdetailwithdevice() {
        $this->db->select(array('m.*', 'sd.student_id as subscribed_student','sd.subject_id as subscribed_subject','sd.hours_remaining','sm.subject_name as subject_name','ml.name as faculty_name','ml.user_id as faculty_id','dd.device_id','dd.device_type' ));
        $this->db->from('medi_registered_students as m');
        $this->db->join('subscription_details as sd', 'm.student_id = sd.student_id', 'left');
        $this->db->join('device_details as dd', 'dd.student_id = m.student_id');
        $this->db->join('subject_master as sm', 'sm.id = sd.subject_id', 'left');
        $this->db->join('medi_login_users as ml', 'ml.subject_id = sm.id', 'left');
        $this->db->where('m.status', 1);
        $query = $this->db->get();
        return $query->result_array();
        }


      public function getstudentdetailwithdevicesubject($subject_id) {
        $this->db->select(array('m.*', 'sd.student_id as subscribed_student','sd.subject_id as subscribed_subject','sd.hours_remaining','sm.subject_name as subject_name','ml.name as faculty_name','ml.user_id as faculty_id','dd.device_id','dd.device_type' ));
        $this->db->from('medi_registered_students as m');
        $this->db->join('subscription_details as sd', 'm.student_id = sd.student_id');
        $this->db->join('device_details as dd', 'dd.student_id = m.student_id', 'left');
        $this->db->join('subject_master as sm', 'sm.id = sd.subject_id', 'left');
        $this->db->join('medi_login_users as ml', 'ml.subject_id = sm.id', 'left');
        $this->db->where('m.status', 1);
        $this->db->where('sd.subject_id', $subject_id);
        $query = $this->db->get();
        return $query->result_array();
    }
	
	/* unsscrib std */
	
		 public function getsubscribedstudentdetail() {
        $this->db->select(array('m.*', 'sd.student_id as subscribed_student','sd.hours_remaining','sd.subject_id as subscribed_subject','sm.subject_name as subject_name','ml.name as faculty_name','ml.user_id as faculty_id' ));
        $this->db->from('medi_registered_students as m');
        $this->db->join('subscription_details as sd', 'm.student_id = sd.student_id');
        $this->db->join('subject_master as sm', 'sm.id = sd.subject_id');
        $this->db->join('medi_login_users as ml', 'ml.subject_id = sm.id');
        $this->db->where('m.status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
	/* sescrib std */
	
	  public function getstudentFilterSubscrib($id) {
		  
        $this->db->select(array('m.*' ));
        $this->db->from('medi_registered_students as m');
		if(!empty($id)){
		$this->db->where_not_in('m.student_id', $id);
		}
        $this->db->where('m.status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
	

    function getstudentFilterSubject($subid)
    {
     $qry = $this->db->select('medi_registered_students.*,medi_login_users.name as facname,subject_master.subject_name,college_master.college_name,subscription_details.subject_id')
         ->from('subscription_details')
         ->where('subscription_details.subject_id',$subid)
         ->join('medi_registered_students','medi_registered_students.student_id = subscription_details.student_id')
         ->join('medi_login_users','medi_login_users.subject_id = subscription_details.subject_id')
         ->join('subject_master','subject_master.id = subscription_details.subject_id')
         ->join('college_master','college_master.id = medi_registered_students.college_id')
         ->get();
     return $qry->result_array(); 
    }

  function getfaculty($Id)
   {
    $sel = $this->db->select()
      ->from('medi_login_users')
      ->where('user_id',$Id)
      ->get();         
      return $sel->row();
   }

  function getfacultyurl($Id)
   {
	  
    $sel = $this->db->select('lecture_videos.video_url')
      ->from('medi_login_users')
      ->where('user_id',$Id)
      ->join('lecture_videos','lecture_videos.subject_id = medi_login_users.subject_id')
      ->get(); 
    
      return $sel->result_array();
   }

  function postDetail($poid)
   {
    $sel = $this->db->select('medi_login_users.name,post.*')
      ->from('post')
      ->where('id',$poid)
      ->join('medi_login_users','medi_login_users.user_id = post.user_id')
      ->get();         
      return $sel->row();
   }

    function facultyDetail($Id)
    {
		if($Id != 1)
		{
		$sel = $this->db->select('medi_login_users.*,user_bank_details.name_as_per_bank_account,user_bank_details.account_no,user_bank_details.id as bank_detail_id,user_bank_details.ifsc_code,user_bank_details.bank_name,user_bank_details.location,subject_master.subject_name')
		  ->from('medi_login_users')
		  ->where('medi_login_users.user_id',$Id)
		  ->join('user_bank_details','user_bank_details.user_id = medi_login_users.user_id','left')
		  ->join('subject_master','subject_master.id = medi_login_users.subject_id','left')
		  ->get();         
		  return $sel->row_array();
		}else
		{
		 $qry = $this->db->select("medi_login_users.*,subject_master.subject_name")
			 ->from('medi_login_users')
			 ->where('medi_login_users.user_id',$Id)
			 ->join('subject_master', 'subject_master.id = medi_login_users.subject_id', 'left')
			 ->get();
		 return $qry->row_array();
		}
    }

    function StudentDetail($subid)
    {
     $qry = $this->db->select('medi_registered_students.*,  subscription_details.subject_id,subscription_details.student_id,medi_login_users.name as facname,subject_master.subject_name,college_master.college_name')
         ->from('medi_login_users')
         ->where('medi_login_users.user_id',$subid)
         ->join('subscription_details','subscription_details.subject_id = medi_login_users.subject_id')
          ->join('medi_registered_students','medi_registered_students.student_id = subscription_details.student_id')
         ->join('subject_master','subject_master.id = subscription_details.subject_id')
         ->join('college_master','college_master.id = medi_registered_students.college_id')
         ->get();
     return $qry->result_array(); 
    }

    function StudentWiseDetail($subid)
    {
     $qry = $this->db->select('medi_registered_students.*,
      subscription_details.subject_id,subscription_details.student_id,medi_login_users.name as facname,subject_master.subject_name,college_master.college_name')
         ->from('medi_registered_students')
         ->where('medi_registered_students.student_id',$subid)
         ->join('subscription_details','subscription_details.student_id = medi_registered_students.student_id','left')
         ->join('medi_login_users','medi_login_users.subject_id = subscription_details.subject_id','left')
         ->join('subject_master','subject_master.id = subscription_details.subject_id','left')
         ->join('college_master','college_master.id = medi_registered_students.college_id')
         ->get();
     return $qry->row_array(); 
    }

    function facultyVideoList()
    {
    $sel = $this->db->select('lecture_videos.video_url,lecture_videos.video_title,lecture_videos.video_type,lecture_videos.subject_id,lecture_videos.id,medi_login_users.name')
      ->from('medi_login_users')
      ->join('lecture_videos','lecture_videos.subject_id = medi_login_users.subject_id')
      ->get();  
	   //echo"<pre>";
       //print_r($sel->result());
       //die();	  
      return $sel->result_array();
   }

   function deleteVideo($vidid)
  {
   $this->db
        ->where('id',$vidid)
        ->delete('lecture_videos');
   return TRUE;
  }

  function deleteCategory($catid)
  {
   $this->db
        ->where('id',$catid)
        ->delete('categorylist');
   return TRUE;
  }

  /* delete oriant vidio */
  function deleteoriantVideo($vidid)
  {
   $this->db
        ->where('id',$vidid)
        ->delete('daily_updates');
   return TRUE;
  }

  function editVideo($id)
  {
    $sel = $this->db->select('lecture_videos.video_url,lecture_videos.id,medi_login_users.name')
      ->from('lecture_videos')
      ->where('lecture_videos.id',$id)
      ->join('medi_login_users','medi_login_users.subject_id = lecture_videos.subject_id')
      ->get();      
      return $sel->row_array();
  }

  function updateVideo($vId,$vidUrl)
   {
     $qry = $this->db->where('id', $vId);
     $this->db->update('lecture_videos', array('video_url'=> $vidUrl));
          return $qry;
   }

    function updatepassword($password,$userid)
   {
     $qry = $this->db->where('user_id', $userid);
     $this->db->update('medi_login_users', array('password'=> $password));
     return $qry;
   }


     function editSubject($id)
  {
    $sel = $this->db->select('subject_master.id,subject_master.subject_name,medi_login_users.name')
      ->from('subject_master')
      ->where('subject_master.id',$id)
      ->join('medi_login_users','medi_login_users.subject_id = subject_master.id','left')
      ->get();      
      return $sel->row_array();
  }

    function updateSubject($subid,$sub)
   {
     $qry = $this->db->where('id', $subid);
     $this->db->update('subject_master', array('subject_name'=> $sub));
          return $qry;
   }

   /////////////////////////////////////  FACULTY MODEL START ///////////////////////////////
   
       function changepassword($session_id,$new_pass)
   {

	$update_pass=$this->db->query("UPDATE medi_login_users set pass='$new_pass'  where id='$session_id'");
	}
 

   function totvideo_fac()
  {
    $this->db->select('medi_login_users.subject_id');
    $this->db->from('medi_login_users');
    $this->db->join('lecture_videos','lecture_videos.subject_id = medi_login_users.subject_id');
    $this->db->where('medi_login_users.user_id',$this->userId);
    $sel=$this->db->count_all_results();
    return $sel;
  }

   function totinvoices($subid)
  {
      $this->db->select('subscription_details.*,subscription_orders.*,medi_login_users.name');
      $this->db->from('subscription_details');
      $this->db->where('subscription_details.subject_id',$subid);
      $this->db->join('medi_login_users','medi_login_users.subject_id = subscription_details.subject_id','left');
      $this->db->join('subscription_orders','subscription_orders.student_id = subscription_details.student_id');
      $sel=$this->db->count_all_results();       
      return $sel;
  }

  

    function totsubscriber_fac()
  {
    $this->db->select('medi_login_users.subject_id');
    $this->db->from('medi_login_users');
    $this->db->join('subscription_details','subscription_details.subject_id = medi_login_users.subject_id');
    $this->db->where('medi_login_users.user_id',$this->userId);
    $sel=$this->db->count_all_results();
    return $sel;
  }

  function getstudentdetail_fac($id)
  {
     $qry = $this->db->select('medi_registered_students.*,  subscription_details.subject_id,subscription_details.student_id,medi_login_users.name as facname,medi_login_users.user_id as facid,subject_master.subject_name,college_master.college_name')
         ->from('medi_login_users')
         ->where('user_id',$id)
         ->join('subscription_details','subscription_details.subject_id = medi_login_users.subject_id')
         ->join('medi_registered_students','medi_registered_students.student_id = subscription_details.student_id')
         ->join('subject_master','subject_master.id = subscription_details.subject_id')
         ->join('college_master','college_master.id = medi_registered_students.college_id')
         ->get();
     return $qry->result_array(); 
  }

  function getstudentFilterSubject_fac($subid)
  {
     $qry = $this->db->select('medi_registered_students.*,  subscription_details.subject_id,subscription_details.student_id,medi_login_users.name as facname,medi_login_users.user_id as facid,subject_master.subject_name,college_master.college_name')
         ->from('medi_login_users','subscription_details')
         ->where('medi_login_users.user_id',$this->userId)
         ->where('subscription_details.subject_id',$subid)
         ->join('subscription_details','subscription_details.subject_id = medi_login_users.subject_id')
         ->join('medi_registered_students','medi_registered_students.student_id = subscription_details.student_id')
         ->join('subject_master','subject_master.id = subscription_details.subject_id')
         ->join('college_master','college_master.id = medi_registered_students.college_id')
         ->get();
     return $qry->result_array(); 
  }

    function allLecture_fac($id)
   {
     $qry = $this->db->select('medi_login_users.name as facname,medi_login_users.user_id as facid,subject_master.subject_name,lecture_videos.*')
         ->from('medi_login_users')
         ->where('medi_login_users.user_id',$id)
         ->join('subject_master','subject_master.id = medi_login_users.subject_id')
         ->join('lecture_videos','lecture_videos.subject_id = medi_login_users.subject_id')
         ->get();
     return $qry->result_array(); 
   }


function getLectureVideo($vid)
{
  $sel=$this->db->select()
                 ->get_where('lecture_videos', array('id'=>$vid));
                 return $sel->row();
}

  function getTestId($vid)  
   {
     $sel=$this->db->select('*')
     ->get_where('test',array('video_id' => $vid));
     return $sel->row();
}

// function inserttestdata($testdata)
// {
//   $qry = $this->db->insert('test',$testdata);
//   return $qry();
// }

  function gettestdata($vid,$subid)  
   {
       $sel=$this->db->select()
                 ->get_where('test', array('video_id'=>$vid , 'subject_id' => $subid));
                 return $sel->row();
  }

    function getquestdata($getTestId,$qst)  
   {
       $sel=$this->db->select()
                 ->get_where('test_questions', array('test_id' => $getTestId,'test_question'=>$qst));
                 return $sel->row();
  }

function testQust($vid)
{
        $qry = $this->db->select('')
         ->from('test')
         ->where('test.video_id',$vid)
         ->join('test_questions','test_questions.test_id = test.id')
         ->get();
     return $qry->result_array(); 
	 $this->db->last_query();
}

// function allAns($id)
// {
//         $qry = $this->db->select('answer_images.question_id as img,answer_images.image_url as imgans,answer_text.question_id as txt,answer_text.option_answer as txtans')
//          ->from('medi_login_users')
//          ->where('medi_login_users.user_id',$id)
//          ->join('test','test.subject_id = medi_login_users.subject_id','left')
//          ->join('test_questions','test_questions.test_id = test.id','left')
//          ->join('answer_text','answer_text.question_id = test_questions.id','left')
//          ->join('answer_images','answer_images.question_id = test_questions.id','left')
//          ->group_by('answer_text.question_id')
//          ->group_by('answer_images.question_id')
//          ->get();
//      return $qry->result_array(); 
// }

 function allAnswerquest($qid)
 {
 $qry1 = "SELECT que.test_question,anst.option_answer,anst.correct_answer from test_questions que join answer_text anst ON anst.question_id=que.id where que.id='$qid'";
 $re1 = $this->db->query($qry1);
    $va =  $re1->result_array();
    if(!empty($va))
    {
     $_SESSION['check'] = 0;
     return $re1->result_array(); 
    }

  $qry2 = "SELECT que.test_question,ansm.image_url,ansm.correct_answer from test_questions que join answer_images ansm ON ansm.question_id=que.id where que.id='$qid'";
$re2 = $this->db->query($qry2);
    $va2 =  $re2->result_array();
    if(!empty($va2))
    {
     $_SESSION['check'] = 1;
     return $re2->result_array(); 
    }
}
 //  function testquest($vid)
 //  {
 // $qry = "SELECT test_questions.test_question,answer_text.option_answer FROM test_questions LEFT JOIN answer_text ON test_questions.id = answer_text.question_id WHERE test_questions.test_id = 49";
 //      $re = $this->db->query($qry);
 //    return $re->result_array();
 //  }
//        function testquest($tesid)
//    {
       // $this->db->select('lecture_videos.video_title,lecture_videos.video_url,test.test_name,test_questions.id as qid,test_questions.test_question,test_questions.answer_type,answer_text.option_answer as optionanswer,answer_text.correct_answer,answer_text.question_id as answqid');
       //  $this->db ->from('lecture_videos');
       //   $this->db->where_in('lecture_videos.id',$tesid);
       //   $this->db->join('test','test.video_id = lecture_videos.id');
       //   $this->db->join('test_questions','test_questions.test_id = test.id');
       //   $this->db->join('answer_text','answer_text.question_id = test_questions.id');
       //   $query1 = $this->db->get_compiled_select();

//        $this->db->select('lecture_videos.video_title,lecture_videos.video_url,test.test_name,test_questions.id as qid,test_questions.test_question,test_questions.answer_type,answer_images.image_url as optionanswer,answer_images.correct_answer,answer_images.question_id as answqid');
//          $this->db->from('lecture_videos');
//          $this->db->where_in('lecture_videos.id',$tesid);
//          $this->db->join('test','test.video_id = lecture_videos.id');
//          $this->db->join('test_questions','test_questions.test_id = test.id');
//          $this->db->join('answer_images','answer_images.question_id = test_questions.id');
//       $query2 = $this->db->get_compiled_select();

//     $query = $this->db->query($query1." UNION ".$query2);
//        return $query->result_array();
// }

  function deletetesquestion($id)
  {
   $this->db->where('id',$id)->delete('test_questions');
   $this->db->where('question_id',$id)->delete('answer_text');
   $this->db->where('question_id',$id)->delete('answer_images');
   return TRUE;
  }  
    function save_subject($data)
    {
		if ($data['id'])
		{
			$this->db->where('id', $data['id']);
			$this->db->update('subject_master', $data);

			$id	= $data['id'];
		}
		else
		{
			$this->db->insert('subject_master', $data);
			$id	= $this->db->insert_id();
		}

		return $id;
	}
	function save_subjectDetails($data)
    {
		if ($data['id'])
		{
			$this->db->where('id', $data['id']);
			$this->db->update('subject_details', $data);

			$id	= $data['id'];
		}
		else
		{
			$this->db->insert('subject_details', $data);
			$id	= $this->db->insert_id();
		}

		return $id;

	}
    function getAllSubject()
    {
      $qry = $this->db->select("subject_master.*,subject_details.subject_id,subject_details.subject_description,subject_details.subject_features,subject_details.image")
         ->from('subject_master')
         ->join('subject_details', 'subject_master.id = subject_details.subject_id')
		  ->order_by('subject_master.id', 'DESC')
         ->get();
     return $qry->result_array();
    } 
    function get_subject_by_id($subjectId)
    {
      $qry = $this->db->select("subject_master.*,subject_details.subject_id,subject_details.subject_description,subject_details.subject_features,subject_details.image,subject_details.id as subject_detail_id")
         ->from('subject_master')
         ->join('subject_details', 'subject_master.id = subject_details.subject_id')
		 ->where('subject_master.id',$subjectId)
		  ->order_by('subject_master.id', 'DESC')
         ->get();
     return $qry->row_array();
   }
   function delete_subject($id){
        $this->db->where('id',$id);
        $this->db->delete('subject_master');
		
		$this->db->where('subject_id',$id);
        $this->db->delete('subject_details');
		return true;
   }
   function get_adminPost($adminId){
	   
      $qry = $this->db->select("post.*,medi_login_users.name,medi_login_users.subject_id")->from('post')->join('medi_login_users', 'post.user_id = medi_login_users.user_id')->order_by('id', 'DESC')->get();
      return $qry->result_array();
   }

  function getpostdetails($postid){
     
      $qry = $this->db->select("*")->from('post')->where('id',$postid)->get();
      return $qry->row_array();
   }

   
   function save_faculty($data)
    {
		if ($data['user_id'])
		{
			$this->db->where('user_id', $data['user_id']);
			$this->db->update('medi_login_users', $data);

			$id	= $data['user_id'];
		}
		else
		{
			$this->db->insert('medi_login_users', $data);
			$id	= $this->db->insert_id();
		}

		return $id;
		

	}
	function save_bank_details($data)
    {
		if ($data['id'])
		{
			$this->db->where('id', $data['id']);
			$this->db->update('user_bank_details', $data);
			$id	= $data['id'];
		}
		else
		{
			$this->db->insert('user_bank_details', $data);
			$id	= $this->db->insert_id();
		}

		return $id;
	}

	function getQueryList()
    {
		$this->db->select('*');
		$this->db->from('query_details');
		$this->db->order_by('id','DESC');
		$query=$this->db->get();         
		return $query->result_array();
		
    }

  function getCatList()
    {
    $this->db->select('*');
    $this->db->from('categorylist');
    $this->db->order_by('faculty','ASC');
    $query = $this->db->get();         
    return $query->result_array();
    
  }

  function getFacltyCat(){
    $this->db->select('*');
    $this->db->from('categorylist');
    $this->db->where('cat_type',0);
    $sel = $this->db->get();
      return $sel->result_array();
  }

  function getFacultyList(){
    $this->db->select('*');
    $this->db->from('medi_login_users');
    $this->db->where('user_type',0);
    $sel = $this->db->get();
      return $sel->result_array();
  }

  function categoriesFaculty($userId){
    $this->db->select('*');
    $this->db->from('categorylist');
    $this->db->where('faculty_id', $userId);
    $sel = $this->db->get();
      return $sel->result_array();
  }


  function addCategory($data)
  {
    
    $result = $this->db->insert('categorylist', $data);
      return $this->db->insert_id();
  }

  function editCat($id){
    $this->db->select('*');
    $this->db->from('categorylist');
    $this->db->where('id', $id);
    $result = $this->db->get();

        return $result->result_array(); 
  }

  function updateCatList($id, $data){
    $this->db->where('id', $id);
    $result = $this->db->update('categorylist', $data);    
    if($result){

        return true;

    }else{

        return false;

    }
  }
	
  function delete_query($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('query_details');
        return TRUE;
    }
	/*get subject name on the bassis  of id*/
	
	function getsubject($sub_id){
		
		$q = $this->db->select('subject_name')->from('subject_master')->where('id',$sub_id)->get();
		return $q->result();
		
		
	}
	/* delete lactur vidio */
	function deletevidio($v_id){
		
		$this->db->where('id',$v_id);
        $this->db->delete('lecture_videos');
        return TRUE;
	
		
	}
	/* end */
	/* get coll */
	function getcol($colid){
		$this->db->where('id',$colid);
		$query=$this->db->get(' college_master');
		$result=$query->result();
		return $result;
	}
	/* get count total vidio for particuler facalty */
	function gettotalfacultyvidio($id){
		  $this->db->select('video_title');
         $this->db->from('lecture_videos'); 
         $this->db->where('subject_id',$id);
         $sel=$this->db->count_all_results();
         return $sel;
		
	}
	function getoriantvidio(){
		$this->db->select('*');
         $this->db->from('daily_updates'); 
         $sel=$this->db->get();
         return $sel->result();
		
	}

   public function insertnotification($name,$user_id,$title,$description,$device_type,$timestamp) {
        $data = array(
            'name' => $name,
            'user_id' => $user_id,
            'title' => $title,
            'description' => $description,
            'device_type' => $device_type,
            'created_date' => $timestamp,
        );
        $result =$this->db->insert('notifications', $data);
        return $result;
    }
   
}