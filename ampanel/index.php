<?php 
$errorlevel=error_reporting();
error_reporting($errorlevel & ~E_NOTICE);
session_start();
require('includes/script_top.php');

if(isset($_SESSION['isadmin']))
{
	require(am_get_current_template().'comman/main_layout.php');
}
else
{
	require(am_get_current_template().'login.php');
}
?>