<?php
//include("../dbconfig.php");
$msg = $_GET['msg'];

if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
{
	$id = $_REQUEST['id'];
	
	$sel_que ="select * from outlat_loacation where out_loc_id= '".$id."' ";
	$client_data = am_select($sel_que);
	//my_print_R($client_data);exit;
	$mode = "Update";
}
else
{
	$mode = "Add";
}
//include(DIR_SCRIPT_ROOT."/fckeditor/fckeditor.php") ; 
?>


<link rel="stylesheet" href="<?php echo HTTP_ROOT_HOME; ?>css/jquery-ui.css">
  
  <script src="<?php echo HTTP_ROOT_HOME; ?>js/jquery-ui.js"></script>

<script>
$(function() {
$( "#date1" ).datepicker({
dateFormat: 'dd/mm/yy',
});
});
</script>
<div align="center" style="width:80%; margin-bottom:5px;"><font color="#FF0000"><?php print $msg; ?></font></div>
<h2> <?php echo $mode; ?> Outlet Location</h2>
<form name="frm" method="post" action="index.php?rel=outlet_location_action" >
<input type="hidden" name="mode" id="mode" value="<?=$mode;?>">
<input type="hidden" name="location_id" value="<?php print $client_data[0]['out_loc_id']?>" />
<table width="80%" border="0" cellspacing="2" cellpadding="2" > 

  <tr>
	    <td class="black11" >Location Name</td>
	    <td class="black11"><input type="text" name="l_name" id="l_name" value="<?php print $client_data[0]['location_name']?>" /></td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td class="black11"><input type="submit" name="submit" onclick="return validate();" value="<?=$mode;?>" />&nbsp;<!--<input type="reset" name="reset"  value="Reset" />&nbsp;<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=static_pages';" value="Cancel" />--></td>
  </tr>
</table>
</form>

<script type="text/javascript">
function validate()
{
	if(document.getElementById('page_title').value == "")
	{
		alert("Please enter page title");
		document.getElementById('page_title').focus();
		return false;
	}
	return true;
}
</script>
