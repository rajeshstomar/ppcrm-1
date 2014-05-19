<?php
//include("../dbconfig.php");
$arr=array('Pending','Approved','Rejected','Expired');

$modulearray = get_fieldarray();
$module= $_REQUEST['module'];

$targetpage = "index.php?rel=event_list";

$tablename = $modulearray[$module]['tablename'];
$primaryid = $modulearray[$module]['primaryid'];
$secondid = $modulearray[$module]['secondid'];
$leftjoin = $modulearray[$module]['leftjoin'];
//echo $secondid;
$editlink = $modulearray[$module]['editlink'];
$detaillink = $modulearray[$module]['detaillink'];
$shareslink = $modulearray[$module]['shareslink'];
$rellink = $_REQUEST['rellink'];
if($tablename == "")
{
	am_goto_page("index.php");
}

$_GET['sort_option'] = stripslashes($_GET['sort_option']);
$_GET['search_option'] = stripslashes($_GET['search_option']);

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

if($_POST['mode'] == "Delete")
{
//  my_print_r($_POST);exit;
	$ids =  @implode(",",$_POST['chk']);
	if($ids != "")
	{
		$sql = "delete from ".$tablename." where ".$primaryid." in (".$ids.") "; 
		am_query($sql);
		$msg = "Record(s) Deleted Successfully";
		am_goto_page($alllink."&msg=".$msg);
	}
	exit;
}

if(in_array($_POST['mode'],$arr))
{
//  my_print_r($_POST);exit;
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
		$groupby = $modulearray[$module]['groupby'];		
		$sort_image = "";
		$sortoption = "";
	}
	else
	{
		$orderby = $_GET['sort_option'];
	}

	if($_GET['search_option'] != "" && $_GET['keyword'] != "")
	{
		$ssql .= " and ".$_GET['search_option']." like '%".addslashes(addslashes($_GET['keyword']))."%' ";	
	}
	$orderby = $orderby." ".$sortoption;
	/*if($groupby!="") //for registry count
	{
		$query = "select 
count(DISTINCT batch_id) as tot from ".$tablename." where company_id=".$_REQUEST['id']." ".$ssql." group by ".$groupby." order by ".$orderby;
	}
	else
	{*/
		$query = "select count(".$primaryid.") as tot from ".$tablename." where 1=1 ".$ssql;
	/*}	
	/*
	$q = "select id,name,date1,description from event_master order by date1";
	$res = mysql_query($q) or die(mysql_error());
	$list_res_temp = mysql_query($q) or die(mysql_error());
	$total = mysql_num_rows($list_res_temp);
	*/
	//echo $query;
	$tot_arr = am_select($query);
/*	$no_rec=array_sum($tot_arr['tot']);
	echo ($no_rec);	*/
	$fieldarray = $modulearray[$module]['fieldarr'];
	//my_print_R($fieldarray);exit;
	
		$total = $tot_arr[0]['tot']; 
		
	$show = 10;

	/* code by mitesh */
	include(DIR_AM_INCLUDES."/pagination.php");

	/* end code */
	

?>
<div align="center" style="width:80%; margin-bottom:5px;"><font color="#FF0000"><?php print $msg; ?></font></div>

<?php

if($secondid!="")
{   
  $final_query = "select ".$primaryid." ,".$secondid." ,";
}
else
{
  $final_query = "select ".$primaryid." ,";
}
  for($i=0,$ni=count($fieldarray);$i<$ni;$i++)
  {
     $final_query .= $fieldarray[$i][0].",";
  } 
  $final_query = substr($final_query,0,-1);

