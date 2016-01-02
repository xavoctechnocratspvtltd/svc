<?php
$config['url_prefix']='?page=';
$config['url_postfix']='';

$config['js']['versions']['jqueryui']='1.11.master';

// rvadym/language
$config['rvadym']['languages']  = array(
    'languages'            => array('en','ru'),
    'default_language'     => 'en',
    'switcher_type'        => 'session',      // session or url
    'translation_dir_path' => 'translations',  // relative to project root dir path
    'store_type'           => 'file',          // file | db
    //'model'               => 'Translation',   // if 'store_type' == db provide name of Model
    //'switcher_tag'        => 'language_switcher_panel'   // if 'store_type' == db provide name of Model
    //'to_same_page'        => true   //
    'var_name'             => 'lang',   //
    'debug'                => true,   //
);


$config['dsn']=isset($_ENV['DATABASE_URL']) ? str_replace(
  ['mysql2',':3306'],
  ['mysql',''],
  $_ENV['DATABASE_URL']) : $config['dsn']='mysql://root:winserver@127.0.0.1/svc';

$config['tmail']['transport'] = 'Echo';