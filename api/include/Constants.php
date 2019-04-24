<?php
//Constants to connect with the database
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_NAME', 'medivarsity');

//Constants to use 
define('SALT', '5&JDDlwz%Rwh!t2Yg-Igae@QxPzFTSId');
define('BASH_PATH', '');



//date time format
date_default_timezone_set('Asia/Kolkata');
define('FULL_TIME_FORMAT', 'Y-m-d h:i A');
define('TIMESTAMP_FORMAT', time());
define('DATE_FORMAT_SIMPLE', 'Y-m-d');
define('CREATED_DATE', strtotime(date(FULL_TIME_FORMAT)));


