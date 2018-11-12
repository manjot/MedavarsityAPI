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
    public function loginstudent($username,$password){
        $status = 1;
        $password = md5(SALT . $password);
        $stmt = $this->con->prepare("SELECT student_id,name,email,contact_no,status from medi_registered_students WHERE email = ? OR contact_no = ? AND password = ? AND status = ?");
        $stmt->bind_param("ssss", $username,$username,$password,$status);
        $stmt->execute();
        $userdetails = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if(!empty($userdetails)){

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
        $usrpass=$this->random_string(8);
        $password = md5(SALT . $usrpass); 
        $bodymsg = 'Your password for your email id is <strong>'.$usrpass.'</strong>

Regards, 
Team SoOLegal';
            $subject = 'GRIP - Forgot Password';
            $statusmail = $this->SendmailOtp($otp=null,$email,$contact_num=null,$userdetails['first_name'],$bodymsg,$subject);
            
        }
        if($statusmail){
            $stmt = $this->con->prepare("UPDATE member SET password = ? WHERE member_id = ?");
            $stmt->bind_param("ss", $password,$userdetails['member_id']);
            $result = $stmt->execute();
            $stmt->close();
            
            
            return 1;    
            }else{

            return 0;    
            }
    }
    
    
    
     //Method to update userdata
    public function Updateuser($member_id,$address,$country_id,$state_id,$city_id,$zipcode){
        $status = 1;
        $stmt = $this->con->prepare("SELECT * from member WHERE member_id = ?");
        $stmt->bind_param("s", $member_id);
        $stmt->execute();
        $userdetails = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if(!empty($userdetails)){
            
            $stmt = $this->con->prepare("INSERT INTO member_address(address,country,state,city,pin_code,member_id) values(?,?,?,?,?,?)");
            $stmt->bind_param("ssssss", $address,$country_id,$state_id,$city_id,$zipcode,$member_id);
            $result = $stmt->execute();
            $stmt->close();
            
            
            return 1;    
            }else{

            return 0;    
            }
    }
    
    //Method to fetch all main categories
    public function getAllMaincategories(){
        $stmt = $this->con->prepare("SELECT * FROM category WHERE status=1 AND parent_id = 0");
       // $stmt->bind_param("i",$country_id);
        $stmt->execute();
        $maincategories = $stmt->get_result();
        $stmt->close();
        return $maincategories;
    }
    
    public function getOnlyParentCategory($categoryid) {		
       $stmt = $this->con->prepare("SELECT `cp`.`category_id`, `cp`.`name` as `category_name`, `cp`.`slug`, `cp`.`parent_id` FROM `category` as `cp` WHERE `cp`.`parent_id` =0 AND `cp`.`category_id` = '".$categoryid."'"); 
        $stmt->execute();
        $maincategories = $stmt->get_result();
        while($row = $maincategories->fetch_assoc()){
        $category_name = strtolower(str_replace(' ', '-',$row['category_name']));
	    }
        $stmt->close();
        return $category_name;
	}
	
       //Method to fetch all main categories
    public function getSubcategories($parentID, $category_tree_array = ''){
        $stmt = $this->con->prepare("SELECT `cp`.`category_id` AS `category_id`, GROUP_CONCAT(c2.name ORDER BY cp.level SEPARATOR ' » ' ) AS name, `c1`.`parent_id`, `c1`.`sort_order`
FROM `category_path` as `cp` LEFT JOIN `category` as `c1` ON `cp`.`category_id` = `c1`.`category_id` LEFT JOIN `category` as `c2` ON `cp`.`path_id` = `c2`.`category_id` LEFT JOIN `category_description` as `cd1` ON `cp`.`path_id` = `cd1`.`category_id`
LEFT JOIN `category_description` as `cd2` ON `cp`.`category_id` = `cd2`.`category_id` WHERE `cp`.`level` !=0 AND `c1`.`parent_id` = $parentID GROUP BY `cp`.`category_id`");
        $stmt->execute();
        $categories = $stmt->get_result();
        if ($categories->num_rows > 0) {
            while($row = $categories->fetch_assoc()){
             $category_tree_array[] = array(
                    "category_id" => $row['category_id'], 
                    "name" => $row['name']
                );
                $category_tree_array = $this->getSubcategories($row['category_id'], $category_tree_array);   
            }
        }
        $stmt->close();
        return $category_tree_array;
    }
    
    //Method to get parent child category
    /*public function categoryParentChildTree($parentID,$category_tree_array = ''){
         if (!is_array($category_tree_array))
        $category_tree_array = array();
        $stmt = $this->con->prepare("SELECT cp.category_id AS category_id, GROUP_CONCAT(c2.name ORDER BY cp.level SEPARATOR &nbsp;&nbsp;&nbsp; ) AS name,c1.parent_id,c1.sort_order from category_path as cp LEFT JOIN category as c1  ON cp.category_id = c1.category_id 
        LEFT JOIN category as c2 ON cp.path_id = c2.category_id 
        LEFT JOIN category_description as cd1 ON cp.path_id = cd1.category_id
        LEFT JOIN category_description as cd2 ON cp.category_id = cd2.category_id
        WHERE c1.parent_id = ? AND cp.level !=0");
        $stmt->bind_param("s", $parentID);
        $stmt->execute();
        $categorylist = $stmt->get_result()->fetch_all();
        echo "<pre>";print_r($categorylist);exit;
        $stmt->close();
        if(!empty($userdetails)){
            
            $stmt = $this->con->prepare("UPDATE member_address SET address = ?,country = ?,state = ?,city = ?,pin_code = ? WHERE member_id = ?");
            $stmt->bind_param("ssssss", $address,$country_id,$state_id,$city_id,$zipcode,$member_id);
            $result = $stmt->execute();
            $stmt->close();
            
            
            return 1;    
            }else{

            return 0;    
            }
    }*/
    
    //Method to get grip list 
    public function gripdataaccordingtocategory($parentID,$page,$start,$limit){
        $stmt = $this->con->prepare("SELECT rca.url as docurl,rcf.status as libraryStatus, rc.id, rc.slug, rc.title as title,rc.description, rc.created_date, rc.price,concat_ws('', TRIM(m.first_name), TRIM(m.last_name)) AS fullname,m.first_name,m.last_name,m.username, m.member_type,m.member_id,rc.currency_id from category_path as cp LEFT JOIN category_to_resource_centre as crc  ON cp.category_id = crc.resource_centre_category_id 
        LEFT JOIN resource_centre as rc ON crc.resource_centre_id = rc.id 
        LEFT JOIN resource_centre_attachment as rca ON rca.resource_centre_id = rc.id
        LEFT JOIN member as m ON m.member_id = rc.member_id
        LEFT JOIN resource_centre_favorites as rcf ON rcf.resource_centre_id = rc.id
        WHERE rc.status = 1 AND rc.paymentType = 0 AND m.status =1 AND cp.path_id = ? GROUP BY rc.id ORDER BY rc.id DESC LIMIT $start,$limit");
        $stmt->bind_param("s", $parentID);
        $stmt->execute();
        $griplist = $stmt->get_result();
        $stmt->close();
        return $griplist;
    }
    
     //Method to get about us
    public function getAboutUs(){
        $stmt = $this->con->prepare("SELECT * from grip_about_us");
        $stmt->execute();
        $griplist = $stmt->get_result();
        $stmt->close();
        return $griplist;
    }
    
    //Method to get terms & conditions
    public function getTermsconditions(){
        $stmt = $this->con->prepare("SELECT * from grip_terms");
        $stmt->execute();
        $griplist = $stmt->get_result();
        $stmt->close();
        return $griplist;
    }
    
     //Method to get total counts grip list 
    public function gripdatacount($parentID){
        $stmt = $this->con->prepare("SELECT rc.id from category_path as cp LEFT JOIN category_to_resource_centre as crc  ON cp.category_id = crc.resource_centre_category_id 
        LEFT JOIN resource_centre as rc ON crc.resource_centre_id = rc.id 
        LEFT JOIN member as m ON m.member_id = rc.member_id
        WHERE rc.status = 1 AND m.status =1 AND cp.path_id = ? GROUP BY rc.id ORDER BY rc.id DESC");
        $stmt->bind_param("s", $parentID);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows;
    }
    
      //Method to get grip my docs list 
    public function gripmydocs($member_id,$page,$start,$limit){
        $stmt = $this->con->prepare("SELECT rca.url as docurl,rcf.status as libraryStatus, rc.id, rc.slug, rc.title as title,rc.description, rc.created_date, rc.price,concat_ws('', TRIM(m.first_name), TRIM(m.last_name)) AS fullname,m.first_name,m.last_name,m.username, m.member_type,m.member_id,rc.currency_id from category_path as cp 
        LEFT JOIN category_to_resource_centre as crc  ON cp.category_id = crc.resource_centre_category_id 
        LEFT JOIN resource_centre as rc ON crc.resource_centre_id = rc.id 
        LEFT JOIN resource_centre_attachment as rca ON rca.resource_centre_id = rc.id
        LEFT JOIN member as m ON m.member_id = rc.member_id
        LEFT JOIN resource_centre_favorites as rcf ON rcf.resource_centre_id = rc.id
        WHERE rc.status = 1 AND rc.paymentType = 0  AND m.status =1 AND rc.member_id=? GROUP BY rc.id ORDER BY rc.id DESC LIMIT $start,$limit");
        $stmt->bind_param("s", $member_id);
        $stmt->execute();
        $gripmydocslist = $stmt->get_result();
        $stmt->close();
        return $gripmydocslist;
    }
    
     //Method to get grip my docs list 
    public function gripAllydocs($page,$start,$limit){
        $stmt = $this->con->prepare("SELECT rca.url as docurl,rcf.status as libraryStatus, rc.id, rc.slug, rc.title as title,rc.description, rc.created_date, rc.price,concat_ws('', TRIM(m.first_name), TRIM(m.last_name)) AS fullname,m.first_name,m.last_name,m.username, m.member_type,m.member_id,rc.currency_id from category_path as cp 
        LEFT JOIN category_to_resource_centre as crc  ON cp.category_id = crc.resource_centre_category_id 
        LEFT JOIN resource_centre as rc ON crc.resource_centre_id = rc.id 
        LEFT JOIN resource_centre_attachment as rca ON rca.resource_centre_id = rc.id
        LEFT JOIN member as m ON m.member_id = rc.member_id
        LEFT JOIN resource_centre_favorites as rcf ON rcf.resource_centre_id = rc.id
        WHERE rc.status = 1 AND rc.paymentType = 0  AND m.status =1 GROUP BY rc.id ORDER BY rc.id DESC LIMIT $start,$limit");
        $stmt->execute();
        $gripmydocslist = $stmt->get_result();
        $stmt->close();
        return $gripmydocslist;
    }
    
     //Method to get total counts grip my docs list 
    public function gripdatamydocscount($member_id){
        $stmt = $this->con->prepare("SELECT rc.id from category_path as cp LEFT JOIN category_to_resource_centre as crc  ON cp.category_id = crc.resource_centre_category_id 
        LEFT JOIN resource_centre as rc ON crc.resource_centre_id = rc.id 
        LEFT JOIN member as m ON m.member_id = rc.member_id
        WHERE rc.status = 1 AND m.status =1 AND rc.member_id= ? GROUP BY rc.id ORDER BY rc.id DESC");
        $stmt->bind_param("s", $member_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows;
    }
    
    //Method to get total counts grip my docs list 
    public function gripdataAlldocscount(){
        $stmt = $this->con->prepare("SELECT rc.id from category_path as cp LEFT JOIN category_to_resource_centre as crc  ON cp.category_id = crc.resource_centre_category_id 
        LEFT JOIN resource_centre as rc ON crc.resource_centre_id = rc.id 
        LEFT JOIN member as m ON m.member_id = rc.member_id
        WHERE rc.status = 1 AND m.status =1 GROUP BY rc.id ORDER BY rc.id DESC");
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows;
    }
    
    //Method to update add to library
    public function addToLibrary($member_id,$resource_center_id,$status){
        $stmt = $this->con->prepare("SELECT * from resource_centre_favorites WHERE member_id = ? AND resource_centre_id= ? ");
        $stmt->bind_param("ss", $member_id, $resource_center_id);
        $stmt->execute();
        $userdetails = mysqli_num_rows($stmt->get_result());
        
        if(!empty($userdetails) && $userdetails >0){
            $stmt = $this->con->prepare("UPDATE resource_centre_favorites SET status = $status WHERE member_id = $member_id AND resource_centre_id=$resource_center_id");
            if($stmt->execute()){
                return 2;
            }else{
                return 0;
            }
            }else{
            $stmt = $this->con->prepare("INSERT INTO resource_centre_favorites(member_id,resource_centre_id,status) values($member_id, $resource_center_id, $status)");
            if($stmt->execute()){
                return 1;
            }else{
                return 0;
            }
            }
        $stmt->close();
    }
    
//Method to update get all library
    public function getLibrary($member_id,$page,$start,$limit){
        $stmt = $this->con->prepare("SELECT rca.url as docurl,rc.id, rc.slug, rc.title as title,rc.description, rc.created_date, rc.price,concat_ws('', TRIM(m.first_name), TRIM(m.last_name)) AS fullname,m.first_name,m.last_name,m.username, m.member_type,m.member_id,rc.currency_id 
        from resource_centre_favorites as rcf 
        LEFT JOIN resource_centre as rc ON rc.id = rcf.resource_centre_id
        LEFT JOIN resource_centre_attachment as rca ON rca.resource_centre_id = rc.id
        LEFT JOIN category_to_resource_centre as crc  ON crc.resource_centre_id  = rc.id
        LEFT JOIN category_path as cp  ON cp.category_id  = crc.resource_centre_category_id
        LEFT JOIN member as m ON m.member_id = rcf.member_id
        WHERE rc.status = 1 AND rc.paymentType = 0 AND m.status =1 AND rcf.status =1 AND rcf.member_id=? GROUP BY rc.id ORDER BY rc.id DESC LIMIT $start,$limit");
        $stmt->bind_param("s", $member_id);
        $stmt->execute();
        $gripmydocslist = $stmt->get_result();
        $stmt->close();
        return $gripmydocslist;
    }
    
    //Method to get total counts grip my docs list 
    public function gripLibraryDocsCount($member_id){
        $stmt = $this->con->prepare("SELECT rcf.id from resource_centre_favorites as rcf 
        LEFT JOIN resource_centre as rc ON rc.id = rcf.resource_centre_id
        WHERE rcf.member_id = ? AND rcf.status=1 AND rc.status = 1");
        $stmt->bind_param("s", $member_id);
        $stmt->execute();
        $getresult = $stmt->get_result();
        return $getresult->num_rows;
    }
    
    //check Update password
    public function checkUpdatePassword($member_id,$password){
        $password = md5(SALT . $password);
        $stmt = $this->con->prepare("SELECT * from member WHERE member_id = ? AND password= ?");
        $stmt->bind_param("ss", $member_id, $password);
        $stmt->execute();
        $getresult = $stmt->get_result();
        return $getresult->num_rows;
    }
    
    //Update password
    public function updatePassword($member_id, $newpassword){
        $newpassword = md5(SALT . $newpassword);
        $stmt = $this->con->prepare("UPDATE `member` SET `password`='$newpassword' WHERE `member_id`=$member_id");
            if($stmt->execute()){
                return 1;
            }else{
                return 0;
            }
    }
    
    //get userprofile
    public function getUserProfile ($member_id){
        $stmt = $this->con->prepare("SELECT `m`.`member_id`, `m`.`username`, `m`.`first_name`, `m`.`last_name`, `m`.`email`, `m`.`member_type`, `m`.`gst_no`, `m`.`contact_num`, `mo`.`pan_no`, `p`.`url` as `profile_pic`, `a`.`address`, `a`.`country` as `member_country_id`, `a`.`state` as `member_state_id`, `a`.`city` as `member_city_id`, `a`.`pin_code`, `co`.`name` as `country_name`, `s`.`name` as `state_name`, `c`.`name` as `city_name` FROM `member` as `m` LEFT JOIN `member_profile_picture` as `p` ON `m`.`member_id` = `p`.`member_id` LEFT JOIN `member_other_info` as `mo` ON `mo`.`memberId` = `m`.`member_id` LEFT JOIN (SELECT * FROM `member_address` GROUP BY `member_id` ORDER BY `id` ASC) as a ON `m`.`member_id` = `a`.`member_id` LEFT JOIN `cities` as `c` ON `c`.`id` = `a`.`city` LEFT JOIN `states` as `s` ON `s`.`id` = `a`.`state` LEFT JOIN `countries` as `co` ON `co`.`id` = `a`.`country` WHERE `m`.`member_id` = ? AND `m`.`status` = 1");
        $stmt->bind_param("s", $member_id);
        $stmt->execute();
        $getresult = $stmt->get_result();
        return $getresult;
        
    }
    
    //get userprofile picture
    public function getMemberProfilePicture ($member_id){
        $stmt = $this->con->prepare("SELECT * from `member_profile_picture` WHERE `member_id` = ?");
        $stmt->bind_param("s", $member_id);
        $stmt->execute();
        $getresult = $stmt->get_result();
        return $getresult->num_rows;
    }
    
    //Update profile picture
    public function updateMemberProfilePicture($member_id, $filenameimage){
        $stmt = $this->con->prepare("UPDATE member_profile_picture SET url='".$filenameimage."' WHERE member_id='".$member_id."'");
            if($stmt->execute()){ 
                return 1;
            }else{
                return 0;
            }
    }
    
    //insert profile picture
    public function insertMemberProfilePicture($member_id, $filenameimage){
        $stmt = $this->con->prepare("INSERT INTO `member_profile_picture`(`url` ,`member_id`) VALUES('".$filenameimage."','".$member_id."')");
            if($stmt->execute()){
                return 1;
            }else{
                return 0;
            }
    }
    
    //Update profile picture
    public function updateProfileName($member_id, $first, $last){
        $stmt = $this->con->prepare("UPDATE member SET first_name='".$first."',  last_name='".$last."' WHERE member_id='".$member_id."'");
            $stmt->execute();
            return true;
    }
    //Update profile picture
    public function updateProfile($member_id, $address ,$country, $state, $city){
        $stmt = $this->con->prepare("UPDATE member_address SET address='".$address."',  country='".$country."',  state='".$state."',  city='".$city."' WHERE member_id='".$member_id."'");
            $stmt->execute();
            return true;
    }
    
    public function insertAttachment($slug, $title, $url, $resource_center_id) {
         $stmt = $this->con->prepare("INSERT INTO `resource_centre_attachment`(`slug` ,`title`,`url` ,`resource_centre_id`) VALUES('".$slug."','".$title."','".$url."','".$resource_center_id."')");
            if($stmt->execute()){
                return 1;
            }else{
                return 0;
            }
    }
    
     public function insertRC($slug, $title, $description, $tags, $createddate, $modifiededdate, $member_id, $status, $documentType, $paymentType, $country_id) {
         $stmt = $this->con->prepare("INSERT INTO `resource_centre`(`slug` ,`title` ,`description`,`tags` ,`created_date`,`modified_date` ,`member_id`,`status` ,`documentType`,`paymentType` ,`country_id`) VALUES('".$slug."','".$title."','".$description."','".$tags."','".$createddate."','".$modifiededdate."','".$member_id."','".$status."','".$documentType."','".$paymentType."','".$country_id."')");
            if($stmt->execute()){
                return $stmt->insert_id;
            }else{
                return 0;
            }
    }
    
    public function insertCategoryIdRC($resource_center_id, $subcategoryid) {
        $subcatarray = json_decode($subcategoryid,true);
        foreach($subcatarray as $data) {
         $stmt = $this->con->prepare("INSERT INTO `category_to_resource_centre`(`resource_centre_id` ,`resource_centre_category_id`) VALUES('".$resource_center_id."','".$data."')");
            $stmt->execute();
        }
    }
    
     //check resource center numbers
    public function checkSlugViaRC($slug){
        $stmt = $this->con->prepare("SELECT * FROM `resource_centre` WHERE `slug` = ?");
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $getresult = $stmt->get_result();
        return $getresult->num_rows;
    }
 //*********************************Common Functions ***********************//   
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