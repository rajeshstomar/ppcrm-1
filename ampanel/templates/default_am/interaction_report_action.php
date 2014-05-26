<?php
//include("../dbconfig.php");
	//print_R($_REQUEST);exit;
	
	function get_latlong($address){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=india");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($response); 
		$lat = $response->results[0]->geometry->location->lat;
		$long = $response->results[0]->geometry->location->lng;
		return array("latitude"=> $lat, "longitude"=> $long);
	}

	if($_POST['price_type1']!="")
	{
		 $price1=get_price_encrypt($_POST['price_type1'],$_POST['price1']);
		
	}
	if($_POST['price_type2']!="")
	{
		
		
		 $price2=get_price_encrypt($_POST['price_type2'],$_POST['price2']);
	}
	
	$final_price=$price1+$price2;
	
	if($_POST['user_type']=='owner')
	{
		$flage='owner';
	}
	else if($_POST['user_type']=='brokerdirect')
	{
		$flage='brokerdirect';	
	}
	else if($_POST['user_type']=='indirect')
	{
		$flage='indirect';	
	}
	
	//$date=date('d/m/Y');
	
	if($_POST['mode'] == "Add")
	{
 		$date=$_POST['date'];
		$date1=$_POST['date'];
 	}
	else
	{
		$date=$_POST['property_created_date'];
		$date1=$_POST['date'];	
	}


	$firm_no_array=explode('LR',$_POST['form_no']);
	
			
    	$firm_no=$firm_no_array[1];	

    $address = trim($_POST['state'])."+".str_replace(' ', '', $_POST['city'])."+".str_replace(' ', '', $_POST['locality'])."+".str_replace(' ', '', $_POST['sector']);
	echo $address;
	$latlongarray = get_latlong($address);
	$latitude = $latlongarray['latitude'];
	$longitude = $latlongarray['longitude'];

	$data = array(
			  'broker_owner_id' => $_POST['bro_own_id'],
		      'date' => $_POST['date'],
		      'form_no' => $_POST['form_no'],	
		      'pan_or_mobile' => $_POST['pan_mob_no'],
		      'property_main_type' => $_POST['residential'],
		      'onerk' => $_POST['bhk'],
			
		      'specify_area' => $_POST['specify_area'],
		      'scaleble' => $_POST['scaleble'],
		      'carpet' => $_POST['carpet'],
		      'office' => $_POST['office_check'],
		      //'retail' => $_POST['retail'],
		      'furnished' => $_POST['furnished'],
		     // 'unfurnished' => $_POST['unfurnished'],
		      'warm_cell' => $_POST['warm_cell'],
		     // 'cold_cell' => $_POST['cold_cell'],
		      'price' =>$final_price,
		      'trans_type' => $_POST['transaction'],
		      'type' => $_POST['user_type'],
		      'near_building_id' => $_POST['near_buil_id'],
		      'flat' => $_POST['flat'],
		      'nearest_road' => $_POST['nearest_road'],
		      'landmark'  => $_POST['landmark'],
		      'sector' => $_POST['sector'],
		      'locality' => $_POST['locality'],
		      'nearest_road' => $_POST['nearest_road'],
		      'city' => $_POST['city'],
		      'zip_code' => $_POST['zip_code'],

		      'state' => $_POST['state'],
		      'country' => $_POST['country'],
		      'property_created_date' => $date,
		      'property_updated_date' => $date1, 	
		      'flag' => $flage
		    );
			$latlong = "POINT($latitude $longitude)";
		      
		//print_R($data);exit;      
		      

if($_REQUEST['mode'] == "Update")
{	
	if($data['property_main_type'] == 'commercial')
	{
		$data['onerk'] = 0;
		/*$data['onebhk'] = 0;
		$data['twobhk'] = 0;
		$data['threebhk'] = 0;
		$data['fourbhk'] = 0;*/
		
		if( $data['office'] == '1' )
		{
			$data['warm_cell'] = 0;
		}
		if( $data['office'] == '2' )
		{
			$data['furnished'] = 0;
		}
	}
	if($data['property_main_type'] == 'residential')
	{
		$data['office'] = 0;
		$data['warm_cell'] = 0;
	}
	

	am_insertupdate($data,'property_requirement_new','broker_property_id',$_POST['broker_property_id'], $latlong);
	$msg = "Broker Property Updated Successfully on this date ".$_POST['date'];
	am_goto_page("index.php?rel=edit_interaction_report&id=".$_POST['broker_property_id']."&msg=".$msg);
}
else if($_REQUEST['mode'] == "Add")
{	
	am_insertupdate($data,'property_requirement_new', '', '', $latlong);
	$msg = "Broker Property Added Successfully on this date ".$_POST['date'];
	if($_POST['addmore']=='AddMoreProperty')
	{
	am_goto_page("index.php?rel=edit_interaction_report&owner_id=".$_POST['bro_own_id']."&owner_mobile_no=".$_POST['pan_mob_no']."&owner_type=".$_POST['user_type']."&msg=".$msg);
	}
	else
	{
	am_goto_page("index.php?rel=common_listing&module=interaction_report&msg=".$msg);
	}
}
?>

