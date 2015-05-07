<?php

include("SessionManager.php");

$sessionManager = SessionManager::getManager();
	$sessionManager->startSession();
	$sessionManager->endSession();
	
	$url = "../index.html";
		$statuscode = 100;
		header('Location: ' . $url, true, $statusCode);

?>