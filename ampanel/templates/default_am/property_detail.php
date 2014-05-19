<?php
//include("../dbconfig.php");
$shortlist_id = $_REQUEST['shortlist_id'];
$match_query = "SELECT bd.id_building,bd.b_name, pr.* FROM property_requirement as pr LEFT JOIN building_database as bd ON bd.id_building = pr.near_building_id left join broker as bk on pr.broker_owner_id=bk.broker_id LEFT JOIN short_listed_prop as slp on slp.property_listing_id = pr.broker_property_id WHERE slp.id_shortlist=".$shortlist_id;

//echo "<br>".$match_query; exit;
$match_res = am_select($match_query);
if($match_res[0]['flag'] == 'owner')
	$view_link = 'index.php?&rel=view_owner_property&id='.$match_res[0]['broker_property_id'].'&owner_id='.$match_res[0]['broker_owner_id'];
else
	$view_link = 'index.php?&rel=view_interaction_report&id='.$match_res[0]['broker_property_id'].'&mode=read';
//include(DIR_SCRIPT_ROOT."/fckeditor/fckeditor.php") ; 
?>
<table>
<tr>
	<td>
		<div class="prop_match">
			<div class="pro_left">
				<p><b>Nearest Building:</b> &nbsp;&nbsp;<?php echo  $match_res[0]['b_name'];  ?> </p>
				<p><b>Property Location :</b> &nbsp;&nbsp;<?php echo  $match_res[0]['floor'].", ".$match_res[0]['add_line1'].", ".$match_res[0]['add_line2'].", ".$match_res[0]['add_line3'].", ".$match_res[0]['city'];  ?> </p>
				<p><b>Property type:</b>&nbsp;&nbsp; <?php echo ucfirst($match_res[0]['property_main_type']); ?>&nbsp;&nbsp;&nbsp;&nbsp;<b>Approximate Area :</b>&nbsp;&nbsp;<?php echo  $match_res[0]['scaleble']; ?> Sq.Ft.&nbsp;&nbsp;&nbsp;&nbsp;</p>
				<p><b>Price :</b>&nbsp;&nbsp;<?php echo  $match_res[0]['price']; ?></p>
				<?php if(!empty($types)) { ?>
				<p><b>Types:</b>&nbsp;&nbsp; <?php echo $type; ?></p>
				<? } ?>
			</div>
			<div class="pro_right">
				<input value="View Detail" name="viewdetail" id="viewdetail" onclick="javascript:window.open('<?php echo $view_link; ?>&shortlist_id=<?php echo $shortlist_id;?>','_blank');" type="button">
			</div>
		</div>	
	</td>
</tr>
</table>
