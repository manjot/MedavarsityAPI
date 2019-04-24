<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
  |--------------------------------------------------------------------------
  | Display Debug backtrace
  |--------------------------------------------------------------------------
  |
  | If set to TRUE, a backtrace will be displayed along with php errors. If
  | error_reporting is disabled, the backtrace will not display, regardless
  | of this setting
  |
 */
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
  |--------------------------------------------------------------------------
  | Exit Status Codes
  |--------------------------------------------------------------------------
  |
  | Used to indicate the conditions under which the script is exit()ing.
  | While there is no universal standard for error codes, there are some
  | broad conventions.  Three such conventions are mentioned below, for
  | those who wish to make use of them.  The CodeIgniter defaults were
  | chosen for the least overlap with these conventions, while still
  | leaving room for others to be defined in future versions and user
  | applications.
  |
  | The three main conventions used for determining exit status codes
  | are as follows:
  |
  |    Standard C/C++ Library (stdlibc):
  |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
  |       (This link also contains other GNU-specific conventions)
  |    BSD sysexits.h:
  |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
  |    Bash scripting:
  |       http://tldp.org/LDP/abs/html/exitcodes.html
  |
 */
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code




date_default_timezone_set('Asia/Kolkata');
$root = "http://".$_SERVER['SERVER_NAME'];
//if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on"){$ssl_set = "s";} else{$ssl_set = "";}
//$root = 'http'.$ssl_set.'://'.$_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);

$constants['base_url'] = $root;
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'medivarsity');

define('BASH_PATH', 'medivarsity/');
define('SITENAME','Medivarsity');
define('SITEURL','http://localhost/medivarsity/');
define('COURSESURL',SITEURL.'admin/assets/images/subjects/');
define('FACULTYURL',SITEURL.'admin/assets/images/faculty/');
define('COURSEPRICE',4000);
define('DISCOUNTPERCENTAGE',20);
$discount = (COURSEPRICE * DISCOUNTPERCENTAGE)/100;
$discountpercentage = COURSEPRICE - $discount;
define('PREBOOKPRICE',$discountpercentage);
define('USER_IP_ADDRESS', $_SERVER['REMOTE_ADDR']);
define('HTTP_ASSETS_PATH', $constants['base_url'] . 'assets/');
define('HTTP_IMAGE_PATH', $constants['base_url'] . 'profilepicture/');
define('HTTP_LANDING_PATH', $constants['base_url'] . 'assets/landing/');
define('HTTP_CSSELECTION_PATH', $constants['base_url'] . 'assets/csselection/');

define('HTTP_USER_PROFILE_IMAGE_PATH', $constants['base_url'] . 'assets/uploads/');
define('HTTP_USER_PROFILE_THUMB_PATH', $constants['base_url'] . 'assets/uploads/_thumb/');


define('ROOT_UPLOAD_PATH', BASH_PATH . 'assets/uploads/');
define('ROOT_USR_COMPANY_LOGO_UPLOAD_PATH', BASH_PATH . 'assets/uploads/company/logo/');
define('ROOT_USR_COMPANY_SIGNATURE_UPLOAD_PATH', BASH_PATH . 'assets/uploads/company/signature/');



define('hypertensives_male', 10);
define('smoking_male', 9);
define('stroke_male', 1);
define('diabetes_male', 4);
define('hypertensives_female', 11);
define('smoking_female', 9);
define('stroke_female', 4);
define('diabetes_female', 3);
define('ethnicityconstantmales', 8);
define('ethnicityconstantfemales', 5);

define('TO_MAIL', 'info@soolegalhelp.com'); 
define('FROM_MAIL', 'info@soolegalhelp.com');
define('CC_MAIL', 'jaeeme.khan@sitanet.in');
define('ADMIN_MAIL', 'admin@soolegal.com');
define('ABUSE_MAIL', 'abuse@soolegal.com');
define('CONTACTUS_MAIL', 'contactus@soolegal.com');
define('CUSTOMERCARE_MAIL', 'customercare@soolegal.com');
define('LISTEDCASE_MAIL', 'listedcase@soolegal.com');
define('NOREPLY_MAIL', 'no-reply@soolegal.com');
define('IP_ADDRESS', '50.63.161.54');
define('Mailin_TAG', 'SoOLEGAL');
define('FROM_TEXT', 'SoOLEGAL');
define('FROM_TEXT_NEWS', 'Trending legal news of the week');
define('FROM_TEXT_ROAR', 'Trending Legal Article of this week');

