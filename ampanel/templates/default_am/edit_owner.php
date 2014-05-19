<?php
//include("../dbconfig.php");
$msg = $_GET['msg'];

if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
{
	$id = $_REQUEST['id'];
	
	$sel_que ="select * from client_personal_details left join client_property on client_personal_details.client_id=client_property.client_property_id left join client_area on client_personal_details.client_id=client_area.client_area_id   where client_id= '".$id."' ";
	$client_data = am_select($sel_que);
	//my_print_R($client_data);exit;
	$mode = "Update";
}
else
{
	$mode = "Add";
}
//include(DIR_SCRIPT_ROOT."/fckeditor/fckeditor.php") ; 



//echo $cnt;exit;   

$build="select id_building,b_name,b_near_road,b_street_name,b_location_landmark,b_city,b_region_area from building_database";
$build_data = am_select($build);

//print_R($build_data);exit;
$build_array = array();

for($i=0;$i<count($build_data);$i++)
{
	
	$build_array[]='{'.'"label":"'.$build_data[$i]['b_name'].'","val":"'.$build_data[$i]['b_city'].'|'.$build_data[$i]['id_building'].'|'.$build_data[$i]['b_near_road'].'|'.$build_data[$i]['b_street_name'].'|'.$build_data[$i]['b_region_area'].'|'.$build_data[$i]['b_location_landmark'].'"'.'}';
}

 $cnt = '['.implode(',',$build_array).']';

//echo $cnt;exit;

?>
 
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
		$("#add_line2").val(tmp1[2]); 
		$("#add_line1").val(tmp1[3]); 
		$("#add_line3").val(tmp1[4]);
    $("#landmark").val(tmp1[5]); 
		//$("#add_line2").val(tmp1[3]+','+tmp1[4]); 

		
	}
      
    });
  });
  </script>    

<script language="JavaScript" type="text/javascript">
function showhidediv2(){
	
	
	
	if (document.getElementById('add_customer').value='Add Owner')
	{
	
	document.getElementById('customerinfo').style.display = 'block';
	document.getElementById('apart').style.display = 'block';
	document.getElementById('property1').style.display = 'block';
	document.getElementById('customerinfo1').style.display = 'none';
	
	}
	else
	{
	document.getElementById('customerinfo').style.display = 'none';
	document.getElementById('apart').style.display = 'none';
	document.getElementById('property1').style.display = 'none';
	}
	
	
}

function showhidediv1(){
	
	
	
	if (document.getElementById('search_customer').value='Search Owner')
	{
	
	document.getElementById('customerinfo').style.display = 'none';
	document.getElementById('apart').style.display = 'none';
	document.getElementById('property1').style.display = 'none';
	
	
	}
	
	
	
}


</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>  

<script type="text/javascript">
		$(document).ready(function() {
		
			$("#help12").click(function(){
			var c_id = document.getElementById("c_id").value; 
			//var c_name = document.getElementById("c_name").value; 
			//var email_id = document.getElementById("email_id").value;
			//var mob_no = document.getElementById("mob_no").value;  
			
			$("#responsebroker").html('<div style="position: relative;text-align: center;top: 40px;"><img src="images/ajax-loader.gif"></div>');
			
			$.ajax({
			    type: "POST",
			    url: "customer_result.php",
			    dataType: "Text",
			    data: {c_id:c_id},
			    success: function(data) {
				
				if(data==0)
				{
					alert('Your Data Does Not Match');
				}
				else
				{
					document.getElementById("responsebroker").innerHTML = data;
					$(".select_broker").click(function(){
					
						
						$("#customerinfo1").css("display","block");
						
						var client_id= $(this).attr('client_id'); 
						var date = $(this).attr('date');
						var place = $(this).attr('place');
						var f_name = $(this).attr('f_name');
						var l_name = $(this).attr('l_name');
						
						var mobile_no = $(this).attr('mobile_no');
						
						var email1 = $(this).attr('email1');
						
						
						
						
						
						$('#date2').html(date);
						$('#place').html(place);
						$('#f_name').html(f_name);
						$('#l_name').html(l_name);
						$('#mobile').html(mobile_no);
						$('#email1').html(email1);
						
						$("a.customerlink").attr("href", "index.php?rel=edit_customer&id="+client_id);
						$("a.propertylink").attr("href", "index.php?&rel=edit_owner_property&owner_id="+client_id+"&mobile_no="+mobile_no);
						
						
						document.getElementById("close1").click();
					});
				}
				
				
			    }
				});
			});
		
			
		
		});
</script>

<script type="text/javascript">
		function sendNotes()   {
			var $form = $(this); 
			  //alert('vxcbcv');
		    	var mobile_no=$("#mobile2").val()
				//alert(mobile_no);	     
				       
			$.ajax({
				type: "POST",
				url: "uniqueowner_result.php",
				data: {m:mobile_no},
				success: function(html){
					var flg = html.split('$');
					
					if(flg[0] === 1)
					{
						$('#message').html(flg[1]);
						return false;
					}
					else
					{
						$('#message').html(flg[1]);
						return true;
					}
				    }
			    }); 
		return false;
}
		
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
  <script>
