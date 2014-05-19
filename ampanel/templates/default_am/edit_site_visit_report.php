<?php
//include("../dbconfig.php");
$msg = $_GET['msg'];

if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
{
	$id = $_REQUEST['id'];
	
	$sel_que ="select * from site_visit_report   where visit_id= '".$id."' ";
	$report_data = am_select($sel_que);
	//my_print_R($report_data);exit;
	$mode = "Update";
}
else
{
	$mode = "Save";
}
//include(DIR_SCRIPT_ROOT."/fckeditor/fckeditor.php") ; 

$build="select id_building,b_name,b_near_road,b_street_name,b_location_landmark,b_city,b_region_area from building_database";
$build_data = am_select($build);

//print_R($build_data);exit;
$build_array = array();

for($i=0;$i<count($build_data);$i++)
{
	
	$build_array[]='{'.'"label":"'.$build_data[$i]['b_name'].'","val":"'.$build_data[$i]['b_city'].'|'.$build_data[$i]['id_building'].'|'.$build_data[$i]['b_near_road'].'|'.$build_data[$i]['b_street_name'].'|'.$build_data[$i]['b_region_area'].'"'.'}';
}

 $cnt = '['.implode(',',$build_array).']';

//echo $cnt;exit;


$client="select f_name,l_name,client_id from client_personal_details ";
$client_data=am_select($client);
//print_R($client_data);exit;



$client_array = array();

for($i=0;$i<count($client_data);$i++)
{
	
	$client_array[]='{'.'"label":"'.$client_data[$i]['f_name'].' '.$client_data[$i]['l_name'].'","val":"'.$client_data[$i]['client_id'].'"'.'}';
}

 $cnt1 = '['.implode(',',$client_array).']';

//echo $cnt1;exit;




$client1="select * , property_id from client_property";
$client_data1=am_select($client1);

$data=array();
for($j=0;$j<count($client_data1);$j++)
{
	if(!isset($data[$client_data1[$j]['client_property_id']]))
	{
		$data[$client_data1[$j]['client_property_id']]=array();
	}
	array_push($data[$client_data1[$j]['client_property_id']], $client_data1[$j]['property_id']);
}

//print_R($data);exit;

foreach($data as $key => $value)
{
	$data1[$key]= "['".implode("','",$value)."']";
}

//print_R($data1);exit;


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

<?php //$data1[] = '["testtest testtest","alpesh patel","dhwni patel"]'; ?>
  

<script type="text/javascript">
		$(document).ready(function() {
			$("#help12").click(function(){
			var b_id = document.getElementById("b_id").value; 
			//var b_name = document.getElementById("b_name").value; 
			//var email_id = document.getElementById("email_id").value;
			//var mob_no = document.getElementById("mob_no").value;  
			$("#responsebroker").html('<div style="position: relative;text-align: center;top: 40px;"><img src="images/ajax-loader.gif"></div>');
			$.ajax({
			    type: "POST",
			    url: "site_visit_result.php",
			    dataType: "Text",
			    data: {b_id:b_id},
			    success: function(data) {
				
				if(data==0)
				{
					alert('Your Data Does Not Match');
				}
				else
				{
					document.getElementById("responsebroker").innerHTML = data;
					$(".select_broker").click(function(){
						
						
						var broker_owner_id = $(this).attr('broker_owner_id');
						var broker_property_id = $(this).attr('broker_property_id');
						//var broker_name = $(this).attr('broker_name');
						var near_building_id = $(this).attr('near_building_id');
						var floor1 = $(this).attr('floor');
						var add_line2 = $(this).attr('add_line2');
						var add_line1 = $(this).attr('add_line1');
						var city = $(this).attr('city');
						
						
						
						$('#listing_id').val(broker_property_id);
						$('#bro_own_id').val(broker_owner_id);
						$('#nearest_building').val(near_building_id);
						$('#floor').val(floor1);
						
						$('#near_landmark').val(add_line2);
						$('#area').val(add_line1);
						$('#city').val(city);
						
						
						document.getElementById("close1").click();
					});
				}
				
				
			    }
				});
			});
			
			
			

		});
	</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script> 
  
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
		$("#area").val(tmp1[4]); 
		$("#floor").val(tmp1[3]);
		$("#near_landmark").val(tmp1[2]);  
		//$("#add_line2").val(tmp1[3]+','+tmp1[4]); 

		
	}
      
    });
  });
  
  
  
  
  $(function() {
    var availableTags = <?php echo $cnt1; ?>;
    $( "#client_name" ).autocomplete({
      source: availableTags,
      
      select: function(event, ui) {
                var selectedObj = ui.item;
		var tmp1 = selectedObj.val;
		$("#client_id").val(tmp1); 
	
		
	}
      
    });
    
   
  });
  
  
  
  
 /*$(function() {
     var data = <?php echo json_encode($data); ?>;
	
      var arr = new Array();
     
     <?php foreach ( $data as $key => $value ) { ?>
     
     	var arr1 = new Array();
     	
     	<?php foreach ( $value as $key1 => $value1 ) { ?>
     
     	arr1.push('<?php echo $value1 ?>');
     		
     <?php } ?>
     
     //alert(arr1);
     arr[<?php echo $key ?>] = arr1;
     
     <?php } ?> 
     
     
    $( "#listing_id" ).autocomplete({
     
     
     source: function(request, response) {
                        var country = $("#client_id").val(),
                            cities = arr[country];
                        var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term ), "i" );
                        response($.grep(cities, function(value) {
                            return matcher.test(value);
                        }));
                    }
      
    });
    
  }); */
  </script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
 <script type="text/javascript" src="<?php echo HTTP_ROOT_HOME; ?>js/jquery-ui-timepicker-addon.js"></script>
 <link rel="stylesheet"  href="<?php echo HTTP_ROOT_HOME; ?>css/jquery-ui-timepicker-addon.css"> 
  <script>
