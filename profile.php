<!DOCTYPE html>

<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include_once("scripts/SessionManager.php");
include_once ("scripts/CustomerUtilites.php");
include_once ("scripts/Navbar.php");


	$sessionManager = SessionManager::getManager();
	$sessionManager->startSession();
	
	$id = $sessionManager->getSessionVar("userid");
	
	if($id == "invalid")
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
      <title>Home</title>
      <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <meta name="description" content="Bootplus : Sleek, intuitive, and powerful Google styled front-end framework for faster and easier web development" />
      <meta name="keywords" content="bootplus, google plus, google+, plus, bootstrap, framework, web framework, css3, html5" />
      <meta name="author" content="AozoraLabs by Marcello Palmitessa"/>
      <link rel="publisher" href="https://plus.google.com/117689250782136016574">

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
                                   <link rel="shortcut icon" href="assets/ico/favicon.png">
								   

	


	
	</script>

 
  </head>

<body>

    <!-- Navbar
    ================================================== -->
	<?php
	
	$navbar = new Navbar($id,1);
	$navbar->echoNav();
	
	?>
	
	
	<div class="container" style = "position: relative; top: 20px;">
	

		<div class="row">
		
		
		
			<div class="span7 offset2">
			
			<section>
			<div class="page-header">
            <h1>Profile</h1>
			</div>
			
			<form id="addpref">
			
			<label>Add Prefrences</label>
			<select data-placeholder="Add a Preference" required class="chosen-select" multiple style="width:350px;" tabindex="4" id = "addselect">
			
			<?php
			
			$result = $utilites->listAvaliableTypes();
			
			while($row = $result->fetch_assoc())
			{
				echo '<option value="'.$row['idtype'].'">'.$row['content'].'</option>';
			}
			
			?>
			
			
			</select>
			
			<button type="submit" class="btn">Submit</button>
			
			</form>
			
			
			<form id="removepref">
			
			<label>Remove Prefrences</label>
			<select data-placeholder="Add a Preference" required class="chosen-select" multiple style="width:350px;" tabindex="4" id = "removeselect">
			
			<?php
			
			$result = $utilites->listCustomerPreferences();
			
			while($row = $result->fetch_assoc())
			{
				echo '<option value="'.$row['idtype'].'">'.$row['content'].'</option>';
			}
			
			?>
			
			
			</select>
			
			<button type="submit" class="btn">Submit</button>
			
			</form>
			
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

	
	<script>

	
	var script = "scripts/AjaxHandler.php";
	
	
	$("#namecircleinput").click(function(e) {
			
			e.stopPropagation();
	});
	
	$(".acceptcircleinv").click(function(e){
	 
		var cid = $(e.target).attr("id");
		var uid = <?php  echo $id;  ?>;
		var action = 10;
		
		var darray = new Array(action,cid,uid);
		
		$.ajax({
				type: "POST",
				url: script,
				dataType: "json",
				data: {data:darray},
				success: function(msg){
					
					location.reload();
					
				},
				error: function(msg) {
					var y;
				}
				
			});
		
	 
	 });
	 
	 $(".declinecircleinv").click(function(e){
	 
		var cid = $(e.target).attr("id");
		var uid = <?php  echo $id;  ?>;
		var action = 11;
		
		var darray = new Array(action,cid,uid);
		
		$.ajax({
				type: "POST",
				url: script,
				dataType: "json",
				data: {data:darray},
				success: function(msg){
					
					location.reload();
					
				},
				error: function(msg) {
					var y;
				}
				
			});
		
	 
	 });
	 
	 $("#createcircle").submit(function(e){
	 
		e.preventDefault();
		
		var name = $("[name='namecircleinput'").val();
		var uid = <?php  echo $id;  ?>;
		var action = 14;
		
		var darray = new Array(action,name,uid);
		
			
			$.ajax({
				type: "POST",
				url: script,
				dataType: "json",
				data: {data:darray},
				success: function(msg){
					
					location.reload();
					
				},
				error: function(msg) {
					var y;
				}
				
			});
	 
	 
	 });
	 
	 
	 $("#addpref").submit(function(e) {
	 
		e.preventDefault();
		

		$('#addselect :selected').each(function(i, selected){ 
		  var value = $(selected).val(); 
		  
		  var darray = new Array(27,value,<?php echo $id;  ?>);
		  
		  $.ajax({
				type: "POST",
				url: script,
				dataType: "json",
				data: {data:darray},
				success: function(msg){
					
					
				},
				error: function(msg) {
					var y;
				}
				
			});
		  
		});
		
		location.reload();
	 
	 });
	
	 
	 $("#removepref").submit(function(e) {
	 
		e.preventDefault();
		
		$('#removeselect :selected').each(function(i, selected){ 
		  var value = $(selected).val(); 
		  
		  var darray = new Array(28,value,<?php echo $id;  ?>);
		  
		  $.ajax({
				type: "POST",
				url: script,
				dataType: "json",
				data: {data:darray},
				success: function(msg){
					
				
					
				},
				error: function(msg) {
					var y;
				}
				
			});
		  
		});
		
		location.reload();
	 
	 });
	 
	 
	
	
	</script>
	
	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
			  <script src="chosen/chosen.jquery.js" type="text/javascript"></script>
  <script src="chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript">
  
  
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
	
	</script>
	  </body>
</html>
