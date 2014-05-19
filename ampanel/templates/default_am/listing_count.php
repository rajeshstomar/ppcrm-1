<?php
	
	$orderby = $orderby." ".$sortoption;
## Getting count of the records as per Module
	if($module == 'owner')
  {
	$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 AND pr.flag ='owner' ".$ssql." ".$groupby;
   }
   else
   {
   	// Condition applying for Alphabetically search
    if(isset($_GET['alpha_serach']) && $_GET['alpha_serach']!='')
	{
		$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 AND ".$tablename.".broker_name LIKE '".$_GET['alpha_serach']."%'  ".$ssql." ".$groupby;
	}
	// Condition applying for refine search by specific columns
	elseif(isset($_GET['refine_search']) && $_GET['refine_search']!='noValueSelected')
	{
	   if($_GET['refine_search']=='mobile')
	   {
		$ssql = "AND (mobile1_no = ".$_GET['keyword']." OR  mobile2_no =".$_GET['keyword'].")";
		$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1  ".$ssql." ".$groupby;
	   }
	   elseif($_GET['refine_search']=='address')
	   {
		$ssql = "AND (add_line1 LIKE '%".$_GET['keyword']."%' OR  add_line2_1 LIKE '%".$_GET['keyword']."%'  OR  add_line2_2 LIKE '%".$_GET['keyword']."%'  OR  add_line3 LIKE '%".$_GET['keyword']."%')";
		$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1  ".$ssql." ".$groupby;
	   }
	   else
	   {
			$ssql = "AND ".$_GET['refine_search']." LIKE '%".$_GET['keyword']."%'";
			$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1  ".$ssql." ".$groupby;
	   }

	}
	else
	{
		$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1  ".$ssql." ".$groupby;
	}
   
   }	

	$tot_arr = am_select($query);
	$fieldarray = $modulearray[$module]['fieldarr'];
	//print_R($fieldarray);exit;
	if($module == 'call_log'){
  		$total = count($tot_arr); 
  	}else{
		$total = $tot_arr[0]['tot']; 
	}
	//$total = $tot_arr[0]['tot']; 
	// Changed for listing of records per page 
	 $show =(isset($_REQUEST['show_max_row']) && $_REQUEST['show_max_row']!='')?$_REQUEST['show_max_row']:25;
?>