if($_GET['module']=="shares" && isset($_REQUEST['id']))
{
  $sql="SELECT fname,lname FROM member_details WHERE mem_id=".$_REQUEST['id'];
  $result_name = am_select($sql);
  $final_query = $final_query ." from ".$tablename." WHERE investor_id=".$_REQUEST['id']." ".$ssql." order by ".$orderby." limit $start,$limit";
}
else if($_GET['module']=="cshares" && isset($_REQUEST['id']))
{
  $sql="SELECT company_name FROM company_details WHERE company_id=".$_REQUEST['id'];
  $result_name = am_select($sql);
  $final_query = $final_query ." from ".$tablename." WHERE company_id=".$_REQUEST['id']." ".$ssql." order by ".$orderby." limit $start,$limit";
	
}
else if($_GET['module']=="registry" && isset($_REQUEST['id']))
{
 // $sql="SELECT company_name FROM company_details WHERE company_id=".$_REQUEST['id'];
 // $result_name = am_select($sql);
  $final_query = $final_query ." from ".$tablename." WHERE company_id=".$_REQUEST['id']." ".$ssql." group by ".$groupby." order by ".$orderby." limit $start,$limit";
	
}
else if($_GET['module']=="post" && isset($_REQUEST['filter']))
{
if($_REQUEST['filter']!="Pending")
  $final_query = $final_query ." from ".$tablename." WHERE trans_type='".$_REQUEST['filter']."' ".$ssql." order by ".$orderby." limit $start,$limit";
else
  $final_query = $final_query ." from ".$tablename." WHERE trans_status='".$_REQUEST['filter']."' ".$ssql." order by ".$orderby." limit $start,$limit";
//echo $final_query;
}
else
{
if($leftjoin!="")
{
	if($rellink=="post")
		{
			$final_query = $final_query ." from ".$tablename." ".$leftjoin." where i.for_trans_id = '".$_REQUEST['for_id']."' ".$ssql." order by ".$orderby." limit $start,$limit";	   
		}
	   	else
		{
			$final_query = $final_query ." from ".$tablename." ".$leftjoin." where 1=1 ".$ssql." order by ".$orderby." limit $start,$limit";	   
		}
 // $final_query = $final_query;
	//echo $final_query;
}	
else
{
		
	if($groupby!="")
	{
		$final_query = $final_query ." from ".$tablename." where 1=1 ".$ssql." group by ".$groupby." order by ".$orderby." limit $start,$limit";
	}
	else
	{
		$final_query = $final_query ." from ".$tablename." where 1=1 ".$ssql." order by ".$orderby." limit $start,$limit";
		
	}
}
}
//echo $final_query;
  $result_arr = am_select($final_query);
//my_print_r($fieldarray);
  //echo $final_query;exit;	
	//$list_res = mysql_query($final_que) or die(mysql_error());

  $status_array = am_enum_select($tablename, 'status');
