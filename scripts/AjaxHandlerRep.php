<?php

/*
ACTION CODES

0 = CREATE ADVERTISEMENT
1 = CHECK USER NAME
2 = CHECK EMAIL
3 = CREATE CUSTOMER
4 = EDIT CUSTOMER
5 = DELETE CUSTOMER
6 = DELETE ADVERTISEMENT
7 = GET CUSTOMER RECORD
8 = GET CUSTOMER TRANSACTIONS
9 = GET CUSTOMER SUGGESTIONS
10 = SUGGEST ITEM
11 = UNSUGGEST ITEM


*/


include_once ("RepUtilites.php");

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


	$con = DBcon::getDBcon();
	$mysqli = $con->getMysqliObject();
	

	$utilites = new RepUtilites($_POST['uid']);

	if($_POST['action'] == 0)
	{
		$target_dir = "../assets/img/uploads/avs/";
		$target_file = $target_dir . basename($_FILES["img"]["name"]);
		move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);
		
		$flocation = "assets/img/uploads/avs/". basename($_FILES["img"]["name"]);
		
		$utilites->createAdvertisement($_POST['name'],$_POST['company'],$flocation,$_POST['description'],$_POST['price'],$_POST['units'],$_POST['itemtype']);
	
		echo json_encode(array('result' => 'success'));
	}
	
	if($_POST['action'] == 1)
	{
		$result = $utilites->checkUniqueUsername($_POST['username']);
		
		echo json_encode(array('result' => 'success', 'count' => $result));
	}
	
	if($_POST['action'] == 2)
	{
		$result = $utilites->checkUniqueEmail($_POST['email']);
		
		echo json_encode(array('result' => 'success', 'count' => $result));
	}
	
	if($_POST['action'] == 3)
	{
		$result = $utilites->createCustomer($_POST['firstname'],$_POST['lastname'],$_POST['email'],$_POST['username'],$_POST['password'],$_POST['gender'],$_POST['birthdate'],$_POST['address'],$_POST['city'],$_POST['state'],$_POST['zip'],$_POST['phone']);
	
		echo json_encode(array('result' => 'success'));
	
	}
	
	if($_POST['action'] == 4)
	{
		$result = $utilites->editCustomer($_POST['firstname'],$_POST['lastname'],$_POST['email'],$_POST['username'],$_POST['password'],$_POST['gender'],$_POST['birthdate'],$_POST['address'],$_POST['city'],$_POST['state'],$_POST['zip'],$_POST['phone'],$_POST['idcustomer']);
	
		echo json_encode(array('result' => 'success'));
	
	}
	
	if($_POST['action'] == 5)
	{
		$result = $utilites->deleteCustomer($_POST['idcustomer']);
		
		echo json_encode(array('result' => 'success'));
	}
	
	if($_POST['action'] == 6)
	{
		$result = $utilites->deleteAdvertisement($_POST['idadvertisement']);
		
		echo json_encode(array('result' => 'success'));
	}
	
	if($_POST['action'] == 7)
	{
		$result = $utilites->getCustomerRecord($_POST['idcustomer']);
		
		echo json_encode(array('result' => 'success', 'data' => $result));
	}
	
	if($_POST['action'] == 8)
	{

	
		date_default_timezone_set('America/New_York');
		setlocale(LC_MONETARY, 'en_US');
	
		
		$result = $utilites->getTransactionOfCustomer($_POST['idcustomer']);
		
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
	
	if($_POST['action'] == 9)
	{
		$result = $utilites->getCustomerSuggestions($_POST['idcustomer']);
		
		$sugtable = '<table class="table table-striped table-hover">
              <thead>
                <tr>
				  <th>Thumbnail</th>
				  <th>Item Name</th>				  
				  <th>Company</th>
				  <th>Price</th>
				  <th>Suggested By</th>
                </tr>
              </thead>
              <tbody>';
		//$sugselect = '<form id = "addsuggform">';	  
		//$sugselect .= '<select id = "suggestitemselect" class="chosen-select"  tabindex = "4">';
		$sugselect = '<option  value="" disabled>Suggest an Item</option>';
		
		//$sugdelete = '<form id = "removesuggform">';
		//$sugdelete .= '<select id = "desuggestitemselect" class="chosen-select" >';
		$sugdelete = '<option  value="" disabled>De-Suggest an Item</option>';
		
		while($row = $result->fetch_assoc())
		{
			$advertisementrow = $utilites->getAdvertisementRow($row['advfkey']);
			$reprow = $utilites->getRepRow($row['rep_idrep']);
			
			$name = $reprow['firstname'];
			$name .= " ";
			$name .= $reprow['lastname'];
			
			if($reprow['idcustomerrep'] == $_POST['uid'])
				$name = "You";
			
			
			$path = $advertisementrow['imgloc'];
				$path = "../" . $path;
				
				$im = file_get_contents($path);
				$imdata = base64_encode($im);    
				
				
				
				$cost = $advertisementrow['unitprice'];
				
				
				$formatter = new \NumberFormatter('en_US',  \NumberFormatter::CURRENCY);
				$cost =  $formatter->formatCurrency($cost, 'USD') . PHP_EOL;
				
				
		
			  $sugtable .= '<tr>
			  <td><img class="media-object" alt="90x90" src="data:image/png;base64,'.$imdata.'" style="width: 120px; height: 90px;"></td>
			  <td>'.$advertisementrow['itemname'].'</td>
			  <td>'.$advertisementrow['company'].'</td>
			  <td>'.$cost.'</td>
			  <td>'.$name.'</td>
			  </tr>';
			  
			  if($_POST['uid'] == $reprow['idcustomerrep'])
			  {
			  $sugdelete .= '<option  value="'.$row['advfkey'].'" >'.$advertisementrow['itemname'].'</option>';
			  }
		}
		
		$result2 = $utilites->getSuggestableItems($_POST['idcustomer']);
		
		while($row2 = $result2->fetch_assoc())
		{
			
			$sugselect .= '<option  value="'.$row2['idadvertisement'].'" >'.$row2['itemname'].'</option>';
			
		}
		
		$sugtable .= '</tbody> </table>';
		
		//$sugselect .= '</select><br>';
		//$sugselect .= '<button class = "btn btn-primary" type = "submit">Submit</button></form>';
		
		//$sugdelete .= '</select><br>';
		//$sugdelete .= '<button class = "btn btn-primary" type = "submit">Submit</button></form>';
		
		echo json_encode(array('result' => 'success', 'sugtable' => $sugtable, 'sugselect' => $sugselect, 'sugdelete' => $sugdelete));
	
	}
	
	if($_POST['action'] == 10)
	{
		$result = $utilites->suggestItem($_POST['idcustomer'],$_POST['advkey'],$_POST['uid']);
		
		echo json_encode(array('result' => 'success'));
	}
	
	if($_POST['action'] == 11)
	{
		$result = $utilites->removeSuggestItem($_POST['idcustomer'],$_POST['advkey']);
		
		echo json_encode(array('result' => 'success'));
	}
	
	
	
	


?>