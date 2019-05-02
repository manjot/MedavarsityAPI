<?php

//including the required files
define('Activeongoogleplay',0);
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
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        $response['Payload'] = new stdClass();
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
 * URL: http://13.233.187.243/api/v1/StateList
 * Parameters: none
 * Authorization: Put API Key in Request Header
 * Method: GET
 * */
$app->get('/StateList', function() use ($app){
    $db = new DbOperation();
    $result = $db->getAllState();
    $response = array();
    $response['Activeongoogleplay'] = Activeongoogleplay;
    $response['Error'] = false;
    $response['Status'] = 1;
    $response["Message"] = "State list successfully sent";
    foreach($result as $element){
    $statelist[] = array(
    'state_id' => $element['id'],
    'state_name' => utf8_encode($element['state'])
    );    
    }

    $response['Payload'] = $statelist;
  
   

    echoResponse(200,$response);
});


  /* *

  /* *
 * URL: http://13.233.187.243/api/v1/SubjectList
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
    $response["Message"] = "Subject list successfully sent";
    $response['Payload'] = array();
    $response['Activeongoogleplay'] = Activeongoogleplay;

    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['subject_id'] = $row['id'];
        $temp['subject_name'] = $row['subject_name'];
        $temp['subject_image'] = 'https://medivarsity.com/admin/assets/images/subjects/'.$row['subject_image'];
        array_push($response['Payload'],$temp);
    }

    echoResponse(200,$response);
});



  

  /* *
 * URL: http://13.233.187.243/api/v1/RegisterStudent
 * Parameters: name, email,contact_num,password,college,year
 * Method: POST
 * */
$app->post('/RegisterStudent', function () use ($app) {
    verifyRequiredParams(array('name', 'email','contact_num','password','college','year','gender','device_id','device_type'));
    $response = array();
    $name = $app->request->post('name');
    $email = $app->request->post('email');
    $contact_num = $app->request->post('contact_num');
    $password = $app->request->post('password');
    $college = $app->request->post('college');
    $year = $app->request->post('year');
    $gender = $app->request->post('gender');
    $socialid = $app->request->post('socialid');
    $regtype = $app->request->post('regtype');
    $image=$app->request->post('image');
    $device_id=$app->request->post('device_id');
    $device_type=$app->request->post('device_type');
    if(!empty($image)){
    $filename=$app->request->post('filename');
    define('PARENT_ROOT_PATH', '/var/www/html/');
    define('HTTP_UPLOAD_USER_PROFILE_THUMB_PATH', PARENT_ROOT_PATH.'profilepicture/'); 
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
    }else{
    $filenameimage = '';    
    }
    $db = new DbOperation();
    $res = $db->registerstudent($name, $email, $contact_num, $password,$college,$year,$gender,$socialid,$regtype,$filenameimage,$device_id,$device_type);
    $result = $res[0];
    $response['Activeongoogleplay'] = Activeongoogleplay;
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
        $response['Payload'] = new stdClass();
        echoResponse(200, $response);
    } else if ($result == 2) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Sorry, email already existed";
        $response['Payload'] = new stdClass();
        echoResponse(200, $response);
    } else if ($result == 3) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Sorry, contact number already existed";
        $response['Payload'] = new stdClass();
        echoResponse(200, $response);
    }
});

/* *
 * URL: http://13.233.187.243/api/v1/Resendotp
 * Parameters: student_id
 * Method: POST
 * */
$app->post('/Resendotp', function () use ($app) {
    
    $response = array();
    $student_id = $app->request->post('student_id');
    $db = new DbOperation();
    $res = $db->resendotp($student_id);
    $response['Activeongoogleplay'] = Activeongoogleplay;
    if ($res[0] == 0) {

        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "otp successfully sent";
        $response['Payload'] = $res[1];
        echoResponse(201, $response);
    } else{

        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Sorry, otp not sent";
        $response['Payload'] = array();
        echoResponse(201, $response);
    }
});

/* *
 * URL: http://13.233.187.243/api/v1/Verifyotp
 * Parameters: student_id, otp
 * Method: POST
 * */