$(function() {
$( "#date" ).datetimepicker({
dateFormat: 'yy-mm-dd',
showOn: "button",
buttonImage: "images/calendar.gif",
buttonImageOnly: true,
});
});
</script>

<script type="text/javascript" src="<?php echo HTTP_ROOT_HOME; ?>js/jquery.validate.min.js"></script>	
<style>
.error
{
	border: 1px solid red !important;	
}
label.error
{
    border: medium none !important;
    color: red;
    position: relative;
    top: 3px;
}

</style>

<div align="center" style="width:80%; margin-bottom:5px;"><font color="#FF0000"><?php print $msg; ?></font></div>
<h2><?php if($mode=='Save') { ?> Add Site Visit Report <?php } else if ($mode='Update') { ?> Update Site Visit Report <?php } ?></h2>
<form name="frm" method="post" id="register-form" action="index.php?rel=site_visit_report_action" onsubmit="return validate()">
<input type="hidden" name="mode" id="mode" value="<?=$mode;?>">
<input type="hidden" name="visit_id" value="<?php print $report_data[0]['visit_id']?>" />
<table width="80%" border="0" cellspacing="2" cellpadding="2"> 

 <?php

	$lastid="SELECT MAX( visit_id) FROM site_visit_report";
	$get_lastid=am_select($lastid);
	//print_R($get_lastid);exit;
	//echo $get_lastid[0]['MAX( broker_property_id)'];
	$id_last=$get_lastid[0]['MAX( visit_id)']+1;
	

?>

 
  <tr>
  <?php  //$date=date('Y-m-d'); ?>
	    <td class="black11">Date:</td>
	  <td class="black11"><input type="text" name="date" id="date" value="<?php if($report_data[0]['updated_date'] !='' ) { print $report_data[0]['updated_date']; } else {  echo $date;  } ?>" /></td>
	   <input type="hidden" name="created_date" id="created_date" value="<?php echo $report_data[0]['created_date'] ?>">	
				
	    <td class="black11">Form No:</td>
	    <td class="black11"><input readonly type="text" name="form_no" id="form_no" value="<?php if($mode=='Save') { print 'SV'.$id_last; } else if($mode=='Update') { print 'SV'.$report_data[0]['form_no']; } ?>" /></td>
  </tr>
  <tr>
	    <td class="black11">Client Name:</td>
	    <td class="black11"><input type="text"  name="client_name" id="client_name" value="<?php print $report_data[0]['client_name']?>" /></td>
	
  </tr>
    <tr>
	    <td class="black11">Client ID:</td>
	    <td class="black11"><input type="text" readonly name="client_id" id="client_id" value="<?php print $report_data[0]['client_id']?>" /></td>

	</tr>	
	
	 <tr>
	    <th><a href = "javascript:void(0)" onclick = "document.getElementById('help').style.display='block';document.getElementById('fade').style.display='block'" ><input type="button" name="search_broker"  value="Search Property"></a></th>
  </tr>
	
	