$(function() {
$( "#date1" ).datetimepicker({
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

<form name="frm" method="post" id="register-form" action="index.php?rel=owner_action" enctype="multipart/form-data" >
<input type="hidden" name="mode" id="mode" value="<?=$mode;?>">
<input type="hidden" name="client_id" value="<?php print $client_data[0]['client_id']?>" />
<input type="hidden" name="property_id" value="<?php print $client_data[0]['property_id']?>" />
<input type="hidden" name="area_id" value="<?php print $client_data[0]['area_id']?>" />
	
<?php if($_GET['id']!='') { ?>
<h2> <?php echo $mode; ?> Owner </h2>	
<table width="80%" border="0" cellspacing="2" cellpadding="2" > 
  <tr>
  <?php  //$date=date('d/m/Y'); ?>
	    <td class="black11">Date:</td>
	    <td class="black11"><input type="text" name="date" id="date1" value="<?php if($client_data[0]['client_updated_date'] !='' ) { print $client_data[0]['client_updated_date']; }  ?>" /></td>
	     <input type="hidden" name="client_created_date" id="client_created_date" value="<?php echo $client_data[0]['client_created_date'] ?>">	
	    <td class="black11">Outlet Location:</td>
	    <td class="black11">
	        <select name="place"  id="place"  value="">
		    	<option value="">Select Location</option>
		    	<?php echo get_outlet_location_options($client_data[0]['place']); ?>
	    	</select>
	 
	    </td>
  </tr>
   <!--<tr>
	    <td class="black11"><input type="radio" name="sell" id="sell"  value="Sell/Rent Out" onclick="showhidediv();"></td>
	    <td class="black11">Sell/Rent Out</td>
	
	    <td class="black11"><input type="radio" name="sell" value="Buy/Rent In" onclick="showhidediv(this);"></td>
	    <td class="black11">Buy/Rent In</td>
  </tr>-->
   <tr>
	    <th colspan="2">Personal Details</th>
  </tr>
  <tr>
	    <td class="black11" >First Name</td>
	    <td class="black11"><input type="text" name="f_name" id="f_name" value="<?php print $client_data[0]['f_name']?>" /></td>
	    
</tr>
<tr>	    
	     <td class="black11" >Last Name</td>
	    <td class="black11"><input type="text" name="l_name" id="l_name" value="<?php print $client_data[0]['l_name']?>" /></td>
  </tr>
  
  
  <tr>
	    <th colspan="2">Address</th>
  </tr>
  
  
   <tr>
	    <td class="black11" >Address line 1</td>
	    <td class="black11"><input type="text" name="own_add_line1" id="own_add_line1" value="<?php print $client_data[0]['add_line1']?>" /></td>
	     
  </tr>
  <tr>
	    <td class="black11" >Address line 2</td>
	    <td class="black11"><input type="text" name="own_add_line2" id="own_add_line2" value="<?php print $client_data[0]['add_line2']?>" /></td>
	     
  </tr>
  <tr>
	    <td class="black11" >Address line 3</td>
	    <td class="black11"><input type="text" name="own_add_line3" id="own_add_line3" value="<?php print $client_data[0]['add_line3']?>" /></td>
	     
  </tr>
   <tr>
	    <td class="black11" >Pin Code</td>
	    <td class="black11"><input type="text" name="own_zip_code" id="own_zip_code" value="<?php print $client_data[0]['zip_code']?>" /></td>
</tr>	    
<tr>
	    
	     <td class="black11" >City Name</td>
	    <td class="black11"><input type="text" name="own_city" id="own_city" value="<?php print $client_data[0]['city']?>" /></td>
  </tr>
  <tr>
	    <td class="black11" >State</td>
	    <td class="black11">
	    	 <select name="own_state"  id="own_state"  value="">
		    	<option value="">Select State</option>
		    	<?php echo get_states_options($client_data[0]['state']); ?>
		 </select>
	    </td>
	     
  </tr>
  <tr>
	    <td class="black11" >Country</td>
	    <td class="black11"><input type="text" name="own_country" id="own_country" value="India" /></td>
	     
  </tr>
  
   
  
    <tr>
	    <th colspan="2">Contact</th>
  </tr>
  
     <tr>
	    <td class="black11" >Mobile</td>
	    <td class="black11"><input type="text" name="mobile" id="mobile" value="<?php print $client_data[0]['mobile_no']?>"  onblur="sendNotes()" />  <div id="message" style="position: relative;margin: 4px 0 0 5px;"></div></td>
	    
    </tr>
    <tr>	    
	    
	     <td class="black11" >Phone</td>
	    <td class="black11"><input type="text" name="office" id="office" value="<?php print $client_data[0]['office_no']?>" /></td>
  </tr>
     <tr>
	    <td class="black11" >Email1</td>
	    <td class="black11"><input type="text" name="email1" id="email1" value="<?php print $client_data[0]['email1']?>" /></td>
    </tr>
    <tr>	    
	    
	     <td class="black11" >Email2</td>
	    <td class="black11"><input type="text" name="email2" id="email2" value="<?php print $client_data[0]['email2']?>" /></td>
  </tr>
  

<tr>
    	
	    <th colspan="4">Lead source</th>
    </tr>
     <tr>
	    
	    <td class="black11" colspan="2"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['internet']=='1' || $_SESSION['property']['internet']=='1' ) { ?>  checked <?php } ?>  type="radio" name="internet" id="internet" value="1" />&nbsp;&nbsp;&nbsp;Internet/web</td>
	    
	    <td class="black11" colspan="2"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['internet']=='2' || $_SESSION['property']['internet']=='2') { ?>  checked <?php } ?> type="radio" name="internet" id="newspaper" value="2" />&nbsp;&nbsp;&nbsp;Newspaper Advertise</td>
	</tr>
	<tr>	    
	    <td class="black11" colspan="2"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['internet']=='3' || $_SESSION['property']['internet']=='3' ) { ?>  checked <?php } ?>  type="radio" name="internet" id="friends" value="3" />&nbsp;&nbsp;Friends/Relatives</td>
	     
	     <td class="black11" colspan="2"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['internet']=='4' || $_SESSION['property']['internet']=='4' ) { ?>  checked <?php } ?>  type="radio" name="internet" id="other" value="4" />&nbsp;&nbsp;Other</td>
  </tr>


    <tr>
    	
	    <th colspan="4">Check Below Check box For Notification Via Multiple Options.</th>
    </tr>
     <tr>
	    
	    <td class="black11"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['calls_noti']=='1') { ?>  checked <?php } ?>  type="checkbox" name="calls" id="calls" value="1" />&nbsp;&nbsp;&nbsp;Calls</td>
	  
	</tr>
	<tr>	    
	    
	    <td class="black11"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['sms_noti']=='1') { ?>  checked <?php } ?> type="checkbox" name="sms" id="sms" value="1" />&nbsp;&nbsp;&nbsp;SMS's</td>
	     
  </tr>
  <tr>	    
	    
	    <td class="black11"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['email_noti']=='1') { ?>  checked <?php } ?>  type="checkbox" name="email" id="email" value="1" />&nbsp;&nbsp;&nbsp;Email's</td>
	   
  </tr>
  
 <!-- <tr>
  	<td class="black11" colspan="2">Terms and conditions agreed</td>
  </tr>
   <tr>	    
	    
	    
	    <td class="black11">Yes</td>
	    <td class="black11"><input <?php if($client_data[0]['term_con']=='1') { ?>  checked <?php } ?>  type="radio" name="term_con" id="term_con" value="1"></td>
	    	
	     <td class="black11">No</td>
	    <td class="black11"><input <?php if($client_data[0]['term_con']=='2') { ?>  checked <?php } ?>  type="radio" name="term_con" id="term_con" value="2"></td>
  </tr>
  
  <tr>
	    <td class="black11" >Transaction Time</td>
	    <td class="black11" >
	    	
	    	<select name="trans_time" id="trans_time">
	    		<option value="">Select Time</option>
	    		<option value="7days" <?php if($client_data[0]['trans_time']=='7days') { ?> selected <?php } ?> >Within 7 Days</option>
	    		<option value="15days" <?php if($client_data[0]['trans_time']=='15days') { ?> selected <?php } ?> >Within 15 Days</option>
	    		<option value="1month" <?php if($client_data[0]['trans_time']=='1month') { ?> selected <?php } ?> >Within 1 Month</option>
	    		<option value="more1month" <?php if($client_data[0]['trans_time']=='more1month') { ?> selected <?php } ?> >More than 1 Month</option>
	    	</select>
	    
	    </td>
	    	
	   
	   
  </tr>
  
  <tr>
	    <td class="black11">Client Category</td>
	    <td class="black11">
	    	
	    	<select name="client_cat" id="client_cat">
	    		<option value="">Select Time</option>
	    		<option value="platinum" <?php if($client_data[0]['client_cat']=='platinum') { ?> selected <?php } ?> >Platinum</option>
	    		<option value="gold" <?php if($client_data[0]['client_cat']=='gold') { ?> selected <?php } ?> >Gold</option>
	    		<option value="silver" <?php if($client_data[0]['client_cat']=='silver') { ?> selected <?php } ?> >Silver</option>
	    		<option value="bronze" <?php if($client_data[0]['client_cat']=='bronze') { ?> selected <?php } ?> >Bronze</option>
	    	</select>
	    
	    </td>
	    	
	   
	   
  </tr> 	-->
  
    <tr>	    
	    
	    <td class="black11">Owner Remark</td>
	    <td class="black11" colspan="3">
	    <textarea name="remark" cols="50" rows="5" value=""><?php print $client_data[0]['remark']?></textarea> 
	    </td>
  </tr>
  
  
  <tr>
    <td>&nbsp;</td>
    <td class="black11"><input type="submit" name="submit12"  value="<?=$mode;?>" />&nbsp;<!--<input type="reset" name="reset"  value="Reset" />&nbsp;<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=static_pages';" value="Cancel" />--></td>
  </tr>
