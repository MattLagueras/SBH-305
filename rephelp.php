<!DOCTYPE html>


<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include_once("scripts/SessionManager.php");
include_once ("scripts/RepUtilites.php");


	$sessionManager = SessionManager::getManager();
	$sessionManager->startSession();
	
	$id = $sessionManager->getSessionVar("userid");
	$role = $sessionManager->getSessionVar("role");
	
	if($id == "invalid" || $role != "rep")
	{
		$url = "login.php";
		$statuscode = 403;
		header('Location: ' . $url, true, $statusCode);
	}
	
	$utilites = new RepUtilites($id);
	

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

$utilites->echoNav(6);

?>

<div class="container" style = "position: relative; top: 20px;">
	

		<div class="row">
		
		<div class="span9">
		
		<section>
		
		<div class="page-header">
        <h1>Welcome</h1>
		</div>
		
		<p>Hello, This is the help section for customer representatives.  We will outline your functionality and how to use each page </p>
		
		<h3>Advertisement</h3>
		<p>This page allows you to create and delete advertisements.  Simply fill out the required fields to create an advertisement, you will also need to upload a picture for the advertisement.  Try to choose a large image</p>
		</p>You may also delete an advertisement you have made by selecting it from the dropdown list</p>
		
		<h3>Transactions</h3>
		<p>This page allows you to see the transitions that are occurring on the site.  Simply select a customer from the dropdown menu to view his/her transitions</p>
			
		<h3>Mailing Lists</h3>
		<p>Here you can obtain a mailing list of all customers registered for you to use </p>
		
		<h3>Suggestion Lists</h3>
		<p>This page allows you to build custom suggestion lists for any customer registered.  First select the desired customer from the dropdown.  Then simply add or remove items to suggest using the dropdown menus</p>
		<p>Note that each customer cannot be suggested the same item more than once</p>
		
		<h3>Customers</h3>
		<p>Here you may add, edit, and remove customers from the site.  Simply fill out the form to add a customer, or select a customer from the dropdown on the right to edit/delete</p>
		
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