define('SALT', '5&JDDlwz%Rwh!t2Yg-Igae@QxPzFTSId');
define('SALT_URL', '|gildServer');
define('SALT_HIDDEN', '@GILD@');

define('INVOICE_PRE_FIX', 'INV');
define('TRANSACTION_CHARGE', 5);
define('PREMIUM_MEMBER_AMOUNT', 9999);
define('JUDGEMENT_INTERPRETION_PRICE', 499); 
define('LEGAL_RESEARCH_PRICE', 10000); 




define('DATE_TIME_FORMAT', 'j M Y g:ia');
define('DATE_FORMAT', 'j M Y');
define('DATE_FORMAT_CRON', 'j M y');
define('DATE_TIME_FORMAT_DOB', 'j F');
define('DATE_TIME_FORMAT_DOF', 'j F Y');
define('TIME_FORMAT', 'g:i:s a');
define('FULL_TIME_FORMAT', 'Y-m-d G:i:s');
define('TIMESTAMP_FORMAT', time());
define('DATE_FORMAT_SIMPLE', 'Y-m-d');
define('DATE_FORMAT_DMY', 'd-M-y');
define('DATE_FORMAT_EVENT', 'j M Y @ h:i a');
define('CREATED_DATE', strtotime(date(FULL_TIME_FORMAT)));

/*
// SMS Integration Api credential
define('SMS_USER_NAME', 'T4sitanet');
define('SMS_PWD', '511410');
define('SMS_SENDER_ID', 'SOOLGL');
// delhi high court bar association
define('SMS_DHCBA_SENDER_ID', 'tDHCBA');
// new delhi bar association
define('SMS_NDBA_SENDER_ID', 'TmNDBA');
// dwarka bar association
define('SMS_DCBA_SENDER_ID', 'DCBAhs');
// ranchi bar association
define('SMS_RCBA_SENDER_ID', 'slRCBA');
// Gurugram bar association
define('SMS_DBAG_SENDER_ID', 'slDBAG');
// saket bar association
define('SMS_SCBA_SENDER_ID', 'TMSCBA');
define('SMS_URL', 'http://nimbusit.net/api.php');

// SMS Integration Api Credential (smsfresh)
define('SM_USER_NAME', 'soolegal');
define('SM_PWD', '123456');
define('SM_SENDER_ID', 'SOOLGL');
define('SM_DHCBA_SENDER_ID', 'tDHCBA');
define('SM_NDBA_SENDER_ID', 'TmNDBA');
define('SM_DCBA_SENDER_ID', 'DCBAhs');
define('SM_URL', 'http://promo.smsfresh.co/api/sendmsg.php');
define('SM_PRIORITY_NON_DND', 'ndnd');
define('SM_PRIORITY_DND', 'dnd');
define('SM_TYPE_NORMAL', 'normal');
define('SM_TYPE_FLASH', 'flash');
define('SM_TYPE_UNICODE', 'unicode');*/

// PAYUMONEY Payment Gateway Integration credential
//define('PAYU_MERCHANT_KEY', 'YXFBqczF');
//define('PAYU_SALT', 'pUyoAjm4OT'); 
//define('PAYU_URL', 'https://test.payu.in');

 
define('PAYU_MERCHANT_KEY', 'gtKFFx');
define('PAYU_SALT', 'eCwWELxi');
define('PAYU_URL', 'https://test.payu.in');
define('SERVICE_PROVIDER','');

// SMS Integration Api credential(digitalad)
define('SMS_USER_NAME', 'sitanet');
define('SMS_PWD', 'sitanet');
define('SMS_SENDER_ID', 'SoOLGL');
define('SMS_SENDER_ID_DIGI', 'PIYUSH');
define('SMS_ROUTE_ID', 10);
// delhi high court bar association
define('SMS_DHCBA_SENDER_ID', 'tDHCBA');
// new delhi bar association
define('SMS_NDBA_SENDER_ID', 'TmNDBA');
// dwarka bar association
define('SMS_DCBA_SENDER_ID', 'DCBAhs');
// ranchi bar association
define('SMS_RCBA_SENDER_ID', 'slRCBA');
// Gurugram bar association
define('SMS_DBAG_SENDER_ID', 'slDBAG');
// saket bar association
define('SMS_SCBA_SENDER_ID', 'TMSCBA');
define('SMS_URL', 'http://94.130.51.17/http-api.php');

