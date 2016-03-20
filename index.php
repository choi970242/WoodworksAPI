<?php

// inclue the various view classes
include('views.php');
include('actions.php');

// work out what format they want
$accept = explode(',', $_SERVER['HTTP_ACCEPT']);
if($accept[0] == 'text/html') {
    $view = new HtmlView();
} elseif($accept[0] == 'text/xml') {
    $view = new XmlView();
} else {
    $view = new JsonView();
}

try{
// route the request (filter input!)
if($_SERVER['REQUEST_METHOD'] == 'POST'){
$request = json_decode(file_get_contents("php://input"));
if(property_exists($request,'param'))
	$params = $request -> param;
else
	$params = null;
if(property_exists($request,'user_key'))
	$user_key = $request -> user_key;
else
	$user_key = null;
}
elseif($_SERVER['REQUEST_METHOD'] == 'GET'){
$request = $_GET['method'];
$params = $_GET['params'];	
}

$library = new Actions();
// OBVIOUSLY you would filter input at this point
$action = $request -> method;
$data = $library->$action($params,$user_key);
// output appropriately
$view->render($data);
}
catch(Exception $e){
	$view->render(array("error" => "1", "message" =>$e->getMessage()));
}