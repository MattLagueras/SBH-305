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
		$url = "login.php";
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
      <title><?php echo $row2['name'];  ?></title>
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
	
	<?php 
	
	if($isadmin != true)
	  {
		echo '<button id = "leavecircle" style = "position: relative; right: 25%;" class="btn btn-warning">Leave</button>';
	  }
	?>
	
  </div>
</header>

	
	
<!-- Subhead
================================================== -->



<div class="container" style = "position: relative; top: 20px;">



   <div class="span8 offset2">
   
    <div style="position: relative; left:5%;" class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab" class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Posts</a></li>
      <li role="presentation"><a href="#members" role="tab" id="member-tab" data-toggle="tab" aria-controls="member-tab">Members</a></li>
	  
	  <?php
	  
	   if($isadmin == true)
		echo '
	  <li role="presentation"><a href="#invited" role="tab" id="invited-tab" data-toggle="tab" aria-controls="invited">Invited</a></li>
	  <li role="presentation"><a href="#requests" role="tab" id="requests-tab" data-toggle="tab" aria-controls="requests">Requests</a></li>
	  <li role="presentation"><a href="#add" role="tab" id="add-tab" data-toggle="tab" aria-controls="add">Add</a></li>
	  <li role="presentation"><a href="#options" role="tab" id="options-tab" data-toggle="tab" aria-controls="options">Options</a></li>
	  ';
	  ?>
	  

    </ul>
    <div id="myTabContent" class="tab-content">
      <div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledBy="home-tab" style = "overflow: visible;">
	  
	  
	  
	  <?php
	
	$utilites = new CustomerUtilites($id,$pageid);
	$utilites->generatePostMakerForCircle();
	$utilites->echoPosts();
	
	
	?>


      </div>
      <div role="tabpanel" class="tab-pane fade" id="members" aria-labelledBy="member-tab">
	  
	  	
	<?php
		$utilites->generateCardsForCircle($circleid);
	?>
		
		
	
		
      </div>
	  
	  <?php
	  if($isadmin == true)
	  {
		echo '
	  
	  <div role="tabpanel" class="tab-pane fade" id="invited" aria-labelledBy="invited-tab">';
	  
	  
	  
		echo $utilites->getInvitedCards($circleid);
		
		echo '</div>';
	}
		
	  ?>
	  
	 
	  
	  
	  <?php
	  if($isadmin == true)
	  {
		echo '
	  <div role="tabpanel" class="tab-pane fade" id="requests" aria-labelledBy="requests-tab">';

		echo $utilites->getRequestedCards($circleid);

	  echo '</div>';
	  }
	  ?>
	  
	  
	  
	  <?php
	  if($isadmin == true)
	  {
	  echo'
	  <div role="tabpanel" class="tab-pane fade" id="add" aria-labelledBy="add-tab">
	  
	  <div class="span6">
	  
	  <form class="navbar-search" id="searchpeopleform">
	  <legend>Search for People</legend>
		<input type="text" class="search-query" placeholder="Search" name="namesearch">
		<button type="submit" class="btn">Submit</button>
	  </form>
	  </div>
	  
	  <div class="span6" id = "searchpeople">
	  
	  
	  </div>
	  
	  </div>';
	  }
	  ?>
	  
	   <?php
	  if($isadmin == true)
	  {
		echo '
	  <div role="tabpanel" class="tab-pane fade" id="options" aria-labelledBy="options-tab">
	  
	  <div class="span3">
	  
	<form id="circlesettingsform">
	  <fieldset>
		<legend>Circle Settings</legend>
		<label>Change Name</label>
		<input type="text" placeholder="New Name…" name = "newcirclename" required>
		<button type="submit" class="btn btn-primary">Change</button>
		<button type="button" class="btn btn-danger" id = "deletecircle" >Delete Circle</button>
	  </fieldset>
	</form>

	<form id="circlemembersform">
	  <fieldset>
		<legend>Remove Members</legend>		
		<select requried name="memberselect" required>';
		
		 $result = $utilites->getCustomersOfCircle($circleid);
		 
		 while($row = $result->fetch_assoc())
		 {
			if($row['idcustomer'] != $id)
			{
				echo '<option value='.$row['idcustomer'].'>'.$row['firstname'].' '.$row['lastname'].'</option>';
			}
		 }
		
		echo ';
		</select>
		
		<button type="submit" class="btn btn-primary">Submit</button>
	  </fieldset>
	</form>

	  </div>
	  
	  </div>';
	  }
	  ?>
	  

    </div>
  </div>
   

   
	
   
   



