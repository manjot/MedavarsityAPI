<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Clients Model FrontEnd
 *
 * @author Jaeeme
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home_model extends CI_Model {

    private $_username;
    private $_password;
   
    public function setmessage($message) {
        $this->_message = $message;
    }

    public function setstatus($status) {
        $this->_status = $status;
    }

    public function setuserName($username) {
        $this->_username = $username;
    }

    public function setpassword($password) {
        $this->_password = $password;
    }

    public function setuserid($user_id) {
        $this->_user_id = $user_id;
    }

     public function setgender($gender) {
        $this->_gender = $gender;
    }

     public function setage($age) {
        $this->_age = $age;
    }

     public function setbmi($bmi) {
        $this->_bmi = $bmi;
    }

    public function setwaist($waist) {
            $this->_waist = $waist;

    }

    public function setethnicity($ethnicity) {
            $this->_ethnicity = $ethnicity;

    }

    public function setweight($weight) {
            $this->_weight = $weight;

    }

    public function setheight($height) {
        $this->_height = $height;
    }

     public function setantihypertensives($antihypertensives) {
            $this->_antihypertensives = $antihypertensives;

    }

     public function setdiabetes($diabetes) {
            $this->diabetes = $diabetes;

    }

     public function setsmoking($smoking) {
            $this->_smoking = $smoking;

    }

     public function setstroke($stroke) {
            $this->_stroke = $stroke;

    }

     public function setdiabeticparent($diabeticparent) {
            $this->_diabeticparent = $diabeticparent;

    }

     public function setriskscore($riskscore) {
            $this->_riskscore = $riskscore;

    }

      public function setcomposite($composite) {
            $this->_composite = $composite;

    }

      public function setcompositelevel($compositelevel) {
            $this->_compositelevel = $compositelevel;

    }

      public function setcvd($cvd) {
            $this->_cvd = $cvd;

    }

      public function setcvdlevel($cvdlevel) {
            $this->_cvdlevel = $cvdlevel;

    }

      public function sett2d($t2d) {
            $this->_t2d = $t2d;

    }

      public function sett2dlevel($t2dlevel) {
            $this->_t2dlevel = $t2dlevel;

    }

      public function setckd($ckd) {
            $this->_ckd = $ckd;

    }

      public function setckdlevel($ckdlevel) {
            $this->_ckdlevel = $ckdlevel;

    }

      public function setemail($email) {
            $this->_email = $email;

    }

      public function setcontactNum($ContactNo) {
            $this->_contactNum = $ContactNo;

    }

     public function setname($name) {
            $this->_name = $name;

    }

     public function setyear($year) {
            $this->_year = $year;

    }

     public function setcollege($college) {
            $this->_college = $college;

    }

     public function setaddress($address) {
            $this->_address = $address;

    }

     public function settimestamp($timestamp) {
            $this->_timestamp = $timestamp;

    }

       public function setregistertype($registertype) {
            $this->_registertype = $registertype;

    }

     public function setcountry($country) {
            $this->_country = $country;

    }

     public function setplanid($planid) {
            $this->_planid = $planid;

    }

     public function setexpiredtimestamp($expiredtimestamp) {
            $this->_expiredtimestamp = $expiredtimestamp;

    }

    public function setstate($state) {
            $this->_state = $state;

    } 
	
	public function setamount($amount) {
            $this->_amount = $amount;

    }
	
	public function settax($amount) {
            $this->_tax = $amount;

    }
	public function setsubjectid($id) {
            $this->_subjectid = $id;

    }
	
    // do login function
    public function doLogin() {
        $this->db->select('*');
        $this->db->from('medi_registered_students');
        $this->db->where('password', $this->_password);
        $this->db->where('email', $this->_username);
        $this->db->where('status', $this->_status);

        $this->db->or_where('password', $this->_password);
        $this->db->where('contact_no', $this->_username);
        $this->db->where('status', $this->_status);
        $query = $this->db->get();
        return $query->row_array();
    }

   public function getstudentdetails() {
        $this->db->select('ms.*,cm.college_name');
        $this->db->from('medi_registered_students as ms');
        $this->db->join('college_master as cm','cm.id = ms.college_id','left');
        $this->db->where('ms.student_id',$this->_user_id);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function courseslist() {
        $this->db->select(array('sm.*','sd.*'));
        $this->db->from('subject_master as sm');
        $this->db->join('subject_details as sd','sd.subject_id = sm.id');
        $this->db->order_by('sm.id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function facultieslist() {
        $this->db->select(array('ml.*','ub.*','s.subject_name'));
        $this->db->from('medi_login_users as ml');
        $this->db->join('user_bank_details as ub','ub.user_id = ml.user_id','left');
        $this->db->join('subject_master as s','s.id = ml.subject_id','left');
        $this->db->where('ml.user_type',0);
        $query = $this->db->get();
        return $query->result_array();
    }

     public function statelist() {
        $this->db->select(array('*'));
        $this->db->from('state_master');
        $query = $this->db->get();
        return $query->result_array();
    }

     public function collegelist() {
        $this->db->select(array('*'));
        $this->db->from('college_master');
        $this->db->where('state_id',$this->_state);
        $query = $this->db->get();
        return $query->result_array();
    }

     public function insertstudent() {
        $data = array(
            'name' => $this->_name,
            'email' => $this->_email,
            'contact_no' => $this->_contactNum,
            'password' => $this->_password,
            'college_id' => $this->_college,
            'mbbs_year' => $this->_year,
            'registration_type' => 0,
            'status' => $this->_status,
            'address' => $this->_address,
            'created_date' => $this->_timestamp,
        );
        $this->db->insert('medi_registered_students', $data);
        return $this->db->insert_id();
    }

     public function insertquery() {
        $data = array(
            'name' => $this->_name,
            'email' => $this->_email,
            'contact_num' => $this->_contactNum,
            'address' => $this->_address,
            'message' => $this->_message,
        );
        $this->db->insert('query_details', $data);
        return $this->db->insert_id();
    }

     // check email id
    private function isEmail($username) {
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function isMobile($username) {
        if (is_numeric($username)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getrisk() {
        $this->db->select('*');
        $this->db->from('health_score');
        $this->db->where('user_id', $this->_user_id);
        $query = $this->db->get();
        return $query->row_array();
    }

      public function getethnicitylist() {
        $this->db->select('*');
        $this->db->from('ethincity_master');
        $query = $this->db->get();
        return $query->result_array();
    }

     public function getagerange() {
        $this->db->select('*');
        $this->db->from('age_range_master');
        $query = $this->db->get();
        return $query->result_array();
    }

      public function getagescore() {
        $this->db->select('score');
        $this->db->from('age_range_master');
        $this->db->where('id',$this->_age);
        $query = $this->db->get();
        return $query->row_array();
    }

      public function getbmiscore() {
        $this->db->select('score');
        $this->db->from('bmi_range_master');
        $this->db->where('bmi_min <=',$this->_bmi);
        $this->db->where('bmi_max >',$this->_bmi);
        $this->db->where('gender',$this->_gender);
        $query = $this->db->get();
        return $query->row_array();
    }

       public function getwaistscore() {
        $this->db->select('score');
        $this->db->from('waist_range_master');
        $this->db->where('min_waist <=',$this->_waist);
        $this->db->where('max_waist >',$this->_waist);
        $this->db->where('gender',$this->_gender);
        $query = $this->db->get();
        return $query->row_array();
    }


    

       public function getethnicityscore() {
        $this->db->select('*');
        $this->db->from('ethincity_master');
        $this->db->where('id',$this->_country);
        $query = $this->db->get();
        return $query->row_array();
    }

      public function checkhealthdata() {
        $this->db->select('*');
        $this->db->from('health_form');
        $this->db->where('user_id',$this->_user_id);
        $query = $this->db->get();
        return $query->row_array();
    }


      public function feedbacklist() {
        $this->db->select(array('f.feedback','h.name'));
        $this->db->from('feedback as f');
        $this->db->join('heal_users as h','h.user_id = f.user_id');
        $query = $this->db->get();
        return $query->result_array();
    }

       public function getEmailID() {
        $this->db->select('email,name,contact_no');
        $this->db->from('medi_registered_students');
        $this->db->where('email', $this->_email);
        $query = $this->db->get();
        return $query->row_array();
    }

       // update Password By Forgot Password
    public function updatePasswordByForgotPassword() {
            $data = array(
                'password' => $this->_password
            );
            $this->db->where('email', $this->_email);
            $this->db->update('medi_registered_students', $data);
       
    }

     public function inserthealthformdata() {
        $data = array(
            'user_id' => $this->_user_id,
            'gender' => $this->_gender,
            'ethnicity' => $this->_ethnicity,
            'ethnicity_country' => $this->_country,
            'height' => $this->_height,
            'weight' => $this->_weight,
            'waist' => $this->_waist,
            'age' => $this->_age,
            'use_of_hypertensives' => $this->_antihypertensives,
            'current_smoking' => $this->_smoking,
            'stroke' => $this->_stroke,
            'diabities' => $this->_diabeticparent,
            'created_on' => $this->_timestamp,
        );
        $this->db->insert('health_form', $data);
    }

    public function updatehealthformdata() {

         $data = array(
            'gender' => $this->_gender,
            'ethnicity' => $this->_ethnicity,
            'ethnicity_country' => $this->_country,
            'height' => $this->_height,
            'weight' => $this->_weight,
            'waist' => $this->_waist,
            'age' => $this->_age,
            'use_of_hypertensives' => $this->_antihypertensives,
            'current_smoking' => $this->_smoking,
            'stroke' => $this->_stroke,
            'diabities' => $this->_diabeticparent,
            'created_on' => $this->_timestamp,
        );
        $this->db->where('user_id', $this->_user_id);
        $this->db->update('health_form', $data);
    }

      public function updatehealthformdatastatus() {

         $data = array(
           'post_health_data_status'=>1,
        );
        $this->db->where('user_id', $this->_user_id);
        $this->db->update('heal_users', $data);
    }

    





  public function insertrisk() {
        $data = array(
            'user_id' => $this->_user_id,
            'risk_score' => $this->_riskscore,
            'composite' => $this->_composite,
            'composite_level' => $this->_compositelevel,
            'cvd' => $this->_cvd,
            'cvd_level' => $this->_cvdlevel,
            't2d' => $this->_t2d,
            't2d_level' => $this->_t2dlevel,
            'ckd' => $this->_ckd,
            'ckd_level' => $this->_ckdlevel,
            'created_date' => $this->_timestamp,
        );
        $this->db->insert('health_score', $data);
    }

    public function updaterisk() {

          $data = array(
            'risk_score' => $this->_riskscore,
            'composite' => $this->_composite,
            'composite_level' => $this->_compositelevel,
            'cvd' => $this->_cvd,
            'cvd_level' => $this->_cvdlevel,
            't2d' => $this->_t2d,
            't2d_level' => $this->_t2dlevel,
            'ckd' => $this->_ckd,
            'ckd_level' => $this->_ckdlevel,
            'created_date' => $this->_timestamp,
        );
        $this->db->where('user_id', $this->_user_id);
        $this->db->update('health_score', $data);
    }
     public function checkscorerange() {
        $this->db->select('*');
        $this->db->from('health_range_master');
        $this->db->where('min_score <=',$this->_riskscore);
        $this->db->where('max_score >=',$this->_riskscore);
        $this->db->where('gender',$this->_gender);
        $query = $this->db->get();
        return $query->row_array();
    }  

    

    public function createClients() {
        $clientName = $this->input->post('clientName');
        $emailId = $this->input->post('emailId');
        $contactNo = $this->input->post('contactNo');
        $gender = $this->input->post('gender');
        $data = array(
            'name' => $clientName,
            'email' => $emailId,
            'contactNo' => $contactNo,
            'sex' => $gender
        );
        $this->db->insert('client', $data);
    }

    public function updateClients($clientID) {

        $clientName = $this->input->post('clientName');
        $emailId = $this->input->post('emailId');
        $contactNo = $this->input->post('contactNo');
        $gender = $this->input->post('gender');
        $data = array(
            'name' => $clientName,
            'email' => $emailId,
            'contactNo' => $contactNo,
            'sex' => $gender
        );
        $this->db->where('clientID', $clientID);
        $this->db->update('client', $data);
    }

    public function getTopNewsRSSFeed() {
        // define script parameters
        //$ROARURL = "http://feeds.feedburner.com/LegallyIndia";
        $ROARURL = "http://feeds.feedburner.com/out-law-NewsRoundUP";
        $NUMITEMS = 10;
        // $TIMEFORMAT = "j F Y, g:ia";
        $CACHEFILE = "/tmp/" . md5($ROARURL);
        $CACHETIME = 4; // hours
        // download the feed iff a cached version is missing or too old
        if (!file_exists($CACHEFILE) || ((time() - filemtime($CACHEFILE)) > 3600 * $CACHETIME)) {
            if ($feed_contents = file_get_contents($ROARURL)) {
                // write feed contents to cache file
                $fp = fopen($CACHEFILE, 'w');
                fwrite($fp, $feed_contents);
                fclose($fp);
            }
        }


        $rss_parser = new myRSSParser($CACHEFILE);

        // read feed data from cache file
        $feeddata = $rss_parser->getRawOutput();
        extract($feeddata['RSS']['CHANNEL'][0], EXTR_PREFIX_ALL, 'rss');

        // display leading image
        /* if(isset($rss_IMAGE[0]) && $rss_IMAGE[0]) {
          extract($rss_IMAGE[0], EXTR_PREFIX_ALL, 'img');
          echo "<p><a title=\"{$img_TITLE}\" href=\"{$img_LINK}\"><img src=\"{$img_URL}\" alt=\"\"></a></p>\n";
          } */

        // display feed title
        /* echo "<h4><a title=\"",htmlspecialchars($rss_DESCRIPTION),"\" href=\"{$rss_LINK}\" target=\"_blank\">";
          echo htmlspecialchars($rss_TITLE);
          echo "</a></h4>\n"; */

        // display feed items
        $count = 0;
        $data = array();
        foreach ($rss_ITEM as $itemdata) {
            // strip tags to avoid breaking any html
            $content = stripslashes($itemdata['DESCRIPTION']);


            $string = preg_replace("/<img[^>]+\>/i", "", $content);
            //$itemdataLink = preg_replace('#^https?://#', '', $itemdata['LINK']);
            $itemdataLink = $itemdata['LINK'];
//echo strlen($string)."<br />";
            /* 	
              if (strlen($string) > 170) {

              // truncate string
              $stringCut = substr($string, 0, 150);

              // make sure it ends in a word so assassinate doesn't become ass...
              $string = substr($stringCut, 0, strrpos($stringCut, ' '));
              } else {
              $string = $string;
              } */


            $data[] = array(
                'link' => $itemdataLink,
                'title' => htmlspecialchars(stripslashes($itemdata['TITLE']), ENT_QUOTES),
                'description' => $string,
                'dateTime' => date(DATE_TIME_FORMAT, strtotime($itemdata['PUBDATE']))
            );
            if (++$count >= $NUMITEMS)
                break;
        }
        return $data;
        //$this->load->view('home/Home', $response);
    }

    public function getMemberRoar() {

        $this->db->select(array('m.member_id', 'COUNT(author_id) AS TotalRoar', 'm.username', 'mb.author_id', 'mpp.url as picture'));
        $this->db->from('member as m');
        $this->db->join('member_roar as mb', 'm.member_id = mb.author_id');
        $this->db->join('member_profile_picture as mpp', 'm.member_id = mpp.member_id', 'left');
        $this->db->where('m.status', $this->_status);
        $this->db->limit(2);
        $this->db->group_by('m.member_id');
        $this->db->order_by('TotalRoar', 'DESC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getMemberFollow() {

        $this->db->select(array('m.member_id', 'COUNT(member_to_id) AS TotalFollow', 'm.username', 'mf.member_to_id', 'mpp.url as picture'));
        $this->db->from('member as m');
        $this->db->join('member_follower as mf', 'm.member_id = mf.member_to_id');
        $this->db->join('member_profile_picture as mpp', 'm.member_id = mpp.member_id', 'left');
        $this->db->where('m.status', $this->_status);
        $this->db->limit(2);
        $this->db->group_by('m.member_id');
        $this->db->order_by('TotalFollow', 'DESC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getNewsMaker() {
        $this->db->select(array('m.member_id as user_id', 'm.username', 'm.first_name', 'm.last_name', 'COALESCE(SUM(m.member_id = mb.author_id),0) as roar_count', 'COALESCE(SUM(mf.member_from_id = mf.member_from_id),0) as follower_count', '(COALESCE(SUM(m.member_id = mb.author_id),0) + COALESCE(SUM(mf.member_from_id = mf.member_from_id),0)) AS total', 'mpp.url as picture', 'm.member_type'));
        $this->db->from('member as m');
        $this->db->join('member_roar as mb', 'm.member_id = mb.author_id', 'left');
        $this->db->join('member_follower as mf', 'm.member_id = mf.member_to_id', 'left');
        $this->db->join('member_profile_picture as mpp', 'm.member_id = mpp.member_id', 'left');
        $this->db->where('m.status', $this->_status);
        $this->db->where('m.member_type', 0);
        $this->db->group_by('m.member_id');
        $this->db->order_by('total', 'DESC');
        $this->db->limit(3);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function checkallsocialmedia() {
        $this->db->select(array('member_id', 'first_name', 'last_name', 'created_date', 'email'));
        $this->db->from('member');
        $this->db->order_by('created_date', 'DESC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getRealTimeMemberCount() {
        $this->db->select(array('t.id', 't.pre_registered', 't.registered'));
        $this->db->from('temp_member_count as t');
        $this->db->where('t.id', 1);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getMemberCount() {
        $this->db->select(array('count(*) as count'));
        $this->db->from('member as m');
        $query = $this->db->get();
        return $query->row_array();
    }

    // increase Register Member function
    public function increaseRegisterMember() {
        $data = array(
            'registered' => $this->_registered,
        );
        $this->db->where('id', 1);
        $this->db->update('temp_member_count', $data);
    }
    
    //  star member of lawyer
    public function getstarmemberoflawyer()
    {
        $this->db->select('*');
        $this->db->from('star_member');
        $this->db->where('type',2);
        $query = $this->db->get();
        return $query->row_array();
    }

    //  star member of student
    public function getstarmemberofstudent()
    {
        $this->db->select('*');
        $this->db->from('star_member');
        $this->db->where('type',1);
        $query = $this->db->get();
        return $query->row_array();
    }
    
       public function getglobalinitiativepartner() {
        $this->db->select(array('m.member_id as user_id', 'm.username', 'm.first_name', 'm.last_name','concat_ws(" ", TRIM(m.first_name), TRIM(m.last_name)) AS fullname', 'mpp.url as picture', 'm.member_type','gp.gip_status','mt.name as member_type'));
        $this->db->from('member as m');
        $this->db->join('gip_status as gp', 'm.member_id = gp.member_id');
        $this->db->join('member_profile_picture as mpp', 'm.member_id = mpp.member_id', 'left');
        $this->db->join('member_type as mt', 'm.member_type = mt.member_type_id', 'left');
        $this->db->where('m.status', 1);
        $this->db->where('gp.gip_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

       public function checkemail() {
        $this->db->from('medi_registered_students');
        $this->db->where('email', $this->_email);
        return $this->db->count_all_results();
    }

      public function checkContactNo() {
        $this->db->from('medi_registered_students');
        $this->db->where('contact_no', $this->_contactNum);
        return $this->db->count_all_results();
    }

       public function createuser() {
        $data = array(
            'name' => $this->_name,
            'email' => $this->_email,
            'contact_num' => $this->_contactNum,
            'password' => $this->_password,
            'registration_type' => $this->_registertype,
            'status' => $this->_status,
            'created_date' => $this->_timestamp,
            'post_health_data_status' => 0,
        );
        $this->db->insert('heal_users', $data);
        $id = $this->db->insert_id();
        return $id;
    }

        public function select_country($ethnicity)
    {
        $this->db->select('*');
        $this->db->distinct();
        $this->db->from('ethincity_master');
        $this->db->where('ethnicity_id',$ethnicity);
        $this->db->order_by('country','asc');
        $res = $this->db->get();
        return $res->result();
        }

        

         public function select_agerange($gender)
    {
        $this->db->select('*');
        $this->db->distinct();
        $this->db->from('age_range_master');
        $this->db->where('gender',$gender);
        $res = $this->db->get();
        return $res->result();
        }

         public function deleteuser()
    {
        $this->db->where('user_id',$this->_user_id);  
        $this->db->delete('heal_users');  

        $this->db->where('user_id',$this->_user_id);  
        $this->db->delete('health_form');  

        $this->db->where('user_id',$this->_user_id);  
        $this->db->delete('health_score');  
        }

          public function createsubscription() {
        $data = array(
            'user_id' => $this->_user_id,
            'plan_id' => $this->_planid,
            'subscription_type' => 0,
            'status' => $this->_status,
            'added_on' => $this->_timestamp,
            'expired_on' => $this->_expiredtimestamp,
        );
        $this->db->insert('subscription_details', $data);
    }
    
	function get_subsDetailsByStudentId(){
		$this->db->select('*');
        $this->db->from('subscription_details');
		$this->db->where('student_id',$this->session->userdata('student_id')); 
        $query = $this->db->get();
        return $query->result_array();
	}
    // function get_subsDetailsByStudentId();
	// {
	
		// $this->db->select('*');
        // $this->db->from('subscription_details');
		// $this->db->where('student_id',$this->session->userdata('student_id')); 
        // $query = $this->db->get();
        // return $query->result_array();
	// }
	public function getCourseById($courseId) {
        $this->db->select(array('sm.*','sd.*'));
        $this->db->from('subject_master as sm');
        $this->db->join('subject_details as sd','sd.subject_id = sm.id');
		$this->db->where('sm.id',$courseId); 
        $this->db->order_by('sm.id','DESC');
        $query = $this->db->get();
        return $query->row_array();
    }
	function save_order()
    {
		$data = array(
            'order_id'       => '',
            'transaction_id' => uniqid(),
            'invoice_no'     => '',
            'student_id'     => $this->_user_id,
			'subject_id'     => $this->_subjectid,
            'first_name'     => $this->_name,
            'last_name'      => '',
            'email'          => $this->_email,
            'contact_no'     => $this->_contactNum,
            'address'        => $this->_address,
            'net_amount'     => $this->_amount,
            'tax_rate'       => $this->_tax,
			'data_added'     => $this->_timestamp,
			'status'         => $this->_status,
        );
		if ($data['order_id'])
		{
			$this->db->where('order_id', $data['order_id']);
			$this->db->update('subscription_orders', $data);
			$id	= $data['order_id'];
		}
		else
		{
			$this->db->insert('subscription_orders', $data);
			$id	= $this->db->insert_id();
			if($id)
			{
				$udatatedata['order_id']=$id;
				$udatatedata['invoice_no']='MDV00-'.$id;
				$this->db->where('order_id', $udatatedata['order_id']);
			    $this->db->update('subscription_orders', $udatatedata);
			}
		}
        
		return $id;

	}
	
	public function getOrderById($id) {
        $this->db->select('*');
        $this->db->from('subscription_orders');
		$this->db->where('order_id',$id); 
        $query = $this->db->get();
        return $query->row_array();
    }
	
	function save_order_details()
    {
		
		$sdate=date('Y-m-d',$this->_timestamp);
        $edate=date('Y-m-d', strtotime($sdate .'+1 years'));
		$arrsubject=$this->check_orderBySubjectId($this->_subjectid);
		$id='';
		if(count($arrsubject)>0)
		{
			$id=$arrsubject['id'];
		}
		$data = array(
            'id'             => $id,
            'student_id'     => $this->_user_id,
			'subject_id'     => $this->_subjectid,
            'added_on'       => $this->_timestamp,
            'modified_on'    => strtotime($edate),
			'status'         => $this->_status
        );
		if ($data['id'])
		{
			$this->db->where('id', $data['id']);
			$this->db->update('subscription_details', $data);
			$id	= $data['order_id'];
		}
		else
		{
			$this->db->insert('subscription_details', $data);
			$id	= $this->db->insert_id();
			
		}
        
		return $id;

	}
	public function get_unsubscribecourses($ids)
	{
        $this->db->select(array('sm.*','sd.*'));
        $this->db->from('subject_master as sm');
        $this->db->join('subject_details as sd','sd.subject_id = sm.id');
		//$this->db->where_not_in('sd.subject_id', $ids);
		if(!empty($ids))
		{
			$this->db->where_not_in('sm.id', $ids);
		}else{
			$this->db->where_not_in('sm.id', '');
		}
		
        $this->db->order_by('sm.id','DESC');
        $query = $this->db->get();
        return $query->result_array();
		 $this->db->last_query();
    }
	public function check_orderBySubjectId($ids)
	{
	
        $this->db->select(array('so.*','sd.*'));
        $this->db->from('subscription_orders as so');
        $this->db->join('subscription_details as sd','so.subject_id = sd.subject_id');
		//$this->db->where_not_in('sd.subject_id', $ids);
		$this->db->where('so.subject_id', $ids);
		$this->db->where('so.student_id', $this->_user_id);
       
        $query = $this->db->get();
        return $query->row_array();
    }
}
