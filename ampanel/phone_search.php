<?php
require('includes/script_top.php');
//print_R($_POST);exit;

$phone = $_POST['phone'];
$search_in = $_POST['search_in'];

if($search_in == 'customer')
{
	$sql = "SELECT client_id as id_broker_customer, CONCAT(f_name,' ',l_name) as f_name,mobile_no as phone FROM client_personal_details WHERE mobile_no ='".$phone."' ";
}
else
{
	$sql = "SELECT broker_id as id_broker_customer,broker_name as f_name,mobile1_no as phone FROM broker WHERE mobile1_no ='".$phone."' ";
}
$res = am_select($sql);

$html = '';
$html = '<form id="caller_log" name="caller_log" action="index.php?rel=edit_call_log" method="post">
<input type="hidden" name="caller_phone" value="'.$phone.'">
<input type="hidden" name="user_is" value="'.$search_in.'">
';
$html .= '<table border="1" style="border-collapse: collapse;" cellpadding="5">';
$html .= '<tr>
		<th>Select</th>
		<th>'.ucfirst($search_in).' Name</th>
		<th>Phone</th>
	</tr>';
	
if(count($res)>0)
{

 for($i=0;$i<count($res);$i++)
 {
 	$checked = "";
 	if($i==0)
 		$checked = "checked";
 	$html .= '<tr>
		<td><input type="radio" '.$checked.' name="id_broker_customer" value="'.$res[$i]["id_broker_customer"].'"></td>
		<td>'.$res[$i]["f_name"].'</td>
		<td>'.$res[$i]["phone"].'</td>
	</tr>';
 }

}
else
{
$html .= '<tr>
		<td colspan="3">No record found...</td>
	</tr>';
}
$html .= '</table>';
$html .= '<input type="submit" name="phone_search" value="Next">
</form>
';
echo $html;
?>

