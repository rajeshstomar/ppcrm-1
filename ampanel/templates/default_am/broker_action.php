<?php
//include("../dbconfig.php");

	print_R($_POST);exit;


	$data = array('date' => $_POST['rdate'],
			'time' => $_POST['rtime'],
			'no_of_person' => $_POST['person']);

if($_REQUEST['mode'] == "Update")
{	
	am_insertupdate($data,'reservation','resid',$_POST['resid']);
	$msg = "Record Updated Successfully!";
	am_goto_page("index.php?rel=edit_reservation&id=".$_POST['resid']."&msg=".$msg);
}
else if($_REQUEST['mode'] == "Add")
{	
	am_insertupdate($data,'reservation');
	$msg = "Record Added Successfully!";
	am_goto_page("index.php?rel=common_listing&module=reservation&msg=".$msg);
}
?>