</table>

<?php } else { ?>	

<h2><?php echo $mode; ?> Owner</h2>
<!--	
<table width="80%" border="0" cellspacing="2" cellpadding="2" > 
<tr>
   <td>
	<h2><?php echo $mode; ?> Owner</h2>
  </td>
  <td>
    <a href="index.php?rel=common_listing&module=owner"><h4>Owner Listing</h4></a>
  </td>
</tr>	
  <tr>
	<td colspan="4"><h3>Do You Want to Add Property For Any Exsiting Owner?</h3></td>	
	</tr>
	<tr>
	<td colspan="1"><a href = "javascript:void(0)" onclick = "document.getElementById('help').style.display='block';document.getElementById('fade').style.display='block'" ><input type="button" name="search_customer" id="search_customer" value="Search Owner" onclick="showhidediv1(this);"></a></td>	
	
	<td colspan="1"><h3>OR</h3></td>	
	<td colspan="1"></td>
	<td colspan="1"><input type="button" name="add_customer" id="add_customer" value="Add Owner" onclick="showhidediv2(this);"></td>	
	
	</tr>

</table>


<table width="80%" border="0" cellspacing="2" cellpadding="2" id="customerinfo1" style="display:none;"> 
  <tr>
  
  <?php  $date=date('d/m/Y'); ?>
	    <td class="black11">Date:</td>
	    <td class="black11" ><label  id="date2"> </label> </td>
	
	    <td class="black11">Outlet Location:</td>
	    <td class="black11"> <label for="place" id="place" value=""> </label> </td>
  </tr>
  
   
  <tr>
	    <td class="black11" >First Name</td>
	    <td class="black11"><label for="f_name" id="f_name" value=""> </label> </td>
	     <td class="black11" >Last Name</td>
	    <td class="black11"><label for="l_name" id="l_name" value=""> </label></td>
  </tr>
  
  
  
  
     <tr>
	    <td class="black11" >Mobile</td>
	    <td class="black11"> <label for="mobile" id="mobile" value=""> </label></td>
	    
	    <td class="black11" >Email1</td>
	    <td class="black11"> <label for="email1" id="email1" value=""> </label> </td>
	    
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td class="black11"> <a id="customerlink" name="customerlink" class="customerlink" herf=""> <input type="button" name="button"  value="Edit Customer" /></a>&nbsp; <a id="propertylink" name="propertylink" class="propertylink" herf=""><input type="button" name="addproperty"  value="Add Property" /> </a> <!-- &nbsp;<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=static_pages';" value="Cancel" />--> <!-- </td>
  </tr>
</table> -->




<table width="80%" border="0" cellspacing="2" cellpadding="2" id="customerinfo" > 
  <tr>
  <?php  $date=date('d/m/Y'); ?>
	    <td class="black11">Date:</td>
	    <td class="black11"><input type="text" name="date" id="date1" value="<?php if($client_data[0]['client_updated_date'] !='' ) { print $client_data[0]['client_updated_date']; }  ?>" /></td>
	
	    <td class="black11">Outlet Location:</td>
	    <td class="black11">
	        <select name="place"  id="place"  value="">
		    	<option value="">Select Location</option>
		    	<?php echo get_outlet_location_options($client_data[0]['place']); ?>
	    	</select>
	 
	    </td>
  </tr>
   <!--<tr>
	    <td class="black11"><input type="radio" name="sell" id="sell"  value="Sell/Rent Out" onclick="showhidediv();"></td>
	    <td class="black11">Sell/Rent Out</td>
	
	    <td class="black11"><input type="radio" name="sell" value="Buy/Rent In" onclick="showhidediv(this);"></td>
	    <td class="black11">Buy/Rent In</td>
  </tr>-->
   <tr>
	    <th colspan="2">Personal Details</th>
  </tr>
  <tr>
	    <td class="black11" >First Name</td>
	    <td class="black11"><input type="text" name="f_name" id="f_name" value="<?php print $client_data[0]['f_name']?>" /></td>
  
   </tr>
   <tr>	    
	    
	     <td class="black11" >Last Name</td>
	    <td class="black11"><input type="text" name="l_name" id="l_name" value="<?php print $client_data[0]['l_name']?>" /></td>
  </tr>
  
  
  <tr>
	    <th colspan="2">Address</th>
  </tr>
  
  
   <tr>
	    <td class="black11" >Address line 1</td>
	    <td class="black11"><input type="text" name="own_add_line1" id="own_add_line1" value="<?php print $client_data[0]['add_line1']?>" /></td>
	     
  </tr>
  <tr>
	    <td class="black11" >Address line 2</td>
	    <td class="black11"><input type="text" name="own_add_line2" id="own_add_line2" value="<?php print $client_data[0]['add_line2']?>" /></td>
	     
  </tr>
  <tr>
	    <td class="black11" >Address line 3</td>
	    <td class="black11"><input type="text" name="own_add_line3" id="own_add_line3" value="<?php print $client_data[0]['add_line3']?>" /></td>
	     
  </tr>
   <tr>
	    <td class="black11" >Pin Code</td>
	    <td class="black11"><input type="text" name="own_zip_code" id="own_zip_code" value="<?php print $client_data[0]['zip_code']?>" /></td>
	 
</tr>
<tr>	    
	     <td class="black11" >City Name</td>
	    <td class="black11"><input type="text" name="own_city" id="own_city" value="<?php print $client_data[0]['city']?>" /></td>
  </tr>
  <tr>
	    <td class="black11" >State</td>
	    <td class="black11">
	    	 <select name="own_state"  id="own_state"  value="">
		    	<option value="">Select State</option>
		    	<?php echo get_states_options($client_data[0]['state']); ?>
		 </select>
	    </td>
	     
  </tr>
  <tr>
	    <td class="black11" >Country</td>
	    <td class="black11"><input type="text" name="own_country" id="own_country" value="India" /></td>
	     
  </tr>
  
   
  
    <tr>
	    <th colspan="2">Contact</th>
  </tr>
  
     <tr>
	    <td class="black11" >Mobile</td>
	    <td class="black11"><input type="text" name="mobile" id="mobile2" value="<?php print $client_data[0]['mobile_no']?>" onblur="sendNotes()" <?php if($mode=='Update') { ?> Readonly  <?php } ?>/>
	     <?php if($mode=='Add') { ?>	 <div id="message" style="position: relative;margin: 4px 0 0 5px;"></div> <?php } ?>
	    </td>
    </tr>	    
    <tr>	    
	     <td class="black11" >Phone</td>
	    <td class="black11"><input type="text" name="office" id="office" value="<?php print $client_data[0]['office_no']?>" /></td>
  </tr>
     <tr>
	    <td class="black11" >Email1</td>
	    <td class="black11"><input type="text" name="email1" id="email1" value="<?php print $client_data[0]['email1']?>" /></td>
	<tr>
	</tr>
	
	     <td class="black11" >Email2</td>
	    <td class="black11"><input type="text" name="email2" id="email2" value="<?php print $client_data[0]['email2']?>" /></td>
  </tr>
  
  
  <tr>
    	
	    <th colspan="4">Lead source</th>
    </tr>
     <tr>
	    
	    <td class="black11" colspan="2"><input  <?php  if($client_data[0]['internet']=='1'  ) { ?>  checked <?php } ?>  type="radio" name="internet" id="internet" value="1" />&nbsp;&nbsp;&nbsp;Internet/web</td>
	    
	    <td class="black11" colspan="2"><input   <?php  if($client_data[0]['newspaper']=='2') { ?>  checked <?php } ?> type="radio" name="internet" id="newspaper" value="2" />&nbsp;&nbsp;&nbsp;Newspaper Advertise</td>
	</tr>
	<tr>	    
	    <td class="black11" colspan="2"><input <?php  if($client_data[0]['friends']=='3' ) { ?>  checked <?php } ?>  type="radio" name="internet" id="friends" value="3" />&nbsp;&nbsp;Friends/Relatives</td>
	     
	     <td class="black11" colspan="2"><input <?php  if($client_data[0]['other']=='4'  ) { ?>  checked <?php } ?>  type="radio" name="internet" id="other" value="4" />&nbsp;&nbsp;Other</td>
  </tr>

<?php if($_GET['id']=='') { ?>
  
  <tr>
  	<th class="black11" colspan="4">Terms and Conditions*</th>
  </tr>
   <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="aaa" id="c">&nbsp;&nbsp;&nbsp;1. I hereby agree to pay service charges of PropertyPistol in case I transact (SALE/RENT) with<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; client of PropertyPistol on any of listed Property. (Service charges are: 1% of sale value in case <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; of sale and 15 days rent in case of rent deal subject to minimum rent of R. 15000/-.</td>  
	    
  </tr>
    <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="bbb" id="c">&nbsp;&nbsp;&nbsp;2. Service charges to be paid only by cheque in favor of 'PropertyPistol Reality Pvt Ltd.</td>  
	    
  </tr>
   <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="ccc" id="c">&nbsp;&nbsp;&nbsp;3. I agree to pay 25% of total Service charges to PropertyPistol at time of token in case of<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; transaction both sale/rent. Remaining 75% will be payable upon signing/registration of<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; agreement.</td>  
	    
  </tr>
  <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="ddd" id="c">&nbsp;&nbsp;&nbsp;4. I agree to make keys available to PropertyPistol for inspection of properties listed above at<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; mutually agreed time.</td>  
	    
  </tr>
  <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="eee" id="c">&nbsp;&nbsp;&nbsp;5. I agree to share my contact/property details with any member broker of PropertyPistol<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Reality Pvt Ltd.</td>  
	    
  </tr>
  
  <?php } ?>

    <tr>
    	
	    <th colspan="4">Check Below Check box For Notification Via Multiple Options.</th>
    </tr>
     <tr>
	    
	    <td class="black11" colspan="4"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['calls_noti']=='1') { ?>  checked <?php } ?>  type="checkbox" name="calls" id="calls" value="1" />&nbsp;&nbsp;&nbsp;Calls</td>
	  
	</tr>
	<tr>	    
	    
	    <td class="black11"colspan="4"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['sms_noti']=='1') { ?>  checked <?php } ?> type="checkbox" name="sms" id="sms" value="1" />&nbsp;&nbsp;&nbsp;SMS's</td>
	     
  </tr>
  <tr>	    
	    
	    <td class="black11"colspan="4"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['email_noti']=='1') { ?>  checked <?php } ?>  type="checkbox" name="email" id="email" value="1" />&nbsp;&nbsp;&nbsp;Email's</td>
	   
  </tr>
  
   
  

  
  <tr>
       <td class="black11">Owner  Form: </td>
     <td class="black11"> 
     
      <input type="file" name="cust_form" id="cust_form" value="<?php print $client_data[0]['cust_form'];?>" />
      <br/>(eg- .docs,.pdf)<br/> (Max Upload Size Up To 5MB.)
    </td>
    <td class="black11">
    <?if( $client_data[0]['cust_form'] != "")
    { 
    	 $jpg_pdf=explode(".",$client_data[0]['cust_form']);
    	// print_R($jpg_pdf);exit;
    	 
    	 if($jpg_pdf[1]=='pdf' || $jpg_pdf[1]=='PDF' )
    	 {
    ?>
    <a href="<?php echo HTTP_ROOT_HOME.'/customer_images/'.$client_data[0]['cust_form'];?>" width="50px" height="50px;">View</a>
    
    <?php } else { ?>
    
     
      <img src="<?php echo HTTP_ROOT_HOME.'/customer_images/'.$client_data[0]['cust_form'];?>" width="100px" height="80px;"></td>
   <?php
   	}
    }  ?>	
    	</td>
    	<input type="hidden" name="old_logo" id="old_logo" value="<?php print $client_data[0]['cust_form']; ?>" />
     
	</td>
  </tr>
  	
  
    <tr>	    
	    
	    <td class="black11">Owner Remark</td>
	    <td class="black11" colspan="3">
	    <textarea name="remark" cols="50" rows="5" value=""><?php print $client_data[0]['remark']?></textarea> 
	    </td>
  </tr>
  
   <?php

	$lastid="SELECT MAX( broker_property_id) FROM property_requirement";
	$get_lastid=am_select($lastid);
	//print_R($get_lastid);exit;
	//echo $get_lastid[0]['MAX( broker_property_id)'];
	$id_last=$get_lastid[0]['MAX( broker_property_id)']+1;
	

