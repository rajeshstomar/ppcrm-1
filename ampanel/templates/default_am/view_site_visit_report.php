<?php
//include("../dbconfig.php");
$msg = $_GET['msg'];

if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
{
	$id = $_REQUEST['id'];
	
	$sel_que ="select * from site_visit_report  where visit_id= '".$id."' ";
	$report_data = am_select($sel_que);
	//my_print_R($report_data);exit;
	$mode = "Update";
}
else
{
	$mode = "Add";
}
//include(DIR_SCRIPT_ROOT."/fckeditor/fckeditor.php") ; 

$build="select id_building,b_name,b_near_road,b_street_name,b_location_landmark,b_city from building_database";
$build_data = am_select($build);

//print_R($build_data);exit;
$build_array = array();

for($i=0;$i<count($build_data);$i++)
{
	
	$build_array[]='{'.'"label":"'.$build_data[$i]['b_name'].'","val":"'.$build_data[$i]['b_city'].'|'.$build_data[$i]['id_building'].'|'.$build_data[$i]['b_near_road'].'|'.$build_data[$i]['b_street_name'].'|'.$build_data[$i]['b_location_landmark'].'"'.'}';
}

 $cnt = '['.implode(',',$build_array).']';

//echo $cnt;exit;

?>


<script language="JavaScript" type="text/javascript">
function showhidediv(){

	if (document.getElementById('sell').checked)
	{
	
	document.getElementById('property_div').style.display = 'none';
	}
	else
	{
	document.getElementById('property_div').style.display = 'block';
	}
	


}
</script>

<link rel="stylesheet" href="<?php echo HTTP_ROOT_HOME; ?>css/jquery-ui.css">
  
  <script src="<?php echo HTTP_ROOT_HOME; ?>js/jquery-ui.js"></script>
  
 
  
  <script>
  $(function() {
    var availableTags = <?php echo $cnt; ?>;
    $( "#nearest_building" ).autocomplete({
      source: availableTags,
      
      select: function(event, ui) {
                var selectedObj = ui.item;
		var tmp1 = selectedObj.val.split("|");
		$("#city").val(tmp1[0]); 
		$("#near_buil_id").val(tmp1[1]); 
		$("#area").val(tmp1[2]); 
		$("#floor").val(tmp1[4]);
		$("#near_landmark").val(tmp1[3]);  
		//$("#add_line2").val(tmp1[3]+','+tmp1[4]); 

		
	}
      
    });
  });
  </script>
<script>
$(function() {
$( "#date" ).datepicker({
dateFormat: 'dd/mm/yy',
showOn: "button",
buttonImage: "images/calendar.gif",
buttonImageOnly: true,
});
});
</script>

