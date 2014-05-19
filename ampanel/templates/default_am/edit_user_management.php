<?php
//include("../dbconfig.php");
$msg = $_GET['msg'];

if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
{
	$id = $_REQUEST['id'];
	
	$sel_que ="select * from admin where admin_id= '".$id."' ";
	$event_data = am_select($sel_que);
	//my_print_R($event_data);exit;
	$mode = "Update";
}
else
{
	$mode = "Add";
	
	
}

?>
<div align="center" style="width:80%; margin-bottom:5px;"><font color="#FF0000"><?php print $msg; ?></font></div>
<form name="frm" method="post" action="index.php?rel=user_management_action" >
<input type="hidden" name="mode" id="mode" value="<?=$mode;?>">
<input type="hidden" name="admin_id" id="admin_id" value="<?php print $event_data[0]['admin_id']?>">
<h2> <?php echo $mode; ?> User </h2>
<table width="80%" border="0" cellspacing="2" cellpadding="2"> 
  <tr>
    <td class="black11">User First Name <font color="red" >*</font></td>
    <td class="black11"><input type="text" name="user_f_name" id="user_f_name" value="<?php print $event_data[0]['admin_f_name']?>" /></td>
  </tr>
  <tr>
    <td class="black11">User Last Name <font color="red" >*</font></td>
    <td class="black11"><input type="text" name="user_l_name" id="user_l_name" value="<?php print $event_data[0]['admin_l_name']?>" /></td>
  </tr>
  
  <tr>
    <td class="black11">User Name <font color="red" >*</font></td>
    <td class="black11"><input type="text" name="user_name" id="user_email" value="<?php print $event_data[0]['admin_name']?>" /></td>
  </tr>
  <tr>
    <td class="black11">User Email <font color="red" >*</font></td>
    <td class="black11"><input type="text" name="user_email" id="user_email" value="<?php print $event_data[0]['admin_email']?>" /></td>
  </tr>
  <?php if($mode=='Add') { ?>
  <tr>
    <td class="black11">User Password <font color="red" >*</font></td>
    <td class="black11"><input type="password" name="user_password" id="user_password" value="" /></td>
  </tr>
  <?php } ?>
  
  <tr>
    <td class="black11">User Type <font color="red" >*</font></td>
    <td class="black11">
    	
    		<select name="user_type" id="user_type">
    			<option value="">Select User Type</option>
    			<option value="admin"  <?php if($event_data[0]['role']=='admin') { ?> selected <?php } ?> >Admin</option>
    			<option value="manager" <?php if($event_data[0]['role']=='manager') { ?> selected <?php } ?> >Manager</option>
    			<option value="executive" <?php if($event_data[0]['role']=='executive') { ?> selected <?php } ?> >Executive</option>
    			<option value="caller_executive" <?php if($event_data[0]['role']=='caller_executive') { ?> selected <?php } ?> >Caller Executive</option>
    		</select>
    
    
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td class="black11"><input type="submit" name="submit" onclick="return validate();" value="<?=$mode;?>" />&nbsp;</td>
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
