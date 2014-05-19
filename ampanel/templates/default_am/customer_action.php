<?php
//include("../dbconfig.php");
	
	//print_R($_POST); exit;
	//print_R($_FILES['cust_form']);exit;
	//$_SESSION['property']=$_POST;
	
	
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
	
	if($_POST['mode'] =="Add")
	{
		$executive_id=$_SESSION['user_id'];	
	}
	else if($_POST['mode']=="Update")
	{
		$executive_id=$_POST['executive_id'];	
	}
	
	//echo $executive_id;exit;
	 //$date=date('Y-m-d');

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
			'country' => $_POST['country'],
			'state' => $_POST['state'],
			'add_line1' => $_POST['add_line1'],
			'add_line2' => $_POST['add_line2'],
			'add_line3' => $_POST['add_line3'],
			'zip_code' => $_POST['zip_code'],
			'city' => $_POST['city'],
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
			'executive_remark' => $_POST['executive_remark'],
			//'flag' => 'customer',
			'client_created_date' => $date,
			'client_updated_date' => $date1,
			'executive_id' => $executive_id
			);
	//print_R($data);exit;			
      
      
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
			//'cold_cell' => $_POST['cold_cell'],
			'min_price' => $final_min_price,
			'max_price' => $final_max_price,
			'status' => $_POST['status'],
			'client_pro_created_date' => $date
			);    
      
      
	
		
			

if($_REQUEST['mode'] == "Update")
{	

	am_insertupdate($data,'client_personal_details','client_id',$_POST['client_id']);
	$msg = "Record Updated Successfully on this date ".$_POST['date'];
	am_goto_page("index.php?rel=edit_customer&id=".$_POST['client_id']."&msg=".$msg);
}
else if($_REQUEST['mode'] == "Add")
{	
	am_insertupdate($data,'client_personal_details');
	$client_id=mysql_insert_id();
   //echo $client_id;exit;
  
  $data1['client_property_id'] = $client_id;
	am_insertupdate($data1,'client_property');
	$property_id=mysql_insert_id();
	
	for($i=0;$i<count($_POST['area']);$i++)
		{
			
			$data2=array('area_name' => $_POST['area'][$i],
				'area_created_date' => $date);	
			$data2['client_area_id'] = $client_id;
			$data2['property_area_id'] = $property_id;
			if($_POST['area'][$i] != '')
				am_insertupdate($data2,'client_area');	
		}
	
			
	/* Not Required */
	$area_id=mysql_insert_id();
	 $data3['area_id'] = $area_id;
	am_insertupdate($data3,'client_property','property_id',$property_id);
	/* Not Required */  
	$msg = "Record Added Successfully on this date ".$_POST['date'];
	am_goto_page("index.php?rel=view_customer&id=".$client_id."&msg=".$msg);
}
?>
