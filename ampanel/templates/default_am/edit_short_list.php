<?php
//include("../dbconfig.php");
$msg = $_GET['msg'];

if(isset($_REQUEST['submit_list']))
{
	//print_R($_POST); exit;
	$id = $_REQUEST['id_shortlist'];
	$status_id = $_POST['status_id'];
	$next_call_date = date('Y-m-d', strtotime($_POST['next_call_date']));
	$desc = addslashes($_POST['description']);
	$pp_executive_id = $_POST['pp_executive_id'];
	//echo $next_call_date; exit;
	$sql = "UPDATE short_listed_prop SET description='".$desc."',status_id='".$status_id."', next_call_date='".$next_call_date."',pp_executive_id='".$pp_executive_id."' WHERE id_shortlist=".$id;
	$res = am_query($sql);
	$msg = "Record updated successfully!!";
	am_goto_page("index.php?rel=common_listing&module=short_list&msg=".$msg);
}
if(isset($_REQUEST['id_shortlist']) && is_numeric($_REQUEST['id_shortlist']))
{
	$id = $_REQUEST['id_shortlist'];
	
	//$sel_que ="select * from short_listed_prop where id_shortlist= '".$id."' ";
	$sel_que ="select ss.status_name, id_shortlist ,CONCAT(f_name,' ',l_name) as name,mobile_no,email1,a.admin_name,a.admin_id,a.admin_f_name,a.admin_l_name,sl.* from short_listed_prop as sl LEFT JOIN client_personal_details as cp ON cp.client_id = sl.customer_id LEFT JOIN admin as a ON sl.pp_executive_id = a.admin_id LEFT JOIN shortlist_status as ss ON ss.status_id = sl.status_id where sl.id_shortlist = '".$id."' order by id_shortlist DESC limit 0,10";
	$shortlist_data = am_select($sel_que);
	//my_print_R($shortlist_data);exit;
	$mode = "Update";
}
else
{
	$mode = "Add";
	
	
}

?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
$(function() {
$( "#next_call_date" ).datepicker({
dateFormat: 'dd-mm-yy',
showOn: "button",
buttonImage: "images/calendar.gif",
buttonImageOnly: true,
});
});
</script>


<div align="center" style="width:80%; margin-bottom:5px;"><font color="#FF0000"><?php print $msg; ?></font></div>
<form name="frm" method="post" action="" >
<input type="hidden" name="mode" id="mode" value="<?=$mode;?>">
<h2> <?php echo $mode; ?> Short List </h2>
<table width="80%" border="0" cellspacing="2" cellpadding="2"> 
  <tr>
    <td class="black11">Name</td>
    <td class="black11"><?php echo $shortlist_data[0]['name'];?></td>
  </tr>
  <tr>
    <td class="black11">Mobile No.</td>
    <td class="black11"><?php echo $shortlist_data[0]['mobile_no'];?></td>
  </tr>
  <tr>
    <td class="black11">Email</td>
    <td class="black11"><?php echo $shortlist_data[0]['email1'];?></td>
  </tr>
  <tr>
    <td class="black11">Assigned To</td>
    <td class="black11"><?php //echo $shortlist_data[0]['admin_name'];?>
    <?php echo 
    	$select = am_get_select('admin', 'admin_id', 'pp_executive_id', $shortlist_data[0]['admin_id'], 'admin_f_name', '','' );
    	//echo $select;
    ?>
    </td>
  </tr>
  <tr>
    <td class="black11">Status</td>
    <td class="black11"><?php echo 
    	$select = am_get_select('shortlist_status', 'status_id', 'status_id', $shortlist_data[0]['status_id'], 'status_name', '','' );
    	//echo $select;
    ?></td>
  </tr>
  <tr>
    <td class="black11">Next Call Date</td>
    <td class="black11"><input type="text" name="next_call_date" id="next_call_date" value="<?php echo date('d-m-Y', strtotime($shortlist_data[0]['next_call_date']));?>" /></td>
  </tr>
  <tr>
    <td class="black11">Description</td>
    <td class="black11"><textarea name="description" id="description" rows="5" cols="70"><?php echo $shortlist_data[0]['description']; ?></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="black11"><input type="submit" name="submit_list" onclick="return validate();" value="<?=$mode;?>" />&nbsp;</td>
  </tr>
</table>
</form>

<!--<script type="text/javascript">
function validate()
{
	if(Trim(document.getElementById('user_name').value) == "")
	{
		alert("Please Enter User Name");
		document.getElementById('user_name').focus();
		return false;
	}
	
	if(Trim(document.getElementById('user_email').value) == "")
	{
		alert("Please Enter User Email");
		document.getElementById('user_email').focus();
		return false;
	}
	if(!validate_email(Trim(document.getElementById('user_email').value)))
	{
		alert("Please Enter Valid Email Address");
		return false;
	}
	if(Trim(document.getElementById('user_password').value) == "")
	{
		alert("Please Enter User Password");
		document.getElementById('user_password').focus();
		return false;
	}
	
	if(Trim(document.getElementById('user_type').value) == "")
	{
		alert("Please Select User Type");
		document.getElementById('user_type').focus();
		return false;
	}
	
	return true;
}
</script>-->
