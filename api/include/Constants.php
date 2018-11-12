<?php
//Constants to connect with the database
define('DB_USERNAME', 'newuser');
define('DB_PASSWORD', 'password');
define('DB_HOST', 'localhost');
define('DB_NAME', 'ajath_api_db');

//Constants to use 
define('SALT', '5&JDDlwz%Rwh!t2Yg-Igae@QxPzFTSId');
define('PARENT_ROOT_PATH', '/home/mysita/public_html/24x7/');
define('HTTP_UPLOAD_USER_PROFILE_THUMB_PATH', PARENT_ROOT_PATH.'assets/uploads/_thumb/'); 
define('ROOT_UPLOAD_DC_PATH', PARENT_ROOT_PATH . 'document-center/');
define('BASH_PATH', 'http://24x7.mysita.com/');
define('HTTP_USER_PROFILE_THUMB_PATH', BASH_PATH.'assets/uploads/_thumb/'); 
define('HTTP_USER_UPLOAD_DC_PATH', BASH_PATH . 'document-center/');

//date time format
define('FULL_TIME_FORMAT', 'Y-m-d h:i A');
define('TIMESTAMP_FORMAT', time());
define('DATE_FORMAT_SIMPLE', 'Y-m-d');
define('CREATED_DATE', strtotime(date(FULL_TIME_FORMAT)));