<tr>
	 <td class="black11">Listing ID:</td>
	    <td class="black11"><input type="text" name="listing_id" id="listing_id" value="<?php print $report_data[0]['property_id']?>" /></td>


	    
  </tr>
    <tr>
	   <td class="black11">Broker/Owner ID:</td>
	    <td class="black11"><input type="text" name="bro_own_id" id="bro_own_id" value="<?php print $report_data[0]['broker_id']?>" /></td>
	
	    <td class="black11">Executive:</td>
	    <td class="black11"><input type="text" name="executive" id="executive" value="<?php print $report_data[0]['executive']?>" /></td>
  </tr>
   <tr>
	    <td class="black11">Property Details:</td>
	    <td class="black11">
	    
	   <input type="text" name="property_type" id="property_type" value="<?php print $report_data[0]['property_type']?>" />
	    	<!--<select name="property_type" id="property_type">
	    		<option value="">Select Property Type</option>
	    		<option value="1" <?php if($report_data[0]['property_type']=='1') { ?> selected <?php } ?> >Flat</option>
	    		<option value="2" <?php if($report_data[0]['property_type']=='2') { ?> selected <?php } ?> >Shop</option>
	    		<option value="3" <?php if($report_data[0]['property_type']=='3') { ?> selected <?php } ?> >Office</option>
	    	</select> -->
	    	
	    </td>
	
  </tr>
  <tr>
    <td class="black11">Nearest Building:</td>
    <td class="black11"><input type="text" name="nearest_building" id="nearest_building" value="<?php print $report_data[0]['near_buil_id']?>" /></td>
    
  </tr>
  
  <tr>
	    <td class="black11">On floor:</td>
	    <td class="black11"><input type="text" name="floor1" id="floor" value="<?php print $report_data[0]['floor']?>" /></td>
	
  </tr>
  
  <tr>
	    <td class="black11">Nearest Landmark:</td>
	    <td class="black11"><input type="text" name="near_landmark" id="near_landmark" value="<?php print $report_data[0]['near_landmark']?>" /></td>
	
  </tr>
  
  <tr>
	    <td class="black11">Area:</td>
	    <td class="black11"><input type="text" name="area" id="area" value="<?php print $report_data[0]['area']?>" /></td>
	
  </tr>
  
  <tr>
	    <td class="black11">City:</td>
	    <td class="black11"><input type="text" name="city" id="city" value="<?php print $report_data[0]['city']?>" /></td>
	
  </tr>
   
   <tr>
	    <td class="black11" colsapan="2">Client's Feedback On Property:</td>
	    <td class="black11" colsapan="2"><textarea name="client_comment" id="client_comment" cols="45" rows="4" /><?php print $report_data[0]['client_comment']?></textarea></td>
	
  </tr>
   
   <tr>
	    <th class="black11" colspan="4" >Client's Rating:</th>
   </tr>
   <tr>
	    <td class="black11" colspan="4" >1. How do you rate service of property pistol sales team?</td>
   </tr>
   <tr>
	    <td class="black11" colspan="2">Highly Satisfactory</td>
	    <td class="black11" colspan="1"><input <?php if($report_data[0]['service_property_pistol']=='1') { ?> checked <?php } ?> type="radio" name="service_property_pistol" value="1"></td>
	   
   </tr>
   <tr>
    	    <td class="black11" colspan="2">Satisfactory</td>
	    <td class="black11" colspan="1"><input <?php if($report_data[0]['service_property_pistol']=='2') { ?> checked <?php } ?> type="radio" name="service_property_pistol" value="2"></td>
  </tr>
  <tr>
	    <td class="black11" colspan="2">Unsatisfactory</td>
	    <td class="black11" colspan="1"><input <?php if($report_data[0]['service_property_pistol']=='3') { ?> checked <?php } ?> type="radio" name="service_property_pistol" value="3"></td>
   </tr>
   
   <tr>
	    <td class="black11" colspan="4" >2. How do you rate Professionalism of Broker member?</td>
   </tr>
   <tr>
	    <td class="black11" colspan="2">Highly Satisfactory</td>
	    <td class="black11" colspan="1"><input <?php if($report_data[0]['professionalism_broker']=='1') { ?>  checked <?php } ?> type="radio" name="professionalism_broker" value="1"></td>
	   
   </tr>
   <tr>
    	    <td class="black11" colspan="2">Satisfactory</td>
	    <td class="black11" colspan="1"><input <?php if($report_data[0]['professionalism_broker']=='2') { ?>  checked <?php } ?> type="radio" name="professionalism_broker" value="2"></td>
  </tr>
  <tr>
	    <td class="black11" colspan="2">Unsatisfactory</td>
	    <td class="black11" colspan="1"><input <?php if($report_data[0]['professionalism_broker']=='3') { ?>  checked <?php } ?> type="radio" name="professionalism_broker" value="3"></td>
   </tr>
   
 	
   <tr>
	    <th class="black11" colspan="4" >PP Rating on Broker:</th>
   </tr>   
   <tr>
	    <td class="black11" colspan="4" >1. How do you rate his Professionalism?</td>
   </tr>
   <tr>
	    <td class="black11" colspan="2">Highly Satisfactory</td>
	    <td class="black11" colspan="1"><input <?php if($report_data[0]['professionalism']=='1') { ?>  checked <?php } ?>  type="radio" name="professionalism" value="1"></td>
	   
   </tr>
   <tr>
    	    <td class="black11" colspan="2">Satisfactory</td>
	    <td class="black11" colspan="1"><input <?php if($report_data[0]['professionalism']=='2') { ?>  checked <?php } ?>  type="radio" name="professionalism" value="2"></td>
  </tr>
  <tr>
	    <td class="black11" colspan="2">Unsatisfactory</td>
	    <td class="black11" colspan="1"><input <?php if($report_data[0]['professionalism']=='3') { ?>  checked <?php } ?>  type="radio" name="professionalism" value="3"></td>
   </tr> 
    <?php if($mode=='Save') { ?>
    <tr>
    	   <td class="black11" colspan="1"><input type="checkbox" name="understand" id="understand" value="1" /></td>
	    <td class="black11" colspan="3">I Understand impact of this rating on Broker's Business, and hence rating it with the best of my Knowledge.</td>
	    
   </tr>
   <?php } ?>
   
  <tr>
	    <td class="black11" colspan="1">Executive Feedback On Property/Broker</td>
	     <td class="black11" colsapan="3"><textarea name="executive_comment" id="executive_comment" cols="45" rows="4" /><?php print $report_data[0]['executive_comment']?></textarea></td>
	    
   </tr>
    <tr>
    	
	    <th colspan="4">Check Below Check box For Notification Via Multiple Options.</th>
    </tr>
    <tr>
	    
	    <td class="black11"><input <?php if($report_data[0]['calls_noti']=='1') { ?>  checked <?php } else if($mode=='Save') { ?> checked <?php } ?> type="checkbox" name="calls_noti" id="calls_noti" value="1" /></td>
	    <td class="black11" >Calls</td>
	</tr>
	<tr>	    
	    
	    <td class="black11"><input  <?php if($report_data[0]['sms_noti']=='1') { ?>  checked <?php } else if($mode=='Save') { ?> checked <?php } ?> type="checkbox" name="sms_noti" id="sms_noti" value="1" /></td>
	     <td class="black11" >SMS's</td>
  </tr>
  <tr>	    
	    
	    <td class="black11"><input <?php if($report_data[0]['email_noti']=='1') { ?> checked <?php } else if($mode=='Save') { ?> checked <?php } ?> type="checkbox" name="email_noti" id="email_noti" value="1" /></td>
	     <td class="black11" >Email's</td>
  </tr>
  <?php if($_GET['id']=='') { ?>
  
  <tr>
  	<th class="black11" colspan="4">Terms and Conditions*</th>
  </tr>
   <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="ddd" id="c">&nbsp;&nbsp;&nbsp;1.  hereby agree to pay service charges of PropertyPistol in case I transact (BUY/RENT) above property shown by<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PropertyPlstol. (service charges are: 1% of Agreement value in case of sale /1 month rent in case of Rent subject to <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Minimum of INR 15000/-) </td>  
	    
  </tr>
    <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="aaa" id="c">&nbsp;&nbsp;&nbsp;2. Service charges to be paid only by cheque in favor of 'PropertyPistol Reality Pvt Ltd.</td>  
	    
  </tr>
   <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="bbb" id="c">&nbsp;&nbsp;&nbsp;3.  I agree to pay 25% of total Service charges to PropertyPistol at time of token in case of transaction both sale/rent.<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Remaining 75% will be payable upon signing/registration of agreement.</td>  
	    
  </tr>
  <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="ccc" id="c">&nbsp;&nbsp;&nbsp;4. I agree to give a copy of register agreement to PropertyPistol in case of transaction (sale/Rent) for the said property.</td>  
	    
  </tr>
  
  <?php } ?> 
  <tr>
    <td>&nbsp;</td>
    <td class="black11"><input type="submit" name="submit" onclick="return validate();" value="<?=$mode;?>" />&nbsp;<!--<input type="reset" name="reset"  value="Reset" />&nbsp;<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=static_pages';" value="Cancel" />--></td>
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


        	
        	<div id="help" style="min-height: 130px;" class="white_content">
        	<div style="position:relative;">
        	<form  name="help"  >	
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr class="gray">
					<td>Serach:</td>
					
					<td><input type="text" class="input" placeholder="Search" name="b_id" id="b_id" value="" ></td>
					<!--<td><input type="text" class="input" placeholder="Broker/Owner Name" name="b_name" id="b_name" value="" ></td>
					<td><input type="text" class="input" placeholder="Email Id" name="email_id" id="email_id" value="" ></td>
					<td><input type="text" class="input" placeholder="Mobile No" name="mob_no" id="mob_no" value="" ></td>-->
					
				
				<td><input type="button" name="help" id="help12" class="btn submit" value="search" ></td>
				 </tr>	
				
				
				
			</table>
			
			
		</form>
		
		
		<div id="responsebroker">
		
		</div>
		<a href = "javascript:void(0)"  onclick = "document.getElementById('help').style.display='none';document.getElementById('fade').style.display='none'"><span class="close1" id="close1" ></span></a>
        	
        	</div>
        	</div>
        	<div id="fade" class="black_overlay"></div>
        	
        	
  <script type="text/javascript">      	
      $( document ).ready(function() {
  	autopopulate();
});
function autopopulate()
{
	var table_name = 'broker';
	var vals = 'broker_id,broker_name,email,mobile1_no';
	var url = 'search_result.php?col_name='+vals+'&table_name='+table_name;
	$( "#b_id" ).autocomplete({
		source: url,
	});
}  
</script>	