?>
 <tr>
   <td class="black11" style="width: 15%;"><input readonly type="hidden" name="form_no" id="form_no" value="<?php if($mode=='Add') { print $id_last; } else if($mode=='Update') { print $broker_data[0]['form_no']; } ?>" /></td>
 
  </tr> 
  <tr>
	    <th>Properties</th>
  </tr>
  
   <tr>
	    
	    <td class="black11"><input <?php if($broker_data[0]['property_main_type']=="residential") { ?>  checked="checked" <?php } ?> type="radio" name="residential" id="residential" value="residential" onclick="showhidediv();"></td>
	    <td class="black11">Residential</td>
	    	
	    
	    <td class="black11"><input <?php if($broker_data[0]['property_main_type']=="commercial") { ?>  checked="checked" <?php } ?> type="radio" name="residential" id="commercial" value="commercial" onclick="showhidediv(this);"></td>
	     <td class="black11">Commercial</td>
	   
  </tr>
  <tr id="apart" style="display:none;">
  <td>
  <table width="80%"  border="0" cellspacing="2" cellpadding="2" id="apartment1" <?php if($client_data[0]['property_type']=="commercial") { ?>  style="display:none;" <?php } ?>  >
   <tr>
	    <th class="black11">Type of Apartment:</th>
	    

	 <tr>
	 <td class="black11" style="width: 15%;"><input <?php if($broker_data[0]['onerk']=='1') { ?>  checked <?php } ?>  type="radio" name="1rk" id="1rk" value="1">&nbsp;&nbsp;&nbsp;1RK </td>
	   		