$app->post('/Verifyotp', function () use ($app) {
    
    $response = array();
    $student_id = $app->request->post('student_id');
    $otp = $app->request->post('otp');
    $db = new DbOperation();
    $res = $db->verifyotp($student_id,$otp);
    $response['Activeongoogleplay'] = Activeongoogleplay;
    if ($res[0] == 0) {

        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "student successfully activate";
        $response['Payload'] = $res[1];
        $response['Authtoken'] = $res[2];
        echoResponse(201, $response);
    }else if ($res[0] == 3) {

        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "otp doesnot match";
        $response['Payload'] = new stdClass();
        echoResponse(201, $response);
    } else{

        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "student not activate";
        $response['Payload'] = new stdClass();
        echoResponse(201, $response);
    }
});

/* *
 * URL: http://13.233.187.243/api/v1/LoginStudent
 * Parameters: username, password, login_type, social_id, device_type, device_id
 * Method: POST
 * */
$app->post('/LoginStudent', function () use ($app) {
    verifyRequiredParams(array('login_type','device_type','device_id'));
    $response = array();
    $username = $app->request->post('username');
    $password = $app->request->post('password');
    $login_type = $app->request->post('login_type');
    $social_id = $app->request->post('social_id');
    $device_type = $app->request->post('device_type');
    $device_id = $app->request->post('device_id');
    $db = new DbOperation();
    $result = $db->loginstudent($username, $password,$login_type,$social_id,$device_type,$device_id);
    $response['Activeongoogleplay'] = Activeongoogleplay;
    if (!empty($result[1]) && $result[0] != 3) {
        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "You are successfully logged in";
        $response["Payload"] = $result[0];
        $response["Authtoken"] = $result[1];
        echoResponse(201, $response);
    } else if($result[0] == 1) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Invalid username or password";
        $response['Payload'] = new stdClass();
        echoResponse(200, $response);
    }else if($result[0] == 2) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Social id is empty";
        $response['Payload'] = new stdClass();
        echoResponse(200, $response);
    } 
    else if($result[0] == 3) {
        $response["Error"] = false;
        $response["Status"] = 0;
        $response["Message"] = "Student Exists but not activated";
        $response['Payload'] = $result[1];
        echoResponse(200, $response);
    }  
});


/* *
 * URL: http://13.233.187.243/api/v1/Forgotpassword
 * Parameters: email
 * Method: POST
 * */
$app->post('/Forgotpassword', function () use ($app) {
    verifyRequiredParams(array('email'));
    $response = array();
    $email = $app->request->post('email');
    $db = new DbOperation();
    $result = $db->forgotpassword($email);
    $response['Activeongoogleplay'] = Activeongoogleplay;
    if ($result == 1) {
        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "You password sent to your email id successfully";
        $response['Payload'] = array();
        echoResponse(201, $response);
    } else {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Not a valid email id";
        $response['Payload'] = array();
        echoResponse(200, $response);
    } 
});

/* *
 * URL: http://13.233.187.243/api/v1/Home
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
    $response['Activeongoogleplay'] = Activeongoogleplay;
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
        $response['Payload'] = new stdClass();
        echoResponse(200, $response);
    } 
});

 /* *
 * URL: http://13.233.187.243/api/v1/Lectureslist
 * Parameters: authtoken, topic_id
 * Method: POST
 * */
$app->post('/Lectureslist', function () use ($app) {
    verifyRequiredParams(array('authtoken', 'subject_id'));
    $response = array();
    $authtoken = $app->request->post('authtoken');
    $topic_id = $app->request->post('subject_id');
    $db = new DbOperation();
    $res = $db->lectureslist($authtoken, $topic_id);
    $result = $res[0];
    
    $response['Activeongoogleplay'] = Activeongoogleplay;
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
        $response['Payload'] = array();
        echoResponse(200, $response);
    } else if ($result == 2) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Student not subscribed the subject";
        $response['Payload'] = array();
        echoResponse(200, $response);
    } 
});

 /* *
 * URL: http://13.233.187.243/api/v1/Topicdetails
 * Parameters: authtoken, topic_id
 * Method: POST
 * */
$app->post('/Subjectdetails', function () use ($app) {
    verifyRequiredParams(array('authtoken', 'subject_id'));
    $response = array();
    $authtoken = $app->request->post('authtoken');
    $topic_id = $app->request->post('subject_id');
    $db = new DbOperation();
    $res = $db->subjectdetails($authtoken, $topic_id);
    $result = $res[0];
    $response['Activeongoogleplay'] = Activeongoogleplay;
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
        $response['Payload'] = array();
        echoResponse(200, $response);
    } else if ($result == 2) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Student not subscribed the subject";
        $response['Payload'] = array();
        echoResponse(200, $response);
    } 
});

 /* *
 * URL: http://13.233.187.243/api/v1/Mytopics
 * Parameters: authtoken
 * Method: POST
 * */
