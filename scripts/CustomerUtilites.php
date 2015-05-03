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
	
	
	function echoNav($activetab)
	{
		
		
		
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$queryhelper = new PreparedQueryHelper();
		
		$queryhelper->beginTransaction($mysqli);
		
		$params1 = array("ii",$this->uid,$this->uid);
		
		$result = $queryhelper->executeStatement($mysqli,"SELECT c.* FROM circle c
										 INNER JOIN circlemembers
										 ON circlemembers.idcircle = c.idcircle
										 INNER JOIN customer
										 ON customer.idcustomer = circlemembers.customer_idcustomer
										 WHERE customer.idcustomer = ? AND c.customer_idcustomer = ?",$params1);
		
		
		$result2 = $queryhelper->executeStatement($mysqli,"SELECT c.* FROM circle c
										 INNER JOIN circlemembers
										 ON circlemembers.idcircle = c.idcircle
										 INNER JOIN customer
										 ON customer.idcustomer = circlemembers.customer_idcustomer
										 WHERE customer.idcustomer = ? AND c.customer_idcustomer <> ?",$params1);
		
		
		$queryhelper->commitTransaction($mysqli);
		
		
		
		
	
		echo '<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
		 <div class = "row-fluid" >
		  <div class="span1 offset2">
          <a class="brand" href="./index.html"><img src="assets/img/SBHlogo.jpg" width="40" height="40" ></a>
		  </div>
		 <ul class="nav" style="position: relative; top: 10px;">
		

              <li '; if($activetab == 0) { echo 'class="active"';}  echo'>
                <a href="./home.php">All</a>
              </li>
              <li '; if($activetab == 1) { echo 'class="active"';}  echo'>
                <a href="./profile.php">Profile</a>
              </li>
              <li '; if($activetab == 2) { echo 'class="active"';}  echo'>
                <a href="./accounts.php">Accounts</a>
              </li>
             <li class="dropdown" '; if($activetab == 3) { echo 'class="active"';}  echo'>
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
				
					$crow = $this->getCustomerRowById($this->uid,false);
      
				  echo '
                  <li role="presentation" class="divider"></li>
                  <li role="presentation">
				  <div class="input-append offset1">
					<form id = "createcircle">
					<input class="span9" name="namecircleinput" required type="text">
					<button class="btn" type="submit">Create!</button>
					</form>
					</div>
				  </li>
                </ul>
              </li>
              <li '; if($activetab == 4) { echo 'class="active"';}  echo'>
                <a href="./messages.php">Messages</a>
              </li>
              <li '; if($activetab == 5) { echo 'class="active"';}  echo'>
                <a href="./plus.html">Purchases</a>
              </li>
			  
			  <li '; if($activetab == 6) { echo 'class="active"';}  echo'>
                <a href="./searchcircles.php">Search Circles</a>
              </li>

            </ul>
			
			 <ul class="nav offset2" style="position: relative; top: 10px;">
			 
			 <li style="position: relative; top: 12px;">'.$crow['firstname'].' '.$crow['lastname'].'</li>
			 
			  <li class="dropdown dropdown-notification" style="position: relative; top: -15px;">
			    <a class="btn btn-small dropdown-toggle" data-toggle = "dropdown" href="#"><i class="icon-bell"><span class="badge badge-info"></span></i></a>
			  
				 <ul class="dropdown-menu dropdown-notifications">
                                  <li class="header">Notifications</li>';

								  $this->echoNotifications($this->uid);
								  
                                 echo' <li>
                                     <span class="title"><strong>Notification</strong> title</span>
                                  </li>
                 </ul>
			  
			  </li>
			 
			  <li class="" style="position: relative; top: -5px;">
			    <a class="btn btn-small" href="scripts/LogoutScript.php">Logout</a>
			  </li>
			 
			 </ul>
			 
			 
          </div>
		 </ul>		
		</div>

      </div>';
	
	}
	
	function getCustomersOfCircle($circleid)
	{
	$con = DBcon::getDBcon();
	$mysqli = $con->getMysqliObject();
	
	$params = array("i",$circleid);
	
	$this->queryhelper->beginTransaction($mysqli);
	
	$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM customer c
															INNER JOIN circlemembers
															ON circlemembers.customer_idcustomer = c.idcustomer
															WHERE idcircle = ?",$params);
	
	$this->queryhelper->commitTransaction($mysqli);
	
	return $result;
		
	}
	
	function getAdvertisementRow($id)
	{
			$con = DBcon::getDBcon();
			$mysqli = $con->getMysqliObject();
			
			$params = array("i",$id);
			
			$this->queryhelper->beginTransaction($mysqli);
			
			$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM advertisement WHERE idadvertisement = ?",$params);
			
			$this->queryhelper->commitTransaction($mysqli);
			
			return $result->fetch_assoc();
	
	}
	
	function getTransactionOfAccount($accid)
	{
			$con = DBcon::getDBcon();
			$mysqli = $con->getMysqliObject();
			
			$params = array("i",$accid);
			
			$this->queryhelper->beginTransaction($mysqli);
			
			$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM transaction WHERE accountfkey = ?",$params);
			
			$this->queryhelper->commitTransaction($mysqli);
			
			return $result;
	
	}
	
	function getAccountsOfCustomer()
	{
			$con = DBcon::getDBcon();
			$mysqli = $con->getMysqliObject();
			
			$params = array("i",$this->uid);
			
			$this->queryhelper->beginTransaction($mysqli);
			
			$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM account WHERE customer_idcustomer = ?",$params);
												 
			$this->queryhelper->commitTransaction($mysqli);
			
			return $result;
	}
	

	
	function buildAdvertisementModal($mode)
	{
			/*mode 1 is all advertisement, mode 2 is by prefrence, mode 3 is by past purchase*/
			
			$result;
			
			if($mode == 1)
			{
				$result = $this->listAdvertisementsByPref();
			}
			
			$slidelist = "";
			$contentlist = "";
			$count = 0;
			$firstitemcount;
			
			$formatter = new \NumberFormatter('en_US',  \NumberFormatter::CURRENCY);
			
			while($row = $result->fetch_assoc())
			{
				if($count == 0)
				{
					$firstitemcount = $row['unitsleft'];
				
					$slidelist .= '<li data-target="#itembroswer" data-slide-to="'.$count.'" class="active"></li>';
					$contentlist .= '<div class="item active" id = '.$row['idadvertisement'].'>
						<img src="'.$row['imgloc'].'" alt="">
						<div class="carousel-caption">
						  <h4>'.$row['itemname'].'</h4>
						  <p>'.$row['content'].'</p>
						  <p id = "price'.$row['idadvertisement'].'">Price: '.$formatter->formatCurrency($row['unitprice'], 'USD') . PHP_EOL.'</p>
						  <p>Units Left: '.$row['unitsleft'].'</p>
						</div>
					  </div>';
				}
				else
				{
					$slidelist .= '<li data-target="#itembroswer" data-slide-to="'.$count.'" ></li>';
					$contentlist .= '<div class="item" id = '.$row['idadvertisement'].'>
						<img src="'.$row['imgloc'].'" alt="">
						<div class="carousel-caption">
						  <h4>'.$row['itemname'].'</h4>
						  <p>'.$row['content'].'</p>
						  <p id = "price'.$row['idadvertisement'].'">Price: '.$formatter->formatCurrency($row['unitprice'], 'USD') . PHP_EOL.'</p>
						  <p>Units Left: '.$row['unitsleft'].'</p>
						</div>
					  </div>';
				}
				
				$count++;
			}
			
	//max-height: 750px;
	
		     echo ' <div id="purchasemodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style = "width: 900px;">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="myModalLabel">Shopping</h3>
				  </div>
				  
				  <div class="modal-body" style = "width: 850px;">
				  
					<div class="span8" id = "purchaseinner">
					
				<div id="itembroswer" class="carousel slide">
                <ol class="carousel-indicators">';
				echo $slidelist;
                echo '
                </ol>
				
					<div class="carousel-inner" id = "caroinner">';
					
					echo $contentlist;
					  
					echo '</div>
                <a class="left carousel-control" href="#itembroswer" data-slide="prev">&lsaquo;</a>
                <a class="right carousel-control" href="#itembroswer" data-slide="next">&rsaquo;</a>
                </div>
				 
					</div>

				<form id = "purchaseform">
				  <fieldset>
					<legend>Buy This Item</legend>
					<span class="help-block">Select Account</span>
					
						<select name="accountselect" required>
						<option value="" disabled>Select an Account</option>';
						
						 $result = $this->getAccountsOfCustomer();
						 
						 while($row = $result->fetch_assoc())
						 {
							
								echo '<option value='.$row['idaccount'].'>Credit Card: '.$row['creditcardnum'].'</option>';
							
						 }
						
						echo ';
						</select>
					
					<span class="help-block">Quantity</span>
					<input type="number" min="1" max="'.$firstitemcount.'" name="qtyenter"> <br>
					<span id = "subtotal">Total: $22,000</span> <br>
					<button type="submit" class="btn btn-primary">Submit</button> <span style="color:red" id = "transerror"></span>
				  </fieldset>
				</form>
					
					</div>
					 
				  
				  <div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

			</div>
			</div>';

	}
	
	function makeTransaction($itemid,$qty,$accfkey)
	{
			$con = DBcon::getDBcon();
			$mysqli = $con->getMysqliObject();
			
			date_default_timezone_set('America/New_York');
		
			$date = date('Y-m-d H:i:s', time());
			
			$params = array("siii",$date,$qty,$accfkey,$itemid);
			$params2 = array("i",$itemid);
			
			$this->queryhelper->beginTransaction($mysqli);
			
			$itemres = $this->queryhelper->executeStatement($mysqli,"SELECT unitsleft FROM advertisement WHERE idadvertisement = ?",$params2);
			$itemrow = $itemres->fetch_assoc();
			$amtleft = $itemrow['unitsleft'];
			
			if($amtleft < $qty)
			{
				return "out of stock";
			}
			
			$newamt = $amtleft - $qty;
			
			$params3 = array("ii",$newamt,$itemid);
			
			$updateres = $this->queryhelper->executeStatement($mysqli,"UPDATE advertisement SET unitsleft = ? WHERE idadvertisement = ?",$params3);
			
			
			$result = $this->queryhelper->executeStatement($mysqli,"INSERT INTO transaction (timestamp,amtpurchased,accountfkey,advertisementfkey) VALUES (?,?,?,?)",$params);
			
			$this->queryhelper->commitTransaction($mysqli);
			
			return $result;
			
			
	}
	
	function getItemsLeft($itemid)
	{
			$con = DBcon::getDBcon();
			$mysqli = $con->getMysqliObject();
			
			$params = array("i",$itemid);
			
			$this->queryhelper->beginTransaction($mysqli);
			
			$result = $this->queryhelper->executeStatement($mysqli,"SELECT unitsleft FROM advertisement WHERE idadvertisement = ?",$params);
												 
			$this->queryhelper->commitTransaction($mysqli);
			$row = $result->fetch_assoc();
			return $row['unitsleft'];
			
			
	}
	
	function listAllAdvertisements()
	{
			$con = DBcon::getDBcon();
			$mysqli = $con->getMysqliObject();
			
			$params = array("i",$this->uid);
			
			$this->queryhelper->beginTransaction($mysqli);
			
			$result = $mysqli->query("SELECT * FROM advertisement");
												 
			$this->queryhelper->commitTransaction($mysqli);
			
			return $result;
	}
	
	function listAdvertisementsByPref()
	{
			$con = DBcon::getDBcon();
			$mysqli = $con->getMysqliObject();
			
			$params = array("ii",$this->uid,$this->uid);
			
			$this->queryhelper->beginTransaction($mysqli);
			
			$result = $this->queryhelper->executeStatement($mysqli,"SELECT a.* FROM advertisement a
																	WHERE
																	a.typefkey IN (SELECT hp.type_idtype FROM haspreference hp WHERE hp.customer_idcustomer = ?)
																	UNION
																	SELECT a2.* FROM advertisement a2
																	WHERE
																	a2.typefkey NOT IN (SELECT hp.type_idtype FROM haspreference hp WHERE hp.customer_idcustomer = ?)",$params);
			
			$this->queryhelper->commitTransaction($mysqli);
			
			return $result;
			
	}
	
	function listCustomerPreferences()
	{
			$con = DBcon::getDBcon();
			$mysqli = $con->getMysqliObject();
			
			$params = array("i",$this->uid);
			
			$this->queryhelper->beginTransaction($mysqli);
			
			$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM type WHERE idtype IN (SELECT type_idtype FROM haspreference WHERE customer_idcustomer = ?)",$params);
			
			$this->queryhelper->commitTransaction($mysqli);
			
			return $result;
	}
	
	function listAvaliableTypes()
	{
			$con = DBcon::getDBcon();
			$mysqli = $con->getMysqliObject();
			
			$params = array("i",$this->uid);
			
			$this->queryhelper->beginTransaction($mysqli);
			
			$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM type WHERE idtype NOT IN (SELECT type_idtype FROM haspreference WHERE customer_idcustomer = ?)",$params);
			
			$this->queryhelper->commitTransaction($mysqli);
			
			return $result;
	}
	
	function addPreference($typeid)
	{
			$con = DBcon::getDBcon();
			$mysqli = $con->getMysqliObject();
			
			$params = array("ii",$typeid,$this->uid);
			
			$this->queryhelper->beginTransaction($mysqli);
			
			$result = $this->queryhelper->executeStatement($mysqli,"INSERT INTO haspreference (type_idtype,customer_idcustomer) VALUES (?,?)",$params);
			
			$this->queryhelper->commitTransaction($mysqli);
	}
	
	function removePreference($typeid)
	{
			$con = DBcon::getDBcon();
			$mysqli = $con->getMysqliObject();
			
			$params = array("ii",$typeid,$this->uid);
			
			$this->queryhelper->beginTransaction($mysqli);
			
			$result = $this->queryhelper->executeStatement($mysqli,"DELETE FROM haspreference WHERE type_idtype = ? AND customer_idcustomer = ?",$params);
			
			$this->queryhelper->commitTransaction($mysqli);
	}
	
	function listAdvertisementsByPastPurchse()
	{
	
	}
	
	function createAccount()
	{
	
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
	
	
	function createCircle($circlename)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$params = array("si",$circlename,$this->uid);
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$result = $this->queryhelper->executeStatement($mysqli,"INSERT INTO circle (name,customer_idcustomer) VALUES (?,?)",$params);
		
		$key = $mysqli->insert_id;
		
		$pgresult = $mysqli->query("SELECT MAX(idpage) AS next FROM pages");
		$row = $pgresult->fetch_assoc();
		$pkey = $row['next'];
		$pkey = $pkey + 1;
		
		$params = array("ii",$pkey,$key);
		$pgresult = $this->queryhelper->executeStatement($mysqli,"INSERT INTO pages (idpage,fkcircle) VALUES (?,?)",$params);
		
		
		$params2 = array("ii",$key,$this->uid);
		
		$result2 = $this->queryhelper->executeStatement($mysqli,"INSERT INTO circlemembers (idcircle,customer_idcustomer) VALUES (?,?)",$params2);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		return $result2;
	
	}
	
	
	function editCircleName($circleid,$newname)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$params = array("si",$newname,$circleid);
	
		$this->queryhelper->beginTransaction($mysqli);
		
		$result = $this->queryhelper->executeStatement($mysqli,"UPDATE circle SET name = ? WHERE idcircle = ?",$params);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		return $result;
	
	}
	
	function findCircles($search)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$params = array("siii",$search,$this->uid,$this->uid,$this->uid);
		
		$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM circle c
																WHERE
																c.name LIKE CONCAT('%', ?, '%')
																AND
																c.idcircle NOT IN(
																 SELECT cm.idcircle FROM circlemembers cm WHERE cm.customer_idcustomer = ?
																 UNION
																 SELECT rj.circle_idcircle FROM requestjoincircle rj WHERE rj.customer_idcustomer = ?
																 UNION 
																 SELECT ic.circle_idcircle FROM invitedtocircle ic WHERE ic.customer_idcustomer = ?)",$params);
																 
		
		
		$htmlres = "";
		
		while($row = $result->fetch_assoc())
		{
			$custrow = $this->getCustomerRowById($row['customer_idcustomer'],false);
			
			$pageid = $this->getPageOfCircle($row['idcircle'],false);
			
			
			$params2 = array("i",$pageid);
			$result2 = $this->queryhelper->executeStatement($mysqli,"SELECT COUNT(*) AS postcount FROM posts WHERE fkpage = ?",$params2);
			$row2 = $result2->fetch_assoc();
			$postcount = $row2['postcount'];
			
			
			
			$params3 = array("i",$row['idcircle']);
			$result3 = $this->queryhelper->executeStatement($mysqli,"SELECT COUNT(*) AS membercount FROM circlemembers WHERE idcircle = ?",$params3);
			$row3 = $result3->fetch_assoc();
			$membercount = $row3['membercount'];
			
			$name = "'".$custrow['firstname'].' '.$custrow['lastname']."'";
		
			$htmlres .= '<div class="card hovercard" style = "display: inline-block; margin-right: 50px;">
		   <img src="assets/img/the-simpsons.png" alt=""/>
		   <div class="avatar">
			  <img src="assets/img/avatar_homer.png" alt="" />
		   </div>
		   <div class="info">
			  <div class="title">
				 '.$row['name'].'
			  </div>
			  <div class="desc">Owner: '.$custrow['firstname'].' '.$custrow['lastname'].'</div>
			  <div class="desc">'.$postcount.' Posts</div>
			  <div class="desc">'.$membercount.' Members</div>
		   </div>
		   <div class="bottom">
			  <button class="btn" onclick = "joincircle('.$row['idcircle'].')">Join</button><br>
			  <button onclick = "showMessage('.$custrow['idcustomer'].','.$name.')" class="btn msgowner">Message Owner</button>
		   </div>
		</div>';
		}
		$this->queryhelper->commitTransaction($mysqli);
		
		return $htmlres;
		
	
	}
	
	function getPageOfCircle($circleid, $trans)
	{
			$con = DBcon::getDBcon();
			$mysqli = $con->getMysqliObject();
			
			if($trans == true)
			$this->queryhelper->beginTransaction($mysqli);
		
			$p1 = array("i",$circleid);
			$res1 = $this->queryhelper->executeStatement($mysqli,"SELECT idpage FROM pages WHERE fkcircle = ? ",$p1);
			
			if($trans == true)
			$this->queryhelper->commitTransaction($mysqli);
			
			$row = $res1->fetch_assoc();
			return $row['idpage'];
	}
	
	function removeCustomerFromCircle($circleid,$custid)
	{
	
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$params = array("ii",$circleid,$custid);
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$result = $this->queryhelper->executeStatement($mysqli,"DELETE FROM circlemembers WHERE idcircle = ? AND customer_idcustomer = ? ",$params);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		return $result;
	
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
			
			
			
			$params = array("issiis",$key,$date,$content,$idpage,$this->uid,"F");
			$postresult = $this->queryhelper->executeStatement($mysqli,"INSERT INTO posts (idposts, date, contenttext, fkpage, customer_idcustomer, visibletoall) VALUES (?,?,?,?,?,?)",$params);
			$this->queryhelper->commitTransaction($mysqli);	

			return  $postresult;
		}
		

			
		
	}
	
	function editPost($postid, $newcontent)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$this->queryhelper->beginTransaction($mysqli);
		$params = array("si",$newcontent,$postid);
		$postresult = $this->queryhelper->executeStatement($mysqli,"UPDATE posts SET contenttext = ? WHERE idposts = ?",$params);
		$this->queryhelper->commitTransaction($mysqli);	
		
		return $postresult;
		
	}
	
	function deletePost($postid)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$this->queryhelper->beginTransaction($mysqli);
		$params = array("i",$postid);
		$postresult = $this->queryhelper->executeStatement($mysqli,"DELETE FROM posts WHERE idposts = ?",$params);
		$this->queryhelper->commitTransaction($mysqli);	
		
		return $postresult;
	
	}
	
	
	
	function createComment($postid, $content)
	{
		date_default_timezone_set('America/New_York');
		$date = date('Y-m-d H:i:s', time());
	
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$this->queryhelper->beginTransaction($mysqli);
		$params = array("siis",$content,$postid,$this->uid,$date);
		
		$postresult = $this->queryhelper->executeStatement($mysqli,"INSERT INTO comment (content,fkpost,customer_idcustomer,date) VALUES (?,?,?,?)",$params);
		
		$this->queryhelper->commitTransaction($mysqli);	
		
		return $postresult;
		
	}
	
	function editComment($commentid, $newcontent)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$this->queryhelper->beginTransaction($mysqli);
		$params = array("si",$newcontent,$commentid);
		
		$postresult = $this->queryhelper->executeStatement($mysqli,"UPDATE comment SET content = ? WHERE idcomment = ?",$params);
		
		$this->queryhelper->commitTransaction($mysqli);	
		
		return $postresult;
	}
	
	function deleteComment($commentid)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$this->queryhelper->beginTransaction($mysqli);
		$params = array("i",$commentid);
		$postresult = $this->queryhelper->executeStatement($mysqli,"DELETE FROM comment WHERE idcomment = ?",$params);
		$this->queryhelper->commitTransaction($mysqli);	
		
		return $postresult;
	
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
	
	function likeOrUnlikeComment($commentid)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$params = array("ii",$commentid,$this->uid);
		$this->queryhelper->beginTransaction($mysqli);
		$likeresult = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM commenthaslike WHERE comment_idcomment = ? AND customer_idcustomer = ?",$params);								 
		$likecount = mysqli_num_rows($likeresult);
		
		if($likecount == 0) // No rows for like so insert
		{
			$insertresult = $this->queryhelper->executeStatement($mysqli,"INSERT INTO commenthaslike (comment_idcomment,customer_idcustomer) VALUES (?,?)",$params);
			$this->queryhelper->commitTransaction($mysqli);
			return "liked";
		}
		else
		{
			$deleteresult = $this->queryhelper->executeStatement($mysqli,"DELETE FROM commenthaslike WHERE comment_idcomment = ? AND customer_idcustomer = ?",$params);
			$this->queryhelper->commitTransaction($mysqli);
			return "unliked";
		}
		
		
	}
	
	function getAllCustomer()
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$result = $mysqli->query("SELECT * FROM customer ORDER BY lastname ASC");
		
		return $result;
	
	}
	
	function generateCardById($id,$style)
	{
		
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$params = array("i",$id);
		
		
		$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM customer WHERE idcustomer = ?",$params);
		$row = $result->fetch_assoc();
		
	
		
	
		$card =  '<div class="card people" '.$style.' id="'.$row['idcustomer'].'">
			   <div class="card-top green">
				  <a href="#">
					 <img src="assets/img/silhouette_homer.png" alt=""/>
				  </a>
			   </div>
			   <div class="card-info">
				  <a class="title" href="#">'.$row['firstname'].' '.$row['lastname'].'</a>
				  <div class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
			   </div>
			   <div class="card-bottom">';
				  if($this->uid != $row['idcustomer'])
					{
				      echo '<button class="btn btn-small" href="#newmessagemodal" data-toggle="modal" onclick="newmessage('.$row['idcustomer'].')">Message</button>';
				    }
					echo '
				  </div>
			</div>';
			
		return $card;
	}
	

	
	
	function inviteToCircle($circleid, $custid)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		
		$params = array("ii",$custid,$circleid);
		$params2 = array("i",$circleid);
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$result =  $this->queryhelper->executeStatement($mysqli,"SELECT name, customer_idcustomer FROM circle WHERE idcircle = ?",$params2);
		$circlerow = $result->fetch_assoc();
		
		$circlename = $circlerow['name'];
		
		$custrow = $this->getCustomerRowById($circlerow['customer_idcustomer'], false);
		
		$params3 = array("ssii","Circle Invitation","You have been invited to ".$circlename." by ".$custrow['firstname']." ".$custrow['lastname']."",$custid,$circleid);
		
		
		$result1 = $this->queryhelper->executeStatement($mysqli,"INSERT INTO invitedtocircle (customer_idcustomer,circle_idcircle) VALUES (?,?)",$params);
		$result2 = $this->queryhelper->executeStatement($mysqli,"INSERT INTO notification (type,title,text,customer_idcustomer,circle_idcircle) VALUES (1,?,?,?,?)",$params3);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		return $result;
	
	}
	
	function requestToJoinCircle($circleid)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
	
		$params = array("ii",$this->uid,$circleid);
		$params2 = array("i",$circleid);
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$result =  $this->queryhelper->executeStatement($mysqli,"SELECT name, customer_idcustomer FROM circle WHERE idcircle = ?",$params2);
		$circlerow = $result->fetch_assoc();
		
		$circlename = $circlerow['name'];
		
		$custrowowner = $this->getCustomerRowById($circlerow['customer_idcustomer'], false);
		$custrowthis = $this->getCustomerRowById($this->uid, false);
		
		$params3 = array("ssiii","Circle Join Invitation","".$custrowthis['firstname']." ".$custrowthis['lastname']." wants to join your circle ".$circlerow['name']." ",$circlerow['customer_idcustomer'],$circleid,$this->uid);
		
		$result1 = $this->queryhelper->executeStatement($mysqli,"INSERT INTO requestjoincircle (customer_idcustomer,circle_idcircle) VALUES (?,?)",$params);
		$result2 = $this->queryhelper->executeStatement($mysqli,"INSERT INTO notification (type,title,text,customer_idcustomer,circle_idcircle,invitedcustomer) VALUES (2,?,?,?,?,?)",$params3);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		return $result;
	}
	
	function acceptCircleInv($circleid)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		
		$params = array("ii",$circleid,$this->uid);
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$result =  $this->queryhelper->executeStatement($mysqli,"INSERT INTO circlemembers (idcircle,customer_idcustomer) VALUES (?,?)",$params);
		$result2 = $this->queryhelper->executeStatement($mysqli,"DELETE FROM invitedtocircle WHERE circle_idcircle = ? AND customer_idcustomer = ?",$params);
		$result3 = $this->queryhelper->executeStatement($mysqli,"DELETE FROM notification WHERE circle_idcircle = ? AND customer_idcustomer = ?",$params);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		return $result;
	}
	
	function declineCircleInv($circleid)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		
		$params = array("ii",$circleid,$this->uid);
		
		$this->queryhelper->beginTransaction($mysqli);
	
		$result = $this->queryhelper->executeStatement($mysqli,"DELETE FROM invitedtocircle WHERE circle_idcircle = ? AND customer_idcustomer = ?",$params);
		$result1 = $this->queryhelper->executeStatement($mysqli,"DELETE FROM notification WHERE circle_idcircle = ? AND customer_idcustomer = ?",$params);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		return $result1;
	
	}
	
	function acceptCircleRequest($idnotification)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$params1 = array("i",$idnotification);
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$notres = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM notification WHERE idnotification = ?",$params1);
		$notirow = $notres->fetch_assoc();
		
		$circleid = $notirow['circle_idcircle'];
		$custid = $notirow['invitedcustomer'];
		
		$params = array("ii",$circleid,$custid);
		
		$result =  $this->queryhelper->executeStatement($mysqli,"INSERT INTO circlemembers (idcircle,customer_idcustomer) VALUES (?,?)",$params);
		$result2 = $this->queryhelper->executeStatement($mysqli,"DELETE FROM requestjoincircle WHERE circle_idcircle = ? AND customer_idcustomer = ?",$params);
		$result3 = $this->queryhelper->executeStatement($mysqli,"DELETE FROM notification WHERE idnotification = ?",$params1);
		
		
		$this->queryhelper->commitTransaction($mysqli);
		
	
	}
	
	function declineCircleRequest($idnotification)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$params1 = array("i",$idnotification);
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$notres = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM notification WHERE idnotification = ?",$params1);
		$notirow = $notres->fetch_assoc();
		
		$circleid = $notirow['circle_idcircle'];
		$custid = $notirow['invitedcustomer'];
		
		$params = array("ii",$circleid,$custid);
		
		$result2 = $this->queryhelper->executeStatement($mysqli,"DELETE FROM requestjoincircle WHERE circle_idcircle = ? AND customer_idcustomer = ?",$params);
		$result3 = $this->queryhelper->executeStatement($mysqli,"DELETE FROM notification WHERE idnotification = ?",$params1);
		
		$this->queryhelper->commitTransaction($mysqli);
		
	
	}
	
	function echoNotifications($custid)
	{
	
		/*type1: circle invitation*/
	
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$params = array("i",$custid);
		
		$result =  $this->queryhelper->executeStatement($mysqli,"SELECT * FROM notification WHERE customer_idcustomer = ? ORDER BY idnotification DESC",$params);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		while($row = $result->fetch_assoc())
		{
					if($row['type'] == 1)
					{
									echo '<li>
                                     <span class="title">'.$row['title'].'</span>
                                     <div class="media">
                                        <a class="pull-left" href="#">
                                           <img class="media-object" data-src="holder.js/48x48/#fff:#444">
                                        </a>
                                        <div class="media-body">
                                         '.$row['text'].'
                                        </div>
										<div class="card-actions">
										<button class="btn btn-primary acceptcircleinv" id = "'.$row['circle_idcircle'].'">Accept</button>
										<button class="btn btn-warning declinecircleinv" id = "'.$row['circle_idcircle'].'">Decline</button>
										</div>
                                     </div>
                                  </li>';
					}
					
					if($row['type'] == 2)
					{
									echo '<li>
										 <span class="title">'.$row['title'].'</span>
										 <div class="media">
											<a class="pull-left" href="#">
											   <img class="media-object" data-src="holder.js/48x48/#fff:#444">
											</a>
											<div class="media-body">
											 '.$row['text'].'
											</div>
											<div class="card-actions">
											<button class="btn btn-primary acceptjoinrequest" id = "'.$row['idnotification'].'">Accept</button>
											<button class="btn btn-warning declinejoinrequest" id = "'.$row['idnotification'].'">Decline</button>
											</div>
										 </div>
									  </li>';
					}
		}
		
	}
	
	function getInvitedCards($circleid)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$params = array("i",$circleid);
		$result = $this->queryhelper->executeStatement($mysqli,"SELECT customer_idcustomer FROM invitedtocircle WHERE circle_idcircle = ?",$params);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		$cards = "";
		$count = 0;
		
		$style = "";
		
		while($row = $result->fetch_assoc())
		{
			if($count > 0 && $count % 4 == 0)
			{
				$style="style='margin-left:0px;'";
			}
			else
			{
				$style="";
			}
		
			$cards .= $this->generateCardById($row['customer_idcustomer'],$style);
			$count++;
		}
		
		return $cards;
		
	}
	
	function getRequestedCards($circleid)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$params = array("i",$circleid);
		$result = $this->queryhelper->executeStatement($mysqli,"SELECT customer_idcustomer FROM requestjoincircle WHERE circle_idcircle = ?",$params);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		$cards = "";
		$count = 0;
		
		$style = "";
		
		while($row = $result->fetch_assoc())
		{
			if($count > 0 && $count % 4 == 0)
			{
				$style="style='margin-left:0px;'";
			}
			else
			{
				$style="";
			}
		
			$cards .= $this->generateCardById($row['customer_idcustomer'],$style);
			$count++;
		}
		
		return $cards;
		
	}
	
	function getCardsFromSearch($search,$circleid)
	{
		$htmlres = "";
	
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		
		$params = array("ss",$search,$search);
		
		$this->queryhelper->beginTransaction($mysqli);
		$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM customer WHERE CONCAT(firstname, ' ' , lastname) LIKE CONCAT('%', ?, '%') OR CONCAT(lastname, ' ' , firstname) LIKE CONCAT('%', ?, '%') ",$params);
		
		$count = 0;
		
		
		while($row = $result->fetch_assoc())
		{
			if($row['idcustomer'] == $this->uid)
				continue;
		
		
			if($count > 0 && $count % 3 == 0)
				{
					$style="style='margin-left:0px;'";
				}
				else
				{
					$style="";
				}
		
			$htmlres .= '<div class="card people" '.$style.' id="'.$row['idcustomer'].'">
			   <div class="card-top green">
				  <a href="#">
					 <img src="assets/img/silhouette_homer.png" alt=""/>
				  </a>
			   </div>
			   <div class="card-info">
				  <a class="title" href="#">'.$row['firstname'].' '.$row['lastname'].'</a>
				  <div class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
			   </div>
			   <div class="card-bottom">';

				      $htmlres.= '<button class="btn btn-small" href="#newmessagemodal" data-toggle="modal" onclick="newmessage('.$row['idcustomer'].')">Message</button>';

					
				  
				  $params2 = array("ii",$row['idcustomer'],$circleid);
				  
				  $result2 = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM invitedtocircle WHERE customer_idcustomer = ? AND circle_idcircle = ?",$params2);
				  $result3 = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM requestjoincircle WHERE customer_idcustomer = ? AND circle_idcircle = ?",$params2);
				  $result4 = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM circlemembers WHERE customer_idcustomer = ? AND idcircle = ?",$params2);
				  
				  if(mysqli_num_rows($result2) == 0 && mysqli_num_rows($result3) == 0 && mysqli_num_rows($result4) == 0)
				  {
					$htmlres.= '<button class="btn btn-small" onclick="inviteToCircle('.$row['idcustomer'].')">Invite</button>';
				  }
				  else
				  {
				    if( mysqli_num_rows($result4) > 0)
					  $htmlres.= '<button class="btn btn-small" disabled>Joined</button>';
					  
					if( mysqli_num_rows($result2) > 0 ||  mysqli_num_rows($result3) > 0)
				      $htmlres.= '<button class="btn btn-small" disabled>Pending..</button>';
					
					
				  }
				  
				  
				  
				  
				  $htmlres.= '
			   </div>
			</div>';
			
			$count++;
			
		}
		
										 
		$this->queryhelper->commitTransaction($mysqli);
		
		return $htmlres;
	
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
			   <div class="card-bottom">';
					if($this->uid != $row['idcustomer'])
					{
				      echo '<button class="btn btn-small" href="#newmessagemodal" data-toggle="modal" onclick="newmessage('.$row['idcustomer'].')">Message</button>';
				    }
				echo '
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
	
	function getCustomerRowById($id, $trans)
	{
			$con = DBcon::getDBcon();
			$mysqli = $con->getMysqliObject();
	
			$params = array("i", $id);
			
			if($trans == true)
			$this->queryhelper->beginTransaction($mysqli);
			
			$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM customer WHERE idcustomer = ?",$params);
			
			if($trans == true)
			$this->queryhelper->commitTransaction($mysqli);
			
			return $result->fetch_assoc();
			
	}
	
	function getConversations()
	{
			$con = DBcon::getDBcon();
			$mysqli = $con->getMysqliObject();
	
			$params = array("iii", $this->uid, $this->uid, $this->uid);
			
			$this->queryhelper->beginTransaction($mysqli);
			
			$result = $this->queryhelper->executeStatement($mysqli,"SELECT DISTINCT c.idcustomer FROM customer c
			  WHERE c.idcustomer <> ?
			  AND
			  (
			  c.idcustomer IN (SELECT m1.customer_from FROM message m1 WHERE m1.customer_to = ?)
			  OR
			  c.idcustomer IN (SELECT m2.customer_to FROM message m2 WHERE m2.customer_from = ?))",$params);
			
			$this->queryhelper->commitTransaction($mysqli);
			
			return $result;


	}
	
	function buildChatSelector()
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$result = $this->getConversations();
		
		$this->queryhelper->commitTransaction($mysqli);
		
		while($row = $result->fetch_assoc())
		{
			$custrow = $this->getCustomerRowById($row['idcustomer'],true);
		
			echo '<li><a href="#" class = "messagethread" id = "mthread'.$row['idcustomer'].'"><img style = "position: relative; left: -20px;" "src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC4AAAAuCAYAAABXuSs3AAACDUlEQVRoQ+2USYsCMRSEq8V9P4giInpQEDdE8P//AHEBUVxQ0IO4exBcEO3hPRhx5tCJEoQZkkun+6UrlS+VGLvdzsQfbIY2/uFd08Q/DByauCYuSUBHRRKUsmGauDKUkkKauCQoZcM0cWUoJYU0cUlQyob9f+Kn0wntdhumaaJarcLtdmM6nWIymeB2uyEYDKJUKsHj8VhSVaUjTbzX62E+n8Pr9bLxw+GAbreLZDLJixgOh9zPZDKWxlXpSBlfLpfo9/u43+9wuVxsnGgvFgvuBwKBh9nRaMS1VCrFixwMBojFYsjn81itVtI6osMgNH4+n9FqteDz+XC5XHC9XtnseDzGZrOBzWbj799RsdvtaDQa/M0wDDgcDlQqFe6/oiOKnNA4be1+v+fJqf9snHYim83C6XRyLRKJcM7X6zXHiM5DLpdDPB7n+qs6VtQtjRPtZrOJ4/H4Q4MiEAqFmDjRJ6o0jp61Wg2z2QwUGWrpdBqJROItnbeN//6xXq8/iD8fTlpEp9NBNBploxQJihDFg3aoXC4jHA4/5GR0CoWCZcyFUXn++3lCOqR0FRJdug7JWLFY5Ntlu91yRCjvFBm/389Ro3dqIh2KG+krIy466Z+sv0T8k8ZEc2njIkKq65q4aqIiPU1cREh1XRNXTVSkp4mLCKmua+KqiYr0NHERIdV1TVw1UZHenyX+BZNo41wwGYJwAAAAAElFTkSuQmCC" alt="46x46" data-src="holder.js/46x46" style="width: 46px; height: 46px;">'.$custrow['firstname'].' '.$custrow['lastname'].'</a></li>';
		}
	}
	
	function getMessages($custid)
	{
		date_default_timezone_set('America/New_York');
	
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$params = array("iiii", $this->uid, $custid, $this->uid, $custid);
		
		$this->queryhelper->beginTransaction($mysqli);
		
		
		$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM message WHERE (customer_to = ? OR customer_to = ?) AND (customer_from = ? OR customer_from = ?) ORDER BY date ASC",$params);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		$htmlres = "";
		
		while($row = $result->fetch_assoc())
		{
			
			$custrowfrom = $this->getCustomerRowById($row['customer_from'],true);
			$custrowto = $this->getCustomerRowById($row['customer_to'],true);
			
			$htmlres .= '<div class="media">
              <a class="pull-left" href="#">
                <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAACfElEQVR4Xu2Y54piQRCFj4oRURETiAEVEyKCvv8TiAmMmBUMmDEgKO5Wg+LsMjsz9+LsoNV/BLHrdp8+db5rKxaLxQUvPBQsADuAW4Az4IUzEByCTAGmAFOAKcAUeGEFGIOMQcYgY5Ax+MIQ4D9DjEHGIGOQMcgYZAy+sAKyMTibzVCv13E4HKDVahEOh+F0Ot9IWqvVMBwOEQqF4Pf7P5T7ETXfe6gsAbbbLfL5PEwmE4LBIAqFAjQaDVKplPik8RuzKJVKOJ1OnxLgETX/pbgsAfr9PlqtFmKxGFwu11/POZ/PKBaLWC6XuFwuNwE6nQ7a7Tbsdrv4joSj3yaTSazXa0k1P7TVOz+QJUClUsF4PBbWpxbQ6XSIRqOw2WzicVeBLBYL5vP5TQByQy6Xw36/F+4hgag1yEVSa/4XAcrlMkajkTh92gCdpEqlQiaTEZan9tDr9SAByCn3GUDCVatVcfJGoxHpdBpqtRpyakoRQZYDaLGTyQTxeFyIQBsmCycSCVCQTadTYevVaoVms/lGABIom82Cet7r9YrwpCGn5rcL0Ov1xMlGIhG43e5bv9Nmut2usPif4+qCaw5QNlALkVBmsxlyan67ANfENhgMovcp8JRK5c3O1wWRGPcOuM5TKBRwOBwYDAawWq2CHrvdTjjpqzWlbJ7myGoBKkAt0Gg0cDwexaKpHajn78e9AD6f72bzQCAAj8cjsmOz2dyc9NWan3m3eMh7gFTVf9I82Q74SZuRshYWgG+E+EaIb4T4RkhKej7LHKYAU4ApwBRgCjxLokvZB1OAKcAUYAowBaSk57PMYQowBZgCTAGmwLMkupR9MAVenQK/ABFDeJ+TLM9JAAAAAElFTkSuQmCC" style="width: 64px; height: 64px;">
              </a>';
			  

			  $htmlres .= '
              <div class="media-body">
                <h4 class="media-heading">'.$custrowfrom['firstname'].' '.$custrowfrom['lastname'].' <span style = "  font-size: 12px; color: #999999; opacity: .5">Sent at '.date('h:i a m/d/Y', strtotime($row['date'])).'</span>';
				
				if($custrowfrom['idcustomer'] == $this->uid)
				{
				$htmlres .= '<div class="dropdown" style="display:inline; position: relative; top:-10px">
					   <a id="'.$row['idmessage'].'options" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><b class="caret"></b></a>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="'.$row['idmessage'].'options" style = "z-index: 4000">                 
                        <li role="presentation" class="deletemessage"><a role="menuitem" tabindex="-1" href="#" onclick = "deleteMessage('.$row['idmessage'].')">Delete</a></li>         
                      </ul>
						</div>';
				
				}
				
				$htmlres .= '
				</h4>
                '.$row['content'].'
              </div>
            </div>';
			
		}
		
		return $htmlres;
	}
	
	function sendMessage($messagecontent, $recid)
	{
		date_default_timezone_set('America/New_York');
	
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$date = date('Y-m-d H:i:s', time());
		
		$params = array("siis", $messagecontent, $recid, $this->uid, $date);
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$result = $this->queryhelper->executeStatement($mysqli,"INSERT INTO message (content,customer_to,customer_from,date) VALUES (?,?,?,?)",$params);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		return $result;
	
	}
	
	function deleteMessage($messageid)
	{
	
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$params = array("i", $messageid);
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$result = $this->queryhelper->executeStatement($mysqli,"DELETE FROM message WHERE idmessage = ?",$params);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		return $result;
	
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
					   <div class="card-heading image">';
					   
					   if($row["customer_idcustomer"] == $this->uid)
					   {
					   echo '
					   <div class="dropdown" style="display:inline; position: relative; float: right; top:-10px">
					   <a id="'.$row['idposts'].'options" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><b class="caret"></b></a>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="'.$row['idposts'].'options">
                        <li role="presentation" class="editpost"><a role="menuitem" tabindex="-1" href="#">Edit</a></li>
                        <li role="presentation" class="deletepost"><a role="menuitem" tabindex="-1" href="#deletePostModal" data-toggle="modal" onclick = "setDeletePost('.$row['idposts'].')">Delete</a></li>         
                      </ul>
						</div>';
					   }
					   echo'
						  <img src="holder.js/46x46" alt=""/>
						  <div class="card-heading-header">
							 <h3>'.$row['firstname'].' '.$row['lastname'].' </h3>
							 <span>Published at - '.date('h:i a m/d/Y', strtotime($row['date'])).'</span>
						  </div>
					   </div>
					   <div class="card-body" id="post'.$row['idposts'].'body">';
					   
					   if($row["customer_idcustomer"] == $this->uid)
					   {
					   echo '<div class="card-body" id = "'.$row['idposts'].'formdiv" style="display: none"> <form class="editpostform"><fieldset><textarea rows="4" cols="50" style = "width: 95%; resize: none;" name="editstatus" required>'.$row['contenttext'].'</textarea><button type="submit" class="btn-primary">Submit</button><button type="button" onclick="hideEditPost('.$row['idposts'].',post'.$row['idposts'].'body)" class="btn-warning">Cancel</button></fieldset></form></div>';
					   }
						echo '
						<p id="contenttext'.$row['idposts'].'" >'.$row['contenttext'].'</p>';
					
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
						   $custrec = $this->getCustomerRowById($lrow['customer_idcustomer'],true);
						   echo'<span>'.$custrec['firstname'].' '.$custrec['lastname'].' likes this</span>';
						  }
						  else
						  {
							$custlisthtml = "<p>";
							
							while($lrow = $likeresult->fetch_assoc())
							{
							
								$custrec = $this->getCustomerRowById($lrow['customer_idcustomer'],true);
								
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
								
							
								
								<div class="media-body" id = "'.$row2['idcomment'].'">
								
								 		   <h4 class="media-heading">'.$row2['firstname'].' '.$row2['lastname'].'</h4>';
										   
										   if($row2['customer_idcustomer'] == $this->uid)
										   {
										   echo '
										    <i style = "display:inline; position: relative; float: right; top:-20px" class="icon-remove removecomment" href="#deleteCommentModal" data-toggle="modal" onclick = "setDeleteComment('.$row2['idcomment'].')" ></i>
										    <i style = "display:inline; position: relative; float: right; top:-20px; margin-right: 5px;" class="icon-pencil editcomment"></i>
											<div class="card-body" id = "'.$row2['idcomment'].'cformdiv" style="display: none"> <form class="editcommentform"><fieldset><textarea rows="4" cols="50" style = "width: 95%; resize: none;" name="editcomment" required>'.$row2['content'].'</textarea><button type="submit" class="btn-primary">Submit</button><button type="button" onclick="hideEditComment('.$row2['idcomment'].',comment'.$row2['idcomment'].'body)" class="btn-warning closeeditcomment">Cancel</button></fieldset></form></div>';
										   }
										   
										   
										echo '<p style = "margin-bottom: 2px" id="contenttextc'.$row2['idcomment'].'">'.$row2['content'].'</p>';
										
								   
								   
								   $params = array("i",$row2['idcomment']);
								   $this->queryhelper->beginTransaction($mysqli);
								   $likeresult = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM commenthaslike WHERE comment_idcomment = ?",$params);								 
								   $this->queryhelper->commitTransaction($mysqli);
								   $likecount = mysqli_num_rows($likeresult);
								   
								   $params = array("ii",$row2['idcomment'],$this->uid);
								   $this->queryhelper->beginTransaction($mysqli);
								   $likeresult2 = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM commenthaslike WHERE comment_idcomment = ? AND customer_idcustomer = ?",$params);								 
								   $this->queryhelper->commitTransaction($mysqli);
								   $likecheck = mysqli_num_rows($likeresult2);
								   
								   if($likecheck == 0)
								   {
								   echo '<span role="button" style="color: #6d84b4; font-size: 12.5px; opacity: .5%; margin-right:5px;" class="like-button-comment" ><a href="#" id="comment'.$row2['idcomment'].'">Like</a></span>';
								   }
								   else
								   {
								   echo '<span role="button" style="color: #6d84b4; font-size: 12.5px; opacity: .5%; margin-right:5px;" class="like-button-comment" ><a href="#" id="comment'.$row2['idcomment'].'">Unlike</a></span>';
								   }
								   
								   
								   
								   if($likecount >= 1)
								   {
								   

								   
								   		$custlisthtml = "<p>";
							
										while($likerow = $likeresult->fetch_assoc())
										{
										
											$custrec = $this->getCustomerRowById($likerow['customer_idcustomer'],true);
											
											$custlisthtml .= $custrec['firstname'];
											$custlisthtml .= "&nbsp";
											$custlisthtml .= $custrec['lastname'];
											$custlisthtml .= "<br>";
											
										}
										
										$custlisthtml .= "</p>";
								   
								   
								   echo '<i class = "icon-thumbs-up likelist" data-toggle="popover" data-placement="top" data-original-title="" data-trigger="hover" data-html="true" data-content="'.$custlisthtml.'">'.$likecount.'</i>';
								   }
								   
								   echo '
						
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
						  <form class = "createcomment" id = "cc'.$row['idposts'].'">
						  <fieldset>			
							<label>Leave a Comment</label>
							<textarea rows="2" cols="50" style = "width: 100%" name="comment" required></textarea>
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

