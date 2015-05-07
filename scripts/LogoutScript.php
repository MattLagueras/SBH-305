<?php

include("SessionManager.php");

$sessionManager = SessionManager::getManager();
	$sessionManager->startSession();
	$sessionManager->endSession();
	
	$url = "http://localhost/SBH/index.html";
		$statuscode = 100;
		header('Location: ' . $url, true, $statusCode);

?>