<td class="black11" style="width: 15%;"><input <?php if($broker_data[0]['onerk']=='2') { ?>  checked <?php } ?>  type="radio" name="1rk" id="1bhk" value="2">&nbsp;&nbsp;&nbsp;1BHK</td>
		

	  </tr>  
	  <tr>
	 <td class="black11" style="width: 15%;"><input <?php if($broker_data[0]['onerk']=='3') { ?>  checked <?php } ?>  type="radio" name="1rk" id="2bhk" value="3">&nbsp;&nbsp;&nbsp;2BHK </td>
	    	
<td class="black11" style="width: 15%;"><input <?php if($broker_data[0]['onerk']=='4') { ?>  checked <?php } ?>  type="radio" name="1rk" id="3bhk" value="4">&nbsp;&nbsp;&nbsp;3BHK</td>
			

	  </tr>  
	  <tr>
	  
	 <td class="black11"><input <?php if($broker_data[0]['onerk']=='5') { ?>  checked <?php } ?>  type="radio" name="1rk" id="4bhk+" value="5">&nbsp;&nbsp;&nbsp;4BHK+</td>
	    <td class="black11"></td>		
	  </tr>  
	   
   </table>
  </td>
  </tr>
  
  <table  width="80%" border="0" cellspacing="2" cellpadding="2" id="property1" >
    
      
     <!-- <tr>
	    <td class="black11">Specify Area:</td>
	    <td class="black11">
	    	<input type="text" name="specify_area" id="specify_area" value="<?php print $broker_data[0]['specify_area']?>" />
	    </td>
    </tr>-->
    
   <!--<tr>
	    <td class="black11">Carpet:</td>
	    <td class="black11">
	    	<input type="text" name="carpet" id="carpet" value="<?php print $broker_data[0]['carpet']?>" />
	    </td>
    </tr>-->
  
  
  <tr id="off_ret" <?php if($broker_data[0]['property_main_type']=="residential") { ?>  style="display:none;" <?php } ?> >
	    <td class="black11">Office/Retail</td>
	    <td class="black11">
	    	
	    	<select name="office_check" id="office_check" onchange="off_retfun(this);">
	    		<option value="">Select Type</option>
	    		<option value="1" <?php if($broker_data[0]['office']=='1') { ?> selected <?php } ?> >Office</option>
	    		<option value="2" <?php if($broker_data[0]['office']=='2') { ?> selected <?php } ?> >Retail</option>
	    	</select>
	    
	    </td>
	    	
	   
	   
  </tr>
   <tr>
	    <td class="black11">Approximate Area (SQFT):</td>
	    <td class="black11">
	    	<input type="text" name="scaleble" id="scaleble" value="<?php print $broker_data[0]['scaleble']?>" />
	    </td>
    </tr>
     <tr id="furn">
	   
	    <td class="black11"><input <?php if($broker_data[0]['furnished']=='1') { ?>  checked <?php } ?>  type="radio" name="furnished" id="furnished" value="1"></td>
	      <td class="black11">Furnished</td>	
	    
	    <td class="black11"><input <?php if($broker_data[0]['furnished']=='2') { ?>  checked <?php } ?>  type="radio" name="furnished" id="unfurnished" value="2"></td>
	     <td class="black11">Unfurnished</td>
	
	    <td class="black11"><input <?php if($broker_data[0]['furnished']=='3') { ?>  checked <?php } ?>  type="radio" name="furnished" id="any" value="3"></td>
	    <td class="black11">Any</td>
	    
	   
  </tr>
     <tr id="cell" style="width:110%;" <?php if($broker_data[0]['property_main_type']=="residential") { ?>  style="display:none;" <?php } ?>>
	   
	    <td class="black11"><input <?php if($broker_data[0]['warm_cell']=='1') { ?>  checked <?php } ?>  type="radio" name="warm_cell" id="warm_cell" value="1"></td>
	     <td class="black11" title="Flooring & Wall finish available, Toilets are available">Warm Cell ?</td>
	    	
	    
	    <td class="black11"><input <?php if($broker_data[0]['warm_cell']=='2') { ?>  checked <?php } ?>  type="radio" name="warm_cell" id="cold_cell" value="2"></td>
	     <td class="black11" title="flooring, wall finish etc not yet finished">Cold Cell ?</td>
	    
	   
  </tr>
  
  
  <tr>
	    <td class="black11" >Transaction:</td>
	    
	     <td class="black11" >
	     <select name="transaction" id="transaction" value=""  onchange="transaction1(this);">
	        <option value="">Select</option>
	     	<!--<option value="sale" <?php if($broker_data[0]['trans_type']=='sale') { ?> selected <?php } ?> >Sale</option>-->
	     	<option value="sell" <?php if($broker_data[0]['trans_type']=='sell') { ?> selected <?php } ?> >Sell</option>
	     	<option value="rent_out" <?php if($broker_data[0]['trans_type']=='rent_out') { ?> selected <?php } ?> >Rent Out</option>
	     <!--	<option value="rent_out" <?php if($broker_data[0]['trans_type']=='rent_out') { ?> selected <?php } ?> >Rent Out</option>  -->
	     </select>
	     </td>
	    
  </tr>
 <?php   $price=$broker_data[0]['price'];
 	       
 	     
 	     if(strpos($price, '0000000'))
 	      	{
 	      		$c1='0000000';
 	      	}	
 	     	else if(strpos($price, '00000'))
 	        {
 	       		$c1='00000';
 	        }
 	        else if(strpos($price, '000'))
 	        {
 	       		$c1='000';
 	        }
 	      
 	       // echo $c1;
 	        $price1=str_replace($c1,'' ,$price);
 	        if($price1>100)
		{
	 	      	$value1=($price1/100);
			$value1=explode(".",$value1);
		
			//print_R($value1);exit;
		
			$value2=($price1%100);
		}	      
 	        else 
 	        {
 	          if($c1==='0000000' && $broker_data[0]['trans_type']=='sell' )
 	          { 	
 	        	if($c1==='0000000')
 	        	{
 	        		$value1[0]=$price1;
 	        	}
 	        	else if($c1==='00000')
 	        	{
 	        		$value2=$price1;
 	        	}
 	          }
 	          else if($c1==='00000' && $broker_data[0]['trans_type']=='sell' )
 	          {
 	          	if($c1==='00000')
 	        	{
 	        		$value2=$price1;
 	        	}
 	          }
 	           
 	          else if($c1==='00000' && $broker_data[0]['trans_type']=='rent_out')
 	          { 	
 	        	if($c1==='00000')
 	        	{
 	        		$value1[0]=$price1;
 	        	}
 	        	else if($c1==='000')
 	        	{
 	        		$value2=$price1;
 	        	}
 	          }
 	          else if($c1==='000' && $broker_data[0]['trans_type']=='rent_out')
 	          { 	
 	        	if($c1==='000')
 	        	{
 	        		$value2=$price1;
 	        	}
 	          }
 	        	
 	        	
 	        	
 	        }
 	      
 	       
 	 ?>
 	 
 	 
  <tr>	
  		<?php if($mode=='Add') { ?>
  		
		    <td class="black11" id="price_exp" >Expected Price (All Inclusive):</td>
		    <td class="black11" id="price_rent" style="display:none;">Expected Rent Per Month:</td>
	    	 <?php } else if($mode=='Update') { ?>
	    	 
	    	 	<?php if($broker_data[0]['trans_type']=='sell') { ?>
	    	  		<td class="black11" id="price_exp" >Expected Price (All Inclusive):</td>
	    	  		  <td class="black11" id="price_rent" style="display:none;">Expected Rent Per Month:</td>
	    	  	<?php } else if($broker_data[0]['trans_type']=='rent_out') { ?>
	    	  		<td class="black11" id="price_exp" style="display:none;">Expected Price:</td>
	    	  		<td class="black11" id="price_rent" >Expected Rent Per Month:</td>
	    	 <?php } } ?>
