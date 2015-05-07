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
		$url = "login.php";
		$statuscode = 403;
		header('Location: ' . $url, true, $statusCode);
	}
	
	$utilites = new CustomerUtilites($id,-1);



?>


<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Search Circles</title>
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
								   
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

 
  </head>
  
  
  <body>
  
  <?php
	
	$navbar = new Navbar($id,6);
	$navbar->echoNav();
	
   ?>
    
  
  <div class="container" style = "position: relative; top: 20px;">

  
  
	<div class="span9">
	
	<section>
	
	<div class="page-header">
            <h1>Join A New Circle</h1>
    </div>
	
	<form id="searchcirclesform">
		<input type="text" class="search-query" placeholder="Search by Name" name="circlesearch">
		<button type="submit" class="btn">Submit</button>
	  </form>
	
	<div id="searchresult">

	</div>
	
	</section>
	
	</div>
	  
  

   
   
  </div>
  
  
  
   <?php
  
	$utilites->buildAdvertisementModal(1);
  
	?>

	  <div id="newmessagemodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel2">New Message</h3>
  </div>
  
  <div class="modal-body">
  
    <form id = "newmessageform">
	<fieldset>
	<input type="text" required name="recipient" readonly data-cid = "" >
	 
	 <textarea rows="4" cols="50" style = "width: 95%; resize: none;" name="newmessagetext" placeholder="Write a Message..." required></textarea>
	  <button class="btn btn-primary" type="submit" id="sendmsgmodal">Send</button>
	  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	</fieldset>
	</form>
 
  </div>

     
  
  <div class="modal-footer">
   


  </div>
</div>


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
	
	
	$("#searchcirclesform").submit(function(e) {
	
		e.preventDefault();
		
		var input = $("[name='circlesearch'").val();
		var uid = <?php  echo $id;  ?>;
		var action = 21;
		
		var darray = new Array(action,input,uid);
		
		$.ajax({
				type: "POST",
				url: script,
				dataType: "json",
				data: {data:darray},
				success: function(msg){
					
					$("#searchresult").html(msg.html);
					
				},
				error: function(msg) {
					var y;
				}
				
			});
		
		
		
	
	});
	
	function showMessage(customerid,name) {
	
		$("[name='recipient'").attr("data-cid",customerid);
		$("[name='recipient'").val(name);
		
	
		$("#newmessagemodal").modal('show');	
	
	}
	

	
	$("#newmessageform").submit(function(e) {
	 
		e.preventDefault();
		
		var messagecontent = $("[name='newmessagetext'").val();
		var uid = <?php  echo $id;  ?>;
		var rid = $("[name='recipient'").attr("data-cid");
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
	 
	 function joincircle(circleid)
	 {
		var uid = <?php  echo $id;  ?>;
		var action = 22;
		
		var darray = new Array(action,circleid,uid);
		
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
	
	
	// THESE NEED TO BE ON ALL PAGES
	
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
	 
	 $(".acceptjoinrequest").click(function(e) {
	 
		var nid = $(e.target).attr("id");
		var uid = <?php  echo $id;  ?>;
		var action = 23;
		
		var darray = new Array(action,nid,uid);
		
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
	 
	 $(".declinejoinrequest").click(function(e) {
	 
		var nid = $(e.target).attr("id");
		var uid = <?php  echo $id;  ?>;
		var action = 24;
		
		var darray = new Array(action,nid,uid);
		
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
	 
	 $('.carousel').carousel({
		interval: false
	});
	
	
	window.setTimeout(showAdvertisement, 5000);

	function showAdvertisement()
	{
		$('#purchasemodal').modal('show');
	}
	
	$("[name='qtyenter'").val(1);
	
	$('.carousel').on('slide',function(e){

		 var slideFrom = $(this).find('.active').attr("id");
		 var slideTo = $(e.relatedTarget).attr("id");
		 var uid = <?php  echo $id;  ?>;
		 
		 var darray = new Array(19,slideTo,uid);
		 
		 $("#transerror").text("");
		 
		 $.ajax({
				type: "POST",
				url: script,
				dataType: "json",
				data: {data:darray},
				success: function(msg){
					
					var amt = $("#price"+slideTo).text();
					amt = amt.replace("Price: ","");
					amt = amt.replace("$","");
					amt = amt.replace(",","");
					amt = formatCurrency(amt);
					$("#subtotal").text("Total: " + amt);
					
					$("[name='qtyenter'").attr('max', msg.num);
					$("[name='qtyenter'").val(1);
					
				},
				error: function(msg) {
					var y;
				}
				
			});
			
			
	
	});
	


	
	
	$("[name='qtyenter'").change(function(e) {
	
		var id = $("#caroinner").find('.active').attr("id");
	
		var amt = $("#price"+id).text();
		amt = amt.replace("Price: ","");
		amt = amt.replace("$","");
		amt = amt.replace(",","");
		
		amt = amt * $(this).val();
		amt = formatCurrency(amt);
		
		$("#subtotal").text("Total: " + amt);
		
		
		
	
	});
	
	$("#purchaseform").submit(function(e) {
	
		e.preventDefault();
		
		$("#transerror").text("");
		
		var itemid = $("#caroinner").find('.active').attr("id");
		var amt = $("[name='qtyenter'").val();
		var accid = $("[name='accountselect'").val();
		var uid = <?php  echo $id;  ?>;
		var action = 20;
		
		var darray = new Array(20,itemid,amt,accid,uid);
		
		$.ajax({
				type: "POST",
				url: script,
				dataType: "json",
				data: {data:darray},
				success: function(msg){
					
					if(msg.res == "out of stock")
					{
						$("#transerror").text("Error: Out of Stock");
					}
					else
					{
						location.reload();
					}
					
				},
				error: function(msg) {
					var y;
				}
				
			});
	
	});
	
	
	 function formatCurrency(total) {
    var neg = false;
    if(total < 0) {
        neg = true;
        total = Math.abs(total);
    }
    return (neg ? "-$" : '$') + parseFloat(total, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
}

	 
	
	</script>
	
	
  
  </body>
  </html>
  