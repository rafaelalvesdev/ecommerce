<?php

header('Content-Type:application/json');

$classes[] = 'ProductController';

$classe = $_GET['class'] . 'Controller';
$metodo = $_GET['action'];

if(!in_array($classe, $classes)){
	http_response_code(500);
	exit('invalid object name');
}
require_once $classe . '.php';
 
$obj = new $classe();
if (!method_exists($obj, $metodo)){
	//http_response_code(501);
	exit('invalid method');
}

$obj->$metodo();