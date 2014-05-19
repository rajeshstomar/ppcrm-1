<?php
$client_req_prop_id = $_REQUEST['client_req_prop_id'];
$customer_id = $_REQUEST['customer_id'];
$cust = "SELECT client_id, f_name, l_name FROM client_personal_details WHERE client_id=".$customer_id." LIMIT 0,1";
$cust_data = am_select($cust);
$client_name = $cust_data[0]['f_name']." ".$cust_data[0]['l_name'];


$match_query = "SELECT bd.id_building,bd.b_name,sl.*,pr.* FROM short_listed_prop as sl LEFT JOIN property_requirement as pr ON sl.property_listing_id=pr.broker_property_id LEFT JOIN building_database as bd ON bd.id_building = pr.near_building_id WHERE sl.active=1 AND sl.customer_id=".$customer_id." AND client_req_prop_id=".$client_req_prop_id." GROUP BY property_listing_id ";

$match_res = am_select($match_query);
//print_R($match_res); exit;

if(count($match_res) == 0)
{
	echo "<h4>No Matching found for this requirement</h4>";
}
else
{
?>
<div align="center" style="width:80%; margin-bottom:5px;"><font color="#FF0000">Short Listed Property For Customer # <?php echo $cust_data[0]['client_id']; ?> - <?php echo $client_name; ?></font></div>
<?php include("customer_detail.php");?>
<!--<form name="short_list" id="short_list" action="" method="post">
<input type="submit" name="submit_upper" value="Shortlist">
<input type="hidden" name="customer_id" value="<?php echo $customer_id;?>">
<input type="hidden" name="executive_id" value="9">-->
<?php
	for($i=0;$i<count($match_res);$i++)
	{
		if($match_res[$i]['flag'] == 'owner')
			$view_link = 'index.php?&rel=view_owner_property&id='.$match_res[$i]['broker_property_id'].'&owner_id='.$match_res[$i]['broker_owner_id'];
		else
			$view_link = 'index.php?&rel=view_interaction_report&id='.$match_res[$i]['broker_property_id'].'&mode=read';

		$types = array();
		if($match_res[$i]['property_main_type'] == 'residential')
		{
			if($match_res[$i]['onerk'] == 1)
				$types[] = "1 RK";
			if($match_res[$i]['onebhk'] == 1)
				$types[] = "1 BHK";
			if($match_res[$i]['twobhk'] == 1)
				$types[] = "2 BHK";
			if($match_res[$i]['threebhk'] == 1)
				$types[] = "3 BHK";
			if($prop_res[$i]['fourbhk'] == 1)
				$types[] = "4+ BHK";
		}
		$type = implode(", ",$types);
		//print_R($match_res[$i]); exit;
?>
<table>
<tr>
	<!--<td>
		<input type="checkbox" name="prop_id[]" value="<?php echo $match_res[$i]['broker_property_id'];?>" <?php if(in_array($match_res[$i]['broker_property_id'], $selected_prop)){?>checked<?php } ?>>
	</td>-->
	<td>
		<div class="prop_match">
			<div class="pro_left">
				<p><b><?php echo  $i+1;  ?>)</b></p>
				<p><b>Nearest Building:</b> &nbsp;&nbsp;<?php echo  $match_res[$i]['b_name'];  ?> </p>
				<p><b>Property Location :</b> &nbsp;&nbsp;<?php echo  $match_res[$i]['floor'].", ".$match_res[$i]['add_line1'].", ".$match_res[$i]['add_line2'].", ".$match_res[$i]['add_line3'].", ".$match_res[$i]['city'];  ?> </p>
				<p><b>Property type:</b>&nbsp;&nbsp; <?php echo ucfirst($match_res[$i]['property_main_type']); ?>&nbsp;&nbsp;&nbsp;&nbsp;<b>Approximate Area :</b>&nbsp;&nbsp;<?php echo  $match_res[$i]['scaleble']; ?> Sq.Ft.&nbsp;&nbsp;&nbsp;&nbsp;</p>
				<p><b>Price :</b>&nbsp;&nbsp;<?php echo  $match_res[$i]['price']; ?></p>
				<?php if(!empty($types)) { ?>
				<p><b>Types:</b>&nbsp;&nbsp; <?php echo $type; ?></p>
				<? } ?>
			</div>
			<div class="pro_right">
				<input value="View Detail" name="viewdetail" id="viewdetail" onclick="javascript:window.open('<?php echo $view_link; ?>','_blank');" type="button">
			</div>
		</div>	
	</td>
</tr>
</table>
<?php
	}
}
?>
<!--<input type="submit" name="submit_lower" value="Shortlist">-->
</form>
