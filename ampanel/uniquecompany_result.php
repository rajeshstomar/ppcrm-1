<?php
require('includes/script_top.php');
	//print_R($_POST);exit;

	 $c_id=$_POST['m'];
	
	if($c_id !='')
	{
	
	$qry =mysql_query("select mobile_no from broker_firm  where mobile_no=".$c_id);
	//echo $qry; 
	//$result = am_select($qry);
	//print_R($result);exit;
	$cnt=mysql_num_rows($qry);
	
	if($cnt==0)
	{
		echo "0$<span style='color:green'>Valid Mobile No</span>";
	}
	else
	{
		echo "1$<span style='color:red'>This Mobile Number is Already Exits.</span>";
	}
	
	
	}
	?>
