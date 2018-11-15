<?php

//including the required files
require_once '../include/DbOperation.php';
require '.././libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();



function echoResponse($status_code, $response)
{
    $app = \Slim\Slim::getInstance();
    $app->status($status_code);
    $app->contentType('application/json');
    echo json_encode($response);
}


function verifyRequiredParams($required_fields)
{
    $error = false;
    $error_fields = "";
    $request_params = $_REQUEST;

    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }

    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoResponse(400, $response);
        $app->stop();
    }
}

function cleanInput($input) {
 
  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );
    $output = preg_replace($search, '', $input);
    return $output;
    
  } 
function clean($string) {
     return str_replace('Â', '', $string); // Removes special chars.
}

function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = clean(utf8ize($v));
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}



/* *
 * URL: http://localhost/api/v1/CollegeList
 * Parameters: none
 * Authorization: Put API Key in Request Header
 * Method: GET
 * */
$app->get('/CollegeList', function() use ($app){
    $db = new DbOperation();
    $result = $db->getAllCollege();
    $response = array();
    $response['Error'] = false;
    $response['Status'] = 1;
    $response['Payload'] = array();

    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['id'] = $row['id'];
        $temp['college_name'] = $row['college_name'];
        array_push($response['Payload'],$temp);
    }

    echoResponse(200,$response);
});


  /* *

  /* *
 * URL: http://localhost/api/v1/SubjectList
 * Parameters: none
 * Authorization: Put API Key in Request Header
 * Method: GET
 * */
$app->get('/SubjectList', function() use ($app){
    $db = new DbOperation();
    $result = $db->getAllSubject();
    $response = array();
    $response['Error'] = false;
    $response['Status'] = 1;
    $response['Payload'] = array();

    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['id'] = $row['id'];
        $temp['subject_name'] = $row['subject_name'];
        array_push($response['Payload'],$temp);
    }

    echoResponse(200,$response);
});



  

  /* *
 * URL: http://localhost/api/v1/RegisterStudent
 * Parameters: name, email,contact_num,password,college,year
 * Method: POST
 * */
$app->post('/RegisterStudent', function () use ($app) {
    verifyRequiredParams(array('name', 'email','contact_num','password','college','year'));
    $response = array();
    $name = $app->request->post('name');
    $email = $app->request->post('email');
    $contact_num = $app->request->post('contact_num');
    $password = $app->request->post('password');
    $college = $app->request->post('college');
    $year = $app->request->post('year');
    $socialid = $app->request->post('socialid');
    $regtype = $app->request->post('regtype');
    $imageurl = $app->request->post('imageurl');
    $db = new DbOperation();
    $res = $db->registerstudent($name, $email, $contact_num, $password,$college,$year,$socialid,$regtype,$imageurl);
    $result = $res[0];
    if ($result == 0) {

        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "Otp successfully sent";
        $response["Payload"] = $res[1];
        echoResponse(201, $response);
    } else if ($result == 1) {
        $response["Error"] = true;
        $response["Status"] = 1;
        $response["Message"] = "Otp successfully sent to your number";
        echoResponse(200, $response);
    } else if ($result == 2) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Sorry, email already existed";
        echoResponse(200, $response);
    } else if ($result == 3) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Sorry, contact number already existed";
        echoResponse(200, $response);
    }
});

/* *
 * URL: http://localhost/api/v1/Resendotp
 * Parameters: student_id
 * Method: POST
 * */
$app->post('/Resendotp', function () use ($app) {
    
    $response = array();
    $student_id = $app->request->post('student_id');
    $db = new DbOperation();
    $res = $db->resendotp($student_id);
    if ($res == 0) {

        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "otp successfully sent";
        echoResponse(201, $response);
    } else{

        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Sorry, otp not sent";
        echoResponse(201, $response);
    }
});

/* *
 * URL: http://localhost/api/v1/Verifyotp
 * Parameters: student_id, otp
 * Method: POST
 * */
