<?php


include_once ("DBcon.php");
include_once("SessionManager.php");
include_once("PreparedQueryHelper.php");


class CustomerUtilites
{
	private $pageid;
	private $uid;
	private $queryhelper;
	


	function __construct($uid, $pageid) 
	{           
        $this->uid = $uid;
		$this->pageid = $pageid;
		$this->queryhelper = new PreparedQueryHelper();
    }
	
	function setPage($pageid)
	{
		$this->pageid = $pageid;
	}
	
	
	function getCirclesOfCustomer()
	{
	
	
	$con = DBcon::getDBcon();
	$mysqli = $con->getMysqliObject();
	
	$params = array("i",$this->uid);
	
	$this->queryhelper->beginTransaction($mysqli);
	$result = $this->queryhelper->executeStatement($mysqli,"SELECT c.* FROM circle c
										 INNER JOIN circlemembers
										 ON circlemembers.idcircle = c.idcircle
										 INNER JOIN customer
										 ON customer.idcustomer = circlemembers.customer_idcustomer
										 WHERE customer.idcustomer = ?",$params);
										 
	$this->queryhelper->commitTransaction($mysqli);

			
			
			
			$circlearray = array();
			
			while($row = $result->fetch_assoc())
			{
				array_push($circlearray,$row);
			}
			
			return $circlearray;

	}
	
	function createPost($circleid,$content)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
	
		date_default_timezone_set('America/New_York');
		$date = date('Y-m-d H:i:s', time());
	
		if($circleid == "g")
		{
			
		
			$this->queryhelper->beginTransaction($mysqli);
			
			$p1 = array("ss","socialnetwork","posts");
			$res1 = $this->queryhelper->executeStatement($mysqli,"SELECT AUTO_INCREMENT
																FROM information_schema.TABLES
																WHERE TABLE_SCHEMA = ?
																AND TABLE_NAME = ? ",$p1);
			$res1 = $res1->fetch_assoc();
			$key = $res1["AUTO_INCREMENT"];		

			
			$params = array("issis",$key,$date,$content,$this->uid,"T");
			$postresult = $this->queryhelper->executeStatement($mysqli,"INSERT INTO posts (idposts, date, contenttext, customer_idcustomer, visibletoall) VALUES (?,?,?,?,?)",$params);
			$this->queryhelper->commitTransaction($mysqli);	

			return  $postresult;
		}
		else
		{
	
			$this->queryhelper->beginTransaction($mysqli);
			
			$p1 = array("ss","socialnetwork","posts");
			$res1 = $this->queryhelper->executeStatement($mysqli,"SELECT AUTO_INCREMENT
																FROM information_schema.TABLES
																WHERE TABLE_SCHEMA = ?
																AND TABLE_NAME = ? ",$p1);
			$res1 = $res1->fetch_assoc();
			$key = $res1["AUTO_INCREMENT"];

			$p1 = array("i",$circleid);
			$res1 = $this->queryhelper->executeStatement($mysqli,"SELECT idpage FROM pages WHERE fkcircle = ? ",$p1);
			
			$res1 = $res1->fetch_assoc();
			$idpage = $res1["idpage"];

			
			$params = array("issiis",$key,$date,$content,$idpage,$this->uid,"T");
			$postresult = $this->queryhelper->executeStatement($mysqli,"INSERT INTO posts (idposts, date, contenttext, fkpage, customer_idcustomer, visibletoall) VALUES (?,?,?,?,?,?)",$params);
			$this->queryhelper->commitTransaction($mysqli);	

			return  $postresult;
		}
		

			
		
	}
	
	function likeOrUnlikePost($postid)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$params = array("ii",$postid,$this->uid);
		$this->queryhelper->beginTransaction($mysqli);
		$likeresult = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM posthaslike WHERE idpost = ? AND customer_idcustomer = ?",$params);								 
		$likecount = mysqli_num_rows($likeresult);
		
		if($likecount == 0) // No rows for like so insert
		{
			$insertresult = $this->queryhelper->executeStatement($mysqli,"INSERT INTO posthaslike (idpost,customer_idcustomer) VALUES (?,?)",$params);
			$this->queryhelper->commitTransaction($mysqli);
			return "liked";
		}
		else
		{
			$deleteresult = $this->queryhelper->executeStatement($mysqli,"DELETE FROM posthaslike WHERE idpost = ? AND customer_idcustomer = ?",$params);
			$this->queryhelper->commitTransaction($mysqli);
			return "unliked";
		}
		
		
	}
	
	function generateCardsForCircle($idcircle)
	{
	$con = DBcon::getDBcon();
	$mysqli = $con->getMysqliObject();
	
	
	$params = array("i",$idcircle);
	
	$this->queryhelper->beginTransaction($mysqli);
	$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM customer
										  INNER JOIN circlemembers 
										  ON circlemembers.customer_idcustomer = customer.idcustomer
										  WHERE
										  circlemembers.idcircle = ?",$params);
										 
	$this->queryhelper->commitTransaction($mysqli);
		
		
			

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
	
	function generatePostMaker()
	{
				 echo '<div class="card">
		   <div class="card-body">
		   <form action = "scipts/AjaxHandler.php" id="makepost">
		  <fieldset>
		  
		  <legend>Status</legend>
			
			<textarea rows="4" cols="50" style = "width: 95%; resize: none;" name="status" placeholder="Share whats on your mind" required></textarea>
			<span class="help-block">Where would you like to post to?</span>
			<select requried name="location">';
		
			
			$circles = $this->getCirclesOfCustomer();
			
			$count = count($circles);
			
			echo '<option value="g" >All</option>';
			
			for($i = 0; $i < $count; $i++)
			{
			echo '<option value='.$circles[$i]['idcircle'].'>'.$circles[$i]['name'].'</option>';
			}
			
			
			
			echo '
			</select>
			<br>
			<button type="submit" class="btn">Submit</button>
		  </fieldset>
		</form>
		   </div>
		   </div>';
	
	
	
	}
	
	function generatePostMakerForCircle()
	{
		echo ' <div class="span6">
		<div class="card">
		   <div class="card-body">
		   <form action = "scipts/AjaxHandler.php" id="makepost">
		  <fieldset>
		  
		  <legend>Status</legend>
			
			<textarea rows="4" cols="50" style = "width: 95%; resize: none;" name="status" placeholder="Share whats on your mind" required></textarea>

			<br>
			<button type="submit" class="btn">Submit</button>
		  </fieldset>
		</form>
		   </div>
		   </div>
		   </div>';
	}
	
	function getCustomerRowById($id)
	{
			$con = DBcon::getDBcon();
			$mysqli = $con->getMysqliObject();
	
			$params = array("i", $id);
	
			$this->queryhelper->beginTransaction($mysqli);
			$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM customer WHERE idcustomer = ?",$params);
			$this->queryhelper->commitTransaction($mysqli);
			
			return $result->fetch_assoc();
			
	}
	
	function generateCardById($id)
	{
		//include ("DBcon.php");
	}

	function echoPosts()
	{
			$con = DBcon::getDBcon();
			$mysqli = $con->getMysqliObject();
		
		date_default_timezone_set('America/New_York');
		
		$result;
		
		if($this->pageid == -1)
		{
		
			
			$params = array("ii", $this->uid, $this->uid);
	
			$this->queryhelper->beginTransaction($mysqli);
			$result = $this->queryhelper->executeStatement($mysqli,"SELECT p.*, customer.lastname, customer.firstname FROM posts p
			INNER JOIN customer
			ON customer.idcustomer = p.customer_idcustomer
			WHERE 
			p.fkpage IN (
			SELECT pg.idpage FROM pages pg, circle c, circlemembers cm  WHERE
			pg.fkcircle = c.idcircle
			AND
			c.idcircle = cm.idcircle
			AND
			cm.customer_idcustomer = ?) 


			OR

			(p.visibletoall = 'T' AND p.customer_idcustomer IN (
			SELECT DISTINCT cm2.customer_idcustomer FROM circlemembers cm2
			WHERE cm2.idcircle IN
			(
			SELECT cm3.idcircle FROM circlemembers cm3
			WHERE cm3.customer_idcustomer = ?
			))) ORDER BY p.date DESC",$params);
			
			$this->queryhelper->commitTransaction($mysqli);
			
			
		}
		else
		{
		
			$params = array("i", $this->pageid);
	
			$this->queryhelper->beginTransaction($mysqli);
			$result = $this->queryhelper->executeStatement($mysqli,"SELECT p.*, customer.lastname, customer.firstname FROM posts p
																	INNER JOIN customer
																	ON customer.idcustomer = p.customer_idcustomer
																	WHERE 
																	p.fkpage = ? ORDER BY p.date DESC",$params);
										 
			$this->queryhelper->commitTransaction($mysqli);
			
			
			
		}
			
			
			
			
			
			while($row = $result->fetch_assoc())
			{
				if($row['image'] == NULL)
				{
					   $params = array("i",$row['idposts']);
	
					   $this->queryhelper->beginTransaction($mysqli);
					   $result2 = $this->queryhelper->executeStatement($mysqli,"SELECT c.*, customer.lastname, customer.firstname FROM comment c
														 INNER JOIN customer
														 ON customer.idcustomer = c.customer_idcustomer WHERE c.fkpost = ?",$params);
										 
					   $this->queryhelper->commitTransaction($mysqli);
				
					  
					
					   $commentcount = mysqli_num_rows($result2);
				
				
						echo ' <div class="span6">
						<div class="card">
					   <div class="card-heading image">
						  <img src="holder.js/46x46" alt=""/>
						  <div class="card-heading-header">
							 <h3>'.$row['firstname'].' '.$row['lastname'].'</h3>
							 <span>Published at - '.date('h:i a m/d/Y', strtotime($row['date'])).'</span>
						  </div>
					   </div>
					   <div class="card-body">
						  <p>'.$row['contenttext'].'
						  </p>';
					
					   $params = array("ii",$row['idposts'],$this->uid);
					   $this->queryhelper->beginTransaction($mysqli);
					   $result3 = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM posthaslike WHERE idpost = ? AND customer_idcustomer = ?",$params);								 
					   $this->queryhelper->commitTransaction($mysqli);
					   
					   if(mysqli_num_rows($result3) > 0)
					   {
						echo '
						  <span role="button" style="color: #6d84b4; font-size: 12.5px; opacity: .5%" class="like-button-post" ><a href="#" id="post'.$row['idposts'].'">Unlike</a></span></div>';
					   }
					   else
					   {
							echo '
						  <span role="button" style="color: #6d84b4; font-size: 12.5px; opacity: .5%" class="like-button-post" ><a href="#" id="post'.$row['idposts'].'">Like</a></span></div>';
					   }
						  
						 
					   echo '
					   
					   

					   <div class="card-comments">
						  <div class="comments-collapse-toggle">
						  
						  <div style = "margin-bottom: 5px; border-bottom: 1px solid #ccc;">';				

						  $params = array("i",$row['idposts']);
						  $this->queryhelper->beginTransaction($mysqli);
					      $likeresult = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM posthaslike WHERE idpost = ?",$params);								 
					      $this->queryhelper->commitTransaction($mysqli);
						  $likecount = mysqli_num_rows($likeresult);
						  
						  if($likecount == 0)
						  {
						  echo'<span>0 Likes</span>';
						  }
						  else if ($likecount == 1)
						  {
						   $lrow = $likeresult->fetch_assoc();
						   $custrec = $this->getCustomerRowById($lrow['customer_idcustomer']);
						   echo'<span>'.$custrec['firstname'].' '.$custrec['lastname'].' likes this</span>';
						  }
						  else
						  {
							$custlisthtml = "<p>";
							
							while($lrow = $likeresult->fetch_assoc())
							{
							
								$custrec = $this->getCustomerRowById($lrow['customer_idcustomer']);
								
								$custlisthtml .= $custrec['firstname'];
								$custlisthtml .= "&nbsp";
								$custlisthtml .= $custrec['lastname'];
								$custlisthtml .= "<br>";
								
							}
							
							$custlisthtml .= "</p>";
						  
							echo'<span class="likelist" data-toggle="popover" data-placement="top" data-original-title="" data-trigger="hover" data-html="true" data-content="'.$custlisthtml.'" >'.$likecount.' Likes</span>';
						  }
						  echo '
						  </div>
						  
							 <a data-toggle="collapse"data-target="#'.$row['idposts'].'" href="#" class = "comment-drop">'.$commentcount.' comments <i class="icon-angle-down"></i></a>
						  </div>
						  ';
						  
						  if($commentcount > 0)
						  {
						  echo '
						  <div id="'.$row['idposts'].'" class="comments collapse">
						  ';
						  
							while($row2 = $result2->fetch_assoc())
						    {
							 echo '
							 <div class="media">
								<a class="pull-left" href="#">
								   <img class="media-object" data-src="holder.js/28x28" alt="avatar"/>
								</a>
								<div class="media-body">
								   <h4 class="media-heading">'.$row2['firstname'].' '.$row2['lastname'].'</h4>
								   <p>'.$row2['content'].'</p>
							  </div>
							 </div>
							 ';
							}
						  echo '	
						  </div>
						  ';
						  }
						  
						   echo '
						  <div class="card-comments">
						  <form>
						  <fieldset>			
							<label>Leave a Comment</label>
							<textarea rows="2" cols="50" style = "width: 100%" name="comment"></textarea>
							<button type="submit" class="btn">Submit</button>
						  </fieldset>
						</form>
						  </div>';
						  
					echo '	  
					</div>
					</div>
					</div>';
				}
				else
				{
				
				}
			}
		}	
	
  
}




?>

