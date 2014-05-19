<?php
//include("../dbconfig.php");
$msg = $_GET['msg'];

$sel_que ="select * from admin_settings where 1=1";
$event_data = am_select($sel_que);
$mode = "Update";

?>
<div align="center" style="width:80%; margin-bottom:5px;"><font color="#FF0000"><?php print $msg; ?></font></div>
<form name="frm" method="post" action="index.php?rel=settings_action" >
<input type="hidden" name="mode" id="mode" value="<?=$mode;?>">
<table width="80%" border="0" cellspacing="2" cellpadding="2"> 
  <tr>
    <td class="black11">Admin Email <font color="red" >*</font></td>
    <td class="black11"><input type="text" name="admin_email" id="admin_email" value="<?php print $event_data[0]['admin_email']?>" /></td>
  </tr>
  <tr>
    <td class="black11">From Email <font color="red" >*</font></td>
    <td class="black11"><input type="text" name="from_email" id="from_email" value="<?php print $event_data[0]['from_email']?>" /></td>
  </tr>
  <tr>
    <td class="black11">Contact Email <font color="red" >*</font></td>
    <td class="black11"><input type="text" name="contact_email" id="contact_email" value="<?php print $event_data[0]['contact_email']?>" /></td>
  </tr>
  <tr>
    <td class="black11">Contact Phone <font color="red" >*</font></td>
    <td class="black11"><input type="text" name="contact_phone" id="contact_phone" value="<?php print $event_data[0]['contact_phone']?>" /></td>
  </tr>
  <tr>
    <td class="black11">Contact Address <font color="red" >*</font></td>
    <td class="black11"><textarea name="contact_address" style="height:50px;width:200px;" id="contact_address"><?php print $event_data[0]['contact_address']?></textarea></td>
  </tr>
  <tr>
    <td class="black11">Meta Title</td>
    <td class="black11"><textarea name="meta_title" style="height:50px;width:200px;" id="meta_title"><?php print $event_data[0]['meta_title']?></textarea></td>
  </tr>
    <tr>
    <td class="black11">Meta Keyword</td>
    <td class="black11"><textarea name="meta_keyword" style="height:50px;width:200px;"  id="meta_keyword"><?php print $event_data[0]['meta_keyword']?></textarea></td>
  </tr>
    <tr>
    <td class="black11">Meta Description</td>
    <td class="black11"><textarea name="meta_description" style="height:50px;width:200px;"  id="meta_description"><?php print $event_data[0]['meta_description']?></textarea></td>
  </tr>
  <tr>
    <td class="black11">Home Page Consumer Text</td>
    <td class="black11"><textarea name="consumer_text" style="height:140px;width:250px;"  id="consumer_text"><?php print $event_data[0]['consumer_text']?></textarea></td>
  </tr>
  <tr>
    <td class="black11">Home Page Business Text</td>
    <td class="black11"><textarea name="business_text" style="height:140px;width:250px;"  id="business_text"><?php print $event_data[0]['business_text']?></textarea></td>
  </tr>
  <tr>
    <td class="black11">Home Page Charity Text</td>
    <td class="black11"><textarea name="charity_text" style="height:140px;width:250px;"  id="charity_text"><?php print $event_data[0]['charity_text']?></textarea></td>
  </tr>
    <!-- <tr>
    <td class="black11">Payment Mode</td>
    <td class="black11"><select name="payment_option" id="payment_option">
			<?php $option = $event_data[0]['payment_option'];
				
				if($option == "Test")
				{
				 	$op1 = 'selected = "selected"';
				} 
				else
				{
					$op1 = "";
				}
				if($option == "Live")
				{
				 	$op2 = 'selected = "selected"';
				} 
				else
				{
					$op2 = "";
				}
			?>
			<option value="Test" <?php echo $op1 ?>>Test</option>
			<option value="Live" <?php echo $op2 ?>>Live</option>
			</select>
  </tr> -->
  <tr>
    <td>&nbsp;</td>
    <td class="black11"><input type="submit" name="submit" onclick="return validate();" value="<?=$mode;?>" />&nbsp;<input type="reset" name="reset"  value="Reset" />&nbsp;</td>
  </tr>
</table>
</form>

<script type="text/javascript">
function validate()
{
	if(Trim(document.getElementById('admin_email').value) == "")
	{
		alert("Please Enter Admin Email");
		document.getElementById('admin_email').focus();
		return false;
	}
	if(!validate_email(Trim(document.getElementById('admin_email').value)))
	{
		alert("Please Enter Valid Email Address");
		return false;
	}
	if(Trim(document.getElementById('from_email').value) == "")
	{
		alert("Please Enter From Email");
		document.getElementById('from_email').focus();
		return false;
	}
	if(!validate_email(Trim(document.getElementById('from_email').value)))
	{
		alert("Please Enter Valid Email Address");
		return false;
	}
	if(Trim(document.getElementById('contact_email').value) == "")
	{
		alert("Please Enter Contact Email");
		document.getElementById('contact_email').focus();
		return false;
	}
	if(!validate_email(Trim(document.getElementById('contact_email').value)))
	{
		alert("Please Enter Valid Contact Email Address");
		return false;
	}
	if(Trim(document.getElementById('contact_phone').value) == "")
	{
		alert("Please Enter Contact Phone no.");
		document.getElementById('contact_phone').focus();
		return false;
	}
	if(Trim(document.getElementById('contact_address').value) == "")
	{
		alert("Please Enter Contact Address");
		document.getElementById('contact_address').focus();
		return false;
	}
	return true;
}
</script>
