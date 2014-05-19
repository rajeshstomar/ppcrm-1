<?php
//include("../dbconfig.php");
//print_R($_SESSION); exit;
//echo"<pre>";print_r($_GET);print_r($_POST);
## Getting field list as Array from am_function.php file as pre defined.
$modulearray = get_fieldarray();
//echo"<pre>";print_r($modulearray);
$module= $_REQUEST['module'];
$fieldarray = $modulearray[$module]['fieldarr'];

//echo"<pre>";print_r($fieldarray); exit;

$targetpage = "index.php?rel=event_list";

$tablename = $modulearray[$module]['tablename'];
$lastfield = $modulearray[$module]['lastfield'];

$primaryid = $modulearray[$module]['primaryid'];
$editlink = $modulearray[$module]['editlink'];
$leftjoin = $modulearray[$module]['leftjoin'];

//echo"<pre>";print_r($tablename); exit;
//echo"<pre>";print_r($lastfield); exit;

//echo"<pre>";print_r($primaryid); exit;
//echo"<pre>";print_r($leftjoin); exit;


if($tablename == "")
{
	am_goto_page("index.php");
}

$_GET['sort_option'] = stripslashes($_GET['sort_option']);
$_GET['search_option'] = stripslashes($_GET['search_option']);
$groupby = "";
// For Auto Populate in search - Start

//echo $_GET['sort_option'];
//echo $_GET['search_option'];
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<?
// For Auto Populate in search - Ends
// For Search
$cols = array();
for($i=0,$ni=count($fieldarray);$i<$ni;$i++)
{    
   if(trim($fieldarray[$i][4]) == "Y")
   {
   	if (preg_match('/CONCAT/',$fieldarray[$i][0]) || preg_match('/concat/',$fieldarray[$i][0]))
   	{
   		$new = getStrBet($fieldarray[$i][0],"(",")");
   		$new_st = @explode(',',$new);
   		$cols[] = $new_st[0];
   		$cols[] = $new_st[2];
   	}
   	else
   	{
   		$cols[] = $fieldarray[$i][0];
   	}
   }
}
//print_R($cols);
$columns = @implode(',',$cols);
//echo $columns;
// For Search - Ends

foreach($_GET as $key=>$value)
{
	if($key == "msg")
	{
     		continue;
	}     
	if($key != "page")
	{
     		$query_string .= "&".$key."=".$value; 
	}     
	if($key != "sort_option")
	{
     		$sort_string .= "&".$key."=".$value; 
	}
	$all_string .= "&".$key."=".$value; 
}
$targetpage = "index.php?".$query_string;
$sortlink = "index.php?".$sort_string;
$alllink = "index.php?".$all_string;

//echo $targetpage;
//echo"<pre>";print_r($targetpage); exit;
//echo"<pre>";print_r($sortlink); exit;
//echo"<pre>";print_r($alllink); exit;



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
				$sql = "delete from ".$tablename." where ".$primaryid." in (".$ids.") "; 
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
				$sql = "delete from ".$tablename." where ".$primaryid." in (".$ids.") "; 
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
				$sql = "delete from ".$tablename." where ".$primaryid." in (".$ids.") "; 
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
				$sql = "delete from ".$tablename." where ".$primaryid." in (".$ids.") "; 
				am_query($sql);
				$msg = "Record(s) Deleted Successfully";
				am_goto_page($alllink."&msg=".$msg);
			}
			exit;
		
	}
	
	
	
	
	 
	
	
}

