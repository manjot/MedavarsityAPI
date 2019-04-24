<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.htmll
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */
/* $route['default_controller'] = 'home';
  $route['registration'] = 'home/registration'; */

// Home
$route['default_controller'] = 'home';
$route['login'] = 'home/login';
$route['forgotpassword'] = 'home/forgotpassword';
$route['registration'] = 'home/registration';
$route['profile'] = 'home/profile';
$route['saveregistration'] = 'home/saveregistration';
$route['sendquery'] = 'home/sendquery';
$route['bookcourse'] = 'home/bookcourse';
$route['healthform'] = 'home/healthform';
$route['doLogin'] = 'home/doLogin';
$route['logout'] = 'home/logout';
$route['savehealthform'] = 'home/savehealthform';
$route['myprofile'] = 'home/myprofile';
$route['registeruser'] = 'home/registeruser';
$route['forgot'] = 'home/sendforgotpassword';
$route['disclaimer'] = 'home/disclaimer';
$route['terms'] = 'home/terms';
$route['privacypolicy'] = 'home/privacypolicy';
$route['blog/leveraging-artificial-intelligence-towards-a-paradigm-shift-in-healthcare'] = 'home/blog';
$route['blog/promoting-wellness-through-a-digital-health-based-approach'] = 'home/blog1';




$route['404_override'] = 'home/error';



//admin


$route['slconnect'] = "slconnect/index";

$route['translate_uri_dashes'] = FALSE;



