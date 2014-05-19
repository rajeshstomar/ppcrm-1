<?php session_start();
require('includes/script_top.php');

if(isset($_SESSION['isadmin']))
{
	require(am_get_current_template().'comman/popup_layout.php');
}
else
{
	require(am_get_current_template().'login.php');
}

?>
