<?php
$prop_id = $_REQUEST['prop_id'];
//echo $prop_id; exit;
/*$sql = "SELECT `broker_property_id`, `broker_owner_id`, `date`, `form_no`, `pan_or_mobile`, `property_main_type`, `onerk`, `specify_area`, `scaleble`, `carpet`, `office`, `furnished`, `warm_cell`, `price`, `trans_type`, `type`, `near_building_id`, `floor`, `add_line1`, `add_line2`, `add_line3`, `city`, `zip_code`, `state_id`, `country`, `property_created_date`, `flag` FROM `property_requirement` WHERE `broker_property_id`=".$prop_id;
$prop_data = am_select($sql);
*/
$flag = "SELECT flag,broker_owner_id FROM property_requirement WHERE broker_property_id=".$prop_id;
$flag_res = am_select($flag);

$match_cust = "SELECT cd.f_name,cd.l_name,cd.mobile_no,cd.email1,sl.*,pr.flag,cp.* FROM short_listed_prop as sl LEFT JOIN property_requirement as pr ON pr.broker_property_id = sl.property_listing_id LEFT JOIN client_property as cp ON cp.property_id = sl.client_req_prop_id LEFT JOIN client_personal_details as cd ON cd.client_id = sl.customer_id  WHERE active=1 AND property_listing_id=".$prop_id;
$match_data = am_select($match_cust);
//print_r($match_data); exit;

if(count($match_data) == 0)
{
	echo "<h4>No one is interested in this property</h4>";
}
else
{
	if($flag_res[0]['flag'] == 'owner')
	{
		$link = "index.php?&rel=view_owner_property&id=".$prop_id."&owner_id=".$flag_res[0]['broker_owner_id'];
	}
	else
	{
		$link = "index.php?&rel=view_interaction_report&id=".$prop_id;
	}
?>
<div align="center" style="width:80%; margin-bottom:5px;"><font color="#FF0000"><?php print $msg; ?></font></div>
<table class="black11" style="text-align: left;">
		<tr><th colspan="4"><a href="<?php echo $link; ?>"><h3>View Property Listing Details:&nbsp;&nbsp;</th></h3></a></tr>
</table>
<?php
	for($i=0;$i<count($match_data);$i++)
	{
?>

<table class="black11" width="100%">
<tr>
	<td>
		<div class="prop_match">
			<div class="pro_left" style="width:100%;">
				<p><b><?php echo  $i+1;  ?>)</b></p>
				<p><b><u>Customer Details:</u></b></p>
				<p><b>Name:</b> &nbsp;&nbsp;<?php echo  $match_data[$i]['f_name']." ".$match_data[$i]['l_name'];  ?></p>
				<p><b>Email:</b> &nbsp;&nbsp;<?php echo  $match_data[$i]['email1'];?>&nbsp;&nbsp;&nbsp;&nbsp;<b>Mobile:</b> &nbsp;&nbsp;<?php echo  $match_data[$i]['mobile_no'];?></p>
				<p><b><u>Required Property Details:</u></b></p>
				<p><b>Propert Type:</b> &nbsp;&nbsp;<?php echo  ucfirst($match_data[$i]['property_type']);?></p>
				<p><b>Created Data:</b> &nbsp;&nbsp;<?php echo  $match_data[$i]['client_pro_created_date'];?></p>
				
			</div>
<!--			<div class="pro_right">
				<input value="View Detail" name="viewdetail" id="viewdetail" onclick="javascript:window.open('<?php echo $view_link; ?>','_blank');" type="button">
			</div>
-->
		</div>	
	</td>
</tr>
</table>
<? } 
}

?>