if($_POST['mode'] == "Active" || $_POST['mode'] == "Inactive")
{
    //my_print_r($_POST);exit;
	$ids =  @implode(",",$_POST['chk']);
	if($ids != "")
	{
		$sql = "update ".$tablename." set status='".$_POST['mode']."' where ".$primaryid." in (".$ids.") "; 
		am_query($sql);
		$msg = "Record(s) status changed Successfully";
		am_goto_page($alllink."&msg=".$msg);
	}
}

	$ssql = "";
	$sort = $_GET['sort'];
	
	if($sort == "1")
	{
		$sortoption = " DESC ";
		$sort = 0;
		$sort_image = "&nbsp;<img src='images/arrowdown.gif' border='0'> ";
	}
	else
	{
		$sortoption = " ASC ";
		$sort = 1;
		$sort_image = "&nbsp;<img src='images/arrowup.gif' border='0'> ";
	}

	if($_GET['sort_option'] == "")
	{
		$orderby = $modulearray[$module]['orderby'];
		$sort_image = "";
		$sortoption = "";
	}
	else
	{
		$orderby = $_GET['sort_option'];
	}

	if($_GET['search_option'] != "" && $_GET['keyword'] != "")
	{
		$cols = explode(',',$columns);
		
		if($module == 'company')
		{
			$cols[] = "broker_name";
			$cols[] = "mobile1_no";
			$cols[] = "pan_card_num";
			$cols[] = "broker_id";
			$cols[] = "email";
		}
		if($module == 'interaction_report')
		{
			$cols[] = "broker_name";
			
		}	
	
	
		$sql_or = array(); 
		$sql_alpha = array(); /*sort alpha */
		for($k=0; $k<count($cols); $k++)
		{
			if($module == 'company' && ($cols[$k] == 'broker_name' || $cols[$k] == 'mobile1_no' || $cols[$k] == 'pan_card_num' || $cols[$k] == 'broker_id' || $cols[$k] == 'email'))
			{
					$col = "broker.".$cols[$k];
			}
			else if( ($module == "customer"|| $module == "owner" ) && ( $cols[$k]=="f_name" || $cols[$k]=="l_name"))
			{
				$col = ' CONCAT(f_name," ",l_name) ';
			}
			else
			{
				$col = $cols[$k];
			}
			$sql_or[] = " ".$col." LIKE '%".addslashes(addslashes($_GET['keyword']))."%' ";
			//print_R($sql_or); 
			//$sql_or[] = " ".$col." LIKE '%".addslashes(addslashes($_GET['keyword']))."%' ";
		}
		$newsql = "( ".implode(" OR", $sql_or)." ) ";
		$ssql .= "and ". $newsql ;
		//$ssql .= " and ".$_GET['search_option']." like '%".addslashes(addslashes($_GET['keyword']))."%' ";	

	}
  if($module == 'broker' && isset($_REQUEST['firm_id']))
  {
   $ssql .= " AND firm_id = '".$_REQUEST['firm_id']."' ";
   $modulearray[$module]['addlink'] = $modulearray[$module]['addlink']."&firm_id=".$_REQUEST['firm_id'];
  }
  if($module == 'property' && isset($_REQUEST['customer_id']))
  {
   $ssql .= " AND client_property_id = '".$_REQUEST['customer_id']."' ";
   $modulearray[$module]['addlink'] = $modulearray[$module]['addlink']."&customer_id=".$_REQUEST['customer_id'];
  }
   if($module == 'owner_property' && isset($_REQUEST['customer_id']))
  {
   $ssql .= " AND broker_owner_id = '".$_REQUEST['customer_id']."' AND flag='owner' ";
   $modulearray[$module]['addlink'] = $modulearray[$module]['addlink']."&owner_id=".$_REQUEST['customer_id'];
  }
   if($module == 'broker_property' && isset($_REQUEST['broker_id']))
  {
   $ssql .= " AND broker_owner_id = '".$_REQUEST['broker_id']."' AND flag!='owner' ";
   $modulearray[$module]['addlink'] = $modulearray[$module]['addlink']."&owner_id=".$_REQUEST['customer_id'];
  }
  
  if($module == 'short_list')
  {
	   if($_SESSION['admin_level'] == 1)
	   	$ssql .= " AND active = 1";
	   else
	   	$ssql .= " AND active = 1 AND pp_executive_id=".$_SESSION['user_id'];
   
  }
  if($module == 'call_log' || $module == 'other_call_log')
  {
  	if($_SESSION['admin_level'] != 1)
	   	$ssql .= " AND pp_executive_id=".$_SESSION['user_id'];
	   	
  	if($_REQUEST['user_is'] != '' && $_REQUEST['id'] != '')
    	{
    		$ssql .= " AND id_broker_customer=".$_REQUEST['id']." AND user_is='".$_REQUEST['user_is']."' ";
    	}
    	else if($_REQUEST['id_customer'] !='' && $_REQUEST['shortlist_id'] !='')
    	{
    		$ssql .= " AND id_broker_customer=".$_REQUEST['id_customer']." AND user_is='customer' AND shortlist_id=".$_REQUEST['shortlist_id']." AND is_shortlisted='yes'";
    	}
    	
    	if($module == 'call_log')
    	{
    		if(isset($_REQUEST['id_bc']) && isset($_REQUEST['user']) && isset($_REQUEST['date']) )
    		{
    			$ssql .= " AND next_call_date ='".$_REQUEST['date']."' AND id_broker_customer ='".$_REQUEST['id_bc']."' AND user_is ='".$_REQUEST['user']."'";
    		}
    		else
    		{
    			$groupby .= " GROUP BY id_broker_customer,next_call_date,user_is";
    		}
    		$ssql .= " AND is_shortlisted = 'yes'" ;
    	}
  }
  
	
	$orderby = $orderby." ".$sortoption;
