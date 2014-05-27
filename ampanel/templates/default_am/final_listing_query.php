<?php
  if($module == 'owner')
  {
  	$ssql .= "  AND pr.flag ='owner'  ";
  }
 if($module == 'owner' || $module == 'customer' )
  {
  	$final_query = "select distinct(".$tablename.".".$primaryid.") ,";
  }
 else if($module == 'company' )
  {
  	$final_query = "select distinct(".$foRrunTimeTableName.".".$primaryid.") ,";
  }
  else
  {
  	$final_query = "select ".$tablename.".".$primaryid." ,";
  }
 
  //$final_query = "select ".$primaryid." ,";\

  //this for loop selects all the coloums that have to be rendered in the page as given in the field array
  for($i=0,$ni=count($fieldarray);$i<$ni;$i++)
  {
     $final_query .= $fieldarray[$i][0].",";
  } 
  //this line removes the last comma from the final query generated by the for loop
  $final_query = substr($final_query,0,-1);

 ## condition applying for sorting by company name
if($module =='company' && ($_GET['sort_option'] == 'company_name'))
{
	$sortOptTable = 'broker_firm';
	$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 ".$ssql." ".$groupby." order by ".$sortOptTable.".".$orderby." limit $start,$limit";
}
else
{  
	if(isset($_POST['field'])){
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
				}elseif($field=="address"  || $field=="area" || $field=='sector'){
					$query = $query."(add_line1 LIKE '%".$value[$i]."%' OR  add_line2_1 LIKE '%".$value[$i]."%'  OR  add_line2_2 LIKE '%".$value[$i]."%'  OR  add_line3 LIKE '%".$value[$i]."%' OR  city LIKE '%".$value[$i]."%')";
					
				}else{
					$query = $query.'`'.$field.'`'." ".$adv_operation[$i]." '".$value[$i]."' ";
				}

				if($i<$size-1){
					$query = $query.$query_type[$i]." ";
				}
			}
			$ssql = $query.")";
			//generating post data conditions over
			//advanced searching data
			$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 ".$ssql." ".$groupby." order by ".$tablename.".".$orderby." limit $start,$limit";

		
	}
	// Condition applying for Alphabetically search
	elseif(isset($_GET['alpha_serach']) && $_GET['alpha_serach']!='')
	{
		if($module=='company')
		{
			$alphaSearchFieldBy = 'broker_name';
			$alphaSearchtable = $foRrunTimeTableName;
			$orderbyAlphaSearch = $alphaSearchFieldBy;
		}
		elseif($module=='customer' || $module=='owner')
		{
			$alphaSearchFieldBy = 'f_name';
			$alphaSearchtable = $tablename;
			$orderbyAlphaSearch = $orderby;
		}	

		$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 AND ".$alphaSearchtable.".".$alphaSearchFieldBy." LIKE '".$_GET['alpha_serach']."%' ".$ssql." ".$groupByFieldName." order by ".$alphaSearchtable.".".$orderbyAlphaSearch." limit $start,$limit";
	}
	
	 ## condition applying for refine_search by column
	elseif(isset($_GET['refine_search']) && $_GET['refine_search']!='noValueSelected' && $_GET['refine_search']!='undefined')
	{
	     /*Refine search options as per the selected Modules*/
	   	// For Module Company/Firm on common listing
		if(isset($_GET['module']) && !empty($_GET['module']) &&  $_GET['module']=='company' &&  $_GET['rel']=='common_listing')
		{
			if($_GET['refine_search']=='mobile')
			{
				$ssql = "AND (mobile1_no LIKE '".$_GET['keyword']."%' OR  mobile2_no LIKE '".$_GET['keyword']."%')";
				
			}
			elseif($_GET['refine_search']=='address' || $_GET['refine_search']=='area' || $_GET['refine_search']=='sector')
			{
				//$ssql = "AND (pr.add_line1 LIKE '%".$_GET['keyword']."%' OR  pr.add_line2 LIKE '%".$_GET['keyword']."%'  OR  pr.add_line3 LIKE '%".$_GET['keyword']."%')";

				$ssql = $query."(add_line1 LIKE '%".$value[$i]."%' OR  add_line2_1 LIKE '%".$value[$i]."%'  OR  add_line2_2 LIKE '%".$value[$i]."%'  OR  add_line3 LIKE '%".$value[$i]."%' OR  city LIKE '%".$value[$i]."%')";
				
			}
			else
			{
				$ssql = "AND ".$_GET['refine_search']." LIKE '%".$_GET['keyword']."%'";
				
			}

			$groupby = $groupByFieldName;
		}
		// For Module Customer on common listing
		if(isset($_GET['module']) && !empty($_GET['module']) &&  $_GET['module']=='customer' && $_GET['rel']=='common_listing')
		{
			if($_GET['refine_search']=='customer_name')
			{
				$ssql = "AND CONCAT(f_name,' ',l_name) LIKE '%".$_GET['keyword']."%'";
				
			}
			elseif($_GET['refine_search']=='email')
			{
				$ssql = "AND (email1 LIKE '%".$_GET['keyword']."%' OR  email1 LIKE '%".$_GET['keyword']."%')";
				
			}
			else
			{
				$ssql = "AND ".$_GET['refine_search']." LIKE '%".$_GET['keyword']."%'";
				
			}
		}

		// For Module Owner on common listing
		if(isset($_GET['module']) && !empty($_GET['module']) &&  $_GET['module']=='owner' && $_GET['rel']=='common_listing')
		{
			if($_GET['refine_search']=='customer_name')
			{
				$ssql = "AND CONCAT(f_name,' ',l_name) LIKE '%".$_GET['keyword']."%'";
				
			}
			elseif($_GET['refine_search']=='email')
			{
				$ssql = "AND (email1 LIKE '%".$_GET['keyword']."%' OR  email1 LIKE '%".$_GET['keyword']."%')";
				
			}
			else
			{
				$ssql = "AND ".$_GET['refine_search']." LIKE '%".$_GET['keyword']."%'";
				
			}
		}

		$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 ".$ssql." ".$groupby." order by ".$tablename.".".$orderby." limit $start,$limit";

	}
	/* Condition added for sorting over Cutomer name*/
	elseif($module=='customer' &&  (preg_match('/CONCAT/',$_GET['sort_option']) || preg_match('/concat/',$_GET['sort_option'])))
	{
		$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 ".$ssql." ".$groupby." order by ".$orderby." limit $start,$limit";
	}
	/* cheking for landing page of owner module*/
	elseif($module=='owner' && !isset($_GET['alpha_serach']) && !isset($_GET['refine_search']))
	{
		$groupby = $groupByFieldName;
		$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 ".$ssql." ".$groupby." order by ".$orderby." limit $start,$limit";

	}
	elseif($module=='company')
	{
		// Checking if sort option is slected
		if(isset($_GET['sort_option']) && !empty($_GET['sort_option']))
		{
			if( (preg_match('/CONCAT/',$_GET['sort_option']) || preg_match('/concat/',$_GET['sort_option'])))
			{
				$orderByTablename ='';
			}
			if( (preg_match('/DATE_FORMAT/',$_GET['sort_option']) || preg_match('/date_format/',$_GET['sort_option'])))
			{
				$orderByTablename ='';
			}
			elseif($_GET['sort_option'] != 'company_name')
			{
				$orderByTablename = $foRrunTimeTableName.".";
			}			
			else
			{
				$orderByTablename = $tablename.".";
			}

			$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 ".$ssql." ".$groupby." order by ".$orderByTablename."".$orderby."  limit $start,$limit";
			
		}
		else
		{
			$orderByTablename = $foRrunTimeTableName.".";
			$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 ".$ssql." ".$groupByFieldName." order by ".$orderByTablename."".$orderby." DESC limit $start,$limit";
		}

	}
	// intial loading page company listing
	else
	{      
		
			$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 ".$ssql." ".$groupby." order by ".$tablename.".".$orderby." limit $start,$limit";
	}
	
}
 //echo"<pre>";print_r($_GET);
// echo"<br>".$final_query; //exit;
  $result_arr = am_select($final_query);
  $status_array = am_enum_select($tablename, 'status');
//  my_print_r($status_array);exit;
?> 