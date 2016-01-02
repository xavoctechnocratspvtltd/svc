<?php
include '../config-default.php';

$config['frontend_url'] = isset($_ENV['DATABASE_URL']) ? "http://vn-01.daisy.agile55.com/frontned/public/":"http://localhost/vizi/frontend/public/";
$config['tmail']['from'] = "info@company.com";