## Getting count of the records as per Module
	if($module == 'owner')
  {
	$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND pr.flag ='owner' ".$ssql." ".$groupby;
   }
   else
   {
   	// Condition applying for Alphabetically search
    if(isset($_GET['alpha_serach']) && $_GET['alpha_serach']!='')
	{
		$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".broker_name LIKE '".$_GET['alpha_serach']."%'  ".$ssql." ".$groupby;
	}
	// Condition applying for refine search by specific columns
	elseif(isset($_GET['refine_search']) && $_GET['refine_search']!='noValueSelected')
	{
	   if($_GET['refine_search']=='mobile')
	   {
		$ssql = "AND (mobile1_no = ".$_GET['keyword']." OR  mobile2_no =".$_GET['keyword'].")";
		$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1  ".$ssql." ".$groupby;
	   }
	   elseif($_GET['refine_search']=='address')
	   {
		$ssql = "AND (add_line1 LIKE '%".$_GET['keyword']."%' OR  add_line2_1 LIKE '%".$_GET['keyword']."%'  OR  add_line2_2 LIKE '%".$_GET['keyword']."%'  OR  add_line3 LIKE '%".$_GET['keyword']."%')";
		$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1  ".$ssql." ".$groupby;
	   }
	   else
	   {
			$ssql = "AND ".$_GET['refine_search']." LIKE '%".$_GET['keyword']."%'";
			$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1  ".$ssql." ".$groupby;
	   }

	}
	else
	{
		$query = "select count(distinct(".$tablename.".".$primaryid.")) as tot from ".$tablename." ".$leftjoin." where 1=1  ".$ssql." ".$groupby;
	}
   
   }	

	$tot_arr = am_select($query);
	$fieldarray = $modulearray[$module]['fieldarr'];
	//print_R($fieldarray);exit;
	if($module == 'call_log')
  		$total = count($tot_arr); 
  	else
		$total = $tot_arr[0]['tot']; 
	
	//$total = $tot_arr[0]['tot']; 
	// Changed for listing of records per page // vikas.
 $show =(isset($_REQUEST['show_max_row']) && $_REQUEST['show_max_row']!='')?$_REQUEST['show_max_row']:25;
	
	/* code by mitesh */
	include(DIR_AM_INCLUDES."/pagination.php");

	/* end code */
