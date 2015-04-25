<?php

/*
ACTION CODES
0 = Like/Unlike post [0,pid,uid]
1 = Like/Unlike comment [1,cid,uid]
2 = Make Post [2,pid,content,uid]
3 = Edit Post [3,pid,newcontent,uid]
4 = Make Comment [4,pid,content,uid]
5 = Edit Comment [5,cid,newcontent,uid]
6 = Delete Post [6,pid,uid]
7 = Delete Comment [7,cid,uid]
8 = Search Users [8,search,circleid,uid]
9 = Invite to Circle [9,circleid,cid,uid]
10 = Accept Circle Invite [10,circleid,uid]
11 = Decline Circle Invite [11,circleid,uid]
12 = Change Circle Name [12,circleid,newname,uid]
13 = Remove user From Circle [13,circleid,custid,uid]
14 = Create Circle [14,name,uid]
15 = Get Message [15,cid,uid]
16 = Send Message [16,messagecontent,rid,uid]
17 = Delete Message
18 = Get Transactions For Account [18,aid,uid]
19 = Get Items Left [19,itemit,uid]


*/

include_once ("CustomerUtilites.php");

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


	$con = DBcon::getDBcon();
	$mysqli = $con->getMysqliObject();
	
	


	$data = $_POST['data'];
	
	
	
	
	if($data[0] == 0)
	{
		$utilites = new CustomerUtilites($data[2],-1);
		
		$data[1] = str_replace("post",'',$data[1]);
		
		$res = $utilites->likeOrUnlikePost($data[1]);
		
		echo json_encode(array('result' => 'success', 'rdata' => $res));
		
	}
	
	if($data[0] == 1)
	{

	
		$utilites = new CustomerUtilites($data[2],-1);
		
		$data[1] = str_replace("comment",'',$data[1]);
		
		
		$res = $utilites->likeOrUnlikeComment($data[1]);
		
		echo json_encode(array('result' => 'success', 'rdata' => $res));
		
		
	}
	
	if($data[0] == 2)
	{
		$utilites = new CustomerUtilites($data[3],-1);
	
		$res = $utilites->createPost($data[1],$data[2]);
		
		echo json_encode(array('result' => 'success'));
		
	}
	
	if($data[0] == 3)
	{
		$utilites = new CustomerUtilites($data[3],-1);
		
		$utilites->editPost($data[1],$data[2]);
		
		echo json_encode(array('result' => 'success'));
	}
	
	if($data[0] == 4)
	{
		$utilites = new CustomerUtilites($data[3],-1);
		
		$utilites->createComment($data[1],$data[2]);
		
		echo json_encode(array('result' => 'success'));
	
	}
	
	if($data[0] == 5)
	{
		$utilites = new CustomerUtilites($data[3],-1);
		
		$utilites->editComment($data[1],$data[2]);
		
		echo json_encode(array('result' => 'success'));
	}
	
	if($data[0] == 6)
	{
		$utilites = new CustomerUtilites($data[2],-1);
		
		$utilites->deletePost($data[1]);
		
		echo json_encode(array('result' => 'success'));
	}
	
	if($data[0] == 7)
	{
		$utilites = new CustomerUtilites($data[2],-1);
		
		$utilites->deleteComment($data[1]);
		
		echo json_encode(array('result' => 'success'));
	}
	
	if($data[0] == 8)
	{
		$utilites = new CustomerUtilites($data[3],-1);
		
		$htmlres = $utilites->getCardsFromSearch($data[1],$data[2]);
		
		echo json_encode(array('result' => 'success', 'html' => $htmlres));
	}
	
	if($data[0] == 9)
	{
		$utilites = new CustomerUtilites($data[3],-1);
		
		$htmlres = $utilites->inviteToCircle($data[1],$data[2]);
		
		echo json_encode(array('result' => 'success'));
	}
	
	if($data[0] == 10)
	{
		$utilites = new CustomerUtilites($data[2],-1);
		
		$htmlres = $utilites->acceptCircleInv($data[1]);
		
		echo json_encode(array('result' => 'success'));
	}
	
	if($data[0] == 11)
	{
		$utilites = new CustomerUtilites($data[2],-1);
		
		$htmlres = $utilites->declineCircleInv($data[1]);
		
		echo json_encode(array('result' => 'success'));
	}
	
	if($data[0] == 12)
	{
		$utilites = new CustomerUtilites($data[3],-1);
		
		$htmlres = $utilites->editCircleName($data[1],$data[2]);
		
		echo json_encode(array('result' => 'success'));
	
	}
	
	if($data[0] == 13)
	{
		$utilites = new CustomerUtilites($data[3],-1);
		
		$htmlres = $utilites->removeCustomerFromCircle($data[1],$data[2]);
		
		echo json_encode(array('result' => 'success'));
	
	}
	
	if($data[0] == 14)
	{
		$utilites = new CustomerUtilites($data[2],-1);
		
		$htmlres = $utilites->createCircle($data[1]);
		
		echo json_encode(array('result' => 'success'));
	
	}
	
	if($data[0] == 15)
	{
		$utilites = new CustomerUtilites($data[2],-1);
		
		$htmlres = $utilites->getMessages($data[1]);
		
		echo json_encode(array('result' => 'success', 'html' => $htmlres));
	}
	
	if($data[0] == 16)
	{
	
		$utilites = new CustomerUtilites($data[3],-1);
		
		$htmlres = $utilites->sendMessage($data[1],$data[2]);
		
		echo json_encode(array('result' => 'success', 'html' => $htmlres));
	}
	
	if($data[0] == 17)
	{
	
		$utilites = new CustomerUtilites($data[2],-1);
		
		$htmlres = $utilites->deleteMessage($data[1]);
		
		echo json_encode(array('result' => 'success'));
	}
	
	if($data[0] == 18)
	{
	
		date_default_timezone_set('America/New_York');
		setlocale(LC_MONETARY, 'en_US');
	
		$utilites = new CustomerUtilites($data[2],-1);
		
		$result = $utilites->getTransactionOfAccount($data[1]);
		
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
				//$path = str_replace('http://localhost/SBH/','../',$path);
				$path = "../" . $path;
				
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
		
		echo json_encode(array('result' => 'success', 'html' => $htmlres));
	}
	
	if($data[0] == 19)
	{
	
		$utilites = new CustomerUtilites($data[2],-1);
		
		$itemsleft = $utilites->getItemsLeft($data[1]);
		
		echo json_encode(array('result' => 'success', 'num' => $itemsleft));
		
		
	}
	


?>