$app->post('/Verifyotp', function () use ($app) {
    
    $response = array();
    $student_id = $app->request->post('student_id');
    $otp = $app->request->post('otp');
    $db = new DbOperation();
    $res = $db->verifyotp($student_id,$otp);
    if ($res[0] == 0) {

        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "student successfully activate";
        $response['Payload'] = $res[1];
        echoResponse(201, $response);
    }else if ($res[0] == 3) {

        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "otp doesnot match";
        echoResponse(201, $response);
    } else{

        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "student not activate";
        echoResponse(201, $response);
    }
});

/* *
 * URL: http://localhost/api/v1/LoginStudent
 * Parameters: username, password, login_type, device_type, device_id
 * Method: POST
 * */
$app->post('/LoginStudent', function () use ($app) {
    verifyRequiredParams(array('username','password','login_type','device_type','device_id'));
    $response = array();
    $username = $app->request->post('username');
    $password = $app->request->post('password');
    $login_type = $app->request->post('login_type');
    $social_id = $app->request->post('social_id');
    $device_type = $app->request->post('device_type');
    $device_id = $app->request->post('device_id');
    $db = new DbOperation();
    $result = $db->loginstudent($username, $password,$login_type,$social_id,$device_type,$device_id);
    if (!empty($result[1])) {

        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "You are successfully registered";
        $response["Payload"] = $result[0];
        $response["Authtoken"] = $result[1];
        echoResponse(201, $response);
    } else if($result[0] == 1) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Not a valid user";
        echoResponse(200, $response);
    } 
});


/* *
 * URL: http://localhost/api/v1/Forgotpassword
 * Parameters: email
 * Method: POST
 * */
$app->post('/Forgotpassword', function () use ($app) {
    verifyRequiredParams(array('email'));
    $response = array();
    $email = $app->request->post('email');
    $db = new DbOperation();
    $result = $db->forgotpassword($email);
    if ($result == 1) {
        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "You password sent to your email id successfully";
        echoResponse(201, $response);
    } else {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Not a valid email id";
        echoResponse(200, $response);
    } 
});

/* *
 * URL: http://localhost/api/v1/Home
 * Parameters: authtoken
 * Method: POST
 * */
$app->post('/Home', function () use ($app) {
    verifyRequiredParams(array('authtoken'));
    $response = array();
    $authtoken = $app->request->post('authtoken');
    $db = new DbOperation();
    $res = $db->home($authtoken);
    $result = $res[0];
    if ($result == 0) {
        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "Auth token successfully matched";
        $response["Payload"] = $res[1];
        echoResponse(201, $response);
    } else if ($result == 1) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Auth token doesnot exist";
        echoResponse(200, $response);
    } 
});

 /* *
 * URL: http://localhost/api/v1/Lectureslist
 * Parameters: authtoken, topic_id
 * Method: POST
 * */
$app->post('/Lectureslist', function () use ($app) {
    verifyRequiredParams(array('authtoken', 'topic_id'));
    $response = array();
    $authtoken = $app->request->post('authtoken');
    $topic_id = $app->request->post('topic_id');
    $db = new DbOperation();
    $res = $db->lectureslist($authtoken, $topic_id);
    $result = $res[0];
    if ($result == 0) {
        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "Auth token successfully matched";
        $response["Payload"] = $res[1];
        echoResponse(201, $response);
    } else if ($result == 1) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Auth token not matched";
        echoResponse(200, $response);
    } else if ($result == 2) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Student not subscribed the subject";
        echoResponse(200, $response);
    } 
});

 /* *
 * URL: http://localhost/api/v1/Topicdetails
 * Parameters: authtoken, topic_id
 * Method: POST
 * */
