<?php
//include("../dbconfig.php");
	
	//print_R($_POST);exit;
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


	if($_POST['min_price_type1']!="")
	{
		 $min_price1=get_price_encrypt($_POST['min_price_type1'],$_POST['min_price1']);
		
	}
	
	
	if($_POST['min_price_type2']!="")
	{
		
		
		 $min_price2=get_price_encrypt($_POST['min_price_type2'],$_POST['min_price2']);
	}
	
	
	 $final_min_price=$min_price1+$min_price2;
	//echo $final_min_price;exit;
	
	
	if($_POST['max_price_type1']!="")
	{
		$max_price1=get_price_encrypt($_POST['max_price_type1'],$_POST['max_price1']);
	}
	
	if($_POST['max_price_type2']!="")
	{
		$max_price2=get_price_encrypt($_POST['max_price_type2'],$_POST['max_price2']);
	}
	
	
	$final_max_price=$max_price1+$max_price2;
	//echo $final_max_price;exit;
	
	
	
	$date=date('d/m/Y');

	$address = trim($_POST['state'])."+".trim($_POST['city'])."+".trim($_POST['locality'])."+".str_replace(' ', '', $_POST['sector']);
	$latlongarray = get_latlong($address);
	$latitude = $latlongarray['latitude'];
	$longitude = $latlongarray['longitude'];
			
	$data1=	array('main_property_type' => $_POST['transaction_type'],
			'property_type' => $_POST['residential'],
			'onerk' => $_POST['1rk'],
			'onebhk' => $_POST['1bhk'],
			'twobhk' => $_POST['2bhk'],
			'threebhk' => $_POST['3bhk'],
			'fourbhk' => $_POST['4bhk+'],
			
			'specify_area' => $_POST['specify_area'],
			'scaleble' => $_POST['scaleble'],
			'carpet' => $_POST['carpet'],
			'office' => $_POST['office_check'],
			//'retail' => $_POST['retail'],
			'furnished' => $_POST['furnished'],
			//'unfurnished' => $_POST['unfurnished'],
			'warm_cell' => $_POST['warm_cell'],
			'state' 	=> $_POST['state'],
			'city' 	=> $_POST['city'],
			'locality' 	=> $_POST['locality'],
			'sector' 	=> $_POST['sector'],
			'near_building' 	=> $_POST['near_building'],
			'is_choice_flex' 	=> $_POST['is_choice_flex'],
			'flex_pref' 	=> $_POST['flex_pref'],
			'flex_distance' 	=> $_POST['flex_distance'],
			'latlong'		=> "POINT($latitude $longitude)",
			//'cold_cell' => $_POST['cold_cell'],
			'min_price' => $final_min_price,
			'max_price' => $final_max_price,
			'status' => $_POST['status'],
			'client_pro_created_date' => $date
			);
		
			
		//$area=$_POST['area1'].":".$_POST['area2'].":".$_POST['area3'].":".$_POST['area4'];
		//echo $area;exit;	
			
		
		
				
		//print_R($data2);exit;		
						

if($_REQUEST['mode'] == "Update")
{	
	//print_R($_POST);
	//echo $POST['client_id'];exit;
	//am_insertupdate($data,'client_personal_details','client_id',$_POST['client_id']);
	
	if($data1['property_type'] == 'commercial')
	{
		$data1['onerk'] = 0;
		$data1['onebhk'] = 0;
		$data1['twobhk'] = 0;
		$data1['threebhk'] = 0;
		$data1['fourbhk'] = 0;
		
		if( $data1['office'] == '1' )
		{
			$data1['warm_cell'] = 0;
		}
		if( $data1['office'] == '2' )
		{
			$data1['furnished'] = 0;
		}
	}
	if($data1['property_type'] == 'residential')
	{
		$data1['office'] = 0;
		$data1['warm_cell'] = 0;
	}
	
	
	am_insertupdate($data1,'client_property','property_id',$_POST['property_id']);
	
	//echo "delete * from client_area where property_area_id=".$_POST['property_id'];
	
	/*
	$sql="delete  from client_area where property_area_id=".$_POST['property_id'];
	mysql_query($sql);
	
	*/
	
	//am_insertupdate($data2,'client_area','area_id',$_POST['area_id']);
	
	
	for($i=0;$i<count($_POST['area']);$i++)
		{
			
			$data2=array('area_name' => $_POST['area'][$i],
				'area_created_date' => $date);	
			$data2['client_area_id'] = $_POST['customer_id'];
			$data2['property_area_id'] = $_POST['property_id'];
	
			am_insertupdate($data2,'client_area');	
		}
	
		
	$msg = "Record Updated Successfully!";
	am_goto_page("index.php?rel=edit_property&id=".$_POST['property_id']."&msg=".$msg);
}
else if($_REQUEST['mode'] == "Add")
{	
	
	//print_R($_POST);exit;
	
	
	$client_id=$_POST['customer_id'];
	$data1['client_property_id'] = $client_id;
	am_insertupdate($data1,'client_property_new');
	// var_dump($data1);
	//$property_id=mysql_insert_id();
	/*
	for($i=0;$i<count($_POST['area']);$i++)
		{
			
			$data2=array('area_name' => $_POST['area'][$i],
				'area_created_date' => $date);	
			$data2['client_area_id'] = $client_id;
			$data2['property_area_id'] = $property_id;
	
			am_insertupdate($data2,'client_area');	
		}
	
			
	
	$area_id=mysql_insert_id();
	 $data3['area_id'] = $area_id;
	am_insertupdate($data3,'client_property','property_id',$property_id);
	*/
	
	
	/*
	$msg = "Record Added Successfully!";
	am_goto_page("index.php?rel=common_listing&module=property&customer_id=".$client_id."&msg=".$msg);
	*/
}
?>
