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
	     if($data[0] == 'First Name' && $data[9] == 'Mobile' && $data[25] == 'Expected Price' )
	     { 
		//loop through the csv file and insert into database 
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
		{
		//print_R($data);exit;
		if ($data[0]) 
		{ 
			// Check For Owner Exist
			$cust = "SELECT `client_id`,`f_name`,`l_name`,`mobile_no` FROM `client_personal_details` WHERE `mobile_no`=".$data[9];
			
			//echo $cust;	
			$cust_res = am_select($cust);
			 $cust_count = count($cust_res);
			// Enter Owner Details - Starts
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
										
				$cust_ins = "INSERT INTO `client_personal_details`(`date`, `place`, `f_name`, `l_name`, `country`, `state`, `add_line1`, `add_line2`, `add_line3`, `zip_code`, `city`, `mobile_no`, `office_no`, `email1`, `email2`, `internet`, `calls_noti`, `sms_noti`, `email_noti`,`remark`,`client_created_date`, `client_updated_date`) VALUES ('".$date."','".$place."','".$data[0]."','".$data[1]."','India','".$state_id."','".addslashes($data[3])."','".addslashes($data[4])."','".addslashes($data[5])."','".$data[6]."','".$data[7]."','".$data[9]."','".$data[10]."','".$data[11]."','".$data[12]."','".$data[13]."','".$data[14]."','".$data[15]."','".$data[16]."','".addslashes($data[17])."','".$date."','".$date."')";
				
				//echo $cust_ins; exit;
				$cust_ins_res = am_query($cust_ins);
				$cust_id = mysql_insert_id();
				$pan_or_mobile=$data[9];
				//echo $bldr_id; exit;
			
			} 
			else 
			{
				$cust_id = $cust_res[0]['client_id'];
				$pan_or_mobile = $cust_res[0]['mobile_no'];
			}
			
			// Enter owber Details - Ends
			
			// Enter owner Property - Starts
			if($data[0] || $data[9])
			{
				//echo $cust_id; 
				//my_print_r($data); exit;				
				$date = date('Y-m-d H:i:s');
				$transaction_type = strtolower($data[18]);
				$property_type = strtolower($data[19]);
				
				$state_prop = strtoupper($data[34]);
				$state_q_prop = "SELECT * FROM `states` WHERE StateName='".$state_prop."' ";
				$state_res_prop = am_select($state_q_prop);
				$state_id_prop = $state_res_prop[0]['StateID'];

				/* Nearest Bualding start */
				
				$near_prop = strtoupper($data[26]);
				$near_q_prop = "SELECT * FROM `building_database` WHERE b_name='".$near_prop."' ";
				$near_res_prop = am_select($near_q_prop);
				$near_id_prop = $near_res_prop[0]['id_building'];

				/* Nearest Bualding End */

				/* For Form No Start*/
				$lastid="SELECT MAX( broker_property_id) FROM property_requirement";
				$get_lastid=am_select($lastid);
				$id_last=$get_lastid[0]['MAX( broker_property_id)']+1;
				/* For Form No End*/
		
				$prop = array(
					'broker_owner_id' => $cust_id,
					'date' => $date,
					'form_no' =>$id_last ,
					'pan_or_mobile' =>$pan_or_mobile,
					'property_main_type' => $property_type,
					'trans_type' => $transaction_type,
					'scaleble' => $data[20],
					'onerk' => $data[21],
					'furnished' => $data[22],
					'office' => $data[23],					
					'warm_cell' => $data[24],
					'price' => $data[25],
					'type'  => 'owner',
					'near_building_id' =>$near_id_prop,
					'floor' =>$data[27],
					'add_line1' =>$data[30],
					'add_line2' =>$data[29],
					'add_line3' =>$data[28],	
					'landmark'  =>$data[31],
					'city' =>$data[32],
					'zip_code' =>$data[33],
					'state_id' => $state_id_prop,
					'country' =>'India',
					'property_created_date' => $date,
					'property_updated_date' => $date,
					'flag' => 'owner'
				); 

				//print_R($prop);exit;
				
				am_insertupdate($prop,'property_requirement');
				
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
	$table_name = "owner_property_requirement";
	$final_message = $msg;
	create_log($table_name, $csv, $final_message);

	am_goto_page("index.php?rel=owner_import&msg=".$msg);

	} 
}
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<title>Import Owner Property</title> 
</head> 

<body> 
<div style="text-align: center;">
<?php 

//generic success notice 
echo "<b style='color:red;'>".$_GET['msg']."</b><br><br>";
?> 

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
  Choose your file To Import Owner: <br /> 
  <input name="csv" type="file" id="csv" /> 
  <input type="submit" name="Submit" value="Submit" /> 
  
</form> 
</div>
</body> 
</html> 
