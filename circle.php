<!DOCTYPE html>

<?php


ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include("scripts/SessionManager.php");
include ("scripts/DBcon.php");
include ("scripts/CustomerUtilites.php");
include ("scripts/Navbar.php");

	$sessionManager = SessionManager::getManager();
	$sessionManager->startSession();
	
	$id = $sessionManager->getSessionVar("userid");
	
		$con = DBcon::getDBcon();
	$mysqli = $con->getMysqliObject();
	
	if($id == "invalid")
	{
		$url = "http://localhost/SBH/login.php";
		$statuscode = 403;
		header('Location: ' . $url, true, $statusCode);
	}
	
	

	if(!isset($_GET['circleid']))
	{
		echo 'invalid circle';
		die();
	}
	
	$circleid = $_GET['circleid'];
	
	$query2 =  mysqli_prepare($mysqli,"SELECT c.*, p.* FROM circle c, pages p WHERE p.fkcircle = c.idcircle AND c.idcircle = ?");
	mysqli_stmt_bind_param($query2,"i", $circleid);
	mysqli_stmt_execute($query2);
	$result2 = $query2->get_result();
	
	if(mysqli_num_rows($result2) == 0)
	{
		echo 'invalid circle';
		die();
	}

	
	$query =  mysqli_prepare($mysqli,"SELECT COUNT(*) AS access FROM circlemembers cm WHERE cm.customer_idcustomer = ? AND cm.idcircle = ? ");
	mysqli_stmt_bind_param($query,"ii", $id, $circleid);
	mysqli_stmt_execute($query);
	$result = $query->get_result();
	
	$row = $result->fetch_assoc();
	
	if($row['access'] == 0)
	{
		echo 'You dont have permission to view this circle';
		die();
	}
	
	$row2 = $result2->fetch_assoc();
	$isadmin = false;
	
	if($row2['customer_idcustomer'] == $id)
	{
		$isadmin = true;
	}
	
	$pageid = $row2['idpage'];

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

  </head>

<body data-spy="scroll" data-target=".bs-docs-sidebar">

    <!-- Navbar
    ================================================== -->
	<?php
		$navbar = new Navbar($id,-1);
	$navbar->echoNav();
	
	?>
   
	

	<header class="jumbotron" id="overview">
  <div class="container">

    <h1 style = "font-size: 350%; position: relative; right: 17%; text-align: center;"><?php echo $row2['name'];  ?></h1>

  </div>
</header>

	
	
<!-- Subhead
================================================== -->



<div class="container" style = "position: relative; top: 20px;">



   <div class="span8 offset2">
   
    <div style="position: relative; left:5%;" class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab" class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Posts</a></li>
      <li role="presentation"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile">Members</a></li>

    </ul>
    <div id="myTabContent" class="tab-content">
      <div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledBy="home-tab" style = "overflow: visible;">
	  
	  
	  
	  <?php
	
	$utilites = new CustomerUtilites($id,$pageid);
	$utilites->generatePostMakerForCircle();
	$utilites->echoPosts();
	
	
	?>


      </div>
      <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledBy="profile-tab">
	  
	  	
	<?php
		$utilites->generateCardsForCircle($circleid);
	?>
		
		
	
		
      </div>

    </div>
  </div><!-- /example -->
   

   
	
   
   



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
		var pid = <?php echo $circleid; ?>;
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
	 
	  $('.editpost').click(function(e) {
			e.preventDefault();
					
			var id = $(this).parent().parent().children().attr("id");
			
			var post = "post"+id+"body";
			var content = $("#contenttext"+id).text();
			
			$("#"+id+"formdiv").first().show();
			$("#contenttext"+id).hide();
			
			
	 });
	 
	 $('.deletepost').click(function(e) {
			e.preventDefault();
			var id = $(this).parent().parent().children().attr("id");
	 });
	 
	 
	 
	  $(".editpostform").submit(function(e) {
			e.preventDefault();
			var pid = $(e.target).parent().attr("id");
			pid = pid.replace("formdiv","");
	
			var action = 3;
			var content = $(e.target).find('textarea').val();
			
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
	 
	 
	 
	 
	 function hideEditPost(idpost, selector)
	 {
			var ptext = $("#contenttext"+idpost).text();
	 
			$("#"+idpost+"formdiv").first().hide();
			$("#"+idpost+"formdiv").find('textarea').val(ptext);
			$("#contenttext"+idpost).show();
			
	 }
	
	 
	</script>




  </body>
</html>
