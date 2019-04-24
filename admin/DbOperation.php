<?php
class DbOperation
{
    private $con;

    function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        require_once dirname(__FILE__) . '/Mailin.php';
        $db = new DbConnect();
        $this->con = $db->connect();
    }

       //Method to fetch all countries from database
    public function getAllCollege(){
        $stmt = $this->con->prepare("SELECT * FROM college_master");
        $stmt->execute();
        $countries = $stmt->get_result();
        $stmt->close();
        return $countries;
    }

     //Method to fetch all subjects from database
    public function getAllSubject(){
        $stmt = $this->con->prepare("SELECT * FROM subject_master");
        $stmt->execute();
        $subjects = $stmt->get_result();
        $stmt->close();
        return $subjects;
    }

     //Method to register a new user
    public function registerstudent($name,$email,$contact_num,$password,$college,$year,$socialid,$regtype,$imageurl){
        $user = $this->isUserExistsActive($email,$contact_num);
        if (!empty($user)) { 
        if($user['email']==$email){
        return array(2);
        } 
        else if($user['contact_no']==$contact_num){
        return array(3);
        }
        }
        else{
          
            $password = md5(SALT . $password);
            $created_date = CREATED_DATE;
            $address = '';
            $status = 0;
         
         
             $stmt = $this->con->prepare("INSERT INTO `medi_registered_students`(`name` ,`email`,`contact_no`,`password`,`college_id`,`mbbs_year`,`social_id`,`registration_type`,`image_url`,`status`,`address`,`created_date`) VALUES('".$name."','".$email."','".$contact_num."','".$password."','".$college."','".$year."','".$socialid."','".$regtype."','".$imageurl."','".$status."','".$address."','".$created_date."')");
            
            $result = $stmt->execute();
            $lastinsertid = mysqli_insert_id($this->con);
            $stmt->close();
            $OTP = mt_rand(1000, 9999);
       
        
            $bodymsg = 'Thank you for registering with medivarsity - Online tutorials hub for medical students. To get started kindly enter otp <strong>' . $OTP . '</strong> and enjoy innovative professional networking service for free. Kindly complete your profile for better results.

Regards, 
Team medivarsity';
$subject = 'Medivarsity - Otp Verification';
            $statussms = $this->SendsmsOtp($OTP,$email,$contact_num,$name,$bodymsg);
    
            $statusmail = $this->SendmailOtp($OTP,$email,$contact_num,$name,$bodymsg,$subject);
           
            //otp 
            if(!empty($statussms && $statusmail)){
          
            $stmt = $this->con->prepare("INSERT INTO student_otp(otp,contact_num,student_id,created_date) values(?,?,?,?)");
            $stmt->bind_param("ssss",$OTP,$contact_num,$lastinsertid,$created_date);
            
            $resultotp = $stmt->execute();
            $stmt->close();

           /* $delete = (time() - 1800);
            $stmt = $this->con->prepare("DELETE FROM student_otp WHERE created_date < ?");
            $stmt->bind_param("s",$delete);
         
            $resultotp = $stmt->execute();
            $stmt->close();*/
            }

            if ($result) {
                $ret = array(0,$lastinsertid);
                return $ret;
            } else {
                return array(1);
            }
        }
       
    }

     //Method to resend otp
    public function resendotp($student_id){
        if ($this->isUserExistsbyid($student_id)) {
           $stmt = $this->con->prepare("SELECT * from medi_registered_students WHERE student_id = ?");
           $stmt->bind_param("s", $student_id);
           $stmt->execute();
           $userdetails = $stmt->get_result()->fetch_assoc();

           $stmt = $this->con->prepare("SELECT * from student_otp WHERE student_id = ?");
           $stmt->bind_param("s", $student_id);
           $stmt->execute();
           $otpdetails = $stmt->get_result()->fetch_assoc();
           $created_date = CREATED_DATE;

            $name = $userdetails['name'];
            $lastinsertid = $userdetails['student_id'];
            $OTP = $otpdetails['otp'];
            $email = $userdetails['email'];
            $contact_num = $userdetails['contact_no'];
            $bodymsg = 'Thank you for registering with medivarsity - Online tutorials hub for medical students. To get started kindly enter otp ' . $OTP . ' and enjoy innovative professional networking service for free. Kindly complete your profile for better results.

Regards, 
Team medivarsity';
$subject = 'Medivarsity - Otp';
            $statussms = $this->SendsmsOtp($OTP,$email,$contact_num,$name,$bodymsg);
    
            $statusmail = $this->SendmailOtp($OTP,$email,$contact_num,$name,$bodymsg,$subject);
 
            $stmt->close();
           

            if ($statussms) {
                $ret = 0;
                return $ret;
            } else {
                return 1;
            }
        }else{
         return 2;

        } 
    }


  //Method to verify otp
    public function verifyotp($student_id,$otp){
        if ($this->isUserExistsbyid($student_id)) {
           $stmt = $this->con->prepare("SELECT * from medi_registered_students WHERE student_id = ?");
           $stmt->bind_param("s", $student_id);
           $stmt->execute();
           $userdetails = $stmt->get_result()->fetch_assoc();
           $stmt = $this->con->prepare("SELECT * from student_otp WHERE student_id = ?");
           $stmt->bind_param("s", $student_id);
           $stmt->execute();
           $otpdetails = $stmt->get_result()->fetch_assoc();
           $created_date = CREATED_DATE;

           $contact_num = $userdetails['contact_no'];
           $email = $userdetails['email'];
           $name = $userdetails['name'];
           if(!empty($otpdetails) && $otpdetails['otp'] == $otp){
            $stmt = $this->con->prepare("UPDATE medi_registered_students SET status = 1 WHERE student_id = ?");
            $stmt->bind_param("i",$student_id);
            $result = $stmt->execute();
            $stmt->close();

           
            $bodymsg = 'Thank you for activating your account with medivarsity - Online tutorials hub for medical students.

Regards, 
Team medivarsity';
$subject = 'medivarsity - Login Mail';
            $statussms = $this->SendsmsOtp($otp,$email,$contact_num,$name,$bodymsg);
    
            $statusmail = $this->SendmailOtp($otp,$email,$contact_num,$name,$bodymsg,$subject);
 
          
           

            if ($statussms) {
           $stmt = $this->con->prepare("SELECT * from medi_registered_students WHERE student_id = ?");
           $stmt->bind_param("s", $student_id);
           $stmt->execute();
           $userdetails = $stmt->get_result()->fetch_assoc();
                $ret = 0;
                return array($ret,$userdetails);
            } else {
                return array(1);
            }
        }else{
        return array(3);    
        }
        }else{
         return array(2);

        } 
    }
      //Method to login user
    public function loginstudent($username,$password,$login_type,$social_id,$device_type,$device_id){
        if($login_type == 1){
        $status = 1;
        $password = md5(SALT . $password);
        $stmt = $this->con->prepare("SELECT student_id,name,email,contact_no,status from medi_registered_students WHERE social_id = ? AND status = ?");
        $stmt->bind_param("ss", $social_id,$status);
        $stmt->execute();
        $userdetails = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        }else if($login_type == 0){
        $status = 1;
        $password = md5(SALT . $password);
        $stmt = $this->con->prepare("SELECT student_id,name,email,contact_no,status from medi_registered_students WHERE email = ? OR contact_no = ? AND password = ? AND status = ?");
        $stmt->bind_param("ssss", $username,$username,$password,$status);
        $stmt->execute();
        $userdetails = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        }
        if(!empty($userdetails)){

        $stmt = $this->con->prepare("SELECT * from device_details WHERE student_id = ?");
        $stmt->bind_param("s", $userdetails['student_id']);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();  
        if(!empty($user)){
        $stmt = $this->con->prepare("UPDATE device_details SET device_id = ? WHERE device_type = ?");
        $stmt->bind_param("ss", $device_id,$device_type);
        $result = $stmt->execute();
        $stmt->close();
        }else{
        $stmt = $this->con->prepare("INSERT INTO device_details(student_id,device_id,device_type) values(?,?,?)");
        $stmt->bind_param("sss", $userdetails['student_id'],$device_id,$device_type);
        $result = $stmt->execute();
        $stmt->close();
        }


        $stmt = $this->con->prepare("SELECT * from authentication_token WHERE student_id = ?");
        $stmt->bind_param("s", $userdetails['student_id']);
        $stmt->execute();
        $auth = $stmt->get_result()->fetch_assoc();  
        $authtoken = $auth['auth_token'];
        if(empty($auth)){  
        $uniqueid = uniqid();
        $stmt = $this->con->prepare("INSERT INTO authentication_token(student_id,auth_token) values(?,?)");
        $stmt->bind_param("ss", $userdetails['student_id'],$uniqueid);
        $result = $stmt->execute();
        $stmt->close();
        $authtoken = $auth['auth_token'];
        }
        return array($userdetails,$authtoken);
        }else{
        return array(1);  
        }
    }

     //Method to login user
    public function forgotpassword($email){
        $status = 1;
        $stmt = $this->con->prepare("SELECT * from medi_registered_students WHERE email = ? AND status = ?");
        $stmt->bind_param("ss", $email,$status);
        $stmt->execute();
        $userdetails = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if(!empty($userdetails)){
        $usrpass=$this->random_string(8);
        $password = md5(SALT . $usrpass); 
        $bodymsg = 'Your password for your email id is <strong>'.$usrpass.'</strong>

Regards, 
Team Medivarsity';
            $subject = 'mediversity - Forgot Password';
            $statusmail = $this->SendmailOtp($otp=null,$email,$contact_num=null,$userdetails['name'],$bodymsg,$subject);
            
        }
        echo $statusmail;exit;
            if($statusmail){
            $stmt = $this->con->prepare("UPDATE medi_registered_students SET password = ? WHERE student_id = ?");
            $stmt->bind_param("ss", $password,$userdetails['student_id']);
            $result = $stmt->execute();
            $stmt->close();
            
            
            return 1;    
            }else{

            return 0;    
            }
    }

      //Method to home
  /*  public function home($authtoken){
        $response = array();
        $status = 1;
        $auth = $this->istokenexists($authtoken);
        if (!empty($auth)) { 
        $student_id = $auth['student_id'];

        $stmt = $this->con->prepare("SELECT * from intro_url");
        $stmt->execute();
        $intro = $stmt->get_result()->fetch_assoc(); 
        $introurl = $intro['intro_url'];
        $response['introurl'] = $introurl;
        $stmt = $this->con->prepare("SELECT * from daily_updates WHERE status = ?");
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $dailyupdates = $stmt->get_result(); 
        $response['subjects']['dailyupdates'] = array();
        while($row = $dailyupdates->fetch_assoc()){
        $temp = array();
        $temp['title'] = $row['title'];
        $temp['url'] = $row['url'];
        array_push($response['subjects']['dailyupdates'],$temp);
        }

        $stmt = $this->con->prepare("SELECT sm.id as subject_id,sm.subject_name, sd.subject_description, sd.subject_features from subject_master as sm 
        LEFT JOIN subject_details as sd  ON sd.subject_id = sm.id ");
        $stmt->execute();
        $subjectlist = $stmt->get_result();
        $subject = array();
        while($row = $subjectlist->fetch_assoc()){
        $temp = array();
        $temp['subject_id'] = $row['subject_id'];
        $temp['subject_name'] = $row['subject_name'];
        $temp['subject_description'] = $row['subject_description'];
        $temp['subject_features'] = $row['subject_features'];
        array_push($subject,$temp);

        }
       
        foreach($subject as $element){
        $videotype = 0;
        $status = 1;
        $stmt = $this->con->prepare("SELECT * from subscription_details WHERE subject_id = ? AND student_id = ? AND status = ?");
        $stmt->bind_param("sss", $element['subject_id'],$student_id,$status);
        $stmt->execute();
        $subscription = $stmt->get_result();
        if(!empty($subscription)){
        $subs = 'subscribed';
        $videotype = 1;    
        }else{
        $subs = 'subscribe';
        $videotype = 0;    
        }
        $stmt = $this->con->prepare("SELECT * from lecture_videos WHERE subject_id = ? AND video_type = ? AND status = ?");
        $stmt->bind_param("sss", $element['subject_id'],$videotype,$status);
        $stmt->execute();
        $videolist = $stmt->get_result();

        $response['subjects'][$element['subject_name']] = array();
        while($row = $videolist->fetch_assoc()){
        $temp = array();
        $temp['video_url'] = $row['video_url'];
        $temp['video_image_url'] = $row['video_image_url'];
        $temp['video_type'] = $row['video_type'];
        array_push($response['subjects'][$element['subject_name']],$temp);
        }
        }
        return array(0,$response);
        }
        else{
            return array(1);
            }
       
       
    }*/

 
