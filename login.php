<html lang="en">
   <head>
<meta charset="utf-8">
      <title>Bootplus</title>
      <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!--<meta name="description" content="Bootplus : Sleek, intuitive, and powerful Google styled front-end framework for faster and easier web development" />
      <meta name="keywords" content="bootplus, google plus, google+, plus, bootstrap, framework, web framework, css3, html5" />
      <meta name="author" content="AozoraLabs by Marcello Palmitessa"/>
      <link rel="publisher" href="https://plus.google.com/117689250782136016574">-->

      <!-- Le styles -->
      <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
      <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      <!--[if IE 7]>
      <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css">
      <![endif]-->

      <link href="assets/css/bootplus.css" rel="stylesheet">
      <link href="assets/css/bootplus-responsive.css" rel="stylesheet">
	  <link href="assets/css/loginstyle.css" rel="stylesheet">

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
							
							
		   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		   <script src="assets/js/bootstrap.min.js"></script>
		        <script src="js/jquery-1.11.0.js"></script>



	</head>
	
	<body>

    <div class="container">
        <div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <img id="profile-img" class="profile-img-card" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" id = "login" method="post" action="./scripts/LoginScript.php">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <div id="remember" class="checkbox">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
            </form><!-- /form -->
            <a href="#" class="forgot-password">
                Forgot the password?
            </a>
        </div><!-- /card-container -->
    </div><!-- /container -->
	
	</body>
	
	
	<script>
	
	 $("#login").submit(function(event){

    event.preventDefault();

    var serial = $("#login").serialize();
    var script = $("#login").attr('action');

     $.post(script, serial, function(result) {

        if(result.message == "error")
        {
          
        }
        else
        {
            if(result.message == "customer")
            {
			  window.location.replace("http://localhost/SBH/home.php");
            }
			
			if(result.message == "manager")
            {
			  window.location.replace("http://localhost/SBH/managerhome.php");
            }
        }

      }, "json")
     .fail(function(result) {
      var x;
     }, "json");

  });



	
	
	</script>
	
	
</html>