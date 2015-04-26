<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include_once("SessionManager.php");

include_once ("DBcon.php");


	$sessionManager = SessionManager::getManager();
	$sessionManager->startSession();
	
	
	$con = DBcon::getDBcon();
	$mysqli = $con->getMysqliObject();
	
	
	$email = $_POST['email'];
	$pass = $_POST['password'];
	
	
	
	
	$query = mysqli_prepare($mysqli,"SELECT * FROM customer WHERE email = ? AND password = ?");
	
			 mysqli_stmt_bind_param($query,"ss",$email,$pass);
			 mysqli_stmt_execute($query);

			 $result = $query->get_result();

	if(mysqli_num_rows($result) > 0)
	{
		$row = $result->fetch_assoc();
		$sessionManager->setSessionVar("userid",$row['idcustomer']);
		$sessionManager->setSessionVar("role","customer");
		$res = array('message' => "customer");
		echo json_encode($res);
		$con->closeConnection();
	}
	else
	{
		$query = mysqli_prepare($mysqli,"SELECT * FROM manager WHERE email = ? AND password = ?");
		
		mysqli_stmt_bind_param($query,"ss",$email,$pass);
		mysqli_stmt_execute($query);
		
		$result = $query->get_result();
		
		if(mysqli_num_rows($result) > 0)
		{
		$row = $result->fetch_assoc();
		$sessionManager->setSessionVar("userid",$row['idmanager']);
		$sessionManager->setSessionVar("role","manager");
		$res = array('message' => "manager");
		echo json_encode($res);
		$con->closeConnection();
		}
		else
		{
		$res = array('message' => "error");
		echo json_encode($res);
		$con->closeConnection();
		}
	}
	
	


?>