<div align="center" style="width:80%; margin-bottom:5px;"><font color="#FF0000"><?php print $msg; ?></font></div>
<h2>View Site Visit Report</h2>
<form name="frm" method="post" action="index.php?rel=site_visit_report_action" >
<input type="hidden" name="mode" id="mode" value="<?=$mode;?>">
<input type="hidden" name="visit_id" value="<?php print $report_data[0]['visit_id']?>" />
<table width="80%" border="0" cellspacing="2" cellpadding="2"> 
 
  <tr>
  <?php  $date=date('d/m/Y'); ?>
	    <td class="black11">Date:</td>
	  <td class="black11"><?php  print $report_data[0]['report_date']; ?></td>
	
	    <td class="black11">Form No:</td>
	    <td class="black11"><?php print 'SV'.$report_data[0]['form_no']; ?></td>
  </tr>
  <tr>
	    <td class="black11">Client Name:</td>
	    <td class="black11"><?php print $report_data[0]['client_name']; ?></td>
	
  </tr>
    <tr>
	    <td class="black11">Client ID:</td>
	    <td class="black11"><?php print $report_data[0]['client_id']; ?></td>
	
	    <td class="black11">Broker/Owner ID:</td>
	    <td class="black11"><?php print $report_data[0]['broker_id']; ?></td>
  </tr>
    <tr>
	    <td class="black11">Listing ID:</td>
	    <td class="black11"><?php print $report_data[0]['property_id']; ?></td>
	
	    <td class="black11">Executive:</td>
	    <td class="black11"><?php print $report_data[0]['executive']; ?></td>
  </tr>
   <tr>
	    <td class="black11">Property Type:</td>
	   <td class="black11">  
	     <?php  echo $report_data[0]['property_type']; ?> 
	    	
	    </td>
	
  </tr>
  <tr>
    <td class="black11">Nearest Building:</td>
    <td class="black11"><?php print $report_data[0]['near_buil_id']; ?></td>
    
  </tr>
  
  <tr>
	    <td class="black11">On floor:</td>
	    <td class="black11"><?php print $report_data[0]['floor']; ?></td>
	
  </tr>
  
  <tr>
	    <td class="black11">Nearest Landmark:</td>
	    <td class="black11"><?php print $report_data[0]['near_landmark']; ?></td>
	
  </tr>
  
  <tr>
	    <td class="black11">Area:</td>
	    <td class="black11"><?php print $report_data[0]['area']; ?></td>
	
  </tr>
  
  <tr>
	    <td class="black11">City:</td>
	    <td class="black11"><?php print $report_data[0]['city']; ?></td>
	
  </tr>
   
   <tr>
	    <td class="black11" colsapan="2">Client's Comment on Property:</td>
	    <td class="black11" colsapan="2"><?php print $report_data[0]['client_comment']?></td>
	
  </tr>
   
   <tr>
	    <th class="black11" colspan="4" >Client's Rating:</th>
   </tr>
   <tr>
	    <td class="black11" colspan="4" >1. How do you rate service of property pistol sales team?</td>
   </tr>
   <tr>
	
	    <td class="black11" colspan="1"> <?php if($report_data[0]['service_property_pistol']=='1') { ?> Highly Satisfactory <?php } ?> </td>
	   
   </tr>
   <tr>
    	 
	    <td class="black11" colspan="1"> <?php if($report_data[0]['service_property_pistol']=='2') { ?> Satisfactory <?php } ?> </td>
  </tr>
  <tr>
	  
	    <td class="black11" colspan="1"><?php if($report_data[0]['service_property_pistol']=='3') { ?> Unsatisfactory <?php } ?></td>
   </tr>
   
   <tr>
	    <td class="black11" colspan="4" >2. How do you rate Professionalism of Broker member?</td>
   </tr>
   <tr>
	   
	    <td class="black11" colspan="1"> <?php if($report_data[0]['professionalism_broker']=='1') { ?>  Highly Satisfactory <?php } ?> </td>
	   
   </tr>
   <tr>
    	 
	    <td class="black11" colspan="1"> <?php if($report_data[0]['professionalism_broker']=='2') { ?>  Satisfactory <?php } ?></td>
  </tr>
  <tr>
	   
	    <td class="black11" colspan="1"> <?php if($report_data[0]['professionalism_broker']=='3') { ?>  Unsatisfactory <?php } ?> </td>
   </tr>
   
   <?php if($mode=='Add') { ?>
    <tr>
  	<td class="black11" colspan="4">Terms and conditions agreed?</td>
  </tr>
   <tr>	    
	    
	    
	    <td class="black11">Yes</td>
	    <td class="black11"><input <?php if($report_data[0]['term_con']=='1') { ?>  checked <?php } ?>  type="radio" name="term_con" id="term_con" value="1"></td>
	    	
	     <td class="black11">No</td>
	    <td class="black11"><input <?php if($report_data[0]['term_con']=='2') { ?>  checked <?php } ?>  type="radio" name="term_con" id="term_con" value="2"></td>
  </tr>	
<?php } ?>	
   <tr>
	    <th class="black11" colspan="4" >PP Rating on Broker:</th>
   </tr>   
   <tr>
	    <td class="black11" colspan="4" >1. How do you rate his Professionalism?</td>
   </tr>
   <tr>
	   
	    <td class="black11" colspan="1"> <?php if($report_data[0]['professionalism']=='1') { ?>  Highly Satisfactory <?php } ?> </td>
	   
   </tr>
   <tr>
    	  
	    <td class="black11" colspan="1"> <?php if($report_data[0]['professionalism']=='2') { ?>  Satisfactory <?php } ?> </td>
  </tr>
  <tr>
	    
	    <td class="black11" colspan="1"> <?php if($report_data[0]['professionalism']=='3') { ?>  Unsatisfactory <?php } ?>  </td>
   </tr> 
    <?php if($mode=='Add') { ?>
    <tr>
    	   <td class="black11" colspan="1"><input type="checkbox" name="understand" id="understand" value="1" /></td>
	    <td class="black11" colspan="3">I Understand impact of this rating on Broker's Business, and hence rating it with the best of my Knowledge.</td>
	    
   </tr>
   <?php } ?>
   
  <tr>
	    <td class="black11" colspan="1">Executive Comment on site visit/Broker</td>
	     <td class="black11" colsapan="3"><?php print $report_data[0]['executive_comment']?></td>
	    
   </tr>
    <tr>
    	
	    <th colspan="4">Check Below Check box For Notification Via Multiple Options.</th>
    </tr>
    <tr>
	    
	    <td class="black11"> <?php if($report_data[0]['calls_noti']=='1') { ?>  Calls <?php } ?> </td>
	   
	</tr>
	<tr>	    
	    
	    <td class="black11"> <?php if($report_data[0]['sms_noti']=='1') { ?>  SMS's <?php } ?></td>
	
  </tr>
  <tr>	    
	    
	    <td class="black11"><?php if($report_data[0]['email_noti']=='1') { ?> Email's <?php } ?> </td>
	 
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td class="black11"> <a href="index.php?&rel=edit_site_visit_report&id=<?php print $report_data[0]['visit_id']?>"><input type="button" name="submit" onclick="return validate();" value="Edit Report" /></a>&nbsp;<!--<input type="reset" name="reset"  value="Reset" />&nbsp;<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=static_pages';" value="Cancel" />--></td>
  </tr>
</table>
</form>

<script type="text/javascript">
function validate()
{
	if(document.getElementById('page_title').value == "")
	{
		alert("Please enter page title");
		document.getElementById('page_title').focus();
		return false;
	}
	return true;
}
</script>
