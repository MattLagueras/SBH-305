<?php

include_once("SessionManager.php");
include_once ("DBcon.php");


class Navbar
{
	private $uid;
	private $activetab;


	function __construct($uid, $activetab)
	{           
        $this->uid = $uid;
		$this->activetab = $activetab;
    }
	

	
	function echoNav()
	{
		
		
		
		
		
		$con = DBcon::getDBcon();
	$mysqli = $con->getMysqliObject();
		
		
		
		$query = mysqli_prepare($mysqli,"SELECT c.* FROM circle c
										 INNER JOIN circlemembers
										 ON circlemembers.idcircle = c.idcircle
										 INNER JOIN customer
										 ON customer.idcustomer = circlemembers.customer_idcustomer
										 WHERE customer.idcustomer = ? AND c.customer_idcustomer = ?;");
										 
	    mysqli_stmt_bind_param($query,"ii", $this->uid, $this->uid);
		mysqli_stmt_execute($query);
		$result = $query->get_result();
		
		
		$query2 = mysqli_prepare($mysqli,"SELECT c.* FROM circle c
										 INNER JOIN circlemembers
										 ON circlemembers.idcircle = c.idcircle
										 INNER JOIN customer
										 ON customer.idcustomer = circlemembers.customer_idcustomer
										 WHERE customer.idcustomer = ? AND c.customer_idcustomer <> ?;");
										 
	    mysqli_stmt_bind_param($query2,"ii", $this->uid, $this->uid);
		mysqli_stmt_execute($query2);
		$result2 = $query2->get_result();
		
		
	
		echo '<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
		 <div class = "row-fluid">
		  <div class="span1 offset2">
          <a class="brand" href="./index.html"><img src="assets/img/SBHlogo.jpg" width="40" height="40" ></a>
		  </div>
		 <ul class="nav" style="position: relative; top: 10px;">
		

              <li '; if($this->activetab == 0) { echo 'class="active"';}  echo'>
                <a href="./home.php">All</a>
              </li>
              <li '; if($this->activetab == 1) { echo 'class="active"';}  echo'>
                <a href="./getting-started.html">Profile</a>
              </li>
              <li '; if($this->activetab == 2) { echo 'class="active"';}  echo'>
                <a href="./scaffolding.html">Accounts</a>
              </li>
             <li class="dropdown" '; if($this->activetab == 3) { echo 'class="active"';}  echo'>
                <a class="dropdown-toggle" id="drop5" role="button" data-toggle="dropdown" href="#">My Circles<b class="caret"></b></a>
                <ul id="circledrop" class="dropdown-menu" role="menu" aria-labelledby="drop5" style="width: 250px">';
				
					while($row = $result->fetch_assoc())
					{
						echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="http://localhost/SBH/circle.php?circleid='.$row['idcircle'].'">'.$row['name'].' &nbsp <i class="icon-star"></i></a></li>';
					}
				
					while($row2 = $result2->fetch_assoc())
					{
						echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="http://localhost/SBH/circle.php?circleid='.$row2['idcircle'].'">'.$row2['name'].'</a></li>';
					}
				
      
				  echo '
                  <li role="presentation" class="divider"></li>
                  <li role="presentation">
				  <div class="input-append offset1">
					<input class="span9" id="namecircleinput" type="text">
					<button class="btn" type="button">Create!</button>
					</div>
				  </li>
                </ul>
              </li>
              <li '; if($this->activetab == 4) { echo 'class="active"';}  echo'>
                <a href="./components.html">Messages</a>
              </li>
              <li '; if($this->activetab == 5) { echo 'class="active"';}  echo'>
                <a href="./plus.html">Purchases</a>
              </li>

            </ul>
			
			 <ul class="nav offset4" style="position: relative; top: 10px;">
			 
			  <li class="" style="position: relative; top: -5px;">
			    <a class="btn btn-small" href="#"><i class="icon-bell"><span class="badge badge-info">8</span></i></a>
			  </li>
			 
			  <li class="" style="position: relative; top: -5px;">
			    <a class="btn btn-small" href="scripts/LogoutScript.php">Logout</a>
			  </li>
			 
			 </ul>
			 
			 
          </div>
		 </ul>		
		</div>

      </div>';
	  
	  //mysqli_stmt_close($query);
	 // mysqli_stmt_close($query2);
	 // mysqli_close($mysqli);
	
	}

}


?>