<?php
if($_POST['mode'] == "Active" || $_POST['mode'] == "Inactive")
{
    //my_print_r($_POST);exit;
	$ids =  @implode(",",$_POST['chk']);
	if($ids != "")
	{
		$sql = "update ".$tablename." set status='".$_POST['mode']."' where ".$primaryid." in (".$ids.") "; 
		am_query($sql);
		$msg = "Record(s) status changed Successfully";
		am_goto_page($alllink."&msg=".$msg);
	}
}
?>