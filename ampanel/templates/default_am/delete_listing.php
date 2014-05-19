<?php
if($_POST['mode'] == "Delete")
{
    //my_print_r($_POST);exit;
	$ids =  @implode(",",$_POST['chk']);
	
	//echo $ids;exit;
	
	
	if($_POST['module']=='customer' && $ids != "" )
	{
		echo "test12";exit;
		$sql1 = "select * from property_requirement where broker_owner_id =".$ids; 
		$result=am_select($sql1);
		$count=count($result);
		
		 $sql2 = "select * from client_property where client_property_id =".$ids; 
		$result2=am_select($sql2);
		$count2=count($result2);
		
		
		
		if($count==0 && $count2==0)
		{
			//$msg = " There is Property Associated With This Owner";
			
			
			if($ids != "")
			{
				//$sql = "delete from ".$tablename." where ".$primaryid." in (".$ids.") "; 
				// update query implemented for soft delete records.
				$sql = "update ".$tablename." set is_active =0  where ".$primaryid." in (".$ids.") "; 
				
				am_query($sql);
				$msg = "Record(s) Deleted Successfully";
				am_goto_page($alllink."&msg=".$msg);
			}
			exit;
			
		}
		else  if($count>0 && $count2>0)
		{
			
			echo "<script> alert('You Can not Delete This Customer. There is Property Associated With This Customer') </script>";
			
			am_goto_page($alllink."&msg=".$msg);
			exit;
		}
		else if($count>0)
		{
			echo "<script> alert('You Can not Delete This Customer. There is Property Associated With This Customer') </script>";
			
			am_goto_page($alllink."&msg=".$msg);
			exit;
		}
		else
		{
		
			echo "<script> alert('You Can not Delete This Customer. There is Property Associated With This Customer') </script>";
			
			am_goto_page($alllink."&msg=".$msg);
			exit;
		}
		
		
		
		//echo  $count;exit;
		
	}
	else if($_POST['module']=='company' && $ids != "")
	{
		//echo "test";exit;
		$sql1 = "select * from broker where firm_id =".$ids; 
		$result=am_select($sql1);
		$count=count($result);
		//echo $count;exit;
		if($count==0)
		{
			//$msg = " There is Property Associated With This Owner";
			
			
			if($ids != "")
			{
				//$sql = "delete from ".$tablename." where ".$primaryid." in (".$ids.") "; 
				$sql = "update ".$tablename." set is_active =0  where ".$primaryid." in (".$ids.") "; 
				am_query($sql);
				$msg = "Record(s) Deleted Successfully";
				am_goto_page($alllink."&msg=".$msg);
			}
			exit;
			
		}
		else  if($count>0)
		{
			
			echo "<script> alert('You Can not Delete This Firm. There is Broker Associated With This Firm') </script>";
			
			am_goto_page($alllink."&msg=".$msg);
			exit;
		}
		
	
	}
	
	else if($_POST['module']=='broker' && $ids != "")
	{
		//echo "test";exit;
		$sql1 = "select * from property_requirement where broker_owner_id =".$ids; 
		$result=am_select($sql1);
		$count=count($result);
		//echo $count;exit;
		if($count==0)
		{
			//$msg = " There is Property Associated With This Owner";
			
			
			if($ids != "")
			{
				//$sql = "delete from ".$tablename." where ".$primaryid." in (".$ids.") "; 
				$sql = "update ".$tablename." set is_active =0  where ".$primaryid." in (".$ids.") "; 
				am_query($sql);
				$msg = "Record(s) Deleted Successfully";
				am_goto_page($alllink."&msg=".$msg);
			}
			exit;
			
		}
		else  if($count>0)
		{
			
			echo "<script> alert('You Can not Delete This Broker. There is Property Associated With This Broker') </script>";
			
			am_goto_page($alllink."&msg=".$msg);
			exit;
		}
		
	
	}	
	
	
	else
	{
		//echo "testcbvb12";exit;
		if($ids != "")
			{
				//$sql = "delete from ".$tablename." where ".$primaryid." in (".$ids.") "; 
				$sql = "update ".$tablename." set is_active =0  where ".$primaryid." in (".$ids.") "; 
				am_query($sql);
				$msg = "Record(s) Deleted Successfully";
				am_goto_page($alllink."&msg=".$msg);
			}
			exit;
		
	}

}
?>