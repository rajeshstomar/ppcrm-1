<?php
require('includes/script_top.php');
	//print_R($_POST);exit;

	$c_id=$_POST['client_id'];

	$qry ="select property_id from client_property where client_property_id=".$c_id;
	
	$result = am_select($qry);
	print_R($result);exit; 
	$dis_string = '';
	$dis_string.="<h3>Select Any One Customer</h3>";
	$dis_string.="<table border='1'>";
	$dis_string.="<tr>";
	$dis_string.="<th></th>";
	$dis_string.="<th>Property ID</th>";
	$dis_string.="</tr>";


	?>


<?php	for($i=0;$i<count($result);$i++)
	{ 
		$dis_string.="<tr>";
		$dis_string.="<td><a href='javascript:' property_id='".$result[$i]['property_id']."'  class='select_broker'>Select</a></td>";
		$dis_string.="<td>".$result[$i]['property_id']."</td>";
		
		$dis_string.="</tr>";

	}

$dis_string.="</table>";
//$dis_string.="<input type='button' name='broker_id' value='Go' id='click'>";
echo $dis_string;
?>
		
