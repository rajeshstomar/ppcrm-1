<?php
//include("../dbconfig.php");

	//print_R($_POST);exit;	
	
	
	
	if($_POST['user_type']=='admin')
	{
		$level=1;
	}
	else if($_POST['user_type']=='manager')
	{
		$level=2;
	}
	else if($_POST['user_type']=='executive')
	{
		$level=3;
	}
	else
	{
		$level=4;
	}
	
	
	$data = array(
			'admin_f_name' => $_POST['user_f_name'],
			'admin_l_name' => $_POST['user_l_name'],
			'admin_name' => $_POST['user_name'],
			'admin_email' => $_POST['user_email'],
			'admin_pass' => md5($_POST['user_password']),
			'admin_level' => $level,
			
			'role' => $_POST['user_type'],
			);

	$c_date = date('Y-m-d H:i:s');
	if($_POST['mode']=="Add")
	{
		$data['admin_last_login_date']=$c_date;
		$data['admin_create_date']=$c_date;
	}
	if($_POST['mode']=="Update")
	{
		$data['admin_last_login_date']=$c_date;
	}
	 	
	//print_R($data);exit;

if($_REQUEST['mode'] == "Update")
{	
	
	
	am_insertupdate($data,'admin','admin_id',$_POST['admin_id']);
	$msg = "User Updated Successfully!";
	am_goto_page("index.php?rel=edit_user_management&id=".$_POST['admin_id']."&msg=".$msg);
}
else if($_REQUEST['mode'] == "Add")
{	
	am_insertupdate($data,'admin');
	$msg = "User Added Successfully!";
	am_goto_page("index.php?rel=common_listing&module=user_management&msg=".$msg);
	
}
?>