<script type="text/javascript">
/**
  * Basic jQuery Validation Form Demo Code
  * Copyright Sam Deering 2012
  * Licence: http://www.jquery4u.com/license/
  */
(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#register-form").validate({
                rules: {
                    client_name: "required",
                    listing_id: "required",
                   
                   
                    nearest_building: "required",
                    floor1:"required",
                   
                    city:"required",
                    client_comment:"required",
                    service_property_pistol:"required",
                    professionalism_broker:"required",
                    understand:"required",
                    executive_comment:"required",
                    aaa: "required",
                     bbb: "required",
                     ccc: "required",
                     ddd: "required",
                    
                    
                },
                messages: {
                    client_name: "Please Enter client Name",
                    listing_id: "Please Enter Listing Id",
                  
                     
                     nearest_building: "Please enter  Nearest Building", 
                     floor1: "Please enter  Building Name / Flat No/ Floor",
                     city: "Please enter  City", 
                     client_comment:"Please enter Client Comment", 
                     service_property_pistol: "Please Select Client Rating",  
                     professionalism_broker: "Please Select Client Rating",
                     understand:"Please Select Employee declaration",
                     executive_comment:"Please enter Executive Comment",
                     aaa: "Please Accept Term And Condition",
                     bbb: "Please Accept Term And Condition",
                     ccc: "Please Accept Term And Condition",
                     ddd: "Please Accept Term And Condition",
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);
</script>
