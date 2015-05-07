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
		$url = "http://localhost/SBH/login.php";
		$statuscode = 403;
		header('Location: ' . $url, true, $statusCode);
	}
	
	$utilites = new RepUtilites($id);
	

?>

<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Advertisements</title>
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

$utilites->echoNav(1);

?>

<div class="container" style = "position: relative; top: 20px;">
	

		<div class="row">
		
		<div class="span6 offset2">
			
			
			
			<section id="advcreate">

			<div class="page-header">
            <h1>Advertisement Creation</h1>
			</div>
			
			<form id="createadv">
			  <fieldset>
				<label>Product Name</label>
				<input type="text" placeholder="" required name="aname">
				<label>Company</label>
				<input type="text" placeholder="" required name="company">
				<label>Description</label>
				<textarea rows="4" cols="50" style = "width: 95%; resize: none;" name="idescription" required></textarea>
				<label>Item Type</label>
				
				 <select name = "itemtype" required>
				<option value="" disabled>Select A Type</option>
				
				<?php  
				
					$result = $utilites->getAdvertisementTypes();
					
					while($row = $result->fetch_assoc())
					{
						echo '<option value="'.$row['idtype'].'" >'.$row['content'].'</option>';
					}
				
				?>
				</select>
				
				<label>Item Price</label>
				
				<div class="input-prepend input-append">
				  <span class="add-on">$</span>
				  <input type="number" placeholder="" required name="price" step="0.01" min = "0.01" style = "width: 100px">
				</div>
				
				<label>Units Available</label>
				<input type="number" placeholder="" required name="units" step="1" min ="1" style = "width: 100px">
				
				
				
				<label>Item Image</label>
				<input type="file" style="line-height: 0px" required id = "fileup" name="img" accept="image/png, image/jpeg, image/gif"><br><br>
				<button type="submit" class="btn">Submit</button>
			  </fieldset>
			</form>
		
			</section>
			
			<section id="advedit">

			<div class="page-header">
            <h1>Delete Advertisement</h1>
			</div>
			
			<form id="deleteadv">
			
			<select name = "advselect">
			
			<?php 
			
				$result = $utilites->getAdvertisements();
				
				while($row = $result->fetch_assoc())
					{
						echo '<option value="'.$row['idadvertisement'].'" >'.$row['itemname'].'</option>';
					}
			
			?>
			
			
			</select><br>
			
			<button type="submit" class="btn btn-danger">Delete</button>
			
			
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
	
	var script = "scripts/AjaxHandlerRep.php";
	
	$("#createadv").submit(function(e) {
		
		e.preventDefault();
		
		
		var file = document.getElementById("fileup");
		
		var des = $("[name='idescription'").val();
		
		var formData = new FormData();
		
		formData.append("action",0);
		formData.append("name",$("[name='aname'").val());
		formData.append("company",$("[name='company'").val());
		formData.append("description",des);
		formData.append("itemtype",$("[name='itemtype'").val());
		formData.append("price",$("[name='price'").val());
		formData.append("units",$("[name='units'").val());
		formData.append("img",file.files[0]);
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
					location.reload();

					
				},
				error: function(msg) {
					var y;
				}
				
			});
	
	
	
	});
	
	
	$("#deleteadv").submit(function(e) {
	
		e.preventDefault();
		
		
		var formData = new FormData();
		
		formData.append("action",6);
		formData.append("idadvertisement",$("[name='advselect'").val());
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