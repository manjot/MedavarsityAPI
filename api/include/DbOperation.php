  <?php
// define('SITEURL','localhost/medivarsity/api');
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
    public function getAllState(){
        $stmt = $this->con->prepare("SELECT * FROM state_master");
        $stmt->execute();
        $statelist = $stmt->get_result();
        $statelist = mysqli_fetch_all ($statelist, MYSQLI_ASSOC);
        $stmt->close();
        return $statelist;
    }

     //Method to fetch all subjects from database
    public function getAllSubject(){
        $stmt = $this->con->prepare("SELECT sm.id,sm.subject_name, sd.image as subject_image from subject_master as sm 
        LEFT JOIN subject_details as sd  ON sd.subject_id = sm.id ");
        $stmt->execute();
        $subjects = $stmt->get_result();
        return $subjects;
    }

     //Method to register a new user
    public function registerstudent($name,$email,$contact_num,$password,$college,$year,$gender,$socialid,$regtype,$imageurl,$device_id,$device_type){
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
         
         
             $stmt = $this->con->prepare("INSERT INTO `medi_registered_students`(`name` ,`email`,`contact_no`,`gender`,`password`,`college_id`,`mbbs_year`,`social_id`,`registration_type`,`image_url`,`status`,`address`,`created_date`) VALUES('".$name."','".$email."','".$contact_num."','".$gender."','".$password."','".$college."','".$year."','".$socialid."','".$regtype."','".$imageurl."','".$status."','".$address."','".$created_date."')");
            
            $result = $stmt->execute();
            $lastinsertid = mysqli_insert_id($this->con);
            $stmt->close();

            $stmt = $this->con->prepare("INSERT INTO device_details(student_id,device_id,device_type) values(?,?,?)");
            $stmt->bind_param("sss", $lastinsertid,$device_id,$device_type);
            $result = $stmt->execute();
            $stmt->close();

            $OTP = mt_rand(1000, 9999);
       
              //userdetails
        $stmt = $this->con->prepare("SELECT student_id,contact_no from medi_registered_students WHERE student_id = ?");
        $stmt->bind_param("s", $lastinsertid);
        $stmt->execute();
        $studentdetail = $stmt->get_result()->fetch_assoc();
        $studentarray = array('student_id'=>$studentdetail['student_id'],
        'contact_no' => $studentdetail['contact_no'],
        'otp' => $OTP);
            $bodymsg = 'Thank you for registering with medivarsity. To get started kindly enter otp ' . $OTP . '. Kindly complete your profile for better results.%nRegards,%nTeam Medivarsity';
			$subject = 'Medivarsity - Otp Verification';
            $statussms = $this->SendsmsOtp($OTP,$email,$contact_num,$name,$bodymsg);
                $bodymsg = '<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding: 20px; border: 1px solid #000; position: relative;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" style="background: #fff; padding: 15px 0px;" bgcolor="#120001"><img src="'.SITEURL.'assets/img/home2/logo-white.png" width="100px;" height="100px;"  alt="" /></td>
      </tr>
      <tr>
        <td height="50"><hr style="width: 100%;" color="#000" size="1" /></td>
      </tr> 
      <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;">Dear '.$name.',</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
        <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;">Thank you for registering with medivarsity.To get started kindly enter otp ' . $OTP . '. Kindly complete your profile for better results.<br>Regards,<br>Team medivarsity
</td>
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
                $ret = array(0,$studentarray);
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
			//print_r($userdetails);
           $stmt = $this->con->prepare("SELECT * from student_otp WHERE student_id = ?");
           $stmt->bind_param("s", $student_id);
           $stmt->execute();
           $otpdetails = $stmt->get_result()->fetch_assoc();
           //print_r($otpdetails);
		   $created_date = CREATED_DATE;

            $name = $userdetails['name'];
            $lastinsertid = $userdetails['student_id'];
            $OTP = $otpdetails['otp'];
            $email = $userdetails['email'];
            $contact_num = $userdetails['contact_no'];
            $otp = array('otp'=> $OTP);
            $bodymsg = 'Thank you for registering with medivarsity. To get started kindly enter otp ' . $OTP . '. Kindly complete your profile for better results.%nRegards,%nTeam Medivarsity';
			$subject = 'Medivarsity - Otp';

            $statussms = $this->SendsmsOtp($OTP,$email,$contact_num,$name,$bodymsg);
			
            $bodymsg = '<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding: 20px; border: 1px solid #000; position: relative;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" style="background: #fff; padding: 15px 0px;" bgcolor="#120001"><img src="'.SITEURL.'assets/img/home2/logo-white.png" width="100px;" height="100px;"  alt="" /></td>
      </tr>
      <tr>
        <td height="50"><hr style="width: 100%;" color="#000" size="1" /></td>
      </tr> 
      <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;">Dear '.$name.',</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
        <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;">Thank you for registering with medivarsity.To get started kindly enter otp ' . $OTP . '. Kindly complete your profile for better results.<br> Regards,<br>Team medivarsity
</td>
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
            $statusmail = $this->SendmailOtp($OTP,$email,$contact_num,$name,$bodymsg,$subject);
 
            $stmt->close();
           
        
            if ($statussms) {
                $ret = 0;
                return array($ret,$otp);
            } else {
                return array(1);
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

           
            $bodymsg = 'Thank you for activating your account with medivarsity - Online tutorials hub for medical students.%nRegards,%nTeam medivarsity';
$subject = 'Medivarsity - Welcome Mail';
            $statussms = $this->SendsmsOtp($otp,$email,$contact_num,$name,$bodymsg);
                $bodymsg = '<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding: 20px; border: 1px solid #000; position: relative;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" style="background: #fff; padding: 15px 0px;" bgcolor="#120001"><img src="'.SITEURL.'assets/img/home2/logo-white.png" width="100px;" height="100px;"  alt="" /></td>
      </tr>
      <tr>
        <td height="50"><hr style="width: 100%;" color="#000" size="1" /></td>
      </tr> 
      <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;">Dear '.$name.',</td>
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
            $statusmail = $this->SendmailOtp($otp,$email,$contact_num,$name,$bodymsg,$subject);
 
          
           

            if ($statussms) {
           $stmt = $this->con->prepare("SELECT m.student_id,m.name,m.email,m.contact_no,m.gender,m.mbbs_year,m.status,m.image_url,c.college_name from medi_registered_students as m 
        LEFT JOIN college_master as c  ON c.id = m.college_id WHERE m.student_id = '".$student_id."'");
           $stmt->execute();
           $userdetails = $stmt->get_result()->fetch_assoc();
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
             $authtoken = $uniqueid;
             }
               if(!empty($userdetails['image_url'])){
        $image_url =   SITEURL.'profilepicture/'.$userdetails['image_url'];  
        }else{
        $image_url = '';    
        }
        $details = array('student_id'=> $userdetails['student_id'],
            'name'=> $userdetails['name'],
            'gender'=> $userdetails['gender'],
            'email'=> $userdetails['email'],
            'contact_no'=> $userdetails['contact_no'],
            'mbbs_year'=> $userdetails['mbbs_year'],
            'status'=> $userdetails['status'],
             'image_url'=> $image_url,
              'college_name'=> $userdetails['college_name']);
                $ret = 0;
                return array($ret,$details,$authtoken);
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
        if($social_id == ''){
        return array(2);
        }else{
        $password = md5(SALT . $password);

        $stmt = $this->con->prepare("SELECT m.student_id,m.name,m.gender,m.email,m.contact_no,m.mbbs_year,m.status,m.image_url,c.college_name from medi_registered_students as m 
        LEFT JOIN college_master as c  ON c.id = m.college_id WHERE social_id = '".$social_id."'");


        $stmt->execute();
        $userdetails = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        }
        }else if($login_type == 0){
        $status = 1;
        $password = md5(SALT . $password);

        $stmt = $this->con->prepare("SELECT m.student_id,m.name,m.gender,m.email,m.contact_no,m.mbbs_year,m.status,m.image_url,c.college_name from medi_registered_students as m 
        LEFT JOIN college_master as c  ON c.id = m.college_id WHERE password = '".$password."' AND email = '".$username."' OR contact_no = '".$username."'");

        $stmt->execute();
        $userdetails = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        }
        //print_r($userdetails);die;
        if(!empty($userdetails)){
        if($userdetails['status'] == 1){
        $stmt = $this->con->prepare("SELECT * from device_details WHERE student_id = ?");
        $stmt->bind_param("s", $userdetails['student_id']);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();  
        if(!empty($user)){
        $stmt = $this->con->prepare("UPDATE device_details SET device_id = ?,device_type = ? WHERE student_id = ?");
        $stmt->bind_param("sss", $device_id,$device_type,$userdetails['student_id']);
        $result = $stmt->execute();
        $stmt->close();
        $device = $user['device_type'];
        }else{
        $stmt = $this->con->prepare("INSERT INTO device_details(student_id,device_id,device_type) values(?,?,?)");
        $stmt->bind_param("sss", $userdetails['student_id'],$device_id,$device_type);
        $result = $stmt->execute();
        $stmt->close();
        $device = '';
        }



        $stmt = $this->con->prepare("SELECT * from authentication_token WHERE student_id = ?");
        $stmt->bind_param("s", $userdetails['student_id']);
        $stmt->execute();
        $auth = $stmt->get_result()->fetch_assoc();  
       // echo "<pre>";print_r($auth);exit;



        if(empty($auth)){
       $uniqueid = uniqid();
       $stmt = $this->con->prepare("INSERT INTO authentication_token(student_id,auth_token) values(?,?)");
      $stmt->bind_param("ss", $userdetails['student_id'],$uniqueid);
       $result = $stmt->execute();
      $stmt->close();
      $authtoken = $uniqueid;
       }else{
    /*   if($device_type == $device){
       $authtoken = $auth['auth_token'];
       }else{*/


        $uniqueid = uniqid();
        $stmt = $this->con->prepare("UPDATE authentication_token SET auth_token = ? WHERE student_id = ?");
        $stmt->bind_param("ss", $uniqueid,$userdetails['student_id']);
        $result = $stmt->execute();
        $stmt->close();
        $authtoken = $uniqueid;
        


    /*  }*/
       }



        if(!empty($userdetails['image_url'])){
        $image_url =   SITEURL.'profilepicture/'.$userdetails['image_url'];  
        }else{
        $image_url = '';    
        }
         
        $details = array('student_id'=> $userdetails['student_id'],
            'name'=> $userdetails['name'],
            'gender'=> $userdetails['gender'],
            'email'=> $userdetails['email'],
            'contact_no'=> $userdetails['contact_no'],
            'mbbs_year'=> $userdetails['mbbs_year'],
            'status'=> $userdetails['status'],
             'image_url'=> $image_url,
              'college_name'=> $userdetails['college_name']);
        return array($details,$authtoken);
        }else{
		$stmt = $this->con->prepare("SELECT * from student_otp WHERE student_id = ?");
           $stmt->bind_param("s", $userdetails['student_id']);
           $stmt->execute();
           $otpdetails = $stmt->get_result()->fetch_assoc();	
        $details = array('student_id'=> $userdetails['student_id'],'otp'=>$otpdetails['otp'],'status'=>0);
	  /*  	$resend=$this->resendotp($details['student_id']);*/
         $bodymsg = 'Thank you for registering with medivarsity. To get started kindly enter otp ' . $otpdetails['otp'] . '. Kindly complete your profile for better results.%nRegards,%nTeam Medivarsity';
         $subject = 'Medivarsity - Otp';
         $statussms = $this->SendsmsOtp($otpdetails['otp'],$userdetails['email'],$userdetails['contact_no'],$userdetails['name'],$bodymsg);
      
            $bodymsg = '<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding: 20px; border: 1px solid #000; position: relative;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" style="background: #fff; padding: 15px 0px;" bgcolor="#120001"><img src="'.SITEURL.'assets/img/home2/logo-white.png" width="100px;" height="100px;"  alt="" /></td>
      </tr>
      <tr>
        <td height="50"><hr style="width: 100%;" color="#000" size="1" /></td>
      </tr> 
      <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;">Dear '.$userdetails['name'].',</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
        <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 16px; color: #000;">Thank you for registering with medivarsity.To get started kindly enter otp ' . $otpdetails['otp'] . '. Kindly complete your profile for better results.<br> Regards,<br>Team medivarsity
</td>
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
            $statusmail = $this->SendmailOtp($otpdetails['otp'],$userdetails['email'],$userdetails['contact_no'],$userdetails['name'],$bodymsg,$subject);
        return array(3,$details);    
        }
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
        $msg = 'Your password for your email id is '.$usrpass.'.<br>Regards,<br>Team Medivarsity';
            $subject = 'Medivarsity - Forgot Password';
         $bodymsg = '<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td style="padding: 20px; border: 1px solid #c3c3c3; position: relative;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" style="background: #fff; padding: 15px 0px;" bgcolor="#120001"><img src="https://www.medivarsity.com/assets/img/home2/logo-white.png" width="100px" alt="Medivarsity" /></td>
      </tr>
      <tr>
        <td height="50"><hr style="width: 100%;" color="#c3c3c3" size="1" /></td>
      </tr> 
      <tr>
        <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 18px; color: #666666;">Dear '.$userdetails['name'].',</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
  <tr>
         <td style="font-family: \'Helvetica Neue\', \'Segoe UI\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 18px; color: #666666;">'.$msg.'</td>
      </tr>
      <tr>
        
      </tr>
      <tr>
        <td>
       </td>
      </tr>
    </table>
    </td>
  </tr>
</table>';
            $statusmail = $this->SendmailOtp($otp=null,$email,$contact_num=null,$userdetails['name'],$bodymsg,$subject);
            
        }else{
            $statusmail = 0;
        }

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
        $status = 0;
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
        $temp['video_image_url'] = $row['image_url'];
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
        if($subscription['hours_remaining'] == 0){
        $subs = 0;  
        }else{
        $subs = 1;
        }
        }else{
        $subs = 0;  
        }
        $videotype = 1;
        $stmt = $this->con->prepare("SELECT * from lecture_videos WHERE subject_id = ? AND video_type = ? AND status = ? LIMIT 10");
        $stmt->bind_param("sss", $element['subject_id'],$videotype,$status);
        $stmt->execute();
        $videolist = $stmt->get_result();
        $videos['videos'] = mysqli_fetch_all ($videolist, MYSQLI_ASSOC);
        $subject = array('subject_name' => $element['subject_name']);
        $subjectid = array('subject_id' => $element['subject_id']);
        $subscription = array('subscription' => $subs);
        $response['subjects'][] = array_merge($subject,$subjectid,$subscription,$videos);
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
        $cattype = 0;
        $stmt = $this->con->prepare("SELECT subject_id,video_category as category from lecture_videos WHERE subject_id = ? AND video_type = ? AND status = ? GROUP BY(video_category) LIMIT 10");
        $stmt->bind_param("sss",$topic_id,$cattype,$status);
        $stmt->execute();
        $catlist = $stmt->get_result();
        $categories = mysqli_fetch_all ($catlist, MYSQLI_ASSOC);
        foreach($categories as $catelement){
        $videotype = 0;
        $vct = " ";
        $stmt = $this->con->prepare("SELECT video_title,id as video_id from lecture_videos WHERE subject_id = ? AND video_type = ? AND status = ? AND video_category = ? AND video_category <> ? LIMIT 10");
        $stmt->bind_param("iiiss",$catelement['subject_id'],$videotype,$status, $catelement['category'], $vct);

        $stmt->execute();
        $videolist = $stmt->get_result();
        $videos['video'] = mysqli_fetch_all ($videolist, MYSQLI_ASSOC);
        if(!empty($catelement['category'])){
        $catglist = array('category_name' => $catelement['category']);
        $newone[] = array_merge($catglist, $videos);
        }else{
        $catglist = array('category_name' => 'Not Found!');
        $vi = array('video_title' => 'Not Aviable!', 'video_id' => 0);
        $newone[] = array_merge($catglist, $videos);
        }
        }
        return array(0,$newone);

        }else{
        return array(2);
        }
        }
        else{
            return array(1);
            }
       
       
    }

     public function collegelist($state_id){
          
        $stmt = $this->con->prepare("SELECT id as college_id,college_name from college_master WHERE state_id = ?");
        $stmt->bind_param("s",$state_id);
        $stmt->execute();
        $collegelist = $stmt->get_result();
        $college = mysqli_fetch_all ($collegelist, MYSQLI_ASSOC);
        if(!empty($college)){
        return array(0,$college);
        }else{
        return array(2);
        }
        }
      

    public function subjectdetails($authtoken,$topic_id){
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
        if($subscription['hours_remaining'] == 0){
        $sub = 0; 
        $remaininghours = $subscription['hours_remaining'];   
        }else{ 
        $sub = 1; 
        $remaininghours = $subscription['hours_remaining'];
        }   
        }else{
        $sub = 0; 
        $remaininghours = 0;    
        }
        $subscription['subscription_details'] = array('subscription' => $sub,'remaining_hours' => $remaininghours);
        $stmt = $this->con->prepare("SELECT sm.*,sd.* from subject_master as sm 
        LEFT JOIN subject_details as sd  ON sd.subject_id = sm.id 
        WHERE sm.id = ?");
        $stmt->bind_param("s",$topic_id);
        $stmt->execute();
        $about = $stmt->get_result()->fetch_assoc();
        if(!empty($about['subject_description'])){
        $subjectdescription = strip_tags($about['subject_description']);    
        }else{
        $subjectdescription = '';     
        }

        if(!empty($about['subject_features'])){
        $subjectfeatures = $about['subject_features'];    
        }else{
        $subjectfeatures = '';     
        }

        if(!empty($about['image'])){
        $subjectimage = SITEURL.'admin/assets/images/subjects/'.$about['image'];    
        }else{
        $subjectimage = '';     
        }

        if(!empty($about['price'])){
        $subjectprice = $about['price'];    
        }else{
        $subjectprice = '';     
        }
        foreach($about as $about);
        $subjectdetails['subjectdetails'] = array('subject_description' => $subjectdescription,
        'subject_features' => $subjectfeatures,
        'subject_image' => $subjectimage,
        'subject_price' => $subjectprice
        );
       

        $videotype = 0;
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

        $response = array_merge($subjectdetails,$subscription,$videos,$reviews,$test);
        return array(0,$response);
        }
        else{
            return array(1);
          }
        }

      public function updatesubscriptionhours($authtoken,$topic_id,$remaininghours){
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
        $subscriptionid = $subscription['id'];
        $stmt = $this->con->prepare("UPDATE subscription_details SET hours_remaining = ? WHERE id = ?");
        $stmt->bind_param("ii",$remaininghours,$subscriptionid);
        $result = $stmt->execute();
        $stmt->close();
        $status = 1;        
        $stmt = $this->con->prepare("SELECT * from subscription_details WHERE subject_id = ? AND student_id = ? AND status = ?");
        $stmt->bind_param("sss",$topic_id,$student_id,$status);
        $stmt->execute();
        $subscription = $stmt->get_result()->fetch_assoc();
        if(!empty($subscription)){
        $sub = 1; 
        $remaininghours = $subscription['hours_remaining'];   
        }else{
        $remaininghours = 0;    
        }
        $subscr['subscription_details'] = array('subscription' => $sub,
            'subject_id' => $subscription['subject_id'],
            'student_id' => $subscription['student_id'],
            'remaining_hours' => $subscription['hours_remaining']);
        return array(0,$subscr);
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

  public function Mytopics($authtoken){
        $response = array();
        $status = 1;
        $auth = $this->istokenexists($authtoken);
        if (!empty($auth)) { 
        $student_id = $auth['student_id'];  
        $status = 1;        
        $stmt = $this->con->prepare("SELECT * from subscription_details WHERE subject_id = ? AND student_id = ? AND status = ?");
        $stmt = $this->con->prepare("SELECT  s.id,s.subject_name,su.subject_description,su.image,sd.hours_remaining from subject_master as s 
        JOIN subject_details as su  ON su.subject_id = s.id 
        JOIN subscription_details as sd  ON sd.subject_id = s.id 
        WHERE sd.student_id = ?");
        $stmt->bind_param("s",$student_id);
        $stmt->execute();
        $mytopics = $stmt->get_result();
        $mytopic = mysqli_fetch_all ($mytopics, MYSQLI_ASSOC);
        $topics = array();
        foreach($mytopic as $element){
        if($element['hours_remaining'] != 0 ){
        $topics[] = array(
        'id'=> $element['id'],
        'subject_name'=> $element['subject_name'],
        'subject_description'=> $element['subject_description'],
        'subject_image'=> SITEURL.'admin/assets/images/subjects/'.$element['image']
        ); 
        }
        }
        if(!empty($topics)){
        return array(0,$topics);
        }else{
        return array(2);
        }
        }
        else{
            return array(1);
            }
       
       
    }

 public function questionslist($authtoken,$test_id){
        $response = array();
        $status = 1;
        $auth = $this->istokenexists($authtoken);
        if (!empty($auth)) { 
        $student_id = $auth['student_id']; 
        $status = 1;        

        $stmt = $this->con->prepare("SELECT * from test WHERE id = ?");
        $stmt->bind_param("s",$test_id);
        $stmt->execute();
        $test = $stmt->get_result();
        $testlist = mysqli_fetch_all ($test, MYSQLI_ASSOC);
        if(!empty($testlist)){

        $stmt = $this->con->prepare("SELECT * from test_questions WHERE test_id = ?");
        $stmt->bind_param("s",$test_id);
        $stmt->execute();
        $questions = $stmt->get_result();
        $questionslist = mysqli_fetch_all ($questions, MYSQLI_ASSOC);
        if(!empty($questionslist)){
        foreach($questionslist as $element){
        if($element['answer_type'] == 0){
        $stmt = $this->con->prepare("SELECT * from answer_text WHERE question_id = ?");
        $stmt->bind_param("s",$element['id']);
        $stmt->execute();
        $options = $stmt->get_result();
        $optionslist = mysqli_fetch_all ($options, MYSQLI_ASSOC);
        foreach($optionslist as $option){
        $opt[] = array(
        'option_id' => $option['id'],
        'option' => $option['option_answer'],
        'correct' => $option['correct_answer'],
        );
        }
        }else if ($element['answer_type'] == 1){
        $stmt = $this->con->prepare("SELECT * from answer_images WHERE question_id = ?");
        $stmt->bind_param("s",$element['id']);
        $stmt->execute();
        $options = $stmt->get_result();
        $optionslist = mysqli_fetch_all ($options, MYSQLI_ASSOC);
        foreach($optionslist as $option){
        $opt[] = array(
        'option_id' => $option['id'],
        'option' => SITEURL.'admin/assets/test_img/'.$option['image_url'],
        'correct' => $option['correct_answer'],
        );
        }
        }
        $question[] = array(
        'question_id' => $element['id'],
        'question' => $element['test_question'],
        'answer_type' => $element['answer_type'],
        'options' => $opt);     
        }
        if(!empty($question)){
        return array(0,$question);
        }else{
        return array(2);
        }
        }else{
        return array(3);    
        }
        }else{
        return array(4);    
        }
        }
        else{
            return array(1);
            }
       
       
    }


     public function answerlist($authtoken,$test_id, $someJSON){
        $response = array();
        $status = 1;
        $auth = $this->istokenexists($authtoken);
        if (!empty($auth)) {

      // Convert JSON string to Array
      $someArray = json_decode($someJSON, true);    
        $student_id = $auth['student_id']; 
        $status = 1;        

        $stmt = $this->con->prepare("SELECT * from test WHERE id = ?");
        $stmt->bind_param("s",$test_id);
        $stmt->execute();
        $test = $stmt->get_result();
        $testlist = mysqli_fetch_all ($test, MYSQLI_ASSOC);
        if(!empty($testlist)){

        $stmt = $this->con->prepare("SELECT * from test_questions WHERE test_id = ?");
        $stmt->bind_param("s",$test_id);
        $stmt->execute();
        $questions = $stmt->get_result();
        $questionslist = mysqli_fetch_all ($questions, MYSQLI_ASSOC);
        if(!empty($questionslist)){
        foreach($questionslist as $element){
        if($element['answer_type'] == 0){
        $correct = 1;
        $stmt = $this->con->prepare("SELECT * from answer_text WHERE question_id = ? AND correct_answer = ?");
        $stmt->bind_param("ss",$element['id'],$correct);
        $stmt->execute();
        $options = $stmt->get_result()->fetch_assoc();
        $correct = $options['option_answer'];
        }else if ($element['answer_type'] == 1){
        $correct = 1;
        $stmt = $this->con->prepare("SELECT * from answer_images WHERE question_id = ? AND correct_answer = ?");
        $stmt->bind_param("ss",$element['id'],$correct);
        $stmt->execute();
        $options = $stmt->get_result()->fetch_assoc();
        $correct = SITEURL.'admin/assets/test_img/'.$options['image_url'];
        }
        $questionresult[] = array(
        'question_id' => $element['id'],
        'question' => $element['test_question'],
        'answer_type' => $element['answer_type'],
        'correct' => $correct); 
        }

        $total = count($someArray);
        $calculate = 0;
        if(!empty($someArray)){
        foreach($someArray as $key=>$value){
        $questionid = $value['question_id'];
        $stmt = $this->con->prepare("SELECT * from test_questions WHERE id = ?");
        $stmt->bind_param("s",$questionid);
        $stmt->execute();
        $question = $stmt->get_result()->fetch_assoc();
        if(!empty($question)){
        if($question['answer_type'] == 0){
        $correct = 1;
        $stmt = $this->con->prepare("SELECT id from answer_text WHERE question_id = ? AND correct_answer = ?");
        $stmt->bind_param("ss",$question['id'],$correct);
        $stmt->execute();
        $options = $stmt->get_result()->fetch_assoc();
        $correctoption = $options['id'];
        }else if ($question['answer_type'] == 1){
        $correct = 1;
        $stmt = $this->con->prepare("SELECT id from answer_images WHERE question_id = ? AND correct_answer = ?");
        $stmt->bind_param("ss",$question['id'],$correct);
        $stmt->execute();
        $options = $stmt->get_result()->fetch_assoc();
        $correctoption = $options['id'];
        }
        if($value['option_id'] == $correctoption){
        $calculate = $calculate + 1;    
        } 
        }
        }
        $incorrectanswer = $total - $calculate;
        $result = array('correctanswer' => $calculate,
        'totalquestions' => $total,
        'incorrectanswer' => $incorrectanswer
        );
        }else{
        $result = array();   
        }

        $resultcal = array('questions' => $questionresult,
        'result' => $result);
        if(!empty($resultcal)){
        return array(0,$resultcal);
        }else{
        return array(2);
        }
        }else{
        return array(3);    
        }
        }else{
        return array(4);    
        }
        }
        else{
            return array(1);
            }
       
       
    }

        public function checkauthtoken($authtoken){
        $response = array();
        $status = 1;
        $auth = $this->istokenexists($authtoken);
        if (!empty($auth)) {
        return 1;
        }else{
        return 0; 
        }
       
       
    }


    /*sz code start*/
    public function checkIsLoggedIn($authtoken,$id){
        $response = array();
        $status = 1;
        $stmt = $this->con->prepare("SELECT * from authentication_token WHERE student_id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $authexists = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if($authexists['auth_token']){
            if ($authtoken == $authexists['auth_token']) {
                return 0;
            }else{
                return 1;
            }
        } else {
            return 2;
        }

    }
    /*sz code end*/



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
     $apiKey = urlencode('Y+LexaAtwH0-J6xZaqkQtmwTQMK84u6BUstlu7Ybna');
	
	$numbers = array('91'.$contact_num);
	$sender = urlencode('MEDIVR');
	$message = rawurlencode($bodymsg);
 
	$numbers = implode(',', $numbers);
 
	// Prepare data for POST request
	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
 
	// Send the POST request with cURL
	$ch = curl_init('https://api.textlocal.in/send/');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
    }   
        if($ch){
        $status = 1;    
        }
        return $status;
    }

 //Method to send mail
    private function SendmailOtp($otp,$email,$contact_num,$name,$bodymsg,$subject) {        
    if(!empty($email)){
    $message = $bodymsg;
			require_once('../mail/class.phpmailer.php');
			
			$mail = new PHPMailer();
			$mail->CharSet =  "utf-8";
			//$mail->SMTPDebug = 3;
			//$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->Username = "info@medivarsity.com";
			$mail->Password = "Sourav/2912";
			$mail->SMTPSecure = "tls";  
			$mail->Host = "smtp.gmail.com";
			$mail->Port = "587";
			
			$mail->setFrom('info@medivarsity.com', 'Medivarsity');
		    $mail->AddAddress($email, $name);
           
		    $mail->Subject  =  $subject;
			$mail->IsHTML(true);
			$mail->Body = $message;
			$mail->Send();
    }                           
    $status = 'success';
    return $status;
    }

    public function getnotification($authtoken){
    
        $response = array();
        $status = 1;
        $auth = $this->istokenexists($authtoken);
        if (!empty($auth)) { 
        $user_id = $auth['student_id']; 
        $stmt = $this->con->prepare("SELECT name,title,description from notifications WHERE user_id = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $notifyData = $stmt->get_result();
        $notifydata = mysqli_fetch_all ($notifyData, MYSQLI_ASSOC);
        if(!empty($notifydata))
        {
        $result = array('Notifications' => $notifydata);
        return array(0,$result);
        }else
        {  
        $result = array('Notifications' => array());
           return array(2,$result);
        }
        }
        else
        {
           return array(1);
        }
       
       
    }
}



