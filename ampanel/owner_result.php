<?php
require('includes/script_top.php');
	//print_R($_POST);exit;

	$c_id=$_POST['c_id'];
	$c_name=$_POST['c_id'];
	$email=$_POST['c_id'];
	$c_name=trim($c_name," ");
	$c=explode(" ",$c_name);
	//print_R($c);exit;
	$count=count($c);

	//$email_id=$_POST['email_id'];
	$mob_no=$_POST['c_id'];
	$ssql = array();
	$where = '';
	if($c_id != '' )
		$ssql[] = " client_id like '".$c_id."' ";

	if($count == 1 && $c[0] != '')
		$ssql[] = " (f_name like '%".$c[0]."%' or l_name like '%".$c[0]."%' )";

	if($count == 2 && $c[0] != '' && $c[1] != '')
		$ssql[] = " (f_name like '%".$c[0]."%' or l_name like '%".$c[1]."%' or f_name like '%".$c[1]."%' or l_name like '%".$c[0]."%' )";
	
	//if($email_id != '' )
	//	$ssql[] = " email1 like '%".$email_id."%'";
	if($mob_no != '' )
		$ssql[] = " mobile_no like '%".$mob_no."%' ";
	if($email != '' )
		$ssql[] = " email1 like '%".$email."%' ";	
	
	if(count($ssql) > 0)
		$where = " WHERE ".implode(" OR   ", $ssql);
	$qry ="select * from client_personal_details  ".$where."  " ;
	//echo $qry; 
	$result = am_select($qry);
	//print_R($result);exit; 
	$dis_string = '';
	$dis_string.="<h3>Select Any One Owner</h3>";
	$dis_string.="<table border='1'>";
	$dis_string.="<tr>";
	$dis_string.="<th></th>";
	$dis_string.="<th>Owner ID</th>";
	$dis_string.="<th>First Name</th>";
	$dis_string.="<th>Last Name</th>";
	$dis_string.="<th>Email ID</th>";
	$dis_string.="<th>Mobile No</th>";
	$dis_string.="</tr>";


	?>


<?php	for($i=0;$i<count($result);$i++)
	{ 
		$dis_string.="<tr>";
		$dis_string.="<td><a href='javascript:' client_id='".$result[$i]['client_id']."' date='".$result[$i]['date']."' 	place='".$result[$i]['place']."' f_name='".$result[$i]['f_name']."' l_name='".$result[$i]['l_name']."'  mobile_no='".$result[$i]['mobile_no']."' email1='".$result[$i]['email1']."'  class='select_broker1'>Select</a></td>";
		$dis_string.="<td>".$result[$i]['client_id']."</td>";
		$dis_string.="<td>".$result[$i]['f_name']."</td>";
		$dis_string.="<td>".$result[$i]['l_name']."</td>";
		$dis_string.="<td>".$result[$i]['email1']."</td>";
		$dis_string.="<td>".$result[$i]['mobile_no']."</td>";
		$dis_string.="</tr>";

	}

$dis_string.="</table>";
//$dis_string.="<input type='button' name='broker_id' value='Go' id='click'>";
echo $dis_string;
?>
		
