<?php
chdir('..');
require_once'../vendor/autoload.php';
require_once 'lib/Frontend.php';

file_put_contents('../assets/'.str_replace("_vizi_frontend_public_","",str_replace("/", "_", $_SERVER['REDIRECT_URL'])).'.txt', "SERVER = ". print_r($_SERVER,true)."\n GET = ". print_r($_GET,true) . "\n POST = ". print_r($_POST,true)."\n REQUEST = ". print_r($_REQUEST,true). "\n Request Body = ". @file_get_contents('php://input'));
file_put_contents('../assets/flow.txt', "IN " . $_SERVER['REDIRECT_URL']." - \n" . @file_get_contents('php://input'),FILE_APPEND);

$api=new Frontend('front');
$api->main();
// file_put_contents('../assets/output.txt',ob_get_contents());