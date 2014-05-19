<?php
//include("../dbconfig.php");


	 //$date=date('d/m/Y');

	if($_POST['mode'] == "Add")
	{
 		$date=$_POST['date'];
		$date1=$_POST['date'];
 	}
	else
	{
		$date=$_POST['firm_created_date'];
		$date1=$_POST['date'];	
	}	

	 
	// print_R($_POST);exit;
	 
	
	//print_R($_FILES['firm_scan']);exit;
	
	$image=imageupload(DIR_SCRIPT_ROOT.'firm_images/',$_FILES['firm_scan']['tmp_name'],$_FILES['firm_scan']['name'],"");
	//print_R($image);exit;

	if($mode == "Add")
	{	
		
		 $image = $_FILES['firm_scan']['name'];
		if($image != "")
			{
				$image=imageupload(DIR_SCRIPT_ROOT.'firm_images/',$_FILES['firm_scan']['tmp_name'],$image,"");
				$data['firm_scan']=$image[0];
	
			}
	
	}
	else
	{
		$image = $_FILES['firm_scan']['name'];
		
		 $old_image = $_POST['old_logo'];
		
		if($image != "")
		{
			 
			if($old_image != "")
			{
				unlink(DIR_SCRIPT_ROOT.'firm_images/'.$old_image);
			}
			 $image=imageupload(DIR_SCRIPT_ROOT.'firm_images/',$_FILES['firm_scan']['tmp_name'],$image,"");
			 
			  $image=$image[0];
			 
		}
		else
		{
			 $image= $old_image;
		}
	}

	$firm_no_array=explode('FN',$_POST['form_no']);
	
			
    	$firm_no=$firm_no_array[1];	
    	//echo $firm_no;exit;

	$data = array('date' => $_POST['date'],
			'form_no' => $firm_no,
			'place' => $_POST['place'],
			'company_name' => $_POST['company_name'],
			'nature_company' => $_POST['nature_company'],
			'country' => $_POST['country'],
			'state' => $_POST['state'],
			'near_buil_id' => $_POST['near_buil_id'],
			'add_line1' => $_POST['add_line1'],
			'add_line2_1' => $_POST['add_line2_1'],
			'add_line2_2' => $_POST['add_line2_2'],
			'add_line3' => $_POST['add_line3'],
			'city' => $_POST['city'],
			'pin_code' => $_POST['pin_code'],
			'company_logo' => $image,
			'no_of_years' => $_POST['no_of_years'],
			'operation_id'=> $_POST['operation_id'],
			'specialization' => $_POST['specialization'],
			'mobile_no' => $_POST['mobile'],
			'office_no' => $_POST['office'],
			'firm_created_date' => $date,
			'firm_updated_date' => $date1
			
			);
	
	$data1 = array('operation_area' => $_POST['operation']);
	
	
	
	
			
	//print_R($data);
	//print_R($data1);exit;
	
	//	exit;	
			

if($_REQUEST['mode'] == "Save")
{	
	am_insertupdate($data1,'operation','operation_id',$_POST['operation_id']);
	
	am_insertupdate($data,'broker_firm','company_id',$_POST['company_id']);
	$msg = "Record Updated Successfully on this date ".$_POST['date'];
	am_goto_page("index.php?rel=edit_company&id=".$_POST['company_id']."&msg=".$msg);
}
else if($_REQUEST['mode'] == "Add")
{	
	am_insertupdate($data1,'operation');
	$operation_id=mysql_insert_id();
	
	$data['operation_id'] = $operation_id;
	//print_R($data);exit;
	am_insertupdate($data,'broker_firm');
	$firm_id=mysql_insert_id();
	$msg = "Firm Added Successfully on this date ".$_POST['date'];
	//am_goto_page("index.php?rel=common_listing&module=company&msg=".$msg);
	am_goto_page("index.php?rel=edit_company&mode=view&id=".$firm_id."&msg=".$msg);
}
?>