</tr>
<tr>	
	    
	    <td class="black11"><input type="text" name="price1" id="price1" value="<?php print $value1[0]; ?>" /></td>
	     <td class="black11" >
	     <select name="price_type1" id="price_type1" value="">
	     	<option value="">Select</option>
	     	<option value="crores" <?php if($c1 === "0000000") { ?> selected <?php } ?> >Crore</option>
	     	
	     </select>
	     </td>
	</tr>
	<tr>     
	     <td class="black11"><input type="text" name="price2" id="price2" value="<?php print $value2; ?>" /></td>
	     <td class="black11" >
	     <select name="price_type2" id="price_type2" value="">
	     	<option value="">Select</option>
	     	<option value="crores" <?php if($c1 === "0000000") { ?> selected <?php } ?> >Crore</option>
	     	
	     </select>
	     </td>
	    
  </tr>
   
     
     
    <!-- <tr>
	    <td class="black11" >Type:</td>
	   	     <td class="black11" >
	     <select name="type_owner" id="type_owner" value="">
	     	<option value="">Select</option>
	     	<!--<option value="owner" <?php if($broker_data[0]['type']=='owner') { ?> selected <?php } ?>>Owner</option>
	     	<option value="brokerdirect" <?php if($broker_data[0]['type']=='brokerdirect') { ?> selected <?php } ?> >Broker-direct</option>
	     	<option value="indirect" <?php if($broker_data[0]['type']=='indirect') { ?> selected <?php } ?> >Broker-Indirect</option>
	    
	     </select>
	     </td>
	    
  </tr>-->
  
  
    <tr>
	    <th>Address</th>
  </tr>
  
  <tr>
    <td class="black11">Nearest Building:</td>
    <td class="black11"><input type="text" name="nearest_building" id="nearest_building" value="<?php print $broker_data[0]['b_name']?>" /><input type="hidden" name="near_buil_id" id="near_buil_id" value="<?php print $broker_data[0]['near_building_id']?>" /></td>
    
  </tr>
  
   <tr>
	    <td class="black11" >Building Name / Flat No/ Floor</td>
	    <td class="black11"><input type="text" name="floor1" id="floor" value="<?php print $broker_data[0]['floor']?>" /></td>
	     
  </tr>
    <tr>
	    <td class="black11" >Region / Area</td>
	    <td class="black11"><input type="text" name="add_line3" id="add_line3" value="<?php print $broker_data[0]['add_line3']?>" /></td>
	     
  </tr>
    <tr>
	    <td class="black11" >Nearest Road</td>
	    <td class="black11"><input type="text" name="add_line2" id="add_line2" value="<?php print $broker_data[0]['add_line2']?>" /></td>
	     
  </tr>
  
   <tr>
	    <td class="black11" >Street Name</td>
	    <td class="black11"><input type="text" name="add_line1" id="add_line1" value="<?php print $broker_data[0]['add_line1']?>" /></td>
	     
  </tr>
     <tr>
	    <td class="black11" >Location Landmark</td>
	    <td class="black11"><input type="text" name="landmark" id="landmark" value="<?php print $broker_data[0]['landmark']?>" /></td>
	     
  </tr>
   <tr>
	     <td class="black11" >City Name</td>
	    <td class="black11"><input type="text" name="city" id="city" value="<?php print $broker_data[0]['city']?>" /></td>
	     
  </tr>
   <tr>
	    <td class="black11" >Pin Code</td>
	    <td class="black11"><input type="text" name="zip_code" id="zip_code" value="<?php print $broker_data[0]['zip_code']?>" /></td>
	    
  </tr>
   <tr>
	    <td class="black11" >State</td>
	    <td class="black11">
	    	 <select name="state"  id="state"  value="">
		    	<option value="">Select State</option>
		    	<?php echo get_states_options($broker_data[0]['state_id']); ?>
		 </select>
	    </td>
	     
  </tr>
  
  <tr>
	    <td class="black11" >Country</td>
	    <td class="black11"><input type="text" name="country" id="country" value="India" /></td>
	     
  </tr>
  
  
  
  
  
  
  
  
  
  <tr>
    <td>&nbsp;</td>
    <td class="black11"><input type="submit" name="submit1"  value="<?=$mode;?>" />&nbsp;<!--<input type="reset" name="reset"  value="Reset" />&nbsp;<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=static_pages';" value="Cancel" />--></td>
  </tr>
