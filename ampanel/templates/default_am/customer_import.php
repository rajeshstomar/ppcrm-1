<?php  
session_start();

if($_POST['Submit']) {
$path = $_FILES['csv']['tmp_name'];
$row = 1;
$insert = 0 ;
$update = 0 ;
$msgs = array();
$new_path = DIR_SCRIPT_ROOT."uploads/";
$file_names= $new_path.basename( $_FILES['csv']['name'] );
move_uploaded_file($path, $file_names);
$file_name = str_replace(DIR_SCRIPT_ROOT_HOME, "", $file_names);

	if (($handle = fopen($file_names, "r")) !== FALSE) 
	{
	$data = fgetcsv($handle,1000,",","'"); 
	//my_print_r($data);exit;
	     if($data[0] == 'First Name' && $data[9] == 'Mobile' &&  $data[37] == 'Min Budget Price' &&  $data[38] == 'Max Budget Price' )
	     { 
		//loop through the csv file and insert into database 
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
		{
		//print_R($data);exit; 
		if ($data[0]) 
		{ 
			// Check For Customer Exist
			$cust = "SELECT `client_id`,`f_name`,`l_name`,`mobile_no` FROM `client_personal_details` WHERE `mobile_no`=".$data[9];
			$cust_res = am_select($cust);
			$cust_count = count($cust_res);
			// Enter Customer Details - Starts
			if($cust_count == 0 )
			{
				$date = date('Y-m-d H:i:s');
				
				$outlet = "SELECT * FROM outlat_loacation WHERE location_name='".$data[2]."' ";
				$outlet_res = am_select($outlet);
				
				if(count($outlet_res)>0)
				{
					$place = $outlet_res[0]['location_name'];
				}
				else
				{
					$outlet_ins = "INSERT INTO `outlat_loacation`(`location_name`) VALUES ('".$data[2]."')";
					$outlet_ins_res = am_query($outlet_ins);
					$place = $data[2];	
				}
				
				$state = strtoupper($data[8]);
				$state_q = "SELECT * FROM `states` WHERE StateName='".$state."' ";
				$state_res = am_select($state_q);
				$state_id = $state_res[0]['StateID'];
				
				if($data[13] == 'Within 7 Days')
					$trans_time = '7days';
				else if($data[13] == 'Within 15 Days')
					$trans_time = '15days';
				else if($data[13] == 'Within 1 Month')
					$trans_time = '1month';
				else if($data[13] == 'More than 1 Month')
					$trans_time = 'more1month';
				else
					$trans_time = '';
				
				
				$client_cat = strtolower($data[14]);
										
				$cust_ins = "INSERT INTO `client_personal_details`(`date`, `place`, `f_name`, `l_name`, `country`, `state`, `add_line1`, `add_line2`, `add_line3`, `zip_code`, `city`, `mobile_no`, `office_no`, `email1`, `email2`, `internet`, `calls_noti`, `sms_noti`, `email_noti`, `term_agree`, `trans_time`, `client_cat`, `remark`, `executive_remark`, `client_created_date`, `client_updated_date`, `executive_id`) VALUES ('".$date."','".$place."','".$data[0]."','".$data[1]."','India','".$state_id."','".addslashes($data[3])."','".addslashes($data[4])."','".addslashes($data[5])."','".$data[6]."','".$data[7]."','".$data[9]."','".$data[10]."','".$data[11]."','".$data[12]."','".$data[15]."','".$data[15]."','".$data[16]."','".$data[17]."','1','".$trans_time."','".$client_cat."','".addslashes($data[19])."','".addslashes($data[20])."','".$date."','".$date."','".$data[21]."')";
				
				//echo $cust_ins; exit;
				$cust_ins_res = am_query($cust_ins);
				$cust_id = mysql_insert_id();
				//echo $bldr_id; exit;
			
			} 
			else 
			{
				$cust_id = $cust_res[0]['client_id'];
			}
			
			// Enter Customer Details - Ends
			
			// Enter Customers Requirement Property - Starts
			if($data[21])
			{
				//echo $cust_id; 
				//my_print_r($data); exit;				
				$date = date("d/m/Y");
				$transaction_type = strtolower($data[22]);
				$property_type = strtolower($data[23]);
				
				$prop = array(
					'client_property_id' => $cust_id,
					'main_property_type' => $transaction_type,
					'property_type' => $property_type,
					'scaleble' => $data[24],
					'onerk' => $data[25],
					'onebhk' => $data[26],
					'twobhk' => $data[27],
					'threebhk' => $data[28],
					'fourbhk' => $data[29],
					'furnished' => $data[30],
					'office' => $data[31],
					'warm_cell' => $data[32],
					'min_price' => $data[37],
					'max_price' => $data[38],
					'client_pro_created_date' => $date
				);
				
				am_insertupdate($prop,'client_property');
				$prop_id = mysql_insert_id();
				
				for($k=33; $k < 37; $k++)
				{
					if($data[$k] != '')
					{
						$area = array(
							'client_area_id'=> $cust_id,
							'property_area_id' => $prop_id,
							'area_name' => $data[$k],
							'area_created_date' => $date
						);
						am_insertupdate($area,'client_area');
					}
					
				}
			}		
			$insert++;
		} 
		} // End of While
	     } // End of If 
	     else
	     {
	   		$msgs[] = "Wrong CSV Format!! Plz check CSV..";
	     }
	//echo $update; exit;
	if($insert > 0) {
		$msgs[] = $insert." Record(s) inserted Successfully.";
	}
	if($update > 0) {
		$msgs[] = $update." Record(s) updated Successfully.";
	}
	
	$msg = @implode("</br>",$msgs);
	
	$_SESSION['msg'] = $msg; 
	//redirect 
	//exit;
	$csv = $file_name;
	$table_name = "client_property";
	$final_message = $msg;
	create_log($table_name, $csv, $final_message);

	am_goto_page("index.php?rel=customer_import&msg=".$msg);

	} 
}
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<title>Import Customers</title> 
</head> 

<body> 
<div style="text-align: center;">
<?php 

//generic success notice 
echo "<b style='color:red;'>".$_GET['msg']."</b><br><br>";
?> 

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
  Choose your file To Import Customer: <br /> 
  <input name="csv" type="file" id="csv" /> 
  <input type="submit" name="Submit" value="Submit" /> 
  
</form> 
</div>
</body> 
</html> 
