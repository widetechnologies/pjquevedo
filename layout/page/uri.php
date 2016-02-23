<?php

$url = $_SERVER ['REQUEST_URI'];
$a_url = explode('/', $url);
$URI = "/{$a_url[1]}";
define('_URI_', $URI);