$app->post('/Topicdetails', function () use ($app) {
    verifyRequiredParams(array('authtoken', 'topic_id'));
    $response = array();
    $authtoken = $app->request->post('authtoken');
    $topic_id = $app->request->post('topic_id');
    $db = new DbOperation();
    $res = $db->topicdetails($authtoken, $topic_id);
    $result = $res[0];
    if ($result == 0) {
        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "Auth token successfully matched";
        $response["Payload"] = $res[1];
        echoResponse(201, $response);
    } else if ($result == 1) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Auth token not matched";
        echoResponse(200, $response);
    } else if ($result == 2) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Student not subscribed the subject";
        echoResponse(200, $response);
    } 
});

/* *
 * URL: http://localhost/api/v1/AddReview
 * Parameters: 'authtoken', 'video_id','topic_id','review','rating'
 * Method: POST
 * */
$app->post('/AddReview', function () use ($app) {
    verifyRequiredParams(array('authtoken', 'video_id','topic_id','review','rating'));
    $response = array();
    $authtoken = $app->request->post('authtoken');
    $videoid = $app->request->post('video_id');
    $topic_id = $app->request->post('topic_id');
    $review = $app->request->post('review');
    $rating = $app->request->post('rating');
    $db = new DbOperation();
    $res = $db->addreview($authtoken,$videoid,$topic_id,$review,$rating);
    $result = $res[0];
    if ($result == 0) {
        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "Review added successfully";
        echoResponse(201, $response);
    } else if ($result == 1) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Auth token not matched";
        echoResponse(200, $response);
    }
});

/* *
 * URL: http://localhost/gripproject/v1/LoginUser
 * Parameters: name, username, password
 * Method: POST
 * */
$app->post('/Updateuser', function () use ($app) {
    verifyRequiredParams(array('member_id'));
    $response = array();
    $member_id = $app->request->post('member_id');
    $address = $app->request->post('address');
    $country_id = $app->request->post('country_id');
    $state_id = $app->request->post('state_id');
    $city_id = $app->request->post('city_id');
    $zipcode = $app->request->post('zipcode');
    $db = new DbOperation();
    $result = $db->Updateuser($member_id,$address,$country_id,$state_id,$city_id,$zipcode);
    if ($result == 1) {
        $response["error"] = false;
        $response["message"] = "Your details updated successfully";
        $response["user_id"] = $result;
        echoResponse(201, $response);
    } else {
        $response["error"] = true;
        $response["message"] = "Not a valid member id";
        echoResponse(200, $response);
    } 
});

/* *
 * URL: http://localhost/gripproject/v1/Childcategories
 * Parameters: name, username, password
 * Method: POST
 * */
/*$app->post('/Childcategories', function () use ($app) {
    verifyRequiredParams(array('parent_id'));
    $response = array();
    $parent_id = $app->request->post('parent_id');
   
    $db = new DbOperation();
    $result = $db->categoryParentChildTree($parent_id);
    if ($result == 1) {
        $response["error"] = false;
        $response["message"] = "Your details updated successfully";
        $response["user_id"] = $result;
        echoResponse(201, $response);
    } else {
        $response["error"] = true;
        $response["message"] = "Not a valid member id";
        echoResponse(200, $response);
    } 
});*/



/* *
 * URL: http://localhost/gripproject/v1/Maincategories
 * Parameters: none
 * Authorization: Put API Key in Request Header
 * Method: GET
 * */
$app->get('/Maincategories', function() use ($app){
    $db = new DbOperation();
    $result = $db->getAllMaincategories();
    $response = array();
    $response['error'] = false;
    $response['maincategories'] = array();
    
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['category_id'] = $row['category_id'];
        $temp['name'] = $row['name'];
        $temp['slug'] = $row['slug'];
        $temp['parent_id'] = $row['parent_id'];
        $temp['category_image'] = BASH_PATH.'assets/uploads/resource-centre/grip/'.$row['grip_image'];
        array_push($response['maincategories'],$temp);
    }
    echoResponse(200,$response);
});

