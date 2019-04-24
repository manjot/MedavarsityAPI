<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
// create hook for langunage
$hook['post_controller_constructor'][] = array(
    'class'    => 'ProfileLoader',
    'function' => 'initialize',
    'filename' => 'ProfileLoader.php',
    'filepath' => 'hooks'
);

$hook['post_controller_constructor'][] = array(
    'class'    => 'PackageLoader',
    'function' => 'initializePackage',
    'filename' => 'PackageLoader.php',
    'filepath' => 'hooks'   
);