<?php
//include("../dbconfig.php");

	
	//print_R($_POST);

	
	if($_POST['mode'] == "Save")
	{
 		$date=$_POST['date'];
		$date1=$_POST['date'];
 	}
	else
	{
		$date=$_POST['created_date'];
		$date1=$_POST['date'];	
	}		
	
 	$firm_no_array=explode('SV',$_POST['form_no']);
	
			
    	$firm_no=$firm_no_array[1];	
 	
 	
	$data = array('report_date' => $_POST['date'],
			'form_no' => $firm_no,
			'client_name' => $_POST['client_name'],
			'client_id' => $_POST['client_id'],
			'broker_id' => $_POST['bro_own_id'],
			'property_id' => $_POST['listing_id'],
			'executive' => $_POST['executive'],
			'property_type' => $_POST['property_type'],
			'near_buil_id' => $_POST['nearest_building'],
			'floor' => $_POST['floor1'],
			'near_landmark' => $_POST['near_landmark'],
			'area' => $_POST['area'],
			'city' => $_POST['city'],
			'client_comment' => $_POST['client_comment'],
			'service_property_pistol' => $_POST['service_property_pistol'],
			'professionalism_broker' => $_POST['professionalism_broker'],
			'professionalism' => $_POST['professionalism'],
			'executive_comment' => $_POST['executive_comment'],
			'calls_noti' => $_POST['calls_noti'],
			'sms_noti' => $_POST['sms_noti'],
			'email_noti' => $_POST['email_noti'],
			'created_date' => $date,
			'updated_date' => $date1
			);
	//print_R($data);exit;


if($_REQUEST['mode'] == "Update")
{	
	am_insertupdate($data,'site_visit_report','visit_id',$_POST['visit_id']);
	$msg = "Record Updated Successfully on this date ".$_POST['date'];
	am_goto_page("index.php?rel=edit_site_visit_report&id=".$_POST['visit_id']."&msg=".$msg);
}
else if($_REQUEST['mode'] == "Save")
{	
	am_insertupdate($data,'site_visit_report');
	$msg = "Record Saved Successfully on this date ".$_POST['date'];
	am_goto_page("index.php?rel=common_listing&module=site_visit_report&msg=".$msg);
}
?>
