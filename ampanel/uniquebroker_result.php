<?php
require('includes/script_top.php');
	//print_R($_POST);

	$c_id=$_POST['m'];
	$feild=$_POST['c'];
	//$pan=$_POST['pan'];
	
	if($c_id !='' && $feild !='' )
	{
		if($feild=='pan_card_num')
		{
			$tmp="'".$c_id."'";
		}
		else
		{
			$tmp=$c_id;
		}

		//echo "select ".$feild." from broker  where ".$feild."=".$c_id;exit;
	
		$qry =mysql_query("select ".$feild." from broker  where ".$feild."=".$tmp);
		//echo $qry; 
		//$result = am_select($qry);
		//print_R($result);exit;
		$cnt=mysql_num_rows($qry);
	
		if($feild=='pan_card_num')
		{
			if($cnt==0)
			{
				echo "2$<span style='color:green'>Valid Pan Card Number</span>";
			}
			else
			{
				echo "3$<span style='color:red'>This Pan Card Number is Already Exits.</span>";
			}
	
		}
		else
		{
			if($cnt==0)
			{
				echo "0$<span style='color:green'>Valid Mobile No</span>";
			}
			else
			{
				echo "1$<span style='color:red'>This Mobile Number is Already Exits.</span>";
			}
		}
	
	}
	?>
