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
								   
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

 
  </head>

<body data-spy="scroll" data-target=".bs-docs-sidebar">

    <!-- Navbar
    ================================================== -->
	<?php
	
	$navbar = new Navbar($id,0);
	$navbar->echoNav();
	
	?>
   
	
	
	
	
	
	
<!-- Subhead
================================================== -->



<div class="container" style = "position: relative; top: 20px;">

   <div class="span6 offset2">
   
    <div class="span6">
  
	<?php
	
	$utilites->generatePostMaker();
	
	?>
  
   </div>
   
	<?php
	
	$utilites->echoPosts();
	
	
	?>
   
   


   <div class="span6">
	<div class="card">
   <div class="card-heading image">
      <img src="holder.js/46x46" alt=""/>
      <div class="card-heading-header">
         <h3>Simple News Card</h3>
         <span>Published today - 08.34 AM</span>
      </div>
   </div>
   <div class="card-body">
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua.
      </p>
   </div>
   <div class="card-media">
      <a class="card-media-container" href="#">
         <img src="holder.js/500x300/social" alt="media"/>
      </a>
   </div>
   <div class="card-comments">
      <div class="comments-collapse-toggle">
         <a data-toggle="collapse" data-target="#c2-comments" href="#">34 comments <i class="icon-angle-down"></i></a>
      </div>
      <div id="c2-comments" class="comments collapse">
         <div class="media">
            <a class="pull-left" href="#">
               <img class="media-object" data-src="holder.js/28x28" alt="avatar"/>
            </a>
            <div class="media-body">
               <h4 class="media-heading">Comment title</h4>
               <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...</p>
            </div>
         </div>
      </div>
</div>
</div>
</div>
	
	
		
	

		
		 
		 
	






   </div>

</div>



    <!-- Footer
    ================================================== -->
  
	


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
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
	
	$('.like-button-post').click(function(e) {
			e.preventDefault();
			
			var element = $(this);
			
			var action = 0;
			var pid = $(this).children("a").attr("id");
			var uid = <?php  echo $id;  ?>;
			
			var darray = new Array(action,pid,uid);
			
			$.ajax({
				type: "POST",
				url: script,
				dataType: "json",
				data: {data:darray},
				success: function(msg){
					
					if(msg.rdata == "unliked")
					{
						element.html('<a href="#" id = '+pid+'>Like</a>');
						location.reload();
					}
					else
					{
						element.html('<a href="#" id = '+pid+'>Unlike</a>');
						location.reload();
					}
					
				},
				error: function(msg) {
					var y;
				}
				
			});
			
			
			
	});
	
	
	$('.comment-drop').click(function(e) {
			e.preventDefault();
	});
	
	$('.likelist').hover(function(e) {
	
		$(this).popover('show')
			
	}, function(){
	
		$(this).popover('hide')
   
	 });
	 
	 $("#makepost").submit(function(e){
		
		e.preventDefault();
		
		var action = 2;
		var pid = $("[name='location'").val();
		var content = $("[name='status'").val();
		var uid = <?php  echo $id;  ?>;
		
		var darray = new Array(action,pid,content,uid);
		
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
	
	
	
	</script>




  </body>
</html>