?>
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
	$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 ".$ssql." ".$groupby." order by ".$sortOptTable.".".$orderby." limit $start,$limit";
}
else
{  
	// Condition applying for Alphabetically search
	if(isset($_GET['alpha_serach']) && $_GET['alpha_serach']!='')
	{
		//need to do dynamic searching
		$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 AND ".$tablename.".broker_name LIKE '".$_GET['alpha_serach']."%' ".$ssql." ".$groupby." order by ".$tablename.".".$orderby." limit $start,$limit";
	}
	 ## condition applying for refine_search by column
	elseif(isset($_GET['refine_search']) && $_GET['refine_search']!='noValueSelected')
	{
	   if($_GET['refine_search']=='mobile')
	   {
			$ssql = "AND (mobile1_no LIKE '".$_GET['keyword']."%' OR  mobile2_no LIKE '".$_GET['keyword']."%')";
			$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 ".$ssql." ".$groupby." order by ".$tablename.".".$orderby." limit $start,$limit";
	   }
	   elseif($_GET['refine_search']=='address')
	   {
	   		$ssql = "AND (add_line1 LIKE '%".$_GET['keyword']."%' OR  add_line2_1 LIKE '%".$_GET['keyword']."%'  OR  add_line2_2 LIKE '%".$_GET['keyword']."%'  OR  add_line3 LIKE '%".$_GET['keyword']."%')";
			$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 ".$ssql." ".$groupby." order by ".$tablename.".".$orderby." limit $start,$limit";
	   }
	   else
	   {
			$ssql = "AND ".$_GET['refine_search']." LIKE '%".$_GET['keyword']."%'";
			$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 ".$ssql." ".$groupby." order by ".$tablename.".".$orderby." limit $start,$limit";
	   }

	}
	else
	{
		$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 ".$ssql." ".$groupby." order by ".$tablename.".".$orderby." limit $start,$limit";
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

 <?php include("example.html");?>
 
            
<form name="frmlist" id="frmlist" method="post" action="">
<input type="hidden" name="mode" id="mode" value="">
<input type="hidden" name="module" id="module" value="<?=$module;?>">
<div id="adv_search" style="display:none;"><a href="#" onClick="show_id('show_adv_search_a');$(this).hide();"></div>
<table width="100%" border="0" cellspacing="2" cellpadding="5">

<?php if($_GET['module'] == 'company') { ?>
   
  <td colspan="8"><h2>Firm's Broker Details</h2></td>
  
  
   <?php } else if($_GET['module'] == 'broker')  { ?>
    <td colspan="8"><h2>Details Of Member Broker For <?php echo get_firm_name($_GET['firm_id']); ?> </h2></td>
    <?php } else if($_GET['module'] == 'customer')  { 
    
    ?>
     <td colspan="8"><h2 style="margin:5px 0;">Customer Details</h2></td>
       <?php } else if($_GET['module'] == 'owner_property')  { ?>
     <td colspan="8"><h2>Owner Property Listing</h2>
     <?php include("customer_detail.php");?>
     </td>
     
      <?php } else if($_GET['module'] == 'broker_property')  { ?>
     <td colspan="8"><h2>Broker Property Listing</h2>
     <?php include("broker_detail.php");?>
     </td>
     
     
       <?php } else if($_GET['module'] == 'property')  { 
   ?>
	
     <td colspan="8"><h2 style="margin:5px 0;">Customer Requirement List</h2>
	<?php include("customer_detail.php");?>
     </td>
       <?php } else if($_GET['module'] == 'outlet_location')  { ?>
     <td colspan="8"><h2>Outlet Location</h2></td>
     
     
    <?php } else if($_GET['module'] == 'owner')  { ?>
     <td colspan="8"><h2>Owner Listing</h2></td>
    <?php } else if($_GET['module'] == 'site_visit_report')  { ?>
    <td colspan="8"><h2>Site Visit Report Listing</h2></td>
    <?php } else if($_GET['module'] == 'interaction_report')  { ?>
    <td colspan="8"><h2>Report Listing</h2></td>
    <?php } else if($_GET['module'] == 'call_log' && $_REQUEST['shortlist_id'] != '')  { ?>
     <td colspan="8">
     <?php include("property_detail.php");?>
     </td>
    <?php } ?>
    


<?if($_GET['msg'] != "") {?>
<tr>
	<td align="center" colspan="7" style="color:red;" ><?=$_GET['msg'];?></td>
</tr>
<? } ?>
<? if($modulearray[$module]['addlink'] != ""){ ?>
  <tr>
  
  <?php if($_GET['module'] == 'company') { ?>
 
  <td colspan="4"><input value="Add New Firm" name="addnew" id="addnew" onclick="javascript:window.location='<?=$modulearray[$module]['addlink'];?>';"  type="button"></td>
  <td colspan="4"><a href="#" id="show_adv_search_a" onClick="show_id('adv_search');$(this).hide();">Go to Advanced Search</a></td>
  
  <?php } else if($_GET['module'] == 'broker')  { ?>
    <td colspan="8"><input value="Add New Broker" name="addnew" id="addnew" onclick="javascript:window.location='<?=$modulearray[$module]['addlink'];?>';"  type="button"></td>
   <?php } else if($_GET['module'] == 'customer')  { ?>
    <td colspan="8"><input value="Add New Customer" name="addnew" id="addnew" onclick="javascript:window.location='<?=$modulearray[$module]['addlink'];?>';"  type="button"></td>
    <?php } else if($_GET['module'] == 'owner')  { ?>
    <td colspan="8"><input value="Add New Owner" name="addnew" id="addnew" onclick="javascript:window.location='<?=$modulearray[$module]['addlink'];?>';"  type="button"></td>
    <?php } else if($_GET['module'] == 'site_visit_report')  { ?>
    <td colspan="8"><input value="Add New Report" name="addnew" id="addnew" onclick="javascript:window.location='<?=$modulearray[$module]['addlink'];?>';"  type="button"></td>
    <?php } else if($_GET['module'] == 'interaction_report')  { ?>
    <td colspan="8"><input value="Add New Property" name="addnew" id="addnew" onclick="javascript:window.location='<?=$modulearray[$module]['addlink'];?>';"  type="button"></td>
    <?php } else if($_GET['module'] == 'property')  { ?>
    <td colspan="8"><a href="index.php?&rel=edit_property&customer_id=<?php echo $_GET['customer_id']; ?>"><input value="Add New Property" name="addnew" id="addnew" type="button"></td>
    

<?php } else if($_GET['module'] == 'broker_property')  { ?>
    <td colspan="8"><a href="index.php?&rel=edit_property&customer_id=<?php echo $_GET['customer_id']; ?>"></td>
    

<?php } else if($module == 'call_log' || $module == 'other_call_log' )  { 
	if($_REQUEST['shortlist_id'] != '')
	{
		if(isset($_REQUEST['id_customer']))
			$cust_id = $_REQUEST['id_customer'];
		else
			$cust_id = $_REQUEST['id_bc'];
		$addlink = "index.php?rel=edit_call_log&customer_id=".$cust_id."&shortlist_id=".$_REQUEST['shortlist_id'];
	}
	else
	{
		$addlink = $modulearray[$module]['addlink'];
	}
	if( ($module == 'call_log' && ( isset($_REQUEST['id_bc'])|| isset($_REQUEST['shortlist_id']))) || $module == 'other_call_log' )
	{
?>
	<td colspan="8"><input value="Add New Call Log" name="addnew" id="addnew" onclick="javascript:window.location='<?php echo $addlink; ?>';"  type="button"></td>
    
  <?php } } else { ?>
    <td colspan="8"><input value="Add New" name="addnew" id="addnew" onclick="javascript:window.location='<?=$modulearray[$module]['addlink'];?>';"  type="button"></td>
  
  <?php } ?>
  
  </tr>
<? } ?>
  
  <tr>
	<td colspan="10">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td>
	<select name="action" id="action">
	<option value="" >Bulk Actions</option>
        <? for($j=0,$nj=count($status_array);$j<$nj;$j++){ ?>
		<option value="<?=$status_array[$j];?>"><?=$status_array[$j];?></option>
	<? } ?>
	<option value="Delete">Delete</option>
	</select>&nbsp;
	<input value="Apply" name="doaction1" id="doaction1" onclick="return doaction();"   type="button">
	</td>
	
	<td align="right" >
		<input id="keyword" size="50" placeholder="Search for...." name="keyword" onkeypress="return checkcode(event);" value="<?=am_display($_GET['keyword']);?>" type="text">
		<input value="Search"  type="button" onclick="searchrec();" >
	</td>
	<?php 
	// file included for refine search
		include('refine_search.php');
	 ?>
	</tr>
	</table>
	</td>
  </tr>
  <?php if($_GET['keyword'] != '') { ?>
  <tr>
  	<th  colspan="5">Search Results for: <?php echo $_GET['keyword']; ?> </th>
  </tr>	
  <?php } ?>
  
  
  <tr>
    <th scope="col"  class="black11_bold"><div align='left'><input name='checkall' id='checkall' type='checkbox'></div></th>
    <?php
    
    //print_R($fieldarray);exit;
    
    for($i=0,$ni=count($fieldarray);$i<$ni;$i++)
    {
    
        if($fieldarray[$i][5] == 'users_log' && isset($_REQUEST['id_bc']))
        	continue;
        	    
	if($fieldarray[$i][0] !=  $_GET['sort_option'])
	{
		$show_sort_image = "";
	}
	else
	{
		$show_sort_image = $sort_image;
	}
## showing the heading fields for listing data.
	if($fieldarray[$i][6] == "N")
	{
          echo "<th scope='col' width='".$fieldarray[$i][3]."%' class='black11_bold'><div align='".$fieldarray[$i][2]."'>".$fieldarray[$i][1].$show_sort_image."</div></th>";
       }
       else
       {
          echo "<th scope='col' width='".$fieldarray[$i][3]."%' class='black11_bold'><div align='". $fieldarray[$i][2]."'><a href=\"".$sortlink."&sort_option=".$fieldarray[$i][0]."&sort=".$sort."\">".$fieldarray[$i][1]."</a>".$show_sort_image."</div></th>";
       }   
      
           
           
    }
    
    if($lastfield != '')
    {
     echo "<th scope='col' width='5%' class='black11_bold'><div align='left'>".$lastfield."</div></th>"; 
     }
    ?>

  </tr>
  <?php
    for($j=0,$nj=count($result_arr);$j<$nj;$j++)
    {    
        echo "<tr><td class='black11' width='5%' ><input id='chkme' name='chk[]' value='".$result_arr[$j][$primaryid]."' type='checkbox'></td>";
        for($i=0,$ni=count($fieldarray);$i<$ni;$i++)
        { 
	//	echo"<pre>"; print_r($fieldarray);
		 if($fieldarray[$i][5] == 'users_log' && isset($_REQUEST['id_bc']))
        		continue;
		if(trim($fieldarray[$i][5]) != "")
		{
			$val = call_user_func($fieldarray[$i][5] , $result_arr[$j][$fieldarray[$i][0]]);
			
			
		}
		else
		{
			//echo"<pre>";print_r($result_arr[$j]);echo"$j====".$fieldarray[$i][0]."<br>";
			$val = $result_arr[$j][$fieldarray[$i][0]];
		}
		
	          if($module=='company' && $fieldarray[$i][0] == company_id)
	          {
	          	 echo "<td class='black11' align='".$fieldarray[$i][2]."'></td>"; 
	          }
	          else
	          {
	            echo "<td class='black11' align='".$fieldarray[$i][2]."'>".$val."</td>"; 
	          } 

        }
        if($module == 'company' || $module == 'customer'  || $module == 'interaction_report' || $module == 'site_visit_report' )
        {    
		//echo"<pre>";print_r($result_arr);
        echo "<td class='black11' nowrap width='5%' ><a href='".$editlink.$result_arr[$j]['company_id']."' >View / Edit</a>";
        }
        
        else if($module == 'property')
        {
        echo "<td class='black11' nowrap width='5%' ><a href='".$editlink.$result_arr[$j][$primaryid]."&customer_id=".$_GET['customer_id']."' >View / Edit</a>";
        }
       else if( $module == 'owner_property' )
       {
       	echo "<td class='black11' nowrap width='5%' ><a href='".$editlink.$result_arr[$j][$primaryid]."&owner_id=".$_GET['customer_id']."' >View / Edit</a>";
       } 
       else if($module == 'call_log')
	{
		if(isset($_REQUEST['id_bc']))
			echo "<td class='black11' nowrap width='5%' ><a href='".$editlink.$result_arr[$j][$primaryid]."' >Edit</a>";
	}
	else if($module == 'log')
	{
		echo "<td class='black11' nowrap width='5%' ><a href='".$editlink.$result_arr[$j][$primaryid]."' >View Detail</a>";
	}
   	else
	{
	echo "<td class='black11' nowrap width='5%' ><a href='".$editlink.$result_arr[$j][$primaryid]."' >Edit</a>";
	}
        echo "</td>";
        echo "</tr>"; 
    } 
    ?>
<? if(count($result_arr) == 0) {?>
<tr>
	<td align="center" colspan="7" height="70" style="color:red;" >No records found</td>
</tr>
<? } else {?>
<tr><td colspan="2" ><?=$total_pages.' Records';?></td><td colspan="5" align="right" ><?=$paginate;?></td></tr>

<tbody><tr><td class="navigation_separator"></td><td>
<!--<div class="save_edited hide">save_edited hide
<input type="submit" value="Save edited data"><div class="navigation_separator">|</div></div> --></td>
<td><div class="restore_column hide" style="display: none;"><input type="submit" value="Restore column order">
<div class="navigation_separator">|</div></div></td>
<td class="navigation_goto">
</td>
<td class="navigation_separator"></td></tr></tbody>
<? } ?>
</table>
</form>

<?php
/* added code for selected value for paginations */


if ($show == 25)
{
    $selectedValue25 = 'selected = selected';
}
if ($show == 50) {
    $selectedValue50 = 'selected = selected';
}
if ($show == 100)
{
    $selectedValue100 = 'selected = selected';
}
if ($show == 250 )
{	
	$selectedValue250 = 'selected = selected';
}
if ($show == 500 )
{	
	$selectedValue500 = 'selected = selected';
} 
?>
<form name="frmlist" id="numofPagevalue" method="post" action="">
<input type="hidden" name="hidediv" id="hidediv" value="<?=$total_pages;?>">
<div id="selectdiv">				
Records per page: <select class="autosubmit" id="select" name="show_max_row" onchange="doactionForlimit();">
	<option <?=$selectedValue25;?> value="25">25</option>
    <option <?=$selectedValue50;?> value="50">50</option>
	<option <?=$selectedValue100;?> value="100">100</option>
	<option <?=$selectedValue250;?> value="250">250</option>
	<option <?=$selectedValue500;?> value="500">500</option>
	</select>
</div>
</form>
<script>

var targetpage = "<?=$targetpage;?>";
$(document).ready(function()
{
	$("#checkall").click(function()				
	{
		var checked_status = this.checked;
		$("input[id=chkme]").each(function()
		{
			this.checked = checked_status;
		});
	});
	
	var norecord = document.getElementById("hidediv").value;
	
	//alert(norecord);
	
    if(norecord < 24 )
	
	   {
	   
	   $("#selectdiv").css("display","none");
	   	   
	   }
	
        
});

function doaction()
{
	var val = $("#action").val();
	if(val == "")
	{
		alert("Please Select Action");
		return false;
	}
	var flag = false;	
	$("input[id=chkme]").each(function()
	{
		if(this.checked)
		{
			flag = true;
		}
	});
	if(!flag)
	{
		alert("Please Select Records to "+val);
		return false;
	}
	$("#mode").val(val);
	var con=confirm('Are you sure you want to delete this Records?');
	
	//alert(con);
	
	
	if(con == true)
	{
		$("#frmlist").submit();
	}
	
}
function searchrec()
{
	var keyword = $("#keyword").val();
	/*	
	if(keyword == "")
	{
		alert("Please Enter Keyword");
		return false;
	}
	*/
	var search_option = $("#search_option").val();
	
	/*added for refine search */
	
	var refine_search = $("#refine_search").val();
	
	var serchurl = targetpage+'&keyword='+keyword+'&search_option='+search_option+'&refine_search='+refine_search;
	window.location = serchurl;
}
function checkcode(e)
{
	var code;
	if (!e) var e = window.event;
	if (e.keyCode) code = e.keyCode;
	else if (e.which) code = e.which;
	if(code == 13)
	{
		searchrec();
		return false;
	}
	return true;
}
$("#search_option").change(function () {
	autopopulate();
});
$( document ).ready(function() {
  	autopopulate();
});
function autopopulate()
{
	var table_name = '<?php echo $tablename; ?>';
	var vals = '<?php echo $columns; ?>';
	var url = 'search_result.php?col_name='+vals+'&table_name='+table_name;
	$( "#keyword" ).autocomplete({
		source: url,
	});
}

function doactionForlimit()
{
	$("#numofPagevalue").submit();
}



function doactionForadvsearch()

{
      //alert("vikas");
	  var keyword = $("#keyword").val();
	  alert(keyword);
      $("#advasearch").submit();

}


$("#alphaBtn_<?php echo $_GET['alpha_serach']?>").removeClass("searchAlph").addClass( "searchAlphselected" );
 /*setTimeout(function() {
      $("#alphaBtn_<?php echo $_GET['alpha_serach']?>").removeClass("searchAlph").addClass( "searchAlphselected" );
}, 100);*/

$('#refine_search option')
     .removeAttr('selected')
     .filter('[value=<?php echo trim($_GET['refine_search']);?>]')
         .attr('selected', true)
</script>
<script type="text/javascript">
var show_id = function(id){
	$("#"+id).show();
}
</script>