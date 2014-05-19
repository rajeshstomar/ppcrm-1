<?php
$property_id = $_REQUEST['propery_id'];
$customer_id = $_REQUEST['customer_id'];
$msg = $_GET['msg'];
$cust = "SELECT client_id, f_name, l_name FROM client_personal_details WHERE client_id=".$customer_id." LIMIT 0,1";
$cust_data = am_select($cust);
$client_name = $cust_data[0]['f_name']." ".$cust_data[0]['l_name'];

$ssql = '';
if($_SESSION['admin_level'] != 1)
	$ssql .= " AND pp_executive_id=".$_SESSION['user_id'];

$prop = "SELECT `id_shortlist`, `customer_id`, `property_listing_id`,`client_req_prop_id`, `pp_executive_id`, `next_call_date` FROM short_listed_prop WHERE active=1 AND customer_id =".$customer_id." AND client_req_prop_id=".$property_id." ".$ssql." GROUP BY property_listing_id ";
$short_prop_data = am_select($prop);
//print_R($short_prop_data); exit;

$selected_prop = array();
$short_ids = array();
for($j=0;$j<count($short_prop_data);$j++)
{
	$selected_prop[] = $short_prop_data[$j]['property_listing_id'];
	$short_ids[$short_prop_data[$j]['property_listing_id']] = $short_prop_data[$j]['id_shortlist'];
}
//print_R($short_ids); exit;
// Shotlist Property
if(isset($_POST['submit_upper']) || isset($_POST['submit_lower']))
{
	// DELETE old record
	//$del = "DELETE FROM short_listed_prop WHERE customer_id =".$customer_id." AND client_req_prop_id=".$property_id;
	//$del_res = am_query($del);
	// DELETE old record - Ends
	//print_R($_POST); exit;
	$values = array();
	$customer = $_POST['customer_id'];
	$pp_exec_id = $_SESSION['user_id'];
	$next_call_date = date('Y-m-d H:i:d');
	
	for($l=0; $l<count($_POST['all_prop']); $l++) 
	{
		//print_R($_POST['prop_id']); exit;
		
		$exists = "SELECT id_shortlist FROM short_listed_prop WHERE property_listing_id='".$_POST['all_prop'][$l]."' AND pp_executive_id ='".$pp_exec_id."' AND customer_id='".$customer."' AND client_req_prop_id='".$property_id."'";
		//echo $exists; exit;
		$exists_res = am_select($exists);
				
		if(count($exists_res) > 0) // update
		{
			$update_s = "UPDATE short_listed_prop set active = 0 WHERE id_shortlist=".$exists_res[0]['id_shortlist'];
			//echo $update_s; exit;
			$update_s_res = am_query($update_s);
		}

	}
	
	for($i=0; $i<count($_POST['prop_id']); $i++) 
	{
		//print_R($_POST['prop_id']); exit;
		
		$exist = "SELECT id_shortlist FROM short_listed_prop WHERE property_listing_id='".$_POST['prop_id'][$i]."' AND pp_executive_id ='".$pp_exec_id."' AND customer_id='".$customer."' AND client_req_prop_id='".$property_id."'";
		$exist_res = am_select($exist);
				
		if(count($exist_res) > 0) // update
		{
			$update = "UPDATE short_listed_prop set active = 1 WHERE id_shortlist=".$exist_res[0]['id_shortlist'];
			$update_res = am_query($update);
		}
		else
		{
			$values[] = '("'. $customer.'","'.$_POST['prop_id'][$i].'","'.$property_id.'","'.$pp_exec_id.'","'.$next_call_date.'","1")';
			
		}
	}
	
	if(!empty($values))
	{	
		$sql = "INSERT INTO `short_listed_prop`(`customer_id`, `property_listing_id`,`client_req_prop_id`,`pp_executive_id`, `next_call_date`,`active`) VALUES ".implode(",", $values );
		$res = am_query($sql);
	}
	//print_R($cust_data); exit;
	$msg = addslashes("Property Shortlisted Successfully for Customer - ".$customer." - ".$client_name);
	//echo $msg; exit;
	am_goto_page("index.php?rel=matching_property&customer_id=".$customer_id."&propery_id=".$property_id."&msg=".$msg);
	
}












