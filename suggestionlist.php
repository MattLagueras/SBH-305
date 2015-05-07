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
      <title>Suggestion Lists</title>
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

$utilites->echoNav(4);

?>

<div class="container" style = "position: relative; top: 20px;">
	

		<div class="row">
		
		<div class="span9">
		
		<section>
		
		<div class="page-header">
        <h1>Product Suggestion Lists</h1>
		</div>
		
			<form>
			
			<label>Select Customer</label>
			<select id = "custid" required class="chosen-select">
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
			
			<div id="suggestionlisttable">
			</div>
			
			<div id = "addsuggestionitem">
			
			<form id="addsuggform">
			<label>Suggest Items</label>
			<select id = "suggestitemselect" class="chosen-select" multiple style="width: 350px" tabindex = "4" required placeholder = "Suggest Items">';
			
			</select><br>
			<button class = "btn btn-primary" type = "submit">Submit</button>
			</form>
			
			</div>
			
			<div id = "removesuggestionitem">
			
			<form id="removesuggform">
			<label>Remove Suggestions</label>
			<select id = "removesuggitemlist" class="chosen-select" multiple style="width: 350px" tabindex = "4" required placeholder = "Remove Suggestions">';
			
			</select><br>
			<button class = "btn btn-primary" type = "submit">Submit</button>
			</form>
			
			</div>
			
			
			
		
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
  
  $("#addsuggform").submit(function(e) {
  
	e.preventDefault();
  
		$('#suggestitemselect :selected').each(function(i, selected){ 
		  var value = $(selected).val(); 
		  
			var formData = new FormData();
		
			formData.append("action",10);
			formData.append("idcustomer",$("#custid").val());
			formData.append("advkey",value);
			formData.append("uid",<?php echo $id; ?>);
		  
		  $.ajax({
				type: "POST",
				url: script,
				dataType: "json",
				data: formData,
				cache: false,
				processData: false, 
				contentType: false,
				success: function(msg){
					
	
					
				},
				error: function(msg) {
					var y;
				}
				
			});
		  
		});
	
		location.reload();
  
  });
  
  $("#removesuggform").submit(function(e) {
  
	e.preventDefault();
  
		$('#removesuggitemlist :selected').each(function(i, selected){ 
		  var value = $(selected).val(); 
		  
			var formData = new FormData();
		
			formData.append("action",11);
			formData.append("idcustomer",$("#custid").val());
			formData.append("advkey",value);
			formData.append("uid",<?php echo $id; ?>);
		  
		  $.ajax({
				type: "POST",
				url: script,
				dataType: "json",
				data: formData,
				cache: false,
				processData: false, 
				contentType: false,
				success: function(msg){
					
	
					
				},
				error: function(msg) {
					var y;
				}
				
			});
		  
		});
	
		location.reload();
  
  });
  
  $("#custid").change(function(e) {
  
	var cid = $("#custid").val();
	
	var formData = new FormData();
		
		formData.append("action",9);
		formData.append("idcustomer",cid);
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
				
					$("#suggestionlisttable").html(msg.sugtable);
					
					
					$("#suggestitemselect").empty().append(msg.sugselect);
					$("#suggestitemselect").trigger("chosen:updated");
					
					$("#removesuggitemlist").empty().append(msg.sugdelete);
					$("#removesuggitemlist").trigger("chosen:updated");

					
				},
				error: function(msg) {
					var y;
				}
				
			});
  
  
  });
  
  </script>
  
  
  
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