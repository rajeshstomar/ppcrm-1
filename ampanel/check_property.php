<?php
require('includes/script_top.php');
//print_R($_REQUEST);
if($_REQUEST['price_type1']!="")
{
	$price1=get_price_encrypt($_REQUEST['price_type1'],$_REQUEST['price1']);
}
if($_REQUEST['price_type2']!="")
{
	$price2=get_price_encrypt($_REQUEST['price_type2'],$_REQUEST['price2']);
}
$final_price = $price1+$price2;

$sql = "SELECT * FROM property_requirement WHERE 1=1 ";

$ssql = '';
if($_REQUEST['bro_own_id'] != '')
{
	$ssql .= " AND broker_owner_id=".$_REQUEST['bro_own_id'];
}
if($_REQUEST['user_type'] != '')
{
	$ssql .= " AND flag='".$_REQUEST['user_type']."' ";
}
if($_REQUEST['residential'] != '')
{
	$ssql .= " AND property_main_type='".$_REQUEST['residential']."' ";
}
if($_REQUEST['1rk'] != '')
{
	$ssql .= " AND onerk='".$_REQUEST['1rk']."' ";
}
if($_REQUEST['scaleble'] != '')
{
	$ssql .= " AND scaleble='".$_REQUEST['scaleble']."' ";
}
if($_REQUEST['furnished'] != '')
{
	$ssql .= " AND furnished='".$_REQUEST['furnished']."' ";
}
if($_REQUEST['transaction'] != '')
{
	$ssql .= " AND trans_type='".$_REQUEST['transaction']."' ";
}
if($final_price != '')
{
	$ssql .= " AND price='".$final_price."' ";
}
if($_REQUEST['near_buil_id'] != '')
{
	$ssql .= " AND near_building_id='".$_REQUEST['near_buil_id']."' ";
}
if($_REQUEST['floor1'] != '')
{
	$ssql .= " AND floor='".$_REQUEST['floor1']."' ";
}
if($_REQUEST['zip_code'] != '')
{
	$ssql .= " AND zip_code='".$_REQUEST['zip_code']."' ";
}
if($_REQUEST['state'] != '')
{
	$ssql .= " AND state_id='".$_REQUEST['state']."' ";
}
if($_REQUEST['office_check'] != '')
{
	$ssql .= " AND office='".$_REQUEST['office_check']."' ";
}
if($_REQUEST['warm_cell'] != '')
{
	$ssql .= " AND warm_cell='".$_REQUEST['warm_cell']."' ";
}

$sql = $sql.$ssql;
//echo $sql;
$res = am_select($sql);
if(count($res)>0)
{
	echo "1";
}
else
{
	echo "0";
}
exit;
?>

