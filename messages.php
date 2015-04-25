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
	
	$navbar = new Navbar($id,4);
	$navbar->echoNav();
	
	?>
	
	
	<div class="container" style = "position: relative; top: 20px;">
	

		<div class="row">
		
		
		
		<div class="span3 bs-docs-sidebar" style="margin-top: 20px; ">
        <ul class="nav nav-list bs-docs-sidenav affix-top" style="overflow-y: scroll; height: 428px;">
    
		<?php
		
		$utilites->buildChatSelector();
		
		?>

        </ul>
      </div>
		
			<div class="span7">
			
			<button class = "btn btn-primary" id = "newmessage" style = "position: relative; top: 20px; right: 17px;" href="#newmessagemodal" data-toggle="modal">New Message </button>
			
			<section id="messages" style=" height: 700px; overflow-y: scroll">

		
			
			
		
			</section>
		
		<section style = "margin-top: 0px;">
		<form id="sendmessage">
		  <fieldset>
		  
			
			<textarea rows="4" cols="50" style = "width: 95%; resize: none;" name="messagetext" placeholder="Write back..." required></textarea>
			<button type="submit" class="btn">Submit</button>
		  </fieldset>
		</form>
		</section>
		
		
		
			</div>
			
		</div>
		
   </div>
   
   
  <div id="newmessagemodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">New Message</h3>
  </div>
  
  <div class="modal-body">
  
    <form id = "newmessageform">

	 <select data-placeholder="Choose a Country..." style="width:350px;" tabindex="1" name = "customerselect" required>
            <option value="" disabled>Select A Member</option>
			
			<?php
			
				$result = $utilites->getAllCustomer();
				
				while($row = $result->fetch_assoc())
				{
					if($row['idcustomer'] != $id)
					{
						echo '<option value="'.$row['idcustomer'].'" >'.$row['firstname'].' '.$row['lastname'].'</option>';
					}
				}
			
			?>
			
     </select>
	 
	 <textarea rows="4" cols="50" style = "width: 95%; resize: none;" name="newmessagetext" placeholder="Write a Message..." required></textarea>
    
	</form>
 
  </div>

     
  
  <div class="modal-footer">
    <button class="btn btn-primary" data-dismiss="modal" id="sendmsgmodal">Send</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

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
	var currentthread = -1;
	
	$(".messagethread").click(function(e){
		
		var id = $(e.target).attr("id");
		id = id.replace("mthread", "");
		currentthread = id;
		
		var uid = <?php  echo $id;  ?>;
		var action = 15;
		
		$("#messages").html("");
		
		var darray = new Array(action,id,uid);
		
		$.ajax({
				type: "POST",
				url: script,
				dataType: "json",
				data: {data:darray},
				success: function(msg){
					
					
					$("#messages").html(msg.html);
					//location.reload();
					
				},
				error: function(msg) {
					var y;
				}
				
			});
		
		
	
	});
	
	
	
	
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
	 
	 $("#sendmsgmodal").click(function(e) {
	 
		
	 $("#newmessageform").submit(function(e) {
	 
		e.preventDefault();
		
		var messagecontent = $("[name='newmessagetext'").val();
		var uid = <?php  echo $id;  ?>;
		var rid = $("[name='customerselect'").val();
		var action = 16;
		
		var darray = new Array(action,messagecontent,rid,uid);
		
			
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
	 
	 $("#newmessageform").submit();
	 
	 });
	 

	 
	 $("#sendmessage").submit(function(e){
	 
		e.preventDefault();
		
		if(currentthread == -1)
			return;
		
		var messagecontent = $("[name='messagetext'").val();
		var uid = <?php  echo $id;  ?>;
		var rid = currentthread;
		var action = 16;
		
		var darray = new Array(action,messagecontent,rid,uid);
		
			
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
	 
	 function deleteMessage(id)
	 {
		var action = 17;
		var uid = <?php  echo $id;  ?>;
		var darray = new Array(action,id,uid);
		
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
	 
	 }
	
	
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