</div>
	
	
		
	

			<div id="deletePostModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Delete Post</h3>
  </div>
  <div class="modal-body">
    <p>Are you sure you want to delete this?</p>
  </div>
  <div class="modal-footer">
    <button class="btn btn-danger" id="deletepostb">Delete</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

  </div>
</div>

	<div id="deleteCommentModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Delete Comment</h3>
  </div>
  <div class="modal-body">
    <p>Are you sure you want to delete this?</p>
  </div>
  <div class="modal-footer">
    <button class="btn btn-danger"  id="deletecommentb">Delete</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

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
	<fieldset>
	 <select name disabled = "customerselect" required>
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
	  <button class="btn btn-primary" type="submit" id="sendmsgmodal">Send</button>
	  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	</fieldset>
	</form>
 
  </div>

     
  
  <div class="modal-footer">
   


  </div>
</div>





    <!-- Footer
    ================================================== -->
  
	 <?php
  
	$utilites->buildAdvertisementModal(1);
  
  ?>
  
  



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
	var deletepost;
	var deletecomment;
	
	
	
	
	$("#namecircleinput").click(function(e) {
			
			e.stopPropagation();
			
	});
	
	
	$('#searchpeopleform').submit(function(e) {
	
		e.preventDefault();
		
		var action = 8;
		var name = $("[name='namesearch'").val();
		var circleid = <?php echo $_GET['circleid']; ?>;
		var uid = <?php  echo $id;  ?>;
		
		var darray = new Array(action,name,circleid,uid);
		
			$.ajax({
				type: "POST",
				url: script,
				dataType: "json",
				data: {data:darray},
				success: function(msg){
					
					if(msg.result == "success")
					{
						$("#searchpeople").html(msg.html);
					}
					
				},
				error: function(msg) {
					var y;
				}
				
			});
		
		
	
	});
	
	function inviteToCircle(custid)
	{
			var circleid = <?php echo $circleid; ?>;
		
			var action = 9;
			var uid = <?php  echo $id;  ?>;
			
			var darray = new Array(action,circleid,custid,uid);
			
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
	
	
	
	$('.like-button-comment').click(function(e) {
			e.preventDefault();
			
			var element = $(this);
			
			var action = 1;
			var cid = $(this).children("a").attr("id");
			var uid = <?php  echo $id;  ?>;
			
			var darray = new Array(action,cid,uid);
			
			$.ajax({
				type: "POST",
				url: script,
				dataType: "json",
				data: {data:darray},
				success: function(msg){
					
					if(msg.rdata == "unliked")
					{
						location.reload();
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
	
	$("#deletecircle").click(function (e) {
	
		var darray = new Array(26,<?php echo $_GET['circleid']; ?>,<?php  echo $id; ?>);
		
		$.ajax({
				type: "POST",
				url: script,
				dataType: "json",
				data: {data:darray},
				success: function(msg){
					
					location.assign("home.php")
					
				},
				error: function(msg) {
					var y;
				}
				
			});
	
	
	});
	
	$("#leavecircle").click(function(e) {
	

	 var rid = <?php  echo $id;  ?>;
	 var cid = <?php echo $circleid; ?>;
	 var uid = <?php  echo $id;  ?>;
	 var action = 25;
	 
	 var darray = new Array(action,cid,rid,uid);
	 
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
	
	function newmessage(id)
	{
		$("[name='customerselect'").val(id);
	}
	
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
		var pid = <?php echo $_GET['circleid'];   ?>;
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
	 
	 $("#deletepostb").click(function(e){
	 
		var action = 6;
		var uid = <?php  echo $id;  ?>;
		var darray = new Array(action,deletepost,uid);
		
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
	 
	 $("#deletecommentb").click(function(e){
	 
		var action = 7;
		var uid = <?php  echo $id;  ?>;
		var darray = new Array(action,deletecomment,uid);
		
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
			
			id = id.replace("options","");
			
			var post = "post"+id+"body";
			//var content = $("#contenttext"+id).text();
			
			$("#"+id+"formdiv").first().show();
			$("#contenttext"+id).hide();
			
			
	 });
	 
	 $('.deletepost').click(function(e) {
			e.preventDefault();
			var id = $(this).parent().parent().children().attr("id");
	 });
	 
	 $(".icon-pencil.editcomment").click(function(e) {
		
		var id = $(this).parent().attr("id");
			
			
			$("#"+id+"cformdiv").first().show();
			$("#contenttextc"+id).hide();
	 
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
	 
	 
	 $(".editcommentform").submit(function(e) {
			e.preventDefault();
			var pid = $(e.target).parent().attr("id");
			pid = pid.replace("cformdiv","");
	
			var action = 5;
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
	 
	 function setDeletePost(post)
	 {
		deletepost = post;
	 }
	 
	 function setDeleteComment(comment)
	 {
		deletecomment = comment;
	 }
	 
	 function hideEditComment(idcomment, selector)
	 {
		var ptext = $("#contenttextc"+idcomment).text();
	 
		$("#"+idcomment+"cformdiv").first().hide();
		$("#"+idcomment+"cformdiv").find('textarea').val(ptext);
		
		$("#contenttextc"+idpost).show();
	 }
	 
	 
	 function hideEditPost(idpost, selector)
	 {
			var ptext = $("#contenttext"+idpost).text();
	 
			$("#"+idpost+"formdiv").first().hide();
			$("#"+idpost+"formdiv").find('textarea').val(ptext);
			$("#contenttext"+idpost).show();
			
	 }
	 
	 $(".btn-warning.closeeditcomment").click(function(e){
	 
		var idcomment = $(e.target).parent().parent().parent().attr("id");
		idcomment = idcomment.replace("cformdiv","");
		
		var ptext = $("#contenttextc"+idcomment).text();
	 
		$("#"+idcomment+"cformdiv").first().hide();
		$("#"+idcomment+"cformdiv").find('textarea').val(ptext);
		
		$("#contenttextc"+idcomment).show();
	
	 });
	 
	 $(".createcomment").submit(function(e){
	 
		e.preventDefault();
		
		var idpost = $(e.target).attr("id");
		idpost = idpost.replace("cc","");
		
		var content = $(e.target).find('textarea').val();
		var action = 4;
		var uid = <?php  echo $id;  ?>;
		
		var darray = new Array(action,idpost,content,uid);
		
			
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
	 
	 $("#circlesettingsform").submit(function(e){
		
		e.preventDefault();
	 
		var newname = $("[name='newcirclename'").val();
		var cid = <?php echo $circleid; ?>;
		var uid = <?php  echo $id;  ?>;
		var action = 12;
		
		var darray = new Array(action,cid,newname,uid);
		
		
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
	 
	 
	 $("#circlemembersform").submit(function(e){
	 
	 e.preventDefault();
	 
	 var rid = $("[name='memberselect'").val();
	 var cid = <?php echo $circleid; ?>;
	 var uid = <?php  echo $id;  ?>;
	 var action = 13;
	 
	 var darray = new Array(action,cid,rid,uid);
	 
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