/*$app->get('/Childcategories/:id', function($parent_id) use ($app){
    $db = new DbOperation();
    $result = $db->getAllChildcategories();
    $response = array();
    $response['error'] = false;
    $response['childcategories'] = array();
    
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['category_id'] = $row['category_id'];
        $temp['name'] = $row['name'];
        $temp['slug'] = $row['slug'];
        $temp['parent_id'] = $row['parent_id'];
        array_push($response['childcategories'],$temp);
    }

    echoResponse(200,$response);
});*/

$app->post('/getChildCategories', function() use ($app){
    verifyRequiredParams(array('parentID'));
	try {
	    $response = array();
	    $db = new DbOperation();
	    $parentID = $app->request->post('parentID');
	    $response['error'] = false;
	    $subcategories = $db->getSubcategories($parentID);
	    $response['sub_categories'] = utf8ize($subcategories);
	    echoResponse(200,$response);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
});

$app->post('/Griplistaccordingtocategory', function() use ($app){
    $db = new DbOperation();
    $response = array();
    $parent_id = $app->request->post('parent_id');
    // $page = 1; // Default page start with 1 
     $limit = 6; // Set Limit according to you 1 - 5 -10
     $start = 0;
     $page = $app->request->post('page');
     if(!is_numeric($page)){
     $page = 1;
     }else{
     $page = $page;   
     }
     $start = ($page - 1)*$limit;
    
    $result = $db->gripdataaccordingtocategory($parent_id,$page,$start,$limit);
    $gripcount = $db->gripdatacount($parent_id);
    $response = array();
    $response['error'] = false;
    $response['griplist'] = array();
    $response['gripcount'] = ceil($gripcount/$limit); 
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['id'] = $row['id'];
        $temp['slug'] = $row['slug'];
        $temp['title'] = ucwords($row['title']);
        $temp['description'] = utf8_encode(cleanInput(strip_tags($row['description'])));
        $temp['created_date'] = $row['created_date'];
        $temp['fullname'] = $row['fullname'];
        $temp['username'] = $row['username'];
        $temp['member_type'] = $row['member_type'];
        $temp['member_id'] = $row['member_id'];
        $temp['url'] = BASH_PATH.'rc/'.$row['slug'];
        $temp['docurl'] = BASH_PATH.'document-center/'.$row['docurl'];
        if($row['libraryStatus'] == null){
            $temp['library_status'] = 0;    
        }else{
            $temp['library_status'] = $row['libraryStatus'];
        }
        
        array_push($response['griplist'],$temp);
    }

    echoResponse(200,$response);
});

$app->post('/Mydocs', function() use ($app){
    $db = new DbOperation();
    $response = array();
    $member_id = $app->request->post('member_id');
    // $page = 1; // Default page start with 1 
     $limit = 6; // Set Limit according to you 1 - 5 -10
     $start = 0;
     $page = $app->request->post('page');
     if(!is_numeric($page)){
     $page = 1;
     }else{
     $page = $page;   
     }
     $start = ($page - 1)*$limit;
    
    $result = $db->gripmydocs($member_id,$page,$start,$limit);
    $gripcount = $db->gripdatamydocscount($member_id);
    $response = array();
    $response['error'] = false;
    $response['griplist'] = array();
    $response['gripmydocscount'] = ceil($gripcount/$limit); 
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['id'] = $row['id'];
        $temp['slug'] = $row['slug'];
        $temp['title'] = ucwords($row['title']);
        $temp['description'] = utf8_encode(cleanInput(strip_tags($row['description'])));
        $temp['created_date'] = $row['created_date'];
        $temp['fullname'] = $row['fullname'];
        $temp['username'] = $row['username'];
        $temp['member_type'] = $row['member_type'];
        $temp['member_id'] = $row['member_id'];
        $temp['url'] = BASH_PATH.'rc/'.$row['slug'];
        $temp['docurl'] = BASH_PATH.'document-center/'.$row['docurl'];
        if($row['libraryStatus'] == null){
            $temp['library_status'] = 0;    
        }else{
            $temp['library_status'] = $row['libraryStatus'];
        }
        array_push($response['griplist'],$temp);
    }

    echoResponse(200,$response);
});

