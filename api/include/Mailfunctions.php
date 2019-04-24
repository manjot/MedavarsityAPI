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
    public function getAllCountryList(){
        $stmt = $this->con->prepare("SELECT * FROM countries");
        $stmt->execute();
        $countries = $stmt->get_result();
        $stmt->close();
        return $countries;
    }

       //Method to fetch all states according to country from database
    public function getAllStateList($country_id){
        $stmt = $this->con->prepare("SELECT * FROM states WHERE country_id=?");
        $stmt->bind_param("i",$country_id);
        $stmt->execute();
        $states = $stmt->get_result();
        $stmt->close();
        return $states;
    }
   
     //Method to fetch all cities accoring to country from database
    public function getAllCityList($state_id){
      $stmt = $this->con->prepare("SELECT * FROM cities WHERE state_id=?");
      $stmt->bind_param("i",$state_id);
      $stmt->execute();
      $cities = $stmt->get_result();
      $stmt->close();
      return $cities;
    }

     //Method to register a new user
    public function registeruser($fullname,$email,$contact_num,$password){
        $user = $this->isUserExistsActive($email,$contact_num);
        if (!empty($user) && $user['status'] == 1) { 
        if($user['email']==$email){
        return array(2);
        } 
        else if($user['contact_num']==$contact_num){
        return array(3);
        }
        }
        else{
            $password = md5(SALT . $password);
            $verificationCode = uniqid();
            $rLink = BASH_PATH.'login?usid=' . urlencode(base64_encode($verificationCode));
            $username = $this->createUniqueUsername('member',trim($fullname), 'username');
            $created_date = CREATED_DATE;
            $custom_url = '';
            $last_name = '';
            $status = 0;
            $public = 1;
            $member_type = 13;

            if(!empty($this->isUserExists($email,$contact_num))) { 
            $user = $this->isUserExists($email,$contact_num);
            $lastinsertid = $user['member_id'];
            $result = 1;
            }else{
         
            $stmt = $this->con->prepare("INSERT INTO member(username,custom_url,first_name,last_name,contact_num,email,password,status,public,created_date,member_type,verification_code) values(?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssssssssssss",$username,$custom_url,$fullname,$last_name,$contact_num,$email,$password,$status,$public,$created_date,$member_type,$verificationCode);
            
            $result = $stmt->execute();
            $lastinsertid = mysqli_insert_id($this->con);
            $stmt->close();
            }
            $OTP = mt_rand(1000, 9999);
            $bodymsg = 'Thank you for registering with grip.com - Online Social Value Platform for Lawyers. To get started kindly enter otp ' . $OTP . ' and enjoy innovative professional networking service for free. Kindly complete your profile for better results.

Regards, 
Team SoOLegal';
$subject = 'GRIP - Otp';
            $statussms = $this->SendsmsOtp($OTP,$email,$contact_num,$fullname,$bodymsg);
    
            $statusmail = $this->SendmailOtp($OTP,$email,$contact_num,$fullname,$bodymsg,$subject);
           
            //otp 
            if(!empty($statussms && $statusmail)){
            $otp_type = 2;
            $status = 1;
            $existingotp = $this->isexistingotp($lastinsertid,$otp_type);
            if(empty($existingotp)){
               $stmt = $this->con->prepare("INSERT INTO otp(otp,contact_num,member_id,otp_type,created_date,status) values(?,?,?,?,?,?)");
            $stmt->bind_param("ssssss",$OTP,$contact_num,$lastinsertid,$otp_type,$created_date,$status);
            
            $resultotp = $stmt->execute();
            $stmt->close();
   
            }  
         
            
            //delete otp
            $delete = (time() - 1800);
            $stmt = $this->con->prepare("DELETE FROM otp WHERE created_date < ?");
            $stmt->bind_param("s",$delete);
         
            $resultotp = $stmt->execute();
            $stmt->close();
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
    public function resendotp($user_id){
        if ($this->isUserExistsbyid($user_id)) {
           
           $stmt = $this->con->prepare("SELECT * from member WHERE member_id = ?");
           $stmt->bind_param("s", $user_id);
           $stmt->execute();
           $userdetails = $stmt->get_result()->fetch_assoc();

           $stmt = $this->con->prepare("SELECT * from otp WHERE member_id = ?");
           $stmt->bind_param("s", $user_id);
           $stmt->execute();
           $otpdetails = $stmt->get_result()->fetch_assoc();
           $created_date = CREATED_DATE;

            $fullname = $userdetails['first_name'];
            $lastinsertid = $userdetails['member_id'];
            $OTP = $otpdetails['otp'];
            $email = $userdetails['email'];
            $contact_num = $userdetails['contact_num'];
            $bodymsg = 'Thank you for registering with grip.com - Online Social Value Platform for Lawyers. To get started kindly enter otp ' . $OTP . ' and enjoy innovative professional networking service for free. Kindly complete your profile for better results.

Regards, 
Team SoOLegal';
$subject = 'GRIP - Otp';
            $statussms = $this->SendsmsOtp($OTP,$email,$contact_num,$fullname,$bodymsg);
    
            $statusmail = $this->SendmailOtp($OTP,$email,$contact_num,$fullname,$bodymsg,$subject);
 
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
    public function verifyotp($user_id,$otp){
        if ($this->isUserExistsbyid($user_id)) {
           
           $stmt = $this->con->prepare("SELECT * from member WHERE member_id = ?");
           $stmt->bind_param("s", $user_id);
           $stmt->execute();
           $userdetails = $stmt->get_result()->fetch_assoc();
           $stmt = $this->con->prepare("SELECT * from otp WHERE member_id = ?");
           $stmt->bind_param("s", $user_id);
           $stmt->execute();
           $otpdetails = $stmt->get_result()->fetch_assoc();
           $created_date = CREATED_DATE;

           $contact_num = $userdetails['contact_num'];
           $email = $userdetails['email'];
           $fullname = $userdetails['first_name'];
           if(!empty($otpdetails) && $otpdetails['otp'] == $otp){
            $stmt = $this->con->prepare("UPDATE member SET status = 1, verification_code = 1 WHERE member_id = ?");
            $stmt->bind_param("i",$user_id);
            $result = $stmt->execute();
            $stmt->close();

           }
            $bodymsg = 'Thank you for activating your account with grip - Online Social Value Platform for Lawyers.

Regards, 
Team SoOLegal';
$subject = 'GRIP - Login Mail';
            $statussms = $this->SendsmsOtp($otp,$email,$contact_num,$fullname,$bodymsg);
    
            $statusmail = $this->SendmailOtp($otp,$email,$contact_num,$fullname,$bodymsg,$subject);
 
          
           

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
      //Method to login user
    public function loginuser($email,$password){
        $status = 1;
        $password = md5(SALT . $password);
        $stmt = $this->con->prepare("SELECT * from member WHERE email = ? AND password = ? AND status = ?");
        $stmt->bind_param("sss", $email,$password,$status);
        $stmt->execute();
        $userdetails = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if(!empty($userdetails)){
        return $userdetails;
        }
    }

     //Method to login user
    public function forgotpassword($email){
        $status = 1;
        $stmt = $this->con->prepare("SELECT * from member WHERE email = ? AND status = ?");
        $stmt->bind_param("ss", $email,$status);
        $stmt->execute();
        $userdetails = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if(!empty($userdetails)){
        $bodymsg = 'Your password for your email id is '.$userdetails['password'].'

Regards, 
Team SoOLegal';
            $subject = 'GRIP - Forgot Password';
            $statusmail = $this->SendmailOtp($otp=null,$email,$contact_num=null,$userdetails['first_name'],$bodymsg,$subject);
            
        }
        if($statusmail){
       
            return 1;    
            }else{

            return 0;    
            }
    }

    

 //*********************************Common Functions ***********************//   
     //Method to check the user email or contact number already exist or not
    private function isUserExistsActive($email,$contact_num) {
        $status = 1;
        $stmt = $this->con->prepare("SELECT * from member WHERE status = ? AND email = ? OR contact_num = ?");
        $stmt->bind_param("sss", $status,$email,$contact_num);
        $stmt->execute();
        $userexists = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $userexists;
    }
           
     //Method to check the user email or contact number already exist or not
    private function isUserExists($email,$contact_num) {
        $status = 0;
        $stmt = $this->con->prepare("SELECT * from member WHERE status = ? AND email = ? OR contact_num = ?");
        $stmt->bind_param("sss", $status,$email,$contact_num);
        $stmt->execute();
        $userexists = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $userexists;
    }


     //Method to check the user already exist or not
    private function isUserExistsbyid($user_id) {
        $stmt = $this->con->prepare("SELECT member_id from member WHERE member_id = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

     //Method to check the otp existing
    private function isexistingotp($user_id,$otp_type) {
        $stmt = $this->con->prepare("SELECT id from otp WHERE member_id = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    


    
    //Method to create unique username
    function createUniqueUsername($table_name, $string, $field_name) 
    {   
    $strOriginal = array(" ", ".", ",", "'", "~", "*", "@", "&", "(", ")", "$", "#", "`", "/", "?", "“");
    $strReplace = array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
    $username = strtolower(str_replace($strOriginal, $strReplace, $string));
    $stmt = $this->con->prepare("SELECT COUNT(*) AS NumHits FROM $table_name WHERE  $field_name  LIKE CONCAT( ?, '%')"); 
    $stmt->bind_param("s",$username);  
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $numHits =  $result['NumHits']+1; 
    return ($numHits > 0) ? ($username . '' . $numHits) : $username;
    }

     //Method to send sms
    private function SendsmsOtp($otp,$email,$contact_num,$fullname,$bodymsg) {
     if($contact_num){
     $postData = array(
    'username' => 'sitanet',
    'password' => 'sitanet',
    'senderid' => 'SLGRIP',
    'route' => 2,
    'number' => $contact_num,
    'message' => urlencode('Dear ' . $fullname . ', ' . $bodymsg .''));
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
    private function SendmailOtp($otp,$email,$contact_num,$fullname,$bodymsg,$subject) {
     $topMsg = 'Dear ' . $fullname;
     
            
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
    $data = array( "to" => array($email=>$fullname),
        "from" => array("info@soolegal.com", "GRIP"),
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