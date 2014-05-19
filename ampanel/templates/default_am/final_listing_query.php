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
  	$final_query = "select distinct(".$tablename.".".$primaryid.") ,";
  }
  else
  {
  	$final_query = "select ".$tablename.".".$primaryid." ,";
  }
 
  //$final_query = "select ".$primaryid." ,";
  for($i=0,$ni=count($fieldarray);$i<$ni;$i++)
  {
     $final_query .= $fieldarray[$i][0].",";
  } 
  $final_query = substr($final_query,0,-1);

 ## condition applying for sorting by company name
if($module =='company' && ($_GET['sort_option'] == 'company_name'))
{
	$sortOptTable = 'broker_firm';
	$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 ".$ssql." ".$groupby." order by ".$sortOptTable.".".$orderby." limit $start,$limit";
}
else
{  
	// Condition applying for Alphabetically search
	if(isset($_GET['alpha_serach']) && $_GET['alpha_serach']!='')
	{
		//need to do dynamic searching
		$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 AND ".$tablename.".broker_name LIKE '".$_GET['alpha_serach']."%' ".$ssql." ".$groupby." order by ".$tablename.".".$orderby." limit $start,$limit";
	}
	 ## condition applying for refine_search by column
	elseif(isset($_GET['refine_search']) && $_GET['refine_search']!='noValueSelected')
	{
	   if($_GET['refine_search']=='mobile')
	   {
			$ssql = "AND (mobile1_no LIKE '".$_GET['keyword']."%' OR  mobile2_no LIKE '".$_GET['keyword']."%')";
			$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 ".$ssql." ".$groupby." order by ".$tablename.".".$orderby." limit $start,$limit";
	   }
	   elseif($_GET['refine_search']=='address')
	   {
	   		$ssql = "AND (add_line1 LIKE '%".$_GET['keyword']."%' OR  add_line2_1 LIKE '%".$_GET['keyword']."%'  OR  add_line2_2 LIKE '%".$_GET['keyword']."%'  OR  add_line3 LIKE '%".$_GET['keyword']."%')";
			$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 ".$ssql." ".$groupby." order by ".$tablename.".".$orderby." limit $start,$limit";
	   }
	   else
	   {
			$ssql = "AND ".$_GET['refine_search']." LIKE '%".$_GET['keyword']."%'";
			$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 ".$ssql." ".$groupby." order by ".$tablename.".".$orderby." limit $start,$limit";
	   }

	}
	else
	{
		$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".is_active =1 ".$ssql." ".$groupby." order by ".$tablename.".".$orderby." limit $start,$limit";
	}
	
}
 //echo"<pre>";print_r($_GET);
 //echo"<br>".$final_query;
  $result_arr = am_select($final_query);
//my_print_r($result_arr); exit;
   //echo $final_query;exit;	
	//$list_res = mysql_query($final_que) or die(mysql_error());
	//print_r($result_arr);
  $status_array = am_enum_select($tablename, 'status');
//  my_print_r($status_array);exit;
?> 