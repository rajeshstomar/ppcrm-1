<?php
//include("../dbconfig.php");
	$data = array('admin_email' => $_POST['admin_email'],
			'from_email' => $_POST['from_email'],
			'contact_email' => $_POST['contact_email'],
			'contact_phone' => $_POST['contact_phone'],
			'contact_address' => $_POST['contact_address'],
			'meta_title' => $_POST['meta_title'],
			'meta_keyword' => $_POST['meta_keyword'],
			'meta_description' => $_POST['meta_description'],
			'meta_title' => $_POST['meta_title'],
			'consumer_text' => $_POST['consumer_text'],
			'business_text' => $_POST['business_text'],
			'charity_text'=> $_POST['charity_text']
			);
if($_REQUEST['mode'] == "Update")
{	
	$sql = "update admin_settings set ";
	foreach ($data as $key => $value)
	{		
		$sql .= $key."='".$value."',";
	}
	$sql = substr($sql,0,-1);
	am_query($sql);
//	$sql .= " where ".$pid." = '".$id."' ";
	$msg = "Record Updated Successfully!";
	am_goto_page("index.php?rel=settings&msg=".$msg);
}

?>
