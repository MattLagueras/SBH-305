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
      <title>Purchases</title>
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

    <!-- Navbar
    ================================================== -->
	<?php
	
	$navbar = new Navbar($id,5);
	$navbar->echoNav();
	
	?>
	
	
	<div class="container" style = "position: relative; top: 20px;">
	

		<div class="row">
		
		
		
			<div class="span7 offset2">
			
			<section>
			
			<div class="page-header">
            <h1>Top Selling Items</h1>
			</div>
			
			<?php
			
			$bestres = '<table class="table table-striped table-hover">
              <thead>
                <tr>
				  <th>Thumbnail</th>
				  <th>Item Name</th>
				  <th>Company</th>
				  <th>Price</th>
				  <th>Amount Sold </th>
                </tr>
              </thead>
              <tbody>';
			  
				$result = $utilites->getTopSellingItems();
			  
					while($row = $result->fetch_assoc())
					{
							

							
							$im = file_get_contents($row['imgloc']);
							$imdata = base64_encode($im);    
							
							
							
							$cost = $row['unitprice'];
							
							
							$formatter = new \NumberFormatter('en_US',  \NumberFormatter::CURRENCY);
							$cost =  $formatter->formatCurrency($cost, 'USD') . PHP_EOL;
							
							
					
						  $bestres .= '<tr>
						  <td><img class="media-object" alt="90x90" src="data:image/png;base64,'.$imdata.'" style="width: 120px; height: 90px;"></td>
						  <td>'.$row['itemname'].'</td>
						  <td>'.$row['company'].'</td>
						  <td>'.$cost.'</td>
						  <td>'.$row['AmountSold'].'</td>
						  </tr>';
					}
		
		$bestres .= '</tbody> </table>';
			
			
			echo $bestres;
			  
			  
			
			?>
			
			</section>
			
			<section>
			
			<div class="page-header">
            <h1>Items Like Your Past Purchases</h1>
			</div>
			
			<?php
			
			$sugres = '<table class="table table-striped table-hover">
              <thead>
                <tr>
				  <th>Thumbnail</th>
				  <th>Item Name</th>
				  <th>Company</th>
				  <th>Price</th>
                </tr>
              </thead>
              <tbody>';
			
			$result = $utilites->generateSuggestionList();
			
			while($row = $result->fetch_assoc())
			{
			
				$path = $row['imgloc'];

				
				$im = file_get_contents($path);
				$imdata = base64_encode($im);    
				
				$cost = $row['unitprice'];
				
				
				$formatter = new \NumberFormatter('en_US',  \NumberFormatter::CURRENCY);
				$cost =  $formatter->formatCurrency($cost, 'USD') . PHP_EOL;
				
				  $sugres .= '<tr>
						  <td><img class="media-object" alt="90x90" src="data:image/png;base64,'.$imdata.'" style="width: 120px; height: 90px;"></td>
						  <td>'.$row['itemname'].'</td>
						  <td>'.$row['company'].'</td>
						  <td>'.$cost.'</td>
						  </tr>';
			
			}
			
			$sugres .= '</tbody> </table>';
			
			
			echo $sugres;
			
			?>
			
			</section>
			
			<section>
			
			<div class="page-header">
            <h1>Recommended To You By Our Staff</h1>
			</div>
			
			<?php
			
				$repres = '<table class="table table-striped table-hover">
              <thead>
                <tr>
				  <th>Thumbnail</th>
				  <th>Item Name</th>
				  <th>Company</th>
				  <th>Price</th>
				  <th>Suggested By</th>
                </tr>
              </thead>
              <tbody>';
			  
			  $result = $utilites->getSuggestedItems();
			  
			  while($sugrow = $result->fetch_assoc())
			{
				$row = $utilites->getAdvertisementRow($sugrow['advfkey']);
				$path = $row['imgloc'];

				
				$im = file_get_contents($path);
				$imdata = base64_encode($im);    
				
				$cost = $row['unitprice'];
				
				$reprow = $utilites->getRepRow($sugrow['rep_idrep']);
				
				$name = $reprow['firstname'];
				$name .= " ";
				$name .= $reprow['lastname'];
				
				
				$formatter = new \NumberFormatter('en_US',  \NumberFormatter::CURRENCY);
				$cost =  $formatter->formatCurrency($cost, 'USD') . PHP_EOL;
				
				  $repres .= '<tr>
						  <td><img class="media-object" alt="90x90" src="data:image/png;base64,'.$imdata.'" style="width: 120px; height: 90px;"></td>
						  <td>'.$row['itemname'].'</td>
						  <td>'.$row['company'].'</td>
						  <td>'.$cost.'</td>
						  <td>'.$name.'</td>
						  </tr>';
			
			}
			  $repres .= '</tbody> </table>';
			  echo $repres;
			
			
			?>
			
			
			</section>
			
			<section>
			<div class="page-header">
            <h1>Purchases</h1>
			</div>
			
			<?php
			
			date_default_timezone_set('America/New_York');
		setlocale(LC_MONETARY, 'en_US');
	
		
		$result = $utilites->getTransactionOfCustomer();
		
		$htmlres = '<table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Transaction #</th>
                  <th>Time Stamp</th>
				  <th>Thumbnail</th>
				  <th>Company</th>
				  <th>Item Name</th>
				  <th>Amount Purchased</th>
				  <th>Total Cost</th>
                </tr>
              </thead>
              <tbody>';

			  
			  
			  
		
		
		while($row = $result->fetch_assoc())
		{
				$advertisementrow = $utilites->getAdvertisementRow($row['advertisementfkey']);
				
				$path = $advertisementrow['imgloc'];

				
				$im = file_get_contents($path);
				$imdata = base64_encode($im);    
				
				
				
				$cost = $row['amtpurchased'] * $advertisementrow['unitprice'];
				
				
				$formatter = new \NumberFormatter('en_US',  \NumberFormatter::CURRENCY);
				$cost =  $formatter->formatCurrency($cost, 'USD') . PHP_EOL;
				
				
		
			  $htmlres .= '<tr>
			  <td>'.$row['idtransaction'].'</td>
			  <td>'.date('h:i a m/d/Y', strtotime($row['timestamp'])).'</td>
			  <td><img class="media-object" alt="90x90" src="data:image/png;base64,'.$imdata.'" style="width: 120px; height: 90px;"></td>
			  <td>'.$advertisementrow['itemname'].'</td>
			  <td>'.$advertisementrow['company'].'</td>
			  <td>'.$row['amtpurchased'].'</td>
			  <td>'.$cost.'</td>
			  </tr>';
		}
		
		$htmlres .= '</tbody> </table>';
			
			
			echo $htmlres;
			
			?>

			
			</section>
		
		
		
		
			</div>
			
		</div>
		
   </div>
   
    <?php
  
	$utilites->buildAdvertisementModal(1);
  
	?>

   
   
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
