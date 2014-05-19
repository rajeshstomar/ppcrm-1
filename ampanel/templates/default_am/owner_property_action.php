<?php
//include("../dbconfig.php");

	
	//print_R($_POST); exit;
	
	
	/*if($_POST['price_type']=='thousand')
	{
		$price=$_POST['price'].'000';
	}
	else if($_POST['price_type']=='laks')
	{
		$price=$_POST['price'].'00000';	
	}
	else if($_POST['price_type']=='crores')
	{
		$price=$_POST['price'].'0000000';	
	} */
	
	
	if($_POST['price_type1']!="")
	{
		 $price1=get_price_encrypt($_POST['price_type1'],$_POST['price1']);
		
	}
	if($_POST['price_type2']!="")
	{
		
		
		 $price2=get_price_encrypt($_POST['price_type2'],$_POST['price2']);
	}
	
	$final_price=$price1+$price2;
	
	
	$date=date('d/m/Y');

	$data = array('broker_owner_id' => $_POST['bro_own_id'],
		      'date' => $_POST['date'],
		      'form_no' => $_POST['form_no'],	
		      'pan_or_mobile' => $_POST['pan_mob_no'],
		      'property_main_type' => $_POST['residential'],
		     	'onerk' => $_POST['1rk'],
			/*'onebhk' => $_POST['1bhk'],
			'twobhk' => $_POST['2bhk'],
			'threebhk' => $_POST['3bhk'],
			'fourbhk' => $_POST['4bhk+'],*/
		      'specify_area' => $_POST['specify_area'],
		      'scaleble' => $_POST['scaleble'],
		      'carpet' => $_POST['carpet'],
		     'office' => $_POST['office_check'],
		      'furnished' => $_POST['furnished'],
		      'warm_cell' => $_POST['warm_cell'],
		      'price' => $final_price,
		      'trans_type' => $_POST['transaction'],
		      'type' => $_POST['type_owner'],
		      'near_building_id' => $_POST['near_buil_id'],
		      'floor' => $_POST['floor1'],
		      'add_line1' => $_POST['add_line1'],
		      'add_line2' => $_POST['add_line2'],
		      'add_line3' => $_POST['add_line3'],
		        'landmark' => $_POST['landmark'],
		      'city' => $_POST['city'],
		      'zip_code' => $_POST['zip_code'],
		      'state_id' => $_POST['state'],
		      'country' => $_POST['country'],
		      'property_created_date' => $date,
		      'flag' => 'owner');
		      
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
	//print_R($data);exit;
	am_insertupdate($data,'property_requirement','broker_property_id',$_POST['broker_property_id']);
	$msg = "Broker Property Updated Successfully!";
	am_goto_page("index.php?rel=edit_owner_property&id=".$_POST['broker_property_id']."&owner_id=".$_POST['bro_own_id']."&msg=".$msg);
}
else if($_REQUEST['mode'] == "Add")
{	
	am_insertupdate($data,'property_requirement');
	$msg = "Owner Property Added Successfully!";
	if($_POST['addmore']=='Add More Property')
	{
	am_goto_page("index.php?rel=edit_owner_property&owner_id=".$_POST['bro_own_id']."&msg=".$msg);
	}
	else
	{
	am_goto_page("index.php?rel=common_listing&module=owner_property&customer_id=".$_POST['bro_own_id']."&msg=".$msg);
	}
}
?>

