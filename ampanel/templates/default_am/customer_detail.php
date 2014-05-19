<?php
//include("../dbconfig.php");
$customer_id = $_REQUEST['customer_id'];
$cust = "SELECT cpd.*,s.StateName FROM client_personal_details as cpd LEFT JOIN states as s ON s.StateID=cpd.state WHERE client_id=".$customer_id;
$cust_data = am_select($cust);
//include(DIR_SCRIPT_ROOT."/fckeditor/fckeditor.php") ; 
?>
<table class="black11" style="text-align: left;">
		<tr><th colspan="4"><h3><u>Customer Details:</u>&nbsp;&nbsp;</th></h3></tr>
		<tr><th width="140">Customer Name:&nbsp;&nbsp;</th><td colspan="3"><a href="index.php?&rel=view_customer&id=<?php echo $cust_data[0]['client_id'];?>"><?php echo ucfirst($cust_data[0]['f_name'])." ".ucfirst($cust_data[0]['l_name']);?></a></td></tr>
		<tr><th>Email:&nbsp;&nbsp;</th><td width="200"><?php echo $cust_data[0]['email1'];?></td><th width="140">Mobile:&nbsp;&nbsp;</th><td><?php echo $cust_data[0]['mobile_no'];?></td></tr>
		<tr><th>Address:&nbsp;&nbsp;</th><td colspan="3"><?php echo $cust_data[0]['add_line1'].", ".$cust_data[0]['add_line2'].", ".$cust_data[0]['add_line3'].", ".$cust_data[0]['city'].", ".$cust_data[0]['StateName'];?></td></tr>
</table>
