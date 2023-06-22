<?php
// Version
define('VERSION', '3.0.3.8');

//CarMod


@session_start();
if(isset($_GET['ln'])){
	Header('Location: '.str_replace('?&ln='.$_GET['ln'],'',$_SERVER['REQUEST_URI'])); die();
}
if(isset($_GET['cr'])){
	Header('Location: '.str_replace('?&cr='.$_GET['cr'],'',$_SERVER['REQUEST_URI'])); die();
}
ob_start();
$Selector_Position = 'Right'; // Left/Right position on the page - important for mobile adaptability dropdown menu
$Selector_Template = 'pt1';
include_once($_SERVER['DOCUMENT_ROOT'].'/carparts/add/selector/controller.php');
$CMMSELSCT = ob_get_contents();
define('CM_MSELSCT',$CMMSELSCT);

ob_clean();

ob_start();
$SearchPosition = 'Main'; // Left / Right
include_once($_SERVER['DOCUMENT_ROOT'].'/carparts/add/search/pt1/template.php');
$CM_SEARCH = ob_get_contents();
//var_dump($CM_SEARCH);exit;
define('CM_SEARCH',$CM_SEARCH);

ob_clean();
//ob_end_clean();
//@session_start();
//ob_start();
//$Selector_Position = 'Right'; // Left/Right position on the page - important for mobile adaptability dropdown menu
//$Selector_Template = 'default';
//include($_SERVER['DOCUMENT_ROOT'].'/carparts/add/selector/controller.php');
//$CM_GARAGE = ob_get_contents();
//
//define('CM_GARAGE',$CM_GARAGE);
//ob_clean();

ob_end_clean();

// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

// Install
if (!defined('DIR_APPLICATION')) {
	header('Location: install/index.php');
	exit;
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');

start('catalog');