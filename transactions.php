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
      <title>Transactions</title>
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

$utilites->echoNav(2);

?>

<div class="container" style = "position: relative; top: 20px;">



	<div class="row">
		
		<div class="span9">
			
			
			
			<section>

			<div class="page-header">
            <h1>Customer Transactions</h1>
			</div>
			
			<form>
			
			<label>Select Customer</label>
			<select id = "custid" required>
			<option  value="" disabled>Customer List</option>
			
			<?php
			
				$result = $utilites->getCustomerList();
				
				while($row = $result->fetch_assoc())
				{
					echo '<option value = '.$row['idcustomer'].'>'.$row['firstname'].' '.$row['lastname'].'</option>';
				}
			
			?>
			
			</select>
			
			</form>
			
			<div id="result">
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
	
	<script>
	
	var script = "scripts/AjaxHandlerRep.php";
	
	$("#custid").change(function(e) {
	
		var formData = new FormData();
		
		formData.append("action",8);
		formData.append("idcustomer",$("#custid").val());
		formData.append("uid",<?php echo $id; ?>);
		
		$.ajax({
				type: "POST",
				url: script,
				dataType: "json",
				data: formData,
				cache: false,
				processData: false, 
				contentType: false,
				success: function(msg)
				{
					$("#result").html(msg.html);
					
				},
				error: function(msg) {
					var y;
				}
				
			});
	
	});

	</script>
	
</body>
</html>