// Shotlist Property - Ends
$sql = "SELECT cp.* FROM client_property as cp WHERE property_id = '".$property_id."' ";
$prop_res = am_select($sql);
//print_R($prop_res); exit;


$where = array();

$where[] = " property_main_type = '".$prop_res[0]['property_type']."' ";

$areas = "SELECT area_name,area_id FROM client_area WHERE property_area_id = '".$property_id."' ";
$area = am_select($areas);
$area_q = array();
for($k=0;$k<count($area);$k++)
{
	if($area[$k]['area_name'] !='')
		$area_q[] = " add_line3 LIKE '%".$area[$k]['area_name']."%' ";
}
if(!empty($area_q))
{
	$where[] = " ( ".implode(" OR",$area_q)." ) ";
}

if($prop_res[0]['property_type'] == 'residential')
{
	$bhk = array();
	if($prop_res[0]['onerk'] == 1)
		$bhk[] = " onerk = 1 ";
	if($prop_res[0]['onebhk'] == 1)
		$bhk[] = " onerk = 2 ";
	if($prop_res[0]['twobhk'] == 1)
		$bhk[] = " onerk = 3 ";
	if($prop_res[0]['threebhk'] == 1)
		$bhk[] = " onerk = 4 ";
	if($prop_res[0]['fourbhk'] == 1)
		$bhk[] = " onerk = 5 ";
}
if(!empty($bhk))
{
	$where[] = " ( ".implode(' OR',$bhk)." ) ";
}

if($prop_res[0]['main_property_type'] == 'rent')
{
	$where[] = " ( trans_type = '".$prop_res[0]['main_property_type']."' OR trans_type = '".$prop_res[0]['main_property_type']."_out' ) ";
}
if($prop_res[0]['main_property_type'] == 'buy')
{
	$where[] = " trans_type = 'sell' ";
}
if($prop_res[0]['scaleble'] != '')
{	
	$area = $prop_res[0]['scaleble'];
	$min = $area - ( $area*0.3 );
	$max = $area + ( $area*0.3 );
	$where[] = " ( scaleble >= $min AND scaleble <= $max ) ";
}
if($prop_res[0]['min_price'] != '' && $prop_res[0]['max_price'] != '')
{	
	$min_price = $prop_res[0]['min_price'];
	$max_price = $prop_res[0]['max_price'];
	$where[] = " ( price >= $min_price AND price <= $max_price) ";
}
if($prop_res[0]['furnished'] != '0')
{	
	$where[] = " furnished = '".$prop_res[0]['furnished']."' ";
}
if($prop_res[0]['warm_cell'] != '0')
{	
	$where[] = " warm_cell = '".$prop_res[0]['warm_cell']."' ";
}
//print_r($where); exit;


/* For Filtering Start */


if(isset($_POST['filter1']) && ($_POST['filter'] !='' ) )
{

$keyword=$_POST['filter'];

$where1 = array();

if($keyword !=' ')
{
$where1[] = " b_name LIKE '%".$keyword."%' ";
}
if($keyword !=' ')
{
$where1[] = " add_line1 LIKE '%".$keyword."%' ";
}
if($keyword !=' ')
{
$where1[] = " add_line2 LIKE '%".$keyword."%' ";
}
if($keyword !=' ')
{
$where1[] = " add_line3 LIKE '%".$keyword."%' ";
}
if($keyword !=' ')
{
$where1[] = " city LIKE '%".$keyword."%' ";
}




$prop_id = @implode(',',$_POST['all_prop_id']);

//$match_query = "SELECT bd.id_building,bd.b_name, pr.* FROM property_requirement as pr LEFT JOIN building_database as bd ON bd.id_building = pr.near_building_id left join broker as bk on pr.broker_owner_id=bk.broker_id WHERE pr.broker_property_id IN (".$prop_id.") AND (".implode('OR',$where1).") ORDER BY pr.price ASC,bk.broker_category DESC";

$match_query = "SELECT bd.id_building,bd.b_name, pr.* FROM property_requirement as pr LEFT JOIN building_database as bd ON bd.id_building = pr.near_building_id left join broker as bk on pr.broker_owner_id=bk.broker_id WHERE ".implode('AND',$where)." AND (".implode('OR',$where1).") ORDER BY pr.price ASC,bk.broker_category DESC";
	
//echo $match_query;

}
else
{


$match_query = "SELECT bd.id_building,bd.b_name, pr.* FROM property_requirement as pr LEFT JOIN building_database as bd ON bd.id_building = pr.near_building_id left join broker as bk on pr.broker_owner_id=bk.broker_id  WHERE ".implode('AND',$where)." order by pr.price ASC,bk.broker_category DESC ";

$match_query_new = "SELECT bd.id_building,bd.b_name, pr.* FROM property_requirement as pr LEFT JOIN building_database as bd ON bd.id_building = pr.near_building_id WHERE ".implode('AND',$where)." order by pr.price ";

}
//echo "<br>".$match_query;

