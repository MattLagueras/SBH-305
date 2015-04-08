<?php

class CardGenerator
{
	private $uid;
	
	function __construct($uid) 
	{           
        $this->uid = $uid;
    }
	
	function generateForCircle($idcircle)
	{
		include ("DBcon.php");
		
		$query =  mysqli_prepare($mysqli,"SELECT * FROM customer
										  INNER JOIN circlemembers 
										  ON circlemembers.customer_idcustomer = customer.idcustomer
										  WHERE
										  circlemembers.idcircle = ?"); 
		
	
		
			mysqli_stmt_bind_param($query,"i", $idcircle);
			mysqli_stmt_execute($query);
			$result = $query->get_result();
			
			$count = 0;
			
			while($row = $result->fetch_assoc())
			{
				$style = "";
			
				if($count > 0 && $count % 4 == 0)
				{
					$style="style='margin-left:0px;'";
				}
				else
				{
					$style="";
				}
				
			
				echo '<div class="card people" '.$style.'>
			   <div class="card-top green">
				  <a href="#">
					 <img src="assets/img/silhouette_homer.png" alt=""/>
				  </a>
			   </div>
			   <div class="card-info">
				  <a class="title" href="#">'.$row['firstname'].' '.$row['lastname'].'</a>
				  <div class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
			   </div>
			   <div class="card-bottom">
				  <button class="btn btn-small">Message</button>
			   </div>
			</div>';
			
			$count++;
			
			}
		
		
		
					
		
	}
	
	function generateById($id)
	{
		include ("DBcon.php");
	}


}


?>