$app->post('/Alldocs', function() use ($app){
    $db = new DbOperation();
    $response = array();
    //$member_id = $app->request->post('member_id');
    // $page = 1; // Default page start with 1 
     $limit = 6; // Set Limit according to you 1 - 5 -10
     $start = 0;
     $page = $app->request->post('page');
     if(!is_numeric($page)){
     $page = 1;
     }else{
     $page = $page;   
     }
     $start = ($page - 1)*$limit;
    
    $result = $db->gripAllydocs($page,$start,$limit);
    $gripcount = $db->gripdataAlldocscount();
    $response = array();
    $response['error'] = false;
    $response['griplist'] = array();
    $response['gripmydocscount'] = ceil($gripcount/$limit); 
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['id'] = $row['id'];
        $temp['slug'] = $row['slug'];
        $temp['title'] = ucwords($row['title']);
        $temp['description'] = utf8_encode(cleanInput(strip_tags($row['description'])));
        $temp['created_date'] = $row['created_date'];
        $temp['fullname'] = $row['fullname'];
        $temp['username'] = $row['username'];
        $temp['member_type'] = $row['member_type'];
        $temp['member_id'] = $row['member_id'];
        $temp['url'] = BASH_PATH.'rc/'.$row['slug'];
        $temp['docurl'] = BASH_PATH.'document-center/'.$row['docurl'];
        if($row['libraryStatus'] == null){
            $temp['library_status'] = 0;    
        }else{
            $temp['library_status'] = $row['libraryStatus'];
        }
        array_push($response['griplist'],$temp);
    }

    echoResponse(200,$response);
});

/* *
 * URL: http://localhost/gripproject/v1/LoginUser
 * Parameters: name, username, password
 * Method: POST
 * */
$app->post('/addtofavourite', function () use ($app) {
    verifyRequiredParams(array('member_id','resource_center_id','status'));
    $response = array();
    $member_id = $app->request->post('member_id');
    $resource_center_id = $app->request->post('resource_center_id');
    $status = $app->request->post('status');
    $db = new DbOperation();
    $result = $db->addToLibrary($member_id,$resource_center_id,$status);
    if ($result == 1) {
        $response["error"] = false;
        $response["message"] = "Your Add to library successfully";
        $response["datalibrary"] = $result;
        echoResponse(201, $response);
    }else if ($result == 2) {
        $response["error"] = false;
        $response["message"] = "Your update to library successfully";
        $response["datalibrary"] = $result;
        echoResponse(201, $response);
    }  else {
        $response["error"] = true;
        $response["message"] = "Not a valid member id";
        echoResponse(200, $response);
    } 
});

/* *
 * URL: http://localhost/gripproject/v1/LoginUser
 * Parameters: name, username, password
 * Method: POST
 * */
$app->post('/getLibrary', function () use ($app) {
    $response = array();
    $member_id = $app->request->post('member_id');
    //$page = 1; // Default page start with 1 
     $limit = 6; // Set Limit according to you 1 - 5 -10
     $start = 0;
     $page = $app->request->post('page');
     if(!is_numeric($page)){
     $page = 1;
     }else{
     $page = $page;   
     }
     $start = ($page - 1)*$limit;
    $db = new DbOperation();
    $gripcount = $db->gripLibraryDocsCount($member_id);
    $result = $db->getLibrary($member_id,$page,$start,$limit);
    $response = array();
    $response['error'] = false;
    $response['liblist'] = array();
    $response['gripmypagecount'] = ceil($gripcount/$limit); 
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['id'] = $row['id'];
        $temp['slug'] = $row['slug'];
        $temp['title'] = ucwords($row['title']);
        $temp['description'] = utf8_encode(cleanInput(strip_tags($row['description'])));
        $temp['created_date'] = $row['created_date'];
        $temp['fullname'] = $row['fullname'];
        $temp['username'] = $row['username'];
        $temp['member_type'] = $row['member_type'];
        $temp['member_id'] = $row['member_id'];
        $temp['url'] = BASH_PATH.'rc/'.$row['slug'];
        $temp['docurl'] = BASH_PATH.'document-center/'.$row['docurl'];
        array_push($response['liblist'],$temp);
    }
    echoResponse(200,$response);
});