$match_res = am_select($match_query);
//print_R($match_res); exit;

//print_R($sql_res);exit;
if(count($match_res) == 0)
{
	echo "<h4>No Matching found for this requirement</h4>";
}
else
{
?>
<div align="center" style="width:80%; margin-bottom:5px;"><font color="#FF0000"><?php print $msg; ?></font></div>
<?php include("customer_detail.php");?>
<form name="short_list" id="short_list" action="" method="post">
<input type="submit" name="submit_upper" value="Shortlist">
<input type="hidden" name="customer_id" value="<?php echo $customer_id;?>">
<input type="hidden" name="executive_id" value="9">
<table style="float: right;">
	<tr>
		<td>
		<!--<select name="filter" id="filter" value=" ">
			<option value=" ">Select Filter Type</option>
			<option value="min_price">Min Price</option>
			<option value="max_price">Max Price</option>
			<option value="min_area">Min Area</option>
			<option value="max_area">Max Area</option>
		</select> -->

		<input type="text" name="filter" id="filter" value="<?php echo $_POST['filter'];?>" >
		<input type="submit" name="filter1" value="Search">
		<span title="Search By Nearest Building,Area,Nearest Road,Street Name,City" alt="Search By Nearest Building,Area,Nearest Road,Street Name,City">?</span>
		</td>
	</tr>
</table>

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
		//$mode = "add";
		/*if(in_array($match_res[$i]['broker_property_id'], $selected_prop))
		{
			$mode = "update";
		}
		else
		{	
			$mode = "add";
		}*/
?>
<table style="width: 100%;">
<tr>
	<td>
		<input type="checkbox" name="prop_id[]" value="<?php echo $match_res[$i]['broker_property_id'];?>" <?php if(in_array($match_res[$i]['broker_property_id'], $selected_prop)){?>checked<?php } ?>>
		<input type="hidden" name="all_prop_id[]" value="<?php echo $match_res[$i]['broker_property_id'];?>">
		<input type="hidden" name="mode[]" value="<?php echo $mode;?>" >
		<input type="hidden" name="all_prop[]" value="<?php echo $match_res[$i]['broker_property_id'];?>" >
	</td>
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
				<input value="View Detail" name="viewdetail" id="viewdetail" onclick="javascript:window.open('<?php echo $view_link; ?>&shortlist_id=<?php echo $short_ids[$match_res[$i]['broker_property_id']];?>','_blank');" type="button">
				<?php if(in_array($match_res[$i]['broker_property_id'], $selected_prop)) { ?>
				<input value="Call Log" name="call_log" id="call_log" onclick="javascript:window.open('index.php?rel=common_listing&module=call_log&id_customer=<?php echo $customer_id; ?>&shortlist_id=<?php echo $short_ids[$match_res[$i]['broker_property_id']];?>','_blank');" type="button">
				<?php } ?>
			</div>
		</div>	
	</td>
</tr>
</table>
<?php
	}
}
?>



<input type="submit" name="submit_lower" value="Shortlist">
</form>
