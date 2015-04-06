<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include("SessionManager.php");

include ("DBcon.php");


	$sessionManager = SessionManager::getManager();
	$sessionManager->startSession();
	
	
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
		$res = array('message' => "customer");
		echo json_encode($res);
	}
	else
	{
		$res = array('message' => "error");
		echo json_encode($res);
	}
	
	mysqli_stmt_close($query);


?>