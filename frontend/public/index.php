<?php
chdir('..');
require_once'../vendor/autoload.php';
require_once 'lib/Frontend.php';

$api=new Frontend('front');
$api->main();
// file_put_contents('../assets/output.txt',ob_get_contents());