</table>

<?php } ?>

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
					
					<td><input type="text" class="input" placeholder="Search" name="c_id" id="c_id" value=""></td>
					<!--<td><input type="text" class="input" placeholder="Name" name="c_name" id="c_name" value=""></td>
					<td><input type="text" class="input" placeholder="Email ID" name="email_id" id="email_id" value=""></td>
					<td><input type="text" class="input" placeholder="Mobile No" name="mob_no" id="mob_no" value=""></td>-->
				
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
        	
 <script language="JavaScript" type="text/javascript">        	
$( document ).ready(function() {
  	autopopulate();
});
function autopopulate()
{
	var table_name = 'client_personal_details';
	var vals = 'client_id,f_name,l_name,email1,mobile_no';
	var url = 'search_result.php?col_name='+vals+'&table_name='+table_name+'&where=owner';
	$( "#c_id" ).autocomplete({
		source: url,
	});
}
</script>	

<script language="JavaScript" type="text/javascript">
function showhidediv(){

	if (document.getElementById('residential').checked)
	{
	document.getElementById('apart').style.display = 'block';
	document.getElementById('furn').style.display = 'block';
	document.getElementById('cell').style.display = 'none';
	}
	else
	{
	document.getElementById('apart').style.display = 'none';
	}
	
	if (document.getElementById('commercial').checked)
	{
	document.getElementById('off_ret').style.display = 'block';
	document.getElementById('cell').style.display = 'none';
	document.getElementById('furn').style.display = 'none';
	}
	else
	{
	document.getElementById('off_ret').style.display = 'none';
	}
	


}