$app->post('/Mytopics', function () use ($app) {
    verifyRequiredParams(array('authtoken'));
    $response = array();
    $authtoken = $app->request->post('authtoken');
    $db = new DbOperation();
    $res = $db->mytopics($authtoken);
    $result = $res[0];
    $response['Activeongoogleplay'] = Activeongoogleplay;
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
        $response['Payload'] = array();
        echoResponse(200, $response);
    } else if ($result == 2) {
        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "Student not subscribed to any subject";
        $response['Payload'] = array();
        echoResponse(200, $response);
    } 
});

/* *
 * URL: http://13.233.187.243/api/v1/AddReview
 * Parameters: 'authtoken', 'video_id','topic_id','review','rating'
 * Method: POST
 * */
$app->post('/AddReview', function () use ($app) {
    verifyRequiredParams(array('authtoken', 'video_id','subject_id','review','rating'));
    $response = array();
    $authtoken = $app->request->post('authtoken');
    $videoid = $app->request->post('video_id');
    $topic_id = $app->request->post('subject_id');
    $review = $app->request->post('review');
    $rating = $app->request->post('rating');
    $db = new DbOperation();
    $res = $db->addreview($authtoken,$videoid,$topic_id,$review,$rating);
    $result = $res[0];
    $response['Activeongoogleplay'] = Activeongoogleplay;
    if ($result == 0) {
        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "Review added successfully";
        $response['Payload'] = array();
        echoResponse(201, $response);
    } else if ($result == 1) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Auth token not matched";
        $response['Payload'] = array();
        echoResponse(200, $response);
    }
});

/* *
 * URL: http://13.233.187.243/api/v1/Testlist
 * Parameters: 'authtoken', 'video_id','topic_id','review','rating'
 * Method: POST
 * */
$app->post('/Questionslist', function () use ($app) {
    verifyRequiredParams(array('authtoken', 'test_id'));
    $response = array();
    $authtoken = $app->request->post('authtoken');
    $test_id = $app->request->post('test_id');
    $db = new DbOperation();
    $res = $db->questionslist($authtoken,$test_id);
    $result = $res[0];
    $response['Activeongoogleplay'] = Activeongoogleplay;
    if ($result == 0) {
        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "Questions sent successfully";
        $response['Payload'] = $res[1];
        echoResponse(201, $response);
    } else if ($result == 1) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Auth token not matched";
        $response['Payload'] = array();
        echoResponse(200, $response);
    } else if ($result == 2) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "No questions for this test";
        $response['Payload'] = array();
        echoResponse(200, $response);
    } else if ($result == 3) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "No questions for this test";
        $response['Payload'] = array();
        echoResponse(200, $response);
    } else if ($result == 4) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "This test doesnot exist";
        $response['Payload'] = array();
        echoResponse(200, $response);
    }
});


/* *
 * URL: http://13.233.187.243/api/v1/Answerlist
 * Parameters: 'authtoken', 'video_id','topic_id','review','rating'
 * Method: POST
 * */
$app->post('/Answerlist', function () use ($app) {
    verifyRequiredParams(array('authtoken', 'test_id'));
    $response = array();
    $authtoken = $app->request->post('authtoken');
    $test_id = $app->request->post('test_id');
    $somejson = $app->request->post('answers');
    $db = new DbOperation();
    $res = $db->answerlist($authtoken,$test_id,$somejson);
    $result = $res[0];
    $response['Activeongoogleplay'] = Activeongoogleplay;
    if ($result == 0) {
        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "Questions with correct answer sent successfully";
        $response['Payload'] = $res[1];
        echoResponse(201, $response);
    } else if ($result == 1) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Auth token not matched";
        $response['Payload'] = array();
        echoResponse(200, $response);
    } else if ($result == 2) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "No questions for this test";
        $response['Payload'] = array();
        echoResponse(200, $response);
    } else if ($result == 3) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "No questions for this test";
        $response['Payload'] = array();
        echoResponse(200, $response);
    } else if ($result == 4) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "This test doesnot exist";
        $response['Payload'] = array();
        echoResponse(200, $response);
    }
});

