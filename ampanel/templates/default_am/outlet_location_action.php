<?php
//include("../dbconfig.php");
	
	//print_R($_POST);exit;
	
	
	
	
	$data = array(
			'location_name' => $_POST['l_name'],
			
			);
			
	
			
		//print_R($data);	

if($_REQUEST['mode'] == "Update")
{	
	
	am_insertupdate($data,'outlat_loacation','out_loc_id',$_POST['location_id']);
	
	$msg = "Record Updated Successfully!";
	am_goto_page("index.php?rel=edit_outlet_location&id=".$_POST['location_id']."&msg=".$msg);
}
else if($_REQUEST['mode'] == "Add")
{	
	am_insertupdate($data,'outlat_loacation');
	$client_id=mysql_insert_id();
	$msg = "Record Added Successfully!";
	am_goto_page("index.php?rel=common_listing&module=outlet_location&msg=".$msg);
}
?>