/* *
 * URL: http://localhost/gripproject/v1/aboutus
 * Parameters: none
 * Authorization: Put API Key in Request Header
 * Method: GET
 * */
$app->get('/aboutus', function() use ($app){
    $db = new DbOperation();
    $result = $db->getAboutUs();
    $response = array();
    $row = $result->fetch_assoc();
    $response['description'] = utf8_encode(cleanInput($row['content']));
    $response['status'] = $row['status'];
    echoResponse(200,$response);
});

/* *
 * URL: http://localhost/gripproject/v1/aboutus
 * Parameters: none
 * Authorization: Put API Key in Request Header
 * Method: GET
 * */
$app->get('/termsconditions', function() use ($app){
    $db = new DbOperation();
    $result = $db->getTermsconditions();
    $response = array();
    $row = $result->fetch_assoc();
    $response['description'] = utf8_encode(cleanInput($row['content']));
    $response['status'] = $row['status'];
    echoResponse(200,$response);
});

/* *
 * Parameters: member_id, password
 * Method: POST
 * */
$app->post('/updatePassword', function () use ($app) {
    verifyRequiredParams(array('member_id', 'password', 'newpassword', 'confirmpassword'));
    $response = array();
    $member_id = $app->request->post('member_id');
    $password = $app->request->post('password');
    $newpassword = $app->request->post('newpassword');
    $confirmpassword = $app->request->post('confirmpassword');
    $db = new DbOperation();
    
    $result = $db->checkUpdatePassword($member_id,$password);
    if ($result > 0) {
        if($newpassword != $confirmpassword){
            $response["error"] = true;
            $response["message"] = "New password and confirm password not match";
            echoResponse(200, $response);
        }else{
            $newresult = $db->updatePassword($member_id,$newpassword);
            if($newresult ==1){
                $response["error"] = false;
                $response["message"] = "Your password is successfully updated";
                echoResponse(200, $response);
            }else{
                $response["error"] = true;
                $response["message"] = "Your password is not updated";
                echoResponse(200, $response);
            }
        }
    }  else {
        $response["error"] = true;
        $response["message"] = "Please type valid old password";
        echoResponse(200, $response);
    } 
});

//user profile
$app->post('/getUserProfile', function () use ($app) {
    verifyRequiredParams(array('member_id'));
    $member_id = $app->request->post('member_id');
    $db = new DbOperation();
    $result = $db->getUserProfile($member_id);
    $response = array();
    $response['error'] = false;
    $response['profile'] = array();
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['member_id'] = $row['member_id'];
        $temp['username'] = $row['username'];
        $temp['first_name'] = ucwords($row['first_name']);
        $temp['last_name'] = ucwords($row['last_name']);
        $temp['email'] = $row['email'];
        $temp['pan_no'] = $row['pan_no'];
        $temp['gst_no'] = $row['gst_no'];
        $temp['contact_num'] = $row['contact_num'];
        $temp['profile_pic'] = BASH_PATH.'assets/uploads/_thumb/'.$row['profile_pic'];
        $temp['address'] = $row['address'];
        $temp['country_name'] = $row['country_name'];
        $temp['state_name'] = $row['state_name'];
        $temp['city_name'] = $row['city_name'];
        $temp['member_type'] = $row['member_type'];
        //$temp['url'] = BASH_PATH.'rc/'.$row['slug'];
        array_push($response['profile'],$temp);
    }
    echoResponse(200,$response);
});

