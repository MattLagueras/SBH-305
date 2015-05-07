<?php

include_once ("RepUtilites.php");

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


	$con = DBcon::getDBcon();
	$mysqli = $con->getMysqliObject();
	

	$utilites = new RepUtilites(111221);

	if($_POST['action'] == 0)
	{
		$result = $utilites->checkUniqueEmail($_POST['email']);
		
		echo json_encode(array('result' => 'success', 'count' => $result));
	}
	
	if($_POST['action'] == 1)
	{
		$result = $utilites->checkUniqueUsername($_POST['username']);
		
		echo json_encode(array('result' => 'success', 'count' => $result));
	}
	
	if($_POST['action'] == 2)
	{
		$result = $utilites->createCustomer($_POST['firstname'],$_POST['lastname'],$_POST['email'],$_POST['username'],$_POST['password'],$_POST['gender'],$_POST['birthdate'],$_POST['address'],$_POST['city'],$_POST['state'],$_POST['zip'],$_POST['phone']);
	
		echo json_encode(array('result' => 'success'));
	
	}

?>