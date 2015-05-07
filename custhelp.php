<!DOCTYPE html>


<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include_once("scripts/SessionManager.php");
include_once ("scripts/CustomerUtilites.php");


	$sessionManager = SessionManager::getManager();
	$sessionManager->startSession();
	
	$id = $sessionManager->getSessionVar("userid");
	$role = $sessionManager->getSessionVar("role");
	
	if($id == "invalid" || $role != "customer")
	{
		$url = "http://localhost/SBH/login.php";
		$statuscode = 403;
		header('Location: ' . $url, true, $statusCode);
	}
	
	$utilites = new CustomerUtilites($id,-1);
	

?>

<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Help</title>
      <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <meta name="description" content="Bootplus : Sleek, intuitive, and powerful Google styled front-end framework for faster and easier web development" />
      <meta name="keywords" content="bootplus, google plus, google+, plus, bootstrap, framework, web framework, css3, html5" />
      
      

      <!-- Le styles -->
      <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
      <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      <!--[if IE 7]>
      <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css">
      <![endif]-->

      <link href="assets/css/bootplus.css" rel="stylesheet">
      <link href="assets/css/bootplus-responsive.css" rel="stylesheet">

      <link href="assets/css/docs.css" rel="stylesheet">
      <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">
	  
	  
	  <link rel="stylesheet" href="chosen/chosen.css">
	  
	  




      <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
      <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.js"></script>
      <![endif]-->

      <!-- Le fav and touch icons -->
      <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="assets/ico/SBHlogo.jpg">
								   

	


	
	</script>

 
  </head>

<body>

<?php

$utilites->echoNav(7);

?>

<div class="container" style = "position: relative; top: 20px;">
	

		<div class="row">
		
		<div class="span9">
		
		<section>
		
		<div class="page-header">
        <h1>Welcome</h1>
		</div>
		
		<p>Hello, This is the help section for customers.  We will outline your functionality and how to use each page </p>
		
		<h3>All</h3>
		<p>Here you can see all the activity in regards to the circles you are in.  If your not in any circles you may not see any posts!</p>
		</p>You can post to any of your circles from this page, you may also elect to make a post visible to everyone and not just in a circle</p>
		
		<h3>Profile</h3>
		<p>Here you can view basic information about yourself as well as set item preferences.  Your preferences will dictate which advertisements get shown to you more!</p>
			
		<h3>Accounts</h3>
		<p>Here you can view your current accounts as well as their purchase history.  You may also create accounts here. You will need at least 1 account to make purchases.   </p>
		
		<h3>My Circles</h3>
		<p>Use the dropdown menu to view your in or you own.  In any circle your in you may make posts and comments.</p>
		<p>Circles you own you have the ability to add new members, remove members, as well as rename or delete the circle </p>
		
		
		<h3>Messages</h3>
		<p>The message center allows you to view message threads of those you are chatting with or start a new conversation.  You may also delete messages if you wish.</p>
		
		<h3>Purchases</h3>
		<p>Here you can view the top selling items on the site as well as items suggested for you from our staff!  You can also view all of your recent transitions</p>
		
		<h3>Search Circles</h3>
		<p>Here you can search for circles to join.  Simply hit the request to join button and feel free to message the owner</p>
		
		</section>
		
		</div>
		
		</div>
		
		
</div>


	<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
    <script src="assets/js/bootstrap-affix.js"></script>

    <script src="assets/js/holder/holder.js"></script>
    <script src="assets/js/google-code-prettify/prettify.js"></script>

    <script src="assets/js/application.js"></script>
	
	

	
  			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
			  <script src="chosen/chosen.jquery.js" type="text/javascript"></script>
  <script src="chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
  
  
  <script>
  
  var script = "scripts/AjaxHandlerRep.php";
  

  

  
  </script>
  
  
  

	

	

</body>
</html>