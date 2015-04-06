<?php

include("SessionManager.php");

$sessionManager = SessionManager::getManager();
	$sessionManager->startSession();
	$sessionManager->endSession();

?>