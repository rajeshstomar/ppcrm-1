<?php
//print_R($_REQUEST); exit;
if(isset($_REQUEST['log_id']) && is_numeric($_REQUEST['log_id']))
{
	$id = $_REQUEST['log_id'];
	
	$sql = "SELECT `log_id`, `table_name`, `date`, `msg`, `ip`, `csv_path` FROM `log` WHERE `log_id` = '".$id."' LIMIT 1";
	$log_data = am_select($sql);
	//my_print_R($log_data);exit;
	
	$mode = "Update";
}
else
{
	$mode = "Add";
}
?>

<div align="center" style="width:80%; margin-bottom:5px;"><font color="#FF0000"><?php print $msg; ?></font></div>
<form name="frm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>">
<input type="hidden" name="id_building" id="id_building" value="<?php print $log_data[0]['id_building']?>" />
<input type="hidden" name="id_user" id="id_user" value="<?php print $log_data[0]['id_user']?>" />
<input type="hidden" name="id_pl_photo" id="id_pl_photo" value="<?php print $log_data[0]['id_pl_photo']?>" />
<h3>Log Detail: </h3>
	<table width="100%" border="0" cellspacing="2" cellpadding="2"> 
	
	<tr>
		<td class="black11">Log Date:</td>
		<td class="black11"><label><?php print $log_data[0]['date']?></label></td>
	</tr>
	<tr>
		<td class="black11">Table Name</td>
		<td class="black11"><?php print $log_data[0]['table_name']?></label></td>
	</tr>
	<tr>
		<td class="black11">IP Address</td>
		<td class="black11"><?php print $log_data[0]['ip']?></td>
	</tr>
	<tr>
		<td class="black11">File</td>
		<td class="black11"><?php echo download_csv($log_data[0]['csv_path']); ?></td>
	</tr>
	<tr>
		<td class="black11">Message</td>
		<td class="black11"><?php echo html_entity_decode($log_data[0]['msg']);?></td>
	</tr>
	
	<tr>
		<td>&nbsp;</td>
		<td class="black11"><!--<input type="submit" name="submit" onclick="return validate();" value="<?=$mode;?>" />&nbsp;<input type="reset" name="reset"  value="Reset" />&nbsp;--><input type="button" name="back" onclick="javascript:window.location='index.php?rel=common_listing&module=log';" value="Back" /></td>
	</tr>
	</table>
</form>