function off_retfun(){

	
	if (document.getElementById('office_check').value=='1')
	{
		document.getElementById('furn').style.display = 'block';
		document.getElementById('cell').style.display = 'none';
	
	}
	else if(document.getElementById('office_check').value=='2')
	{
		
		document.getElementById('furn').style.display = 'none';
		document.getElementById('cell').style.display = 'block';
	}
	


}


function transaction1(){

	
	
	if (document.getElementById('transaction').value=='sell')
	{
		document.getElementById('price_exp').style.display = 'block';
		document.getElementById('price_rent').style.display = 'none';
		
		
		document.getElementById('price_type1').innerHTML = '<option value="">Select</option><option value="crores" <?php if($value1[0]> 0 ) { ?> selected <?php } ?> >Crore</option>';
		document.getElementById('price_type2').innerHTML = '<option value="">Select</option><option value="laks" <?php if($c1 === '00000') { ?> selected <?php } ?> >Lac</option>';
		
	
	}
	else if(document.getElementById('transaction').value=='rent_out')
	{
		
		document.getElementById('price_exp').style.display = 'none';
		document.getElementById('price_rent').style.display = 'block';
		
		
		document.getElementById('price_type1').innerHTML = '<option value="">Select</option><option value="laks" <?php if($value1[0]> 0 ) { ?> selected <?php } ?> >Lac</option>';
		document.getElementById('price_type2').innerHTML = '<option value="">Select</option><option value="thousand" <?php if($c1 === '000') { ?> selected <?php } ?> >Thousand</option>';
	}
	


}
$(document).ready(function(){
	
	/*var office_retail = $('#office_check').val();
	var is_office = (office_retail == '1' || office_retail == '2') ? 1 : 0;
	//alert(is_office);
	if(is_office == '1')
	{
		$('#off_ret').show();
		$('#cell').hide();
		$('#furn').hide();
		$('#apartment1').hide();
	}
	else
	{
		$('#apartment1').show();
		$('#furn').show();
		$('#off_ret').hide();
		$('#cell').hide();
	}*/
	showhidediv();
	off_retfun();
	transaction1();
}); 

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
     var mode='<?php echo $mode; ?>';

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#register-form").validate({
                rules: {
                    f_name: "required",
                    l_name: "required",
                   
                    mobile: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                  /*  office: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },*/
                    email1: {
                        required: true,
                        email: true
                    },
                  /*  email2: {
                        required: true,
                        email: true
                    },*/
                     aaa: "required",
                     bbb: "required",
                     ccc: "required",
                     ddd: "required",
                     eee: "required",
                    // remark: "required",
                    
                    
                     transaction_type: "required",
                    residential: "required",
                   
                    scaleble: {
                        required: true,
                        number: true
                        
                    },
                     furnished: "required",
                     transaction: "required",
                     warm_cell: "required",
                     
                     
                    price1: {
                        required: true,
                        number: true
                        
                    },
                   price_type1: "required",
                    
                     price2: {
                        required: true,
                        number: true
                        
                    },
                    price_type2: "required",
                    nearest_building: "required",
                    floor1:"required",
                   /* add_line1:"required",
                    add_line2:"required",
                    add_line3:"required", */
                    city:"required",
                   
                   zip_code: {
                        required: true,
                        number: true
                        
                    },
                    state: "required",
                    
                    
                    
                },
                messages: {
                    f_name: "Please enter First Name",
                    l_name: "Please enter Last Name",
                    city: "Please enter your City",
                    mobile: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },
                  /*  office: {
                        required: "Please enter office No",
                        number: "Please enter office No Numeric",
                        maxlength: "Your office No more than 10 digit",
                    }, */
                     email1: {
                        required: "Please enter email Address",
                        email: "Please enter valid email Address",
                      
                    },
                    
                   /*  email2: {
                        required: "Please enter email Address",
                        email: "Please enter valid email Address",
                      
                    },*/
                     aaa: "Please Accept Term And Condition",
                     bbb: "Please Accept Term And Condition",
                     ccc: "Please Accept Term And Condition",
                     ddd: "Please Accept Term And Condition",
                     eee: "Please Accept Term And Condition",
                     //remark: "Please Enter Owner Remark",
                   
                   transaction_type: "Please Select  Transaction Type",
                    residential: "Please Select Property Type",
                  
                    scaleble: {
                        required: "Please enter Approximate Area",
                        number: "Please enter Approximate Area Numeric",
                       
                    },
                    furnished:"Please Select Furniture Type",
                    transaction:"Please Select Office/Retail",
                     warm_cell:"Please Select Cell",
                   
                   min_price1: {
                        required: "Please enter  Price ",
                        number: "Please enter  Price Numeric",
                       
                    }, 	
                    
                   price_type1: "Please Select  Price Type",
                    
                    price2: {
                        required: "Please enter  Price ",
                        number: "Please enter  Price Numeric",
                       
                    }, 	
                    
                     price_type2: "Please Select  Price Type",
                     
                     nearest_building: "Please enter  Nearest Building", 
                     floor1: "Please enter  Building Name / Flat No/ Floor",
                    /* add_line1:"Please enter  Address 1",
                     add_line2:"Please enter  Address 2",
                     add_line3:"Please enter  Address 3", */
                     city:"Please enter  City",
                     zip_code: {
                        required: "Please enter Pin Code ",
                        number: "Please enter Pin Code Numeric",
                      }, 
                      state:"Please Select  State",
                   
                   
                   
                    
                },
                submitHandler: function(form) {
                 var mobile = $("input[name*='mobile']").val();
                
                 if(mode=='Add')
                	{		
                	//alert(mobile);
                	$.ajax({
                			url : "uniqueowner_result.php",
                			data: {m:mobile},
                			type : "post",
                			success : function(html){
                				
                				var flg = html.split('$');
                				//alert(html);
                				//alert(flg);
                				
                				if( flg[0] == 0 || flg[0] == 2 ) {
                					// alert('vbv');	
                					 form.submit();
                				
                				} else {
                				
                					$('#message').html(flg[1]);
                					
                				}
                			}
                	
                		});
                		
                	}
                	else
                	{
                		form.submit();	
                	}	
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
