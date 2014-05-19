<?php
//include("../dbconfig.php");
	
	//print_R($_POST);exit;
	
	$image=imageupload(DIR_SCRIPT_ROOT.'customer_images/',$_FILES['cust_form']['tmp_name'],$_FILES['cust_form']['name'],"");
	//print_R($image);exit;

	if($mode == "Add")
	{	
		
		 $image = $_FILES['cust_form']['name'];
		if($image != "")
			{
				$image=imageupload(DIR_SCRIPT_ROOT.'customer_images/',$_FILES['cust_form']['tmp_name'],$image,"");
				$data['cust_form']=$image[0];
	
			}
	
	}
	else
	{
		$image = $_FILES['cust_form']['name'];
		
		 $old_image = $_POST['old_logo'];
		
		if($image != "")
		{
			 
			if($old_image != "")
			{
				unlink(DIR_SCRIPT_ROOT.'customer_images/'.$old_image);
			}
			 $image=imageupload(DIR_SCRIPT_ROOT.'customer_images/',$_FILES['cust_form']['tmp_name'],$image,"");
			 
			  $image=$image[0];
			 
		}
		else
		{
			 $image= $old_image;
		}
	}
	
	
	// $date=date('d/m/Y');
	
	if($_POST['mode'] == "Add")
	{
 		$date=$_POST['date'];
		$date1=$_POST['date'];
 	}
	else
	{
		$date=$_POST['client_created_date'];
		$date1=$_POST['date'];	
	}

	$data = array(
			'date' => $_POST['date'],
			'place' => $_POST['place'],
			'f_name' => $_POST['f_name'],
			'l_name' => $_POST['l_name'],
			'country' => $_POST['own_country'],
			'state' => $_POST['own_state'],
			'add_line1' => $_POST['own_add_line1'],
			'add_line2' => $_POST['own_add_line2'],
			'add_line3' => $_POST['own_add_line3'],
			'zip_code' => $_POST['own_zip_code'],
			'city' => $_POST['own_city'],
			'mobile_no' => $_POST['mobile'],
			'office_no' => $_POST['office'],
			'email1' => $_POST['email1'],
			'email2' => $_POST['email2'],
			
			'internet' => $_POST['internet'],
			//'newspaper' => $_POST['newspaper'],
			//'friends' => $_POST['friends'],
			//'other' => $_POST['other'],
			
			'calls_noti' => $_POST['calls'],
			'sms_noti' => $_POST['sms'],
			'email_noti' => $_POST['email'],
			'term_agree' => $_POST['term_con'],
			'trans_time' => $_POST['trans_time'],
			'client_cat' => $_POST['client_cat'],
			'cust_form' => $image,
			'remark' => $_POST['remark'],
			//'flag' => 'owner',
			'client_created_date' => $date,
			'client_updated_date' => $date1,
			'executive_id' => $executive_id
			);
				
	//print_R($data);exit;	

	if($_POST['price_type1']!="")
	{
		 $price1=get_price_encrypt($_POST['price_type1'],$_POST['price1']);
		
	}
	if($_POST['price_type2']!="")
	{
		
		
		 $price2=get_price_encrypt($_POST['price_type2'],$_POST['price2']);
	}
	
	$final_price=$price1+$price2;
	
	
	
	$data1 = array('broker_owner_id' => $_POST['bro_own_id'],
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
	
	
			
		//print_R($data);
		//print_R($data1);exit;      

if($_REQUEST['mode'] == "Update")
{	
	
	am_insertupdate($data,'client_personal_details','client_id',$_POST['client_id']);
	
	$msg = "Record Updated Successfully on this date ".$_POST['date'];
	am_goto_page("index.php?rel=edit_owner&id=".$_POST['client_id']."&msg=".$msg);
}
else if($_REQUEST['mode'] == "Add")
{	
	am_insertupdate($data,'client_personal_details');
	$client_id=mysql_insert_id();
	$data1['broker_owner_id'] = $client_id;
	am_insertupdate($data1,'property_requirement');
	$msg = "Record Added Successfully on this date ".$_POST['date'];
	am_goto_page("index.php?rel=view_owner&id=".$client_id."&msg=".$msg);
}
?>
