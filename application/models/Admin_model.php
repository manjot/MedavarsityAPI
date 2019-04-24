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

class Admin_model extends CI_Model {

    private $_username;
    private $_password;
   

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

     public function settimestamp($timestamp) {
            $this->_timestamp = $timestamp;

    }

       public function setregistertype($registertype) {
            $this->_registertype = $registertype;

    }

     public function setcountry($country) {
            $this->_country = $country;

    }




    // do login function
    public function doLogin() {
       // $check_email = $this->isEmail($this->_username);
       // $check_mobile = $this->isMobile($this->_username);
        $this->db->select('*');
        $this->db->from('administrator');
        $this->db->where('password', $this->_password);
        $this->db->where('username', $this->_username);
        $this->db->where('status', $this->_status);
        $query = $this->db->get();
        return $query->row_array();
    }

     public function getadmindetails() {
        $this->db->select('*');
        $this->db->from('administrator');
        $this->db->where('id', $this->_user_id);
        $query = $this->db->get();
        return $query->row_array();
    }

   public function getregistereduserscount() {
        $this->db->from('heal_users');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getactiveuserscount() {
        $this->db->from('heal_users');
        $this->db->where('status',1);
        $query = $this->db->get();
        return $query->num_rows();
    }

     public function getactiveactionplanscount() {
        $this->db->from('subscription_details');
        $this->db->where('status',1);
        $query = $this->db->get();
        return $query->num_rows();
    }

      public function getfeedbackscount() {
        $this->db->from('feedback');
        $this->db->where('status',1);
        $query = $this->db->get();
        return $query->num_rows();
    }

 

    public function getregisteredusers()
        {
        $this->db->select(array('h.*','sd.added_on','sd.expired_on','ap.plan'));
        $this->db->from('heal_users as h');
        $this->db->join('subscription_details as sd','sd.user_id = h.user_id','left');
        $this->db->join('action_plans as ap','ap.id = sd.plan_id','left');
        $this->db->where('h.status',$this->_status);
        $res = $this->db->get();
        return $res->result_array();
        }

        public function filterreguserlist()
        {

        $this->db->select(array('h.*','sd.added_on','sd.expired_on','ap.plan'));
        $this->db->from('heal_users as h');
        $this->db->join('subscription_details as sd','sd.user_id = h.user_id','left');
        $this->db->join('action_plans as ap','ap.id = sd.plan_id','left');
        if(!empty($this->_user_id)){
        if($this->_user_id == 5){
        $this->db->where('sd.expired_on >=', CREATED_DATE);
        }else{
        $this->db->where('sd.plan_id',$this->_user_id);    
        }
        }
        $this->db->where('h.status',$this->_status);
        $res = $this->db->get();
        return $res->result_array();
        }

        public function getplandetails()
        {
        $this->db->select('*');
        $this->db->distinct();
        $this->db->from('action_plans');
        $this->db->where('id',$this->_user_id);
        $res = $this->db->get();
        return $res->row_array();
        }

        

        public function deleteuser()
        {
        $this->db->where('user_id',$this->_user_id);
        $this->db->delete('heal_users');
        }

        public function deletefeedback()
        {
        $this->db->where('id',$this->_user_id);
        $this->db->delete('feedback');
        }

        public function deleteactionplan()
        {
        $this->db->where('id',$this->_user_id);
        $this->db->delete('action_plans');
        }

        public function feedbacklist() {
        $this->db->select(array('f.id','f.feedback','h.name','h.email'));
        $this->db->from('feedback as f');
        $this->db->join('heal_users as h','h.user_id = f.user_id');
        $query = $this->db->get();
        return $query->result_array();
    }

      public function filterfeedbacklist() {
        $this->db->select(array('f.id','f.feedback','h.name','h.email'));
        $this->db->from('feedback as f');
        $this->db->join('heal_users as h','h.user_id = f.user_id');
        if(!empty($this->_user_id)){
        $this->db->where('quote_id',$this->_user_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

      public function getuserpersonalinformation() {
        $this->db->select(array('h.name','h.email','h.contact_num','hf.height','hf.weight','hf.waist','hf.use_of_hypertensives','hf.current_smoking','hf.stroke','hf.diabities','h.image_url','hf.ethnicity','hf.gender','em.country','em.males','em.females','ag.age_range'));
        $this->db->from('heal_users as h');
        $this->db->join('health_form as hf','h.user_id = hf.user_id','left');
        $this->db->join('ethincity_master as em','em.id = hf.ethnicity','left');
        $this->db->join('age_range_master as ag','ag.id = hf.age','left');
        $this->db->where('h.user_id',$this->_user_id);
        $query = $this->db->get();
        return $query->row_array();
    }

     public function getallnotificationsusers() {
        $this->db->select(array('h.name','h.email','h.contact_num','hf.*'));
        $this->db->from('heal_users as h');
        $this->db->join('heal_device_details as hf','h.user_id = hf.user_id');
        if(!empty($this->_user_id)){
        $this->db->where_in('h.user_id',$this->_user_id);    
        }
        $query = $this->db->get();
        return $query->result_array();
    }

      public function quotelist() {
        $this->db->select(array('*'));
        $this->db->from('feedback_master');
        $query = $this->db->get();
        return $query->result_array();
    }

        public function actionplanlist() {
        $this->db->select(array('*'));
        $this->db->from('action_plans');
        $query = $this->db->get();
        return $query->result_array();
    }

      public function createactionplan($plan,$plan_description,$plan_duration,$price) {
        $data = array(
            'plan' => $plan,
            'plan_description' => $plan_description,
            'duration' => $plan_duration,
            'price' => $price,
            'status' => 1,
        );
        $result =$this->db->insert('action_plans', $data);
        return $result;
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
    

     public function updateplan($id,$plan,$plan_description,$plan_duration,$price) {
        $data = array(
            'plan' => $plan,
            'plan_description' => $plan_description,
            'duration' => $plan_duration,
            'price' => $price,
            'status' => 1,
        );
        $this->db->where('id',$id);
        $result =$this->db->update('action_plans', $data);
        return $result;
    }

    
    

}
