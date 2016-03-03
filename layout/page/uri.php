<?php
//echo '<pre>';
//var_dump($_SERVER); die();
// echo '</pre>';
$url = $_SERVER ['REQUEST_URI'];
//$a_url = explode('/', $url);
//$URI = "/{$a_url[1]}";
$URI = '.';
define('_URI_', $URI);

$url = $_SERVER['DOCUMENT_ROOT'];
define('_ROOT_', $url);