public function home($authtoken){
        $response = array();
        $status = 1;
        $auth = $this->istokenexists($authtoken);
        if (!empty($auth)) { 
        $student_id = $auth['student_id'];

        $stmt = $this->con->prepare("SELECT * from intro_url");
        $stmt->execute();
        $intro = $stmt->get_result()->fetch_assoc(); 
        $introurl = $intro['intro_url'];
        $response['introurl'] = $introurl;
        $stmt = $this->con->prepare("SELECT * from daily_updates WHERE status = ?");
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $dailyupdates = $stmt->get_result(); 
        $response['dailyupdates'] = array();
        while($row = $dailyupdates->fetch_assoc()){
        $temp = array();
        $temp['title'] = $row['title'];
        $temp['url'] = $row['url'];
        array_push($response['dailyupdates'],$temp);
        }
        

        //subjects
        $stmt = $this->con->prepare("SELECT sm.id as subject_id,sm.subject_name, sd.subject_description, sd.subject_features from subject_master as sm 
        LEFT JOIN subject_details as sd  ON sd.subject_id = sm.id ");
        $stmt->execute();
        $subjectlist = $stmt->get_result();
        $subject = array();
        $subjects = mysqli_fetch_all ($subjectlist, MYSQLI_ASSOC);
       
       
        foreach($subjects as $element){
        $status = 1;        
        $stmt = $this->con->prepare("SELECT * from subscription_details WHERE subject_id = ? AND student_id = ? AND status = ?");
        $stmt->bind_param("sss", $element['subject_id'],$student_id,$status);
        $stmt->execute();
        $subscription = $stmt->get_result()->fetch_assoc();
        if(!empty($subscription)){
        $subs = 1;
        $videotype = 1;    
        }else{
        $subs = 0;
        $videotype = 0;    
        }
        $stmt = $this->con->prepare("SELECT * from lecture_videos WHERE subject_id = ? AND video_type = ? AND status = ? LIMIT 10");
        $stmt->bind_param("sss", $element['subject_id'],$videotype,$status);
        $stmt->execute();
        $videolist = $stmt->get_result();
        $videos['videos'] = mysqli_fetch_all ($videolist, MYSQLI_ASSOC);
        $subject = array('subjectname' => $element['subject_name']);
        $subscription = array('subscription' => $subs);
        $response['subjects'][] = array_merge($subject,$subscription,$videos);
        }
        return array(0,$response);
        }
        else{
            return array(1);
            }
       
       
    }


    public function lectureslist($authtoken,$topic_id){
        $status = 1;
        $auth = $this->istokenexists($authtoken);
        if (!empty($auth)) { 
        $student_id = $auth['student_id'];
       
        $status = 1;        
        $stmt = $this->con->prepare("SELECT * from subscription_details WHERE subject_id = ? AND student_id = ? AND status = ?");
        $stmt->bind_param("sss",$topic_id,$student_id,$status);
        $stmt->execute();
        $subscription = $stmt->get_result()->fetch_assoc();
        if(!empty($subscription)){
        $videotype = 1;
        $stmt = $this->con->prepare("SELECT video_title,id as video_id from lecture_videos WHERE subject_id = ? AND video_type = ? AND status = ? LIMIT 10");
        $stmt->bind_param("sss",$topic_id,$videotype,$status);
        $stmt->execute();
        $videolist = $stmt->get_result();
        $videos = mysqli_fetch_all ($videolist, MYSQLI_ASSOC);
        return array(0,$videos);
        }else{
        return array(2);
        }
        }
        else{
            return array(1);
            }
       
       
    }

    public function Topicdetails($authtoken,$topic_id){
        $response = array();
        $status = 1;
        $auth = $this->istokenexists($authtoken);
        if (!empty($auth)) { 
        $student_id = $auth['student_id'];  

        $status = 1;        
        $stmt = $this->con->prepare("SELECT * from subscription_details WHERE subject_id = ? AND student_id = ? AND status = ?");
        $stmt->bind_param("sss",$topic_id,$student_id,$status);
        $stmt->execute();
        $subscription = $stmt->get_result()->fetch_assoc();
        if(!empty($subscription)){
        $stmt = $this->con->prepare("SELECT * from subject_details WHERE subject_id = ?");
        $stmt->bind_param("s",$topic_id);
        $stmt->execute();
        $aboutsubject = $stmt->get_result();
        $about = mysqli_fetch_all ($aboutsubject, MYSQLI_ASSOC);
        foreach($about as $about);
        $subjectdetails['subjectdetails'] = array('subject_description' => $about['subject_description'],
        'subject_features' => $about['subject_features']
        );
       

        $videotype = 1;
        $stmt = $this->con->prepare("SELECT * from lecture_videos WHERE subject_id = ? AND video_type = ? AND status = ?");
        $stmt->bind_param("sss",$topic_id,$videotype,$status);
        $stmt->execute();
        $videolist = $stmt->get_result();
        $videos['videos'] = mysqli_fetch_all ($videolist, MYSQLI_ASSOC);


        $stmt = $this->con->prepare("SELECT rv.review,rv.rating,lv.video_title,mr.name as reviwername,mr.email as revieweremail,mr.image_url as reviwerimageurl from reviews as rv 
        LEFT JOIN lecture_videos as lv  ON lv.id = rv.video_id 
        LEFT JOIN medi_registered_students as mr ON mr.student_id = rv.student_id 
        WHERE rv.status = 1 AND rv.subject_id = ? ORDER BY rv.id DESC");
        $stmt->bind_param("s", $topic_id);
        $stmt->execute();
        $reviewlist = $stmt->get_result();
        $reviews['reviews'] = mysqli_fetch_all ($reviewlist, MYSQLI_ASSOC);

        $stmt = $this->con->prepare("SELECT id as test_id,test_name from test WHERE subject_id = ? AND status = ?");
        $stmt->bind_param("ss",$topic_id,$status);
        $stmt->execute();
        $testlist = $stmt->get_result();
        $test['test'] = mysqli_fetch_all ($testlist, MYSQLI_ASSOC);

        $response = array_merge($subjectdetails,$videos,$reviews,$test);
        return array(0,$response);
        }else{
        return array(2);
        }
        }
        else{
            return array(1);
            }
       
       
    }


      public function addreview($authtoken,$video_id,$topic_id,$review,$rating){
        $response = array();
        $status = 1;
        $auth = $this->istokenexists($authtoken);
        if (!empty($auth)) { 
        $student_id = $auth['student_id'];  
        $status = 1;   

        $stmt = $this->con->prepare("INSERT INTO reviews(video_id,subject_id,student_id,review,rating,status) values($video_id,$topic_id,$student_id,'".$review."',$rating,$status)");
        $result = $stmt->execute();
        $stmt->close();
        return array(0);
        }
        else{
            return array(1);
            }
       
       
    }
    
    
  
 //*********************************Common Functions ***********************//  

   //Method to check the auth token exist or not
    private function istokenExists($authtoken) {
        $stmt = $this->con->prepare("SELECT * from authentication_token WHERE auth_token = ?");
        $stmt->bind_param("s", $authtoken);
        $stmt->execute();
        $authexists = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $authexists;
    }

     //Method to check the user email or contact number already exist or not
    private function isUserExistsActive($email,$contact_num) {
        $status = 1;
        $stmt = $this->con->prepare("SELECT * from medi_registered_students WHERE status = ? AND email = ? OR contact_no = ?");
        $stmt->bind_param("sss", $status,$email,$contact_num);
        $stmt->execute();
        $userexists = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $userexists;
    }
           
     //Method to check the user email or contact number already exist or not
    private function isUserExists($email,$contact_num) {
        $status = 0;
        $stmt = $this->con->prepare("SELECT * from member WHERE status = ? AND email = ? AND contact_num = ?");
        $stmt->bind_param("sss", $status,$email,$contact_num);
        $stmt->execute();
        $userexists = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $userexists;
    }


     //Method to check the user already exist or not
    private function isUserExistsbyid($student_id) {
        $stmt = $this->con->prepare("SELECT student_id from medi_registered_students WHERE student_id = ?");
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

     //Method to check the otp existing
    private function isexistingotp($user_id,$otp_type) {
        $stmt = $this->con->prepare("SELECT id,otp from otp WHERE member_id = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $otpdetails = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $otpdetails;
    }
   
    //method to random string
    function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}


    
    //Method to create unique username
    function createUniqueUsername($table_name, $string, $field_name) 
    {   
    $strOriginal = array(" ", ".", ",", "'", "~", "*", "@", "&", "(", ")", "$", "#", "`", "/", "?", "“");
    $strReplace = array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
    $username = strtolower(str_replace($strOriginal, $strReplace, $string));
  
    $stmt = $this->con->prepare("SELECT COUNT(*) AS NumHits FROM $table_name WHERE  $field_name  LIKE CONCAT('%', ?, '%')"); 
    $stmt->bind_param("s",$username);  
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $numHits =  $result['NumHits']+1; 
    return ($numHits > 0) ? ($username . '' . $numHits) : $username;
    }

     //Method to send sms
    private function SendsmsOtp($otp,$email,$contact_num,$name,$bodymsg) {
     if($contact_num){
     $postData = array(
    'username' => 'sitanet',
    'password' => 'sitanet',
    'senderid' => 'SLGRIP',
    'route' => 10,
    'number' => $contact_num,
    'message' => ('Dear ' . $name . ', ' . $bodymsg .''));
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://94.130.51.17/http-api.php");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
                curl_setopt($ch, CURLOPT_POST, true);               
                curl_setopt($ch, CURLOPT_POSTFIELDS,$postData);
                $result = curl_exec($ch);
                curl_close($ch);
        
    }   
        if($ch){
        $status = 1;    
        }
        return $status;
    }

 //Method to send mail
    private function SendmailOtp($otp,$email,$contact_num,$name,$bodymsg,$subject) {
     $topMsg = 'Dear ' . $name;
     
            
    $body='<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width"/>
    </head>
    <body style="width:100%;height:100%;background:#efefef;-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;color:#3E3E3E;font-family:Helvetica, Arial, sans-serif;line-height:1.65;margin:0;padding:0;">
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%;background:#efefef;-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;color:#3E3E3E;font-family:Helvetica, Arial, sans-serif;line-height:1.65;margin:0;padding:0;">
            <tr>
                <td valign="top" style="display:block;clear:both;margin:0 auto;max-width:580px;">
                    <table border="0" cellpadding="0" cellspacing="0" style="width:100%;border-collapse:collapse;">
                        <tr>
                            <td valign="top" align="center" class="masthead" style="padding:20px 0;background:#03618c;color:white;">
                                <h1 style="font-size:32px;margin:0 auto;max-width:90%;line-height:1.25;"><a href="'.BASH_PATH.'" target="_blank" style="text-decoration:none;color:#ffffff;"><img border="0" src="'.BASH_PATH.'assets/images/elogo.png" alt="SoOLEGAL" title="SoOLEGAL" style="border:none;color:#ffffff;font-size:58px;line-height:52px;max-width:100%;margin:0 auto;display:block;" /></a><p style="margin-bottom:0;line-height:12px;font-weight:normal;margin-top:15px;font-size:18px;">Socially Optimized Legal</p></h1>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="content" style="background:white;padding:20px 35px 10px 35px;">
                                <h4 style="font-size:20px;margin-bottom:10px;line-height:1.25;"> '.$topMsg.',</h4>
                                '. $bodymsg.' 
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" style="display:block;clear:both;margin:0 auto;max-width:580px;">
                                <table border="0" cellpadding="0" cellspacing="0" style="width:100%;border-collapse:collapse;">
                                    <tr>
                                        <td valign="top" class="content thanksMsg" style="background:white;padding:10px 35px 20px 35px;">
                                            <p style="font-size:14px;font-weight:normal;margin-top:0;margin-bottom:5px;">Regards</p>
                                            <p style="font-size:14px;font-weight:normal;margin-top:0;margin-bottom:5px;">Team SoOLEGAL</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="content desc" style="padding:20px 35px;background:#f4f4f4;">
                                            <p style="font-weight:normal;margin-top:0;margin-bottom:10px;font-size:12px;">DID YOU KNOW your SoOLEGAL profile helps you to control your public image when people search for you?</p>
                                            <p style="font-weight:normal;margin-top:0;margin-bottom:10px;font-size:12px;">Please do not reply to this email. Emails sent to this address will not be answered.</p>
                                            <p style="font-weight:normal;margin-top:0;margin-bottom:10px;font-size:12px;"><strong>Incorrect Information</strong><br />If for any reason the information in this email is not what you signed up for, please contact us at SoOLEGAL.com within seven days of receipt of this email.</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td valign="top" style="display:block;clear:both;margin:0 auto;max-width:580px;">
                    <table border="0" cellpadding="0" cellspacing="0" style="width:100%;border-collapse:collapse;">
                        <tr>
                            <td valign="top" class="content footer" align="center" style="background:none;padding:20px 35px;">
                                <p style="margin:0;text-align:center;font-size:11px;font-weight:normal;"><strong>Connect with us</strong> <a href="https://www.facebook.com/SOciallyOptimizedLEGAL" style="-webkit-border-radius:2px;-moz-border-radius:2px;border-radius:2px;display:inline-block;color:white;border-width:0 1px;width:16px;background:#3b5998;border:solid #3b5998;text-decoration:none;font-weight:bold;height:15px;line-height:15px;">f</a> <a href="https://www.linkedin.com/company/soo-legal" style="-webkit-border-radius:2px;-moz-border-radius:2px;border-radius:2px;display:inline-block;color:white;border-width:0 1px;width:16px;background:#007bb6;border:solid #007bb6;text-decoration:none;font-weight:bold;height:15px;line-height:15px;">in</a> <a href="https://twitter.com/Soo_Legal" style="-webkit-border-radius:2px;-moz-border-radius:2px;border-radius:2px;display:inline-block;color:white;border-width:0 1px;width:16px;background:#55acee;border:solid #55acee;text-decoration:none;font-weight:bold;height:15px;line-height:15px;">t</a></p>
                                <p style="margin:0;text-align:center;font-size:11px;font-weight:normal;">Sent by <a href="'.BASH_PATH.'" style="color:#666;text-decoration:none;font-weight:bold;">SoOLEGAL</a>, B4-205 Safdarjung Enclave New Delhi 110029.</p>
                                <p style="margin:0;text-align:center;font-size:11px;font-weight:normal;">&copy; '. date('Y').' <a href="'.BASH_PATH.'" style="color:#666;text-decoration:none;font-weight:bold;">soolegal.com</a>. All rights reserved.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>';    
            
    if(!empty($email)){
    $mailin = new Mailin("https://api.sendinblue.com/v2.0","RWrkmVJSXE7gcfL1");
    $data = array( "to" => array($email=>$name),
        "from" => array("info@medivarsity.com", "medivarsity"),
        "subject" => $subject,
        "html" => $body,
       // "attachment" => array("https://domain.com/path-to-file/filename1.pdf", "https://domain.com/path-to-file/filename2.jpg")
    );
    $mailin->send_email($data);
    }                           
    $status = 'success';
    return $status;
    }
}