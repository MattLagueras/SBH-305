<?php



class PostGenerator
{
	private $pageid;
	private $uid;


	function __construct($uid, $pageid) 
	{           
        $this->uid = $uid;
		$this->pageid = $pageid;
    }

	function echoPosts()
	{
		include ("DBcon.php");
		
		date_default_timezone_set('America/New_York');
		
		if($this->pageid == -1)
		{
		
			$query =  mysqli_prepare($mysqli,"
			SELECT p.*, customer.lastname, customer.firstname FROM posts p
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
			)))
			");
			
			mysqli_stmt_bind_param($query,"ii", $this->uid, $this->uid);
			mysqli_stmt_execute($query);
			$result = $query->get_result();
			
			while($row = $result->fetch_assoc())
			{
				if($row['image'] == NULL)
				{
					   $query2 = mysqli_prepare($mysqli,"SELECT c.*, customer.lastname, customer.firstname FROM comment c
														 INNER JOIN customer
														 ON customer.idcustomer = c.customer_idcustomer WHERE c.fkpost = ?");
					   mysqli_stmt_bind_param($query2,"i",$row['idposts']);
					   mysqli_stmt_execute($query2);
					   
					   $result2 = $query2->get_result();
					
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
						  </p>
						  <span style="color: #6d84b4; font-size: 12.5px; opacity: .5%"><a href="#">Like</a></span>
					   </div>

					   <div class="card-comments">
						  <div class="comments-collapse-toggle">
							 <a data-toggle="collapse" data-target="#'.$row['idposts'].'" href="#">'.$commentcount.' comments <i class="icon-angle-down"></i></a>
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
		else
		{
		
			$query =  mysqli_prepare($mysqli,"
			SELECT p.*, customer.lastname, customer.firstname FROM posts p
			INNER JOIN customer
			ON customer.idcustomer = p.customer_idcustomer
			WHERE 
			p.fkpage = ?");
			
			mysqli_stmt_bind_param($query,"i", $this->pageid);
			mysqli_stmt_execute($query);
			$result = $query->get_result();
			
			while($row = $result->fetch_assoc())
			{
				if($row['image'] == NULL)
				{
					   $query2 = mysqli_prepare($mysqli,"SELECT c.*, customer.lastname, customer.firstname FROM comment c
														 INNER JOIN customer
														 ON customer.idcustomer = c.customer_idcustomer WHERE c.fkpost = ?");
					   mysqli_stmt_bind_param($query2,"i",$row['idposts']);
					   mysqli_stmt_execute($query2);
					   
					   $result2 = $query2->get_result();
					
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
						  </p>
						  <span style="color: #6d84b4; font-size: 12.5px; opacity: .5%"><a href="#">Like</a></span>
					   </div>

					   <div class="card-comments">
						  <div class="comments-collapse-toggle">
							 <a data-toggle="collapse" data-target="#'.$row['idposts'].'" href="#">'.$commentcount.' comments <i class="icon-angle-down"></i></a>
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
	
	  mysqli_stmt_close($query);
	  mysqli_stmt_close($query2);
	  mysqli_close($mysqli);
	
	}
  }
}




?>

