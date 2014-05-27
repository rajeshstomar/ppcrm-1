<?php
	
	$orderby = $orderby." ".$sortoption;
## Getting count of the records as per Module
  if($module == 'owner' && !isset($_GET['alpha_serach']) && !isset($_GET['refine_search']))
  {
	$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 AND pr.flag ='owner' ".$ssql." ".$groupby;
  }
   else
   {
   	// Condition applying for Alphabetically search
   	if(isset($_POST['field']))
   	{
		//code for generating the query conditions as per post data
			$fields = $_POST['field'];
			$adv_operation = $_POST['adv_operation'];
			$value = $_POST['value'];
			$query_type = $_POST['query_type'];
			$size = sizeof($fields);
			$query = "AND (";
			foreach ($fields as $i => $field) {
				if($adv_operation[$i]=="%" && $field!="mobile1_no" && $field!="address" && $field!="area" && $field!="sector"){
					$query = $query.'`'.$field.'`'." LIKE '".$value[$i].$adv_operation[$i]."' ";
				}elseif($field=="mobile1_no"){
					$query = $query."(mobile1_no LIKE '".$value[$i]."%' OR  mobile2_no LIKE '".$value[$i]."%')";
				}elseif($field=="address" || $field=="area" || $field=='sector'){
					$query = $query."(add_line1 LIKE '%".$value[$i]."%' OR  add_line2_1 LIKE '%".$value[$i]."%'  OR  add_line2_2 LIKE '%".$value[$i]."%'  OR  add_line3 LIKE '%".$value[$i]."%' OR  city LIKE '%".$value[$i]."%')";
				}else{
					$query = $query.'`'.$field.'`'." ".$adv_operation[$i]." '".$value[$i]."' ";
				}
				
				if($i<$size-1){
					$query = $query.$query_type[$i]." ";
				}else{
					$query = $query.")";
				}
			}
			//generating post data conditions over
			//advanced searching data
			$rowsCountByField  = $rowsCountBy;
			$query = "select count(distinct(".$tablename.".".$rowsCountByField.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1  ".$query;
		
		
	}
    elseif(isset($_GET['alpha_serach']) && $_GET['alpha_serach']!='')
	{
		if($module=='company')
		{
			$alphaSearchFieldBy = 'broker_name';
			$alphaSearchtable = $foRrunTimeTableName;
			$rowsCountByField  = $rowsCountBy;
			$ownerPrFlage = '';
		}
		elseif($module=='customer')
		{
			$alphaSearchFieldBy = 'f_name';
			$alphaSearchtable = $tablename;
			$rowsCountByField  = $primaryid;
			$ownerPrFlage = '';
		}
		elseif($module=='owner')
		{
			$alphaSearchFieldBy = 'f_name';
			$alphaSearchtable = $tablename;
			$rowsCountByField  = $primaryid;
			$ownerPrFlage = "AND pr.flag ='owner'";
		}

			

		 $query = "select count(distinct(".$tablename.".".$rowsCountByField.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 ".$ownerPrFlage." AND ".$alphaSearchtable.".".$alphaSearchFieldBy." LIKE '".$_GET['alpha_serach']."%'  ".$ssql." ".$groupby;
	}
	
	// Condition applying for refine search by specific columns
	elseif(isset($_GET['refine_search']) && $_GET['refine_search']!='noValueSelected' && $_GET['refine_search']!='undefined')
	{
	   /*Refine search options as per the selected Modules*/
	  
	   	// COMPANY-MODULE :- For Module Company/Firm on common listing
		if(isset($_GET['module']) && !empty($_GET['module']) &&  $_GET['module']=='company' &&  $_GET['rel']=='common_listing')
		{
			if($_GET['refine_search']=='mobile')
			{
				$ssql = "AND (mobile1_no = ".$_GET['keyword']." OR  mobile2_no =".$_GET['keyword'].")";
				//$query = "select count(distinct(".$tablename.".".$rowsCountBy.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1  ".$ssql." ".$groupby;
			}
			elseif($_GET['refine_search']=='address' || $_GET['refine_search']=='area' || $_GET['refine_search']=='sector')
			{
				$ssql = "AND (pr.add_line1 LIKE '%".$_GET['keyword']."%' OR  pr.add_line2 LIKE '%".$_GET['keyword']."%'  OR  pr.add_line3 LIKE '%".$_GET['keyword']."%')";
				//$query = "select count(distinct(".$tablename.".".$rowsCountBy.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1  ".$ssql." ".$groupby;
			}
			else
			{
				$ssql = "AND ".$_GET['refine_search']." LIKE '%".$_GET['keyword']."%'";
				//$query = "select count(distinct(".$tablename.".".$rowsCountBy.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1  ".$ssql." ".$groupby;
			}

			$distinctPrimaryid = $rowsCountBy;
		}
		// CUSTOMER - MOUDLE:-  For Module Customer and Owner on common listing
		elseif(isset($_GET['module']) && !empty($_GET['module']) &&  $_GET['module']=='customer' && $_GET['rel']=='common_listing')
		{
			if($_GET['refine_search']=='customer_name')
			{
				$ssql = "AND CONCAT(f_name,' ',l_name) LIKE '%".$_GET['keyword']."%'";
				//$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1  ".$ssql." ".$groupby;
			}
			elseif($_GET['refine_search']=='email')
			{
				$ssql = "AND (email1 LIKE '%".$_GET['keyword']."%' OR  email1 LIKE '%".$_GET['keyword']."%')";
				//$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1  ".$ssql." ".$groupby;
			}
			else
			{
				$ssql = "AND ".$_GET['refine_search']." LIKE '%".$_GET['keyword']."%'";
				//$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1  ".$ssql." ".$groupby;
			}
			$distinctPrimaryid = $primaryid;
		}

		//OWNER-MODULE :-  For Module Customer and Owner on common listing
		elseif(isset($_GET['module']) && !empty($_GET['module']) &&  $_GET['module']=='owner' && $_GET['rel']=='common_listing')
		{
			if($_GET['refine_search']=='customer_name')
			{
				$ssql = "AND CONCAT(f_name,' ',l_name) LIKE '%".$_GET['keyword']."%'";
				//$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1  ".$ssql." ".$groupby;
			}
			elseif($_GET['refine_search']=='email')
			{
				$ssql = "AND (email1 LIKE '%".$_GET['keyword']."%' OR  email1 LIKE '%".$_GET['keyword']."%')";
				//$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1  ".$ssql." ".$groupby;
			}
			elseif($_GET['refine_search']=='address' || $_GET['refine_search']=='area' || $_GET['refine_search']=='sector')
			{
				$ssql = "AND (pr.add_line1 LIKE '%".$_GET['keyword']."%' OR  pr.add_line2 LIKE '%".$_GET['keyword']."%'  OR  pr.add_line3 LIKE '%".$_GET['keyword']."%')";
				
			}
			else
			{
				$ssql = "AND ".$_GET['refine_search']." LIKE '%".$_GET['keyword']."%'";
				
			}
			$distinctPrimaryid = $primaryid;
		}

			/*COMMON QUERY FOR ABOVE SCENARIOS*/
		$query = "select count(distinct(".$tablename.".".$distinctPrimaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1  ".$ssql." ".$groupby;

	}
	/* Query for getting count for comopany listing module*/
	elseif($module=='company' && $_GET['rel']=='common_listing')
	{
		$query = "select count(".$tablename.".".$rowsCountBy.") as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1  ".$ssql." ".$groupby;
	}	
	
	else
	{
		$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1  ".$ssql." ".$groupby;
	}
   
   }	
	
//echo $query;exit;
	$tot_arr = am_select($query);
	$fieldarray = $modulearray[$module]['fieldarr'];
	//print_R($fieldarray);exit;
	if($module == 'call_log'){
  		$total = count($tot_arr); 
  	}else{
		$total = $tot_arr[0]['tot']; 
	}
	//echo $total;exit;
	//$total = $tot_arr[0]['tot']; 
	// Changed for listing of records per page 
	 $show =(isset($_REQUEST['show_max_row']) && $_REQUEST['show_max_row']!='')?$_REQUEST['show_max_row']:25;
?>