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
      <title>Edit Customers</title>
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

$utilites->echoNav(5);

?>

<div class="container" style = "position: relative; top: 20px;">
	

		<div class="row">
		
		
		
		<div class="span6">
			
			
			
			<section id="customers">

			<div class="page-header">
            <h1>Add Customer</h1>
			</div>
			
			<form id = "createcustomer">
			
			<fieldset>
			
			<label>First Name</label>
			<input type="text" placeholder="" required name="fname">
			
			<label>Last Name</label>
			<input type="text" placeholder="" required name="lname">
			
			<label>Email</label>
			<input type="email" id = "emailfield" placeholder="" required name="email">
			
			<label>Username</label>
			<input id = "userfield" type="text" placeholder="" required name="uname">
			
			<label>Password</label>
			<input type="text" placeholder="" required name="pword">
			
			<label>Gender</label>
			<select name = "gender" required>
			<option value = "M">M</option>
			<option value = "F">F</option>
			</select>
			
			<label>Birthdate</label>
			<input type="date" placeholder="" required name="bdate">
			
			<label>Address</label>
			<input type="text" placeholder="" required name="address">
			
			<label>City</label>
			<input type="text" placeholder="" required name="city">
			
			<label>State</label>
			<select name = "state" required>
				<option value="AL">Alabama</option>
				<option value="AK">Alaska</option>
				<option value="AZ">Arizona</option>
				<option value="AR">Arkansas</option>
				<option value="CA">California</option>
				<option value="CO">Colorado</option>
				<option value="CT">Connecticut</option>
				<option value="DE">Delaware</option>
				<option value="DC">District Of Columbia</option>
				<option value="FL">Florida</option>
				<option value="GA">Georgia</option>
				<option value="HI">Hawaii</option>
				<option value="ID">Idaho</option>
				<option value="IL">Illinois</option>
				<option value="IN">Indiana</option>
				<option value="IA">Iowa</option>
				<option value="KS">Kansas</option>
				<option value="KY">Kentucky</option>
				<option value="LA">Louisiana</option>
				<option value="ME">Maine</option>
				<option value="MD">Maryland</option>
				<option value="MA">Massachusetts</option>
				<option value="MI">Michigan</option>
				<option value="MN">Minnesota</option>
				<option value="MS">Mississippi</option>
				<option value="MO">Missouri</option>
				<option value="MT">Montana</option>
				<option value="NE">Nebraska</option>
				<option value="NV">Nevada</option>
				<option value="NH">New Hampshire</option>
				<option value="NJ">New Jersey</option>
				<option value="NM">New Mexico</option>
				<option value="NY">New York</option>
				<option value="NC">North Carolina</option>
				<option value="ND">North Dakota</option>
				<option value="OH">Ohio</option>
				<option value="OK">Oklahoma</option>
				<option value="OR">Oregon</option>
				<option value="PA">Pennsylvania</option>
				<option value="RI">Rhode Island</option>
				<option value="SC">South Carolina</option>
				<option value="SD">South Dakota</option>
				<option value="TN">Tennessee</option>
				<option value="TX">Texas</option>
				<option value="UT">Utah</option>
				<option value="VT">Vermont</option>
				<option value="VA">Virginia</option>
				<option value="WA">Washington</option>
				<option value="WV">West Virginia</option>
				<option value="WI">Wisconsin</option>
				<option value="WY">Wyoming</option>
			</select>
			
			
			<label>Zip</label>
			<input type="text" required name="zip" pattern="[\d]{5}">
			
			<label>Telephone</label>
			<input type="text" required name="telephone" pattern="[\d]{10}"><br><br>
			
			<button type="submit" class="btn">Submit</button>
			
			
			</fieldset>
			
			</form>
			

		
			</section>
			
		</div>
		
		<div class="span6">
		
		<section id="editcust">
		
		<div class="page-header">
            <h1>Edit Customer</h1>
		</div>
		
		<form id = "editcustomer">
		
			<label>Select Customer</label>
			<select id = "customerselect" name = "custid" required>
			<option  value="" disabled>Customer List</option>
			
			<?php
			
				$result = $utilites->getCustomerList();
				
				while($row = $result->fetch_assoc())
				{
					echo '<option value = '.$row['idcustomer'].'>'.$row['firstname'].' '.$row['lastname'].'</option>';
				}
			
			?>
			
			</select>
			
			<fieldset>
			
			<label>First Name</label>
			<input type="text" placeholder="" required name="fname" id="editfname">
			
			<label>Last Name</label>
			<input type="text" placeholder="" required name="lname" id="editlname">
			
			<label>Email</label>
			<input type="email" id = "editemail" placeholder="" required name="email">
			
			<label>Username</label>
			<input type="text" placeholder="" required name="uname" id="edituname">
			
			<label>Password</label>
			<input type="text" placeholder="" required name="pword" id="editpword">
			
			<label>Gender</label>
			<select name = "gender" required id="editgender">
			<option value = "M">M</option>
			<option value = "F">F</option>
			</select>
			
			<label>Birthdate</label>
			<input type="date" placeholder="" required name="bdate" id="editbdate">
			
			<label>Address</label>
			<input type="text" placeholder="" required name="address" id="editaddress">
			
			<label>City</label>
			<input type="text" placeholder="" required name="city" id="editcity">
			
			<label>State</label>
			<select name = "state" required id="editstate">
				<option value="AL">Alabama</option>
				<option value="AK">Alaska</option>
				<option value="AZ">Arizona</option>
				<option value="AR">Arkansas</option>
				<option value="CA">California</option>
				<option value="CO">Colorado</option>
				<option value="CT">Connecticut</option>
				<option value="DE">Delaware</option>
				<option value="DC">District Of Columbia</option>
				<option value="FL">Florida</option>
				<option value="GA">Georgia</option>
				<option value="HI">Hawaii</option>
				<option value="ID">Idaho</option>
				<option value="IL">Illinois</option>
				<option value="IN">Indiana</option>
				<option value="IA">Iowa</option>
				<option value="KS">Kansas</option>
				<option value="KY">Kentucky</option>
				<option value="LA">Louisiana</option>
				<option value="ME">Maine</option>
				<option value="MD">Maryland</option>
				<option value="MA">Massachusetts</option>
				<option value="MI">Michigan</option>
				<option value="MN">Minnesota</option>
				<option value="MS">Mississippi</option>
				<option value="MO">Missouri</option>
				<option value="MT">Montana</option>
				<option value="NE">Nebraska</option>
				<option value="NV">Nevada</option>
				<option value="NH">New Hampshire</option>
				<option value="NJ">New Jersey</option>
				<option value="NM">New Mexico</option>
				<option value="NY">New York</option>
				<option value="NC">North Carolina</option>
				<option value="ND">North Dakota</option>
				<option value="OH">Ohio</option>
				<option value="OK">Oklahoma</option>
				<option value="OR">Oregon</option>
				<option value="PA">Pennsylvania</option>
				<option value="RI">Rhode Island</option>
				<option value="SC">South Carolina</option>
				<option value="SD">South Dakota</option>
				<option value="TN">Tennessee</option>
				<option value="TX">Texas</option>
				<option value="UT">Utah</option>
				<option value="VT">Vermont</option>
				<option value="VA">Virginia</option>
				<option value="WA">Washington</option>
				<option value="WV">West Virginia</option>
				<option value="WI">Wisconsin</option>
				<option value="WY">Wyoming</option>
			</select>
			
			
			<label>Zip</label>
			<input type="text" required name="zip" pattern="[\d]{5}" id="editzip">
			
			<label>Telephone</label>
			<input type="text" required name="telephone" pattern="[\d]{10}" id="editphone"><br><br>
			
			<button type="submit" class="btn">Submit</button>
			<button type="button" class="btn btn-danger" id="deletecustomer" >Delete</button>
			
			
			
			</fieldset>
			
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
	
	$("#deletecustomer").click(function(e) {
	
		if($("#customerselect").val() == null)
		{
			return;
		}
		
		var formData = new FormData();
		
		formData.append("action",5);
		formData.append("idcustomer",$("#customerselect").val());
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
	
	$("#editcustomer").submit(function(e) {
	
		e.preventDefault();
	
		var formData = new FormData();
		
		formData.append("action",4);
		
		formData.append("idcustomer",$("#customerselect").val());
		formData.append("firstname",$("#editfname").val());
		formData.append("lastname",$("#editlname").val());
		formData.append("email",$("#editemail").val());
		formData.append("username",$("#edituname").val());
		formData.append("password",$("#editpword").val());
		formData.append("gender",$("#editgender").val());
		formData.append("birthdate",$("#editbdate").val());
		formData.append("address",$("#editaddress").val());
		formData.append("city",$("#editcity").val());
		formData.append("state",$("#editstate").val());
		formData.append("zip",$("#editzip").val());
		formData.append("phone",$("#editphone").val());
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
	
	$("#createcustomer").submit(function(e) {
	
		e.preventDefault();
	
		var formData = new FormData();
		
		formData.append("action",3);
		
		
		formData.append("firstname",$("[name='fname'").val());
		formData.append("lastname",$("[name='lname'").val());
		formData.append("email",$("[name='email'").val());
		formData.append("username",$("[name='uname'").val());
		formData.append("password",$("[name='pword'").val());
		formData.append("gender",$("[name='gender'").val());
		formData.append("birthdate",$("[name='bdate'").val());
		formData.append("address",$("[name='address'").val());
		formData.append("city",$("[name='city'").val());
		formData.append("state",$("[name='state'").val());
		formData.append("zip",$("[name='zip'").val());
		formData.append("phone",$("[name='telephone'").val());
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
	
	$("#customerselect").change(function(e) {
	
		
		var formData = new FormData();
		
		formData.append("action",7);
		formData.append("idcustomer",$("#customerselect").val());
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
					$("#editfname").val(msg.data.firstname);
					$("#editlname").val(msg.data.lastname);
					$("#editemail").val(msg.data.email);
					$("#edituname").val(msg.data.username);
					$("#editpword").val(msg.data.password);
					$("#editgender").val(msg.data.gender);
					$("#editbdate").val(msg.data.birthdate);
					$("#editaddress").val(msg.data.address);
					$("#editcity").val(msg.data.city);
					$("#editstate").val(msg.data.state);
					$("#editzip").val(msg.data.zip);
					$("#editphone").val(msg.data.telephone);

					
				},
				error: function(msg) {
					var y;
				}
				
			});
	
		
	
	});
	
		$("#edituname").change(function(e) {
		
		var uname = $("#edituname").val();
		
		var formData = new FormData();
		
		formData.append("action",1);
		formData.append("username",uname);
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
					if (msg.count > 0) {
						document.getElementById('edituname').setCustomValidity('Username already taken');
					} else {
						document.getElementById('edituname').setCustomValidity('');
					}

					
				},
				error: function(msg) {
					var y;
				}
				
			});
	
		
	
	
	});
	
	
	
		$("#editemail").change(function(e) {
		
		var email = $("#editemail").val();
		
		var formData = new FormData();
		
		formData.append("action",2);
		formData.append("email",email);
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
					if (msg.count > 0) {
						document.getElementById('editemail').setCustomValidity('Email already taken');
					} else {
						document.getElementById('editemail').setCustomValidity('');
					}

					
				},
				error: function(msg) {
					var y;
				}
				
			});
	
		
	
	
	});
	
	//----------------
	
	$("#userfield").change(function(e) {
		
		var uname = $("#userfield").val();
		
		var formData = new FormData();
		
		formData.append("action",1);
		formData.append("username",uname);
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
					if (msg.count > 0) {
						document.getElementById('userfield').setCustomValidity('Username already taken');
					} else {
						document.getElementById('userfield').setCustomValidity('');
					}

					
				},
				error: function(msg) {
					var y;
				}
				
			});
	
		
	
	
	});
	
	
	
		$("#emailfield").change(function(e) {
		
		var email = $("#emailfield").val();
		
		var formData = new FormData();
		
		formData.append("action",2);
		formData.append("email",email);
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
					if (msg.count > 0) {
						document.getElementById('emailfield').setCustomValidity('Email already taken');
					} else {
						document.getElementById('emailfield').setCustomValidity('');
					}

					
				},
				error: function(msg) {
					var y;
				}
				
			});
	
		
	
	
	});
	
	
	</script>

</body>
</html>