<?php
//include("../dbconfig.php");
$broker_id = $_REQUEST['broker_id'];
$cust = "SELECT * FROM broker  WHERE broker_id=".$broker_id;
$cust_data = am_select($cust);
//echo"<pre>";print_r($cust_data);
//include(DIR_SCRIPT_ROOT."/fckeditor/fckeditor.php") ; 
?>
<table class="black11" style="text-align: left;">
		<tr><th colspan="4"><h3><u>Broker Details:</u>&nbsp;&nbsp;</th></h3></tr>
		<tr><th width="140">Broker Name:&nbsp;&nbsp;</th><td colspan="3"><a href="index.php?&rel=edit_broker&id=<?php echo $cust_data[0]['broker_id'];?>"><?php echo $cust_data[0]['broker_name'];?></a></td></tr>
		<tr><th>Email:&nbsp;&nbsp;</th><td width="200"><?php echo $cust_data[0]['email'];?></td><th width="140">Mobile:&nbsp;&nbsp;</th><td><?php echo $cust_data[0]['mobile1_no'];?></td></tr>
<tr>
<th colspan="4">
<a href="index.php?&rel=edit_interaction_report&id=&brokerID=<?php echo $broker_id;?>"><input value="Add New Property" name="addnew" id="addnew" type="button">
</th>
</tr>	
</table>