$app->post('/updateImage', function () use ($app) { 
	verifyRequiredParams(array('member_id','image','filename'));
	try {
	    $db = new DbOperation();
	    $member_id = $app->request->post('member_id');
	    $image=$app->request->post('image');
	    $filename=$app->request->post('filename');
	    $decodeimage=base64_decode(str_replace("data:image/jpeg;base64,", '', $image));
	    $filename1  = basename($filename);
        $extension = pathinfo($filename1, PATHINFO_EXTENSION);
        $new       = time().'.'.$extension;
	    $filenameimage = $new;
		$uplpath = HTTP_UPLOAD_USER_PROFILE_THUMB_PATH.$filenameimage;
		header('Content-Type: bitmap; charset=utf-8');
	    $file = fopen($uplpath, 'wb');
	    // Create File
	    fwrite($file, $decodeimage);
	    fclose($file);
	    $user = $db->getUserProfile($member_id);
	    while($row = $user->fetch_assoc()){
        $profile_pic = $row['profile_pic'];
	    }
        $result = $db->getMemberProfilePicture($member_id);
		if ($result > 0) { 
		    $update = $db->updateMemberProfilePicture($member_id,$filenameimage);   
            if($update ==1){
                unlink(HTTP_UPLOAD_USER_PROFILE_THUMB_PATH.$profile_pic);
                $response["error"] = false;
                $response["update_image"] = HTTP_USER_PROFILE_THUMB_PATH . $filenameimage;
                $response["image"] = "Your image is successfully updated";
            }else{
                $response["error"] = true;
                $response["image"] = "Your image is not updated";
            }
		}else{
		    $insert = $db->insertMemberProfilePicture($member_id,$filenameimage);  
		     if($insert ==1){
                $response["error_image"] = false;
                $response["inserted_image"] = HTTP_USER_PROFILE_THUMB_PATH . $filenameimage;
                $response["image"] = "Your image is successfully inserted";
            }else{
                $response["error_image"] = true;
                $response["image"] = "Your image is not inserted";
            }
		}
	    echoResponse(200,$response);
	} catch(PDOException $e) {
		
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
	
		
});

$app->post('/editProfile', function () use ($app) { 
	verifyRequiredParams(array('member_id','name','address','country', 'state', 'city'));
	try {
	    $db = new DbOperation();
	    $member_id = $app->request->post('member_id');
	    $name =$app->request->post('name');
	    $address =$app->request->post('address');
	    $country =$app->request->post('country');
	    $state =$app->request->post('state');
	    $city =$app->request->post('city');
	    $user = $db->getUserProfile($member_id);
	    if($user->num_rows > 0) {
	        $fullname = explode(' ', $name, 2);
	        $first = $fullname[0];
	        $last = $fullname[1];
	        $updateprofilename = $db->updateProfileName($member_id, $first, $last);
	        $updateprofile = $db->updateProfile($member_id, $address ,$country, $state, $city);
	        $response["error"] = false;
            $response["update_name"] = "Your profile is successfully updated";
	    }
		
	    echoResponse(200,$response);
	} catch(PDOException $e) {
		
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
});

   // create Unique Slug
    function createUniqueSlug($tabaName, $string, $field = 'slug', $key = NULL, $value = NULL) {
        $db = new DbOperation();
        $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($string));
        $i = 0;
        $params = array();
        if ($key)
            $params["$key !="] = $value;
        while ($db->checkSlugViaRC($slug)) {
            if (!preg_match('/-{1}[0-9]+$/', $slug))
                $slug .= '-' . ++$i;
            else
                $slug = preg_replace('/[0-9]+$/', ++$i, $slug);
            $params [$field] = $slug;
        }
        return $slug;
    }
    
$app->post('/addDoc', function () use ($app) { 
//	verifyRequiredParams(array('image','filename'));
	try {
	    $db = new DbOperation();
	    $json = array();
	    /*$text = $_POST;
	    $filescheck = $_FILES;
        $var_str = var_export($text, true);
        $var_str1 = var_export($filescheck, true);
        $var = "<?php\n\n\$text = $var_str.'==File'.$var_str1;\n\n?>";
        file_put_contents('filename.php', $var); die;*/     
        $title = $app->request->post('title');
	    $slug = createUniqueSlug('resource_centre', trim($title), 'slug', NULL, NULL);
	    $description = addslashes(utf8_encode(cleanInput(strip_tags($app->request->post('description')))));
	    $tags = $app->request->post('tags');
	    $categoryid = $app->request->post('categoryid');
	    $subcategoryid = $app->request->post('subcategoryid');
	    $createddate = time();
	    $modifiededdate = time();
	    $member_id = $app->request->post('member_id');
	    $status = 1;
	    $documentType = 0;
	    $paymentType = 0;
	    $country_id = $app->request->post('country_id');
	    $image= $app->request->post('resource_center_pdf');
	    //$filename=$app->request->post('filename');
	    $filename = $_FILES["resource_center_pdf"]["name"];
	    $categoryname = $db->getOnlyParentCategory($categoryid);
	    
	    /*================================================================*/
	    $resource_center_id = $db->insertRC($slug, $title, $description, $tags, $createddate, $modifiededdate, $member_id, $status, $documentType, $paymentType, $country_id);
	    if($resource_center_id > 0){
	        $json['msg']= 'Successfully inserted';
	    $db->insertCategoryIdRC($resource_center_id, $subcategoryid);
	    /*=================================================================*/
	    //start pdf upload
	    if($filename != ''){ 
    	    $ownDirectory = ROOT_UPLOAD_DC_PATH;
            // own dir
            $rootPath = $ownDirectory . $member_id;
            // folder dir
            $folderPath = $ownDirectory . $member_id.'/'.$categoryname;
            $filePath = $member_id.'/'.$categoryname;
    	    if (!is_dir($rootPath)) {
                mkdir($rootPath, 0777);
                chmod($rootPath, 0777);
                $content = "<html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>";
                $fp = fopen($rootPath . "/index.php", "wb");
                fwrite($fp,$content);
                fclose($fp);                    
            }
    		if (!is_dir($folderPath)) {
    	        mkdir($folderPath, 0777);
    	        chmod($folderPath, 0777);
    	        $content = "<html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>";
                $fp = fopen($folderPath. "/index.php", "wb");
                fwrite($fp,$content);
                fclose($fp);
    	   }
    	   
    	    $filename1  = basename($filename);
            $extension = pathinfo($filename1, PATHINFO_EXTENSION);
            $new       = time().'.'.$extension;
    	    $filenameimage = $new;
    		$uplpath = $folderPath.'/'.$filenameimage;
    		/*========================*/
    	    if (move_uploaded_file($_FILES["resource_center_pdf"]["tmp_name"], $uplpath) && $extension == "pdf") {
    	        $filecreatedname = HTTP_USER_UPLOAD_DC_PATH.$filePath.'/'.$filenameimage;
    	        $url = $filePath.'/'.$filenameimage;
    	        $attchmentinsert = $db->insertAttachment($slug, $title, $url, $resource_center_id);
        	    if($attchmentinsert > 0){
        	       $json['docmsg']= 'Document insert successfully';
        	       $json['docurl']= $filecreatedname;
        	    }
    	    }else{
    	        $json['docmsg']= 'Document not inserted';
    	    }
	   }
	   }else{
	       $json['msg']= 'Not inserted';
	   }
	   // print_r($user); die;
	    echoResponse(200,$json);
	} catch(PDOException $e) {
		
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
	
		
});
$app->run();