/* *
 * URL: http://13.233.187.243/api/v1/CollegeList
 * Parameters: username, password, login_type, social_id, device_type, device_id
 * Method: POST
 * */
    $app->post('/CollegeList', function () use ($app) {
    verifyRequiredParams(array('state_id'));
    $response = array();
    $state_id = $app->request->post('state_id');
    $db = new DbOperation();
    $result = $db->collegelist($state_id);
    $response['Activeongoogleplay'] = Activeongoogleplay;
    if (!empty($result[1])) {

        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "College list successfully sent";
        $response["Payload"] = $result[1];
        echoResponse(201, $response);
    } else if($result[0] == 2) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "No college in the list";
        $response['Payload'] = array();
        echoResponse(200, $response);
    } 
});

$app->post('/Updatesubscriptionhours', function () use ($app) {
    verifyRequiredParams(array('authtoken', 'subject_id','remaining_hours'));
    $response = array();
    $authtoken = $app->request->post('authtoken');
    $topic_id = $app->request->post('subject_id');
    $remaininghours = $app->request->post('remaining_hours');
    $db = new DbOperation();
    $res = $db->updatesubscriptionhours($authtoken, $topic_id,$remaininghours);
    $result = $res[0];
    $response['Activeongoogleplay'] = Activeongoogleplay;
    if ($result == 0) {
        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "Hours remaining updated successfully";
        $response["Payload"] = $res[1];
        echoResponse(201, $response);
    } else if ($result == 1) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Auth token not matched";
        $response['Payload'] = array();
        echoResponse(200, $response);
    } else if ($result == 2) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Student not subscribed the subject";
        $response['Payload'] = array();
        echoResponse(200, $response);
    } 
});

/* *
 * URL: http://13.233.187.243/api/v1/Topicdetails
 * Parameters: authtoken, topic_id
 * Method: POST
 * */
$app->post('/Checkauthtoken', function () use ($app) {
    verifyRequiredParams(array('authtoken'));
    $response = array();
    $authtoken = $app->request->post('authtoken');
    $db = new DbOperation();
    $res = $db->checkauthtoken($authtoken);
    $response['Activeongoogleplay'] = Activeongoogleplay;
    if ($res == 1) {
        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "Auth token successfully matched";
        $response["Payload"] = new stdClass();
        echoResponse(201, $response);
    } else{
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Auth token not matched";
        $response['Payload'] = new stdClass();
        echoResponse(200, $response);
    } 
});



/*sz code start*/
/* *
 * URL: http://13.233.187.243/api/v1/Isalreadylogin
 * Parameters: authtoken, studentId
 * Method: POST
 * */
$app->post('/Isalreadylogin', function () use ($app) {
    verifyRequiredParams(array('authtoken','studentId'));
    $response = array();
    $authtoken = $app->request->post('authtoken');
    $studentId = $app->request->post('studentId');
    $db = new DbOperation();
    $res = $db->checkIsLoggedIn($authtoken,$studentId);
    $response['Activeongoogleplay'] = Activeongoogleplay;
    if ($res == 0) {
        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "Using same device";
        $response["Payload"] = new stdClass();
        echoResponse(201, $response);
    } elseif ($res == 1){
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Auth Token not match";
        $response['Payload'] = new stdClass();
        echoResponse(200, $response);
    } elseif ($res == 2){
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Student Id not found";
        $response['Payload'] = new stdClass();
        echoResponse(200, $response);
    }
});

/*sz code end*/

/* *
 * URL: http://13.233.187.243/api/v1/user_notification
 * Parameters: authtoken, topic_id
 * Method: POST
 * */
$app->post('/getnotification', function () use ($app) {
    verifyRequiredParams(array('authtoken'));
    $response = array();
    $authtoken = $app->request->post('authtoken');
    
    $db = new DbOperation();
    $res = $db->getnotification($authtoken);
    $result = $res[0];
    if ($result == 0) {
        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "Notification fetched  successfully.";
        $response["Payload"] = $res[1];
        echoResponse(201, $response);
    } else if ($result == 1) {
        $response["Error"] = true;
        $response["Status"] = 0;
        $response["Message"] = "Auth token not matched";
        echoResponse(200, $response);
    } else if ($result == 2) {
        $response["Error"] = false;
        $response["Status"] = 1;
        $response["Message"] = "No Notifications";
        $response["Payload"] = $res[1];
        echoResponse(200, $response);
    }
});


$app->run();