/*// SMS Integration Api credential(thinkbuyget)
define('SMS_USER_NAME', 'sitanet');
define('SMS_PWD', '379559');
define('SMS_SENDER_ID', 'SOOLGL');
// delhi high court bar association
define('SMS_DHCBA_SENDER_ID', 'tDHCBA');
// new delhi bar association
define('SMS_NDBA_SENDER_ID', 'TmNDBA');
// dwarka bar association
define('SMS_DCBA_SENDER_ID', 'DCBAhs');
// ranchi bar association
define('SMS_RCBA_SENDER_ID', 'slRCBA');
// Gurugram bar association
define('SMS_DBAG_SENDER_ID', 'slDBAG');
// saket bar association
define('SMS_SCBA_SENDER_ID', 'TMSCBA');
define('SMS_URL', 'http://sms.thinkbuyget.com/api.php'); */

//define('PAYU_MERCHANT_KEY','TZGgjBSi');
//define('PAYU_SALT','PwJgaq3tvW');
//define('PAYU_URL','https://secure.payu.in');
//define('SERVICE_PROVIDER','payu_paisa');



/*define('PAYU_MERCHANT_KEY','4vqS6H8S');
define('PAYU_SALT','reOBsjU8dd');
define('PAYU_URL','https://secure.payu.in');*/

/*define('PAYU_MERCHANT_KEY','TZGgjBSi');
define('PAYU_SALT','PwJgaq3tvW');
define('PAYU_URL','https://secure.payu.in');*/

define('EMAIL_BASE_URL', 'https://api.sendinblue.com/v2.0');
define('EMAIL_API_KEY_SECOND', 'RWrkmVJSXE7gcfL1');
define('EMAIL_API_KEY', 'Z7sPTfHz5U6hcIwM');

define('GOOGLE_URL_SHORTNER', 'AIzaSyD89FX23QJ85-l87nUaIlWbW7ALj2Izxbs');

define('FIREBASE_API_KEY', "AIzaSyBDjPrxVqMCykYY1XMR1gE0ZZkkTVsZSws");

// SMTP Setting
define('PROTOCOL', 'smtp');
//define('SMTP_HOST', 'ssl://smtp.googlemail.com');
//define('SMTP_PORT', 465);
//define('SMTP_USER', 'soolegal@gmail.com');
//define('SMTP_PASS', 'Sita@m1sSO');

/*define('SMTP_HOST', 'mail.sasthanetwork.in');
define('SMTP_PORT', 587);
define('SMTP_USER', 'demo@sasthanetwork.in');
define('SMTP_PASS', 'sasnet123');*/

/*define('SMTP_HOST', 'mail.sasthanetwork.in');
define('SMTP_PORT', 587);
define('SMTP_USER', 'demo@sasthanetwork.in');
define('SMTP_PASS', 'sasnet123');*/

define('SMTP_HOST', 'mail.soolegalhelp.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'info@soolegalhelp.com');
define('SMTP_PASS', 'soo123legal');

/*define('SMTP_HOST', 'mail.mysita.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'admin@mysita.com');
define('SMTP_PASS', 'Sita12!@');*/

define('MAILTYPE', 'html');
define('CHARSET', 'utf-8');
// Mail Setting
define('MAIL_FROM', 'admin@mysita.com');
//define('MAILING_SERVICE_PROVIDER', 'service-provider');
define('MAILING_SERVICE_PROVIDER', 'smtp');
//define('MAILING_SERVICE_PROVIDER', 'default');



// test Razorpat credential
define('RAZOR_KEY_ID', 'rzp_test_CxcVqBsiwgBhbG');
define('RAZOR_KEY_SECRET', 'BA9SgHHmzGB0BlOH8iUtoAtW');

//define('RAZOR_KEY_ID', 'rzp_live_dQRw63w3ektRgo');
//define('RAZOR_KEY_SECRET', 'StUlczxLiPqkGY99tw3xfuWr');

define('PAYMENT_METHOD', 'RAZOR');
define('GST_SERVICE_TAX_VALUE', 18);
define('INDIAN_LANGUAGE_PRICE', 1000);
define('FOREIGN_LANGUAGE_PRICE', 2000);
define('GB_TOTAL_RC_SPACE_FREE', 2);