//  my_print_r($status_array);exit;
?>             
<form name="frmlist" id="frmlist" method="post" action="">
<input type="hidden" name="mode" id="mode" value="">
<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">
<input type="hidden" name="module" id="module" value="<?=$module;?>">
<table width="100%" border="0" cellspacing="2" cellpadding="5">
<?if($_GET['msg'] != "") {?>
<tr>
	<td align="center" colspan="7" ><font color="#7f951d"><?=$_GET['msg'];?></font></td>
</tr>
<? } ?>
<?php
if($_REQUEST['module']=="registry")
{
	echo "<b>Company Name : ".am_get_company_name1($_REQUEST['id'])."</b>";
}
?>
<? if($modulearray[$module]['addlink'] != ""){ ?>
  <tr>
  <td colspan="8"><input value="Add New" name="addnew" id="addnew" onclick="javascript:window.location='<?=$modulearray[$module]['addlink'];?>';"  type="button"></td>
  </tr>
<? } ?>
  <tr>
	<td colspan="8">
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
	<input value="Apply" name="doaction1" id="doaction1" onclick="return doaction();"  type="button">
	</td> 
	<td>
	<?php if($_REQUEST['module']=="post")
	{
 	?>	<b>&nbsp;|&nbsp;</b>
		<input value="Pending"  type="button" name="show1" id="show" onclick="showdata(show1);" >
		<input value="Sell"  type="button" name="show2" id="show" onclick="showdata(show2);" >
		<input value="Buy"  type="button" name="show3" id="show" onclick="showdata(show3);" ><b>&nbsp;|&nbsp;</b>
	<?php } ?>
	</td>
	<td align="right" >

	
	<select name="search_option" id="search_option" style="min-width:120px;" >
	<?
	for($i=0,$ni=count($fieldarray);$i<$ni;$i++)
        {    
	   if($_GET['search_option'] == $fieldarray[$i][0])
		   $selected = "selected";
	   else 
		   $selected = "";
	   if(trim($fieldarray[$i][4]) == "Y")
	           echo "<option ".$selected." value=\"".$fieldarray[$i][0]."\">".$fieldarray[$i][1]."</option>"; 		  
        }
	?>
	</select>&nbsp;
	<input id="keyword" size="10" name="keyword" onkeypress="return checkcode(event);" value="<?=am_display($_GET['keyword']);?>" type="text">
	<input value="Search"  type="button" onclick="searchrec();" >
	
	</td>
	</tr>
	</table>
	</td>
  </tr>
  <tr><td colspan="5"><b>
	<?php
	if($_GET['module']=="shares")
	{
		echo "Details of Post For Buy / Sell Shares - ".ucfirst($result_name[0]['fname'])." ".ucfirst($result_name[0]['lname']);
	}
	else if($_GET['module']=="cshares")
	{
		echo "Details of Post For Buy / Sell Shares - ".ucfirst($result_name[0]['company_name']);
	}
	?></b>
  </td></tr>
  <tr>
    <th scope="col"  class="black11_bold"><div align='left'><input name='checkall' id='checkall' type='checkbox'></div></th>
    <?php
    for($i=0,$ni=count($fieldarray);$i<$ni;$i++)
    {    
	if($fieldarray[$i][0] !=  $_GET['sort_option'])
	{
		$show_sort_image = "";
	}
	else
	{
		$show_sort_image = $sort_image;
	}
	     if($fieldarray[$i][6] == "N")
	     {
          echo "<th scope='col' width='".$fieldarray[$i][3]."%' class='black11_bold'><div align='".$fieldarray[$i][2]."'>".$fieldarray[$i][1].$show_sort_image."</div></th>";
       }
       else
       {
          echo "<th scope='col' width='".$fieldarray[$i][3]."%' class='black11_bold'><div align='". $fieldarray[$i][2]."'><a href=\"".$sortlink."&sort_option=".$fieldarray[$i][0]."&sort=".$sort."\">".$fieldarray[$i][1]."</a>".$show_sort_image."</div></th>";
       }       
           
    } 
    ?>

  </tr>
  <?php
	//print_r($result_arr);exit;
    for($j=0,$nj=count($result_arr);$j<$nj;$j++)
    {    
        echo "<tr><td class='black11' width='5%' ><input id='chkme' name='chk[]' value='".$result_arr[$j][$primaryid]."' type='checkbox'></td>";
        for($i=0,$ni=count($fieldarray);$i<$ni;$i++)
        { 
	//	my_print_r($fieldarray);
		$exparr = @explode(".",$fieldarray[$i][0]);
		if(count($exparr)==2)
		{
			$fieldarray[$i][0] = $exparr[1];
		}
	
		if($fieldarray[$i][5] != "")
		{
			$val = call_user_func($fieldarray[$i][5] , $result_arr[$j][$fieldarray[$i][0]]);
			
			
		}
		else
		{
			$val = $result_arr[$j][$fieldarray[$i][0]];
		}
		/*
	   if(trim($fieldarray[$i][5]) != "")
	           echo "<td class='black11' align='".$fieldarray[$i][2]."'><a href='".$fieldarray[$i][6].$result_arr[$j][$primaryid]."' >".$result_arr[$j][$fieldarray[$i][0]]."</a></td>";    
	   else
		*/
	           echo "<td class='black11' align='".$fieldarray[$i][2]."'>".$val."</td>";    		  
        }    
	if($editlink!="")
	{
		if($_REQUEST['module']=="nominee")
		{
		        echo "<td class='black11' nowrap width='5%' ><a href='".$editlink.$result_arr[$j][$primaryid]."' >View</a>";
		}
		else if($_REQUEST['module']=="docs")
		{
		        echo "<td class='black11' nowrap width='5%' ><a href='".$editlink.$result_arr[$j][$primaryid]."' >Manage Docs</a>";
		}
		else
		{
			echo "<td class='black11' nowrap width='5%' ><a href='".$editlink.$result_arr[$j][$primaryid]."' >Edit</a>";
		}
	}        
	if($_GET['module']=="investor" || $_GET['module']=="company")
	{
		echo "<td class='black11' nowrap width='5%' ><a href='".$shareslink.$result_arr[$j][$secondid]."' >Shares Transaction</a>";
	}
	if($_GET['module']=="company")
	{
		echo "<td class='black11' nowrap width='5%' ><a href='index.php?rel=common_listing&module=registry&id=".$result_arr[$j][$primaryid]."' >View Registry</a>";
	}
	if($_GET['module']=="post")
	{
		echo "<td class='black11' nowrap width='5%' ><a href='index.php?rel=".$detaillink.$result_arr[$j][$primaryid]."' >View Details</a>";
	}
        echo "</td>";
        echo "</tr>"; 
    } 
    ?>
<? if(count($result_arr) == 0) {?>
<tr>
	<td align="center" colspan="7" height="70" style="color:red;" >No records found</td>
</tr>
<? } else {
if($_GET['module']!="registry")
{
?>

<tr><td colspan="2" ><?=$total_pages.' Records';?></td><td colspan="5" align="right" ><?=$paginate;?></td></tr>
<? } } ?>
</table>
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
	$("#frmlist").submit();
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
	var serchurl = targetpage+'&keyword='+keyword+'&search_option='+search_option;

	window.location = serchurl;
}
function showdata(e)
{
	var keyword = $(e).val();
	/*	
	if(keyword == "")
	{
		alert("Please Enter Keyword");
		return false;
	}
	*/
	//var search_option = $("#search_option").val();
	var serchurl = targetpage+'&filter='+keyword;
	
	//alert(serchurl);
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
</script>
