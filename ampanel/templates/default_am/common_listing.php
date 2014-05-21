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

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="<?php echo HTTP_ROOT_HOME; ?>css/main.css" />
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

/* File included for delete listing from selected module */
require_once("delete_listing.php");

/* File included for updating status from selected module */
require_once("status_update.php");

/* File included for setting parameters for Sorting data list selected module */
require_once("sort_listing.php");

/* File included for call log module */
require_once("call_log.php");

/* File included for showing number of records as listed and setting record per page value also */
require_once("listing_count.php");

/* File included for showing pagination */
include(DIR_AM_INCLUDES."/pagination.php");

/* File included for displaying required main list over page as per the selected module */
require_once("final_listing_query.php");

/* File included for displaying Alphabatical seach */
include("alphabatical_search.html");
 
/* File included for creating form for displaying list as per selected module*/
require_once("common_listing_form.php");   

/* File included for showing record per page as per selected range.*/
require_once("listing_per_page.php"); 

/* File included for contain javaScript functions related for this file*/
require_once("common_listing_js.php"); 
?>