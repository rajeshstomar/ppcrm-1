<?php
//include("../dbconfig.php");
$msg = $_GET['msg'];
//echo"<pre>";print_r($_GET);
if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
{
	$id = $_REQUEST['id'];
	
	$sel_que ="select * from property_requirement_new left join building_database on property_requirement.near_building_id=building_database.id_building where broker_property_id= '".$id."' ";
	$broker_data = am_select($sel_que);
	//my_print_R($broker_data);exit;
	$mode = "Update";
}
else
{
	$mode = "Add";
	
	
}
//include(DIR_SCRIPT_ROOT."/fckeditor/fckeditor.php") ; 

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


<script type="text/javascript">
		$(document).ready(function() {
			$("#help12").click(function(){
			var b_id = document.getElementById("b_id").value; 
			//var b_name = document.getElementById("b_name").value; 
			//var pan_no = document.getElementById("pan_no").value;
			//var mob_no = document.getElementById("mob_no").value;  
			$("#responsebroker").html('<div style="position: relative;text-align: center;top: 40px;"><img src="images/ajax-loader.gif"></div>');
			
			$.ajax({
			    type: "POST",
			    url: "broker_result.php",
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
						var broker_id = $(this).attr('ref');
						var panno = $(this).attr('refno');
						$('#bro_own_id').val(broker_id);
						$('#pan_mob_no').val(panno);
						
						
						
						document.getElementById("close1").click();
						$("#table1").css("display","block");
						$("#table2").css("display","block");
						$("#brokerdiv").css("display","block");
						$("#ownerdiv").css("display","none");
						
						$("#brokertype").css("display","block");
						$("#ownertype").css("display","none");
						
						
						$("#brokermob").css("display","block");
						$("#ownermob").css("display","none");
						
						
					});
				}
				
				
			    }
				});
			});
			
			
			
			
			$("#help22").click(function(){
			var c_id = document.getElementById("c_id").value; 
			//var c_name = document.getElementById("c_name").value; 
			
			//var mob_no = document.getElementById("mob_no").value;  
			$("#responsebroker1").html('<div style="position: relative;text-align: center;top: 40px;"><img src="images/ajax-loader.gif"></div>');
			
			$.ajax({
			    type: "POST",
			    url: "owner_result.php",
			    dataType: "Text",
			   data: {c_id:c_id},
			    success: function(data) {
				
				if(data==0)
				{
					alert('Your Data Does Not Match');
				}
				else
				{
					document.getElementById("responsebroker1").innerHTML = data;
					$(".select_broker1").click(function(){
						
						var client_id= $(this).attr('client_id'); 
						var mobile_no = $(this).attr('mobile_no');
						
						
						$('#bro_own_id').val(client_id);
						$('#pan_mob_no').val(mobile_no);
						
						document.getElementById("close2").click();
						$("#table1").css("display","block");
						$("#table2").css("display","block");
						$("#brokerdiv").css("display","none");
						$("#ownerdiv").css("display","block");
						
						$("#brokertype").css("display","none");
						$("#ownertype").css("display","block");
						$('#user_type').val('owner');
						
						$("#brokermob").css("display","none");
						$("#ownermob").css("display","block");
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
		//$("#near_buil_id").val(tmp1[1]); 
		//$("#add_line2").val(tmp1[2]); 
		//$("#add_line1").val(tmp1[3]); 
		//$("#add_line3").val(tmp1[4]);
    //$("#landmark").val(tmp1[5]); 
		//$("#add_line2").val(tmp1[3]+','+tmp1[4]); 

		
	}
      
    });
  });
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

<form name="frm" method="post" id="register-form" action="index.php?rel=interaction_report_action">
<input type="hidden" name="mode" id="mode" value="<?=$mode;?>">
<input type="hidden" name="broker_property_id" value="<?php print $broker_data[0]['broker_property_id']?>" />
<input type="hidden" name="broker_owner_id" value="<?php print $broker_data[0]['broker_owner_id']?>" />

<?php if($_GET['id']=='') { ?>
<h2><?php echo $mode; ?> Broker Property</h2>
<table width="80%" border="1" cellspacing="2" cellpadding="2"> 
 
 <?php

	$lastid="SELECT MAX( broker_property_id) FROM property_requirement";
	$get_lastid=am_select($lastid);
	//print_R($get_lastid);exit;
	//echo $get_lastid[0]['MAX( broker_property_id)'];
	$id_last=$get_lastid[0]['MAX( broker_property_id)']+1;
	

?>

 
 
  <tr>
  <?php  //$date=date('d/m/Y'); ?>
	    <td class="black11">Date:</td>
	    <td class="black11"><input type="text" name="date" id="date" value="<?php if($broker_data[0]['property_updated_date'] !='' ) { print $broker_data[0]['property_updated_date']; }  ?>" /></td>
	
	    <td class="black11">Form No:</td>
	    <td class="black11"><input readonly type="text" name="form_no" id="form_no" value="<?php if($mode=='Add') { print 'LR'.$id_last; } else if($mode=='Update') { print 'LR'.$broker_data[0]['form_no']; } ?>" /></td>
  </tr>
<?php if($_GET['owner_id']=='' && empty($_GET['brokerID'])) { ?> 
   <tr>
    	    <th colspan="2">Add Property For Broker</th>	
    	    <th colspan="2">Add Property For Owner</th>	
    </tr> 
	


	 <tr>
	    <th colspan="2"><a href = "javascript:void(0)" onclick = "document.getElementById('help').style.display='block';document.getElementById('fade').style.display='block'" ><input type="button" name="search_broker"  value="Search Broker"></a></th>
	   
 	    <th colspan="2"><a href = "javascript:void(0)" onclick = "document.getElementById('help1').style.display='block';document.getElementById('fade').style.display='block'" ><input type="button" name="search_owner1"  value="Search Owner"></a></th>
 	    <th></th>
   </tr>
 <?php } ?> 
 
   </table>
    <table  width="80%" border="1" cellspacing="2" cellpadding="2"  id="table1" <?php if($_GET['owner_id']=='') { ?>  style="display:none;" <?php } ?> >
   <tr >
	    
	    <td class="black11" id="brokerdiv" <?php if($_GET['owner_type']=='owner') { ?> style="display:none" <?php } ?>>Broker ID:</td>
	    <td class="black11" id="ownerdiv" <?php if($_GET['owner_type']!='owner') { ?>   style="display:none" <?php } ?>>Owner ID:</td>
	    <td class="black11"><input type="text"  name="bro_own_id" id="bro_own_id" value="<?php if($_GET['owner_id']!='') { echo $_GET['owner_id']; } else { print $broker_data[0]['broker_owner_id']; } ?>" /></td>
	
	    <td class="black11" id="brokermob" <?php if($_GET['owner_type']=='owner') { ?>  style="display:none" <?php } ?>>Broker Mobile no:</td>
	     <td class="black11" id="ownermob"  <?php if($_GET['owner_type']!='owner') { ?>  style="display:none" <?php } ?>>Owner Mobile no:</td>
	    <td class="black11"><input type="text" name="pan_mob_no" id="pan_mob_no" value="<?php if($_GET['owner_mobile_no']!='') { echo $_GET['owner_mobile_no']; } else { print $broker_data[0]['pan_or_mobile']; } ?>" /></td>
  </tr>
  

   <tr id="ownertype" <?php if($_GET['owner_type']!='owner') { ?>  style="display:none" <?php } ?>>
	    <td class="black11" >Type:</td>
	   	     <td class="black11" >
	     
	     <label>Owner</label>
	     
	     
	     </td>
	    
  </tr>
   <tr id="brokertype" <?php if($_GET['owner_type']=='owner') { ?>  style="display:none" <?php } ?>>
	    <td class="black11" >Type:</td>
	   	     <td class="black11" >
	    
	    <select name="type_owner" id="type_owner" value="">
	     	<option value="brokerdirect" <?php if($broker_data[0]['type']=='brokerdirect') { ?> selected <?php } ?> >Broker-direct</option>
	     	<option value="indirect" <?php if($broker_data[0]['type']=='indirect') { ?> selected <?php } ?> >Broker-Indirect</option>
   
	     </select>
	    
	     </td>
	    
  </tr>
  <input type="hidden" name="user_type" id="user_type" value="" />
  
 
  
  <tr>
	    <th>Properties</th>
  </tr>
  
   <tr>
	   
	    <td class="black11"><input <?php if($broker_data[0]['property_main_type']=="residential") { ?>  checked="checked" <?php } ?> type="radio" name="residential" id="residential" value="residential" onclick="showhidediv();"></td>
	     <td class="black11">Residential</td>
	    	
	   
	    <td class="black11"><input <?php if($broker_data[0]['property_main_type']=="commercial") { ?>  checked="checked" <?php } ?> type="radio" name="residential" id="commercial" value="commercial" onclick="showhidediv(this);"></td>
	      <td class="black11">Commercial</td>
	   
  </tr>
  
  </table>
  
  <table width="80%"  border="1" cellspacing="2" cellpadding="2" id="apartment1"  <?php if($broker_data[0]['property_main_type']=="commercial") { ?>  style="display:none;" <?php } ?>>
   <tr>
	    <th class="black11">Type of Apartment:</th>
	    

	 <tr>
	 <td class="black11" style="width: 1%;"><input <?php if($broker_data[0]['onerk']=='1') { ?>  checked <?php } ?>  type="radio" name="bhk" id="1rk" value="1"></td>
	    <td class="black11" style="width: 4%;">1RK</td>		

<td class="black11" style="width: 1%;"><input <?php if($broker_data[0]['onerk']=='2') { ?>  checked <?php } ?>  type="radio" name="bhk" id="1bhk" value="2"></td>
	<td class="black11" style="width: 18%;">1BHK</td>		

	  </tr>  
	  <tr>
	  <td class="black11"><input <?php if($broker_data[0]['onerk']=='3') { ?>  checked <?php } ?>  type="radio" name="bhk" id="2bhk" value="3"></td>
	    <td class="black11">2BHK</td>		

<td class="black11"><input <?php if($broker_data[0]['onerk']=='4') { ?>  checked <?php } ?>  type="radio" name="bhk" id="3bhk" value="4"></td>
	<td class="black11">3BHK</td>		

	  </tr>  
	  <tr>
<td class="black11"><input <?php if($broker_data[0]['onerk']=='5') { ?>  checked <?php } ?>  type="radio" name="bhk" id="4bhk+" value="5"></td>
	    <td class="black11">4BHK+</td>		

	<td class="black11"></td>		
<td class="black11"></td>
	  </tr>  
	   
   </table>
  
  <table  width="80%" border="1" cellspacing="2" cellpadding="2" id="table2" <?php if($_GET['owner_id']=='') { ?> style="display:none;" <?php } ?> >
    
      
     <!-- <tr>
	    <td class="black11">Specify Area:</td>
	    <td class="black11">
	    	<input type="text" name="specify_area" id="specify_area" value="<?php print $broker_data[0]['specify_area']?>" />
	    </td>
    </tr>-->
    
    
      <tr id="off_ret" <?php if($broker_data[0]['property_main_type']=="residential") { ?>  style="display:none;" <?php } ?>>
	    <td class="black11">Office/Retail</td>
	    <td class="black11">
	    	
	    	<select name="office_check" id="office_check" onchange="off_retfun(this);">
	    		<option value="">Select Type</option>
	    		<option value="1" <?php if($broker_data[0]['office']=='1') { ?> selected <?php } ?>  >Office</option>
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
   <!--<tr>
	    <td class="black11">Carpet:</td>
	    <td class="black11">
	    	<input type="text" name="carpet" id="carpet" value="<?php print $broker_data[0]['carpet']?>" />
	    </td>
    </tr>-->
  
  

     <tr id="furn">
	   
	    <td class="black11"><input <?php if($broker_data[0]['furnished']=='1') { ?>  checked <?php } ?>  type="radio" name="furnished" id="furnished" value="1"></td>
	     <td class="black11">Furnished</td>
	    	
	   
	    <td class="black11"><input <?php if($broker_data[0]['furnished']=='2') { ?>  checked <?php } ?>  type="radio" name="furnished" id="unfurnished" value="2"></td>
	      <td class="black11">Unfurnished</td>
	    
	   
	    <td class="black11"><input <?php if($client_data[0]['furnished']=='3') { ?>  checked <?php } ?>  type="radio" name="furnished" id="any" value="3"></td>	
	     <td class="black11">Any</td>
	   
  </tr>
     <tr id="cell" <?php if($broker_data[0]['property_main_type']=="residential") { ?>  style="display:none;" <?php } ?>>
	    
	    <td class="black11"><input <?php if($broker_data[0]['warm_cell']=='1') { ?>  checked <?php } ?>  type="radio" name="warm_cell" id="warm_cell" value="1"></td>
	    <td class="black11">Warm Cell</td>
	    	
	   
	    <td class="black11"><input <?php if($broker_data[0]['warm_cell']=='2') { ?>  checked <?php } ?>  type="radio" name="warm_cell" id="cold_cell" value="2"></td>
	      <td class="black11">Cold Cell</td>
	   
  </tr>
  
 
 	 
 <tr>
	    <td class="black11" >Transaction:</td>
	    
	     <td class="black11" >
	     <select name="transaction" id="transaction" value=""  onchange="transaction1(this);">
	        <option value="">Select</option>
	     	<!--<option value="sell" <?php if($broker_data[0]['trans_type']=='sell') { ?> selected <?php } ?> >sell</option>-->
	     	<option value="sell" <?php if($broker_data[0]['trans_type']=='sell') { ?> selected <?php } ?> >Sell</option>
	     	<option value="rent" <?php if($broker_data[0]['trans_type']=='rent') { ?> selected <?php } ?> >Rent</option>
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
 	           
 	          else if($c1==='00000' && $broker_data[0]['trans_type']=='rent')
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
 	          else if($c1==='000' && $broker_data[0]['trans_type']=='rent')
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
	    <td class="black11" id="price_exp" >Expected Price:</td>
	    <td class="black11" id="price_rent" style="display:none;">Expected Rent Per Month:</td>
	    <?php } else if($mode=='Update') { ?>
	    	<?php if($broker_data[0]['trans_type']=='sell') { ?>
		    <td class="black11" id="price_exp" >Expected Price:</td>
		    <td class="black11" id="price_rent" style="display:none;">Expected Rent Per Month:</td>
		    <?php } else if($broker_data[0]['trans_type']=='rent') { ?>
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
    <tr>
	    <th>Address</th>
  </tr>
  
  <tr>
    <td class="black11">Nearest Building:</td>
    <td class="black11"><input type="text" name="near_building_id" id="nearest_building" value="<?php print $broker_data[0]['b_name']?>" /><input type="hidden" name="near_buil_id" id="near_buil_id" value="<?php print $broker_data[0]['near_building_id']?>" /></td>
    
  </tr>
   <tr>
	    <td class="black11" >Flat No./House No./Floor</td>
	    <td class="black11"><input type="text" name="flat" id="" value="" /></td>
	     
  </tr>
   <tr>
	    <td class="black11" >Nearest Road</td>
	    <td class="black11"><input type="text" name="nearest_road" id="add_line2" value="<?php print $broker_data[0]['nearest_road']?>" />
	    </td>
	     
  </tr>
  <tr>
	    <td class="black11" >Landmark (if any)</td>
	    <td class="black11"><input type="text" name="landmark" value="" />
	    </td>
	     
  </tr>
  
   <tr>
	    <td class="black11" >Sub-Locality/Sector</td>
	    <td class="black11"><input type="text" name="sector" id="add_line1" value="" /></td>
	     
  </tr>
     <tr>
	    <td class="black11" >Locality/Suburb</td>
	    <td class="black11"><input type="text" name="locality" id="landmark" value="" /></td>
	     
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
		    	<option value="Maharashtra" selected="selected">Maharashtra</option>
		    	
		 </select>
	    </td>
	     
  </tr>
  
  <tr>
	    <td class="black11" >Country</td>
	    <td class="black11"><input type="text" name="country" id="country" value="India" /></td>
	     
  </tr>
 
 <?php if($mode!='Update') { ?>
   <tr>
	    <td class="black11" colspan="1"><input type="submit" onClick="return prop_exist(this);" name="addmore2" id="add_more2" value="Add More Property"></td>
	    <input type="hidden" name="addmore" value="">
<?php } ?>	    
 
  </tr>
  
 
 <?php if($_GET['id']=='') { ?>
  
  <tr>
  	<th class="black11" colspan="4">Terms and Conditions*</th>
  </tr>
   <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="c" id="c">&nbsp;&nbsp;&nbsp;1. I undertake to update PropertyPistoi in case above listed property is sold/rented out. </td>  
	    
  </tr>
    <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="c" id="c">&nbsp;&nbsp;&nbsp;2. I agree to payment terms of PropertyPistoi (side-by-side) in case of transaction <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;involving PropertyPistoi. I will not share my brokerage with PropertyPistoi & neither<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; shall expect any sharing from PropertyPistol.</td>  
	    
  </tr>
   
  
  <?php } ?> 
     
  <tr>
    <td>&nbsp;</td>
    <td class="black11"><input type="submit" name="submit1" value="<?=$mode;?>"/>&nbsp;<!--<input type="reset" name="reset"  value="Reset" />&nbsp;<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=static_pages';" value="Cancel" />-->
    <div class="loading" id="loading"></div>
    </td>
  </tr>
</table>

<?php } else { ?>
<h2><?php echo $mode; ?> Broker Property</h2>
<table width="80%" border="0" cellspacing="2" cellpadding="2"> 
 
  <tr>
  <?php  //$date=date('d/m/Y'); ?>
	    <td class="black11">Date:</td>
	    <td class="black11"><input type="text" name="date" id="date" value="<?php if($broker_data[0]['property_updated_date'] !='' ) { print $broker_data[0]['property_updated_date']; }  ?>" /></td>
	    <input type="hidden" name="property_created_date" id="property_created_date" value="<?php echo $broker_data[0]['property_created_date'] ?>">			

	   <td class="black11">Form No:</td>
	    <td class="black11"><input readonly type="text" name="form_no" id="form_no" value="<?php if($mode=='Add') { print 'LR'.$id_last; } else if($mode=='Update') { print 'LR'.$broker_data[0]['form_no']; } ?>" /></td>
  </tr>
    <tr>
    	  
    	   
    	    <th colspan="2">Add Property For Broker</th>	
    	    <th colspan="2">Add Property For Owner</th>	
    </tr> 
	
	 <tr>
	    <th colspan="2"><a href = "javascript:void(0)" onclick = "document.getElementById('help').style.display='block';document.getElementById('fade').style.display='block'" ><input type="button" name="search_broker"  value="Search Broker"></a></th>
	   
 	    <th colspan="2"><a href = "javascript:void(0)" onclick = "document.getElementById('help1').style.display='block';document.getElementById('fade').style.display='block'" ><input type="button" name="search_owner1"  value="Search Owner"></a></th>
 	    <th></th>
   </tr>
   
   </table>
    <table  width="80%" border="0" cellspacing="2" cellpadding="2"   >
   <tr >
	     <?php if($broker_data[0]['flag']=='brokerdirect' || $broker_data[0]['flag']=='indirect' ) { ?>
	    <td class="black11">Broker ID:</td>
	    <?php } else if($broker_data[0]['flag']=='owner') { ?>
	    
	    <td class="black11">Owner ID:</td>
	    
	    <?php } ?>
	    
	    <td class="black11"><input type="text"  name="bro_own_id" id="bro_own_id" value="<?php if($_GET['owner_id']!='') { echo $_GET['owner_id']; } else { print $broker_data[0]['broker_owner_id']; } ?>" /></td>
	
	   <?php if($broker_data[0]['flag']=='brokerdirect' || $broker_data[0]['flag']=='indirect' ) { ?>
	    <td class="black11">Broker Mobile no:</td>
	     <?php } else if($broker_data[0]['flag']=='owner') { ?>
	     <td class="black11">Owner Mobile no:</td>
	      <?php } ?>
	    <td class="black11"><input type="text" name="pan_mob_no" id="pan_mob_no" value="<?php print $broker_data[0]['pan_or_mobile']?>" /></td>
  </tr>
  

    <?php if($broker_data[0]['flag']=='brokerdirect' || $broker_data[0]['flag']=='indirect' ) { ?>
   <tr>
	    <td class="black11" >Type:</td>
	   	     <td class="black11" >
	    
	    <select name="type_owner" id="type_owner" value="">
	     	<option value="">Select</option>
	     	<!--<option value="owner" <?php if($broker_data[0]['type']=='owner') { ?> selected <?php } ?>>Owner</option>-->
	     	<option value="brokerdirect" <?php if($broker_data[0]['type']=='brokerdirect') { ?> selected <?php } ?> >Broker-direct</option>
	     	<option value="indirect" <?php if($broker_data[0]['type']=='indirect') { ?> selected <?php } ?> >Broker-Indirect</option>
	    
	     </select>
	    
	     </td>
	     <input type="hidden" name="user_type" id="user_type" value="" />
	    
  </tr>
  <?php } else if($broker_data[0]['flag']=='owner') { ?>
  <tr>
	    <td class="black11" >Type:</td>
	   	     <td class="black11" >
	     
	     <label name="type_owner" id="type_owner" value="owner" />Owner</label>
	     <input type="hidden" name="user_type" id="user_type" value="owner" />
	     </td>
	    
  </tr>
 <?php } ?>
  
  <tr>
	    <th>Properties</th>
  </tr>
  
   <tr>
	    <td class="black11">Residential</td>
	    <td class="black11"><input <?php if($broker_data[0]['property_main_type']=="residential") { ?>  checked="checked" <?php } ?> type="radio" name="residential" id="residential" value="residential" onclick="showhidediv();"></td>
	    	
	     <td class="black11">Commercial</td>
	    <td class="black11"><input <?php if($broker_data[0]['property_main_type']=="commercial") { ?>  checked="checked" <?php } ?> type="radio" name="residential" id="commercial" value="commercial" onclick="showhidediv(this);"></td>
	   
  </tr>
  
  </table>
  
  <table width="80%"  border="0" cellspacing="2" cellpadding="2" id="apartment1"  <?php if($broker_data[0]['property_main_type']=="commercial") { ?>  style="display:none;" <?php } ?>>
   <tr>
	    <th class="black11">Type of Apartment:</th>
	    

	 <tr>
	 <td class="black11" style="width: 1%;"><input <?php if($broker_data[0]['onerk']=='1') { ?>  checked <?php } ?>  type="radio" name="bhk" id="1rk" value="1"></td>
	    <td class="black11" style="width: 4%;">1RK</td>		

<td class="black11" style="width: 1%;"><input <?php if($broker_data[0]['onerk']=='2') { ?>  checked <?php } ?>  type="radio" name="bhk" id="1bhk" value="2"></td>
	<td class="black11" style="width: 18%;">1BHK</td>		

	  </tr>  
	  <tr>
	  <td class="black11"><input <?php if($broker_data[0]['onerk']=='3') { ?>  checked <?php } ?>  type="radio" name="bhk" id="2bhk" value="3"></td>
	    <td class="black11">2BHK</td>		

<td class="black11"><input <?php if($broker_data[0]['onerk']=='4') { ?>  checked <?php } ?>  type="radio" name="bhk" id="3bhk" value="4"></td>
	<td class="black11">3BHK</td>		

	  </tr>  
	  <tr>
<td class="black11"><input <?php if($broker_data[0]['onerk']=='5') { ?>  checked <?php } ?>  type="radio" name="bhk" id="4bhk+" value="5"></td>
	    <td class="black11">4BHK+</td>		

	<td class="black11"></td>		
<td class="black11"></td>
	  </tr>  
	   
   </table>
  
  <table  width="80%" border="0" cellspacing="2" cellpadding="2"  >
    
      
     <!-- <tr>
	    <td class="black11">Specify Area:</td>
	    <td class="black11">
	    	<input type="text" name="specify_area" id="specify_area" value="<?php print $broker_data[0]['specify_area']?>" />
	    </td>
    </tr>-->
    
    
      <tr id="off_ret" <?php if($broker_data[0]['property_main_type']=="residential") { ?>  style="display:none;" <?php } ?>>
	    <td class="black11">Office/Retail</td>
	    <td class="black11">
	    	
	    	<select name="office_check" id="office_check" onchange="off_retfun(this);">
	    		<option value="">Select Type</option>
	    		<option value="1" <?php if($broker_data[0]['office']=='1') { ?> selected <?php } ?>  >Office</option>
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
   <!--<tr>
	    <td class="black11">Carpet:</td>
	    <td class="black11">
	    	<input type="text" name="carpet" id="carpet" value="<?php print $broker_data[0]['carpet']?>" />
	    </td>
    </tr>-->
  
  

     <tr id="furn">
	    <td class="black11">Furnished</td>
	    <td class="black11"><input <?php if($broker_data[0]['furnished']=='1') { ?>  checked <?php } ?>  type="radio" name="furnished" id="furnished" value="1"></td>
	    	
	     <td class="black11">Unfurnished</td>
	    <td class="black11"><input <?php if($broker_data[0]['furnished']=='2') { ?>  checked <?php } ?>  type="radio" name="furnished" id="unfurnished" value="2"></td>
	    <td class="black11">Any</td>
	    <td class="black11"><input <?php if($client_data[0]['furnished']=='3') { ?>  checked <?php } ?>  type="radio" name="furnished" id="any" value="3"></td>	
	   
  </tr>
     <tr id="cell" <?php if($broker_data[0]['property_main_type']=="residential") { ?>  style="display:none;" <?php } ?>>
	    <td class="black11">Warm Cell</td>
	    <td class="black11"><input <?php if($broker_data[0]['warm_cell']=='1') { ?>  checked <?php } ?>  type="radio" name="warm_cell" id="warm_cell" value="1"></td>
	    	
	     <td class="black11">Cold Cell</td>
	    <td class="black11"><input <?php if($broker_data[0]['warm_cell']=='2') { ?>  checked <?php } ?>  type="radio" name="warm_cell" id="cold_cell" value="2"></td>
	   
  </tr>
  
 
 	 
 <tr>
	    <td class="black11" >Transaction:</td>
	    
	     <td class="black11" >
	     <select name="transaction" id="transaction" value=""  onchange="transaction1(this);">
	        <option value="">Select</option>
	     	<!--<option value="sell" <?php if($broker_data[0]['trans_type']=='sell') { ?> selected <?php } ?> >sell</option>-->
	     	<option value="sell" <?php if($broker_data[0]['trans_type']=='sell') { ?> selected <?php } ?> >Sell</option>
	     	<option value="rent" <?php if($broker_data[0]['trans_type']=='rent') { ?> selected <?php } ?> >Rent</option>
	     <!--	<option value="rent_out" <?php if($broker_data[0]['trans_type']=='rent_out') { ?> selected <?php } ?> >Rent Out</option>  -->
	     </select>
	     </td>
	    
  </tr>	
 	 <?php    $price=$broker_data[0]['price'];
 	       
 	     
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
 	           
 	          else if($c1==='00000' && $broker_data[0]['trans_type']=='rent')
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
 	          else if($c1==='000' && $broker_data[0]['trans_type']=='rent')
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
	    <td class="black11" id="price_exp" >Expected Price:</td>
	    <td class="black11" id="price_rent" style="display:none;">Expected Rent Per Month:</td>
	    <?php } else if($mode=='Update') { ?>
	    	<?php if($broker_data[0]['trans_type']=='sell') { ?>
		    <td class="black11" id="price_exp" >Expected Price:</td>
		    <td class="black11" id="price_rent" style="display:none;">Expected Rent Per Month:</td>
		    <?php } else if($broker_data[0]['trans_type']=='rent') { ?>
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
	     <td class="black11"><input type="text" name="price2" id="price2" value="<?php print $value2; ?>" /></td>
	     <td class="black11" >
	     <select name="price_type2" id="price_type2" value="">
	     	<option value="">Select</option>
	     	<option value="crores" <?php if($c1 === "0000000") { ?> selected <?php } ?> >Crore</option>
	     	
	     </select>
	     </td>
	    
  </tr>
  <tr>
	    <th>Address</th>
  </tr>
  
  <tr>
    <td class="black11">Nearest Building:</td>
    <td class="black11"><input type="text" name="nearest_building" id="nearest_building" value="<?php print $broker_data[0]['b_name']?>" /><input type="hidden" name="near_buil_id" id="near_buil_id" value="<?php print $broker_data[0]['near_building_id']?>" /></td>
    
  </tr>
   <tr>
	    <td class="black11" >Address line 1</td>
	    <td class="black11"><input type="text" name="add_line1" id="add_line1" value="<?php print $broker_data[0]['add_line1']?>" /></td>
	     
  </tr>
  <tr>
	    <td class="black11" >Address line 2</td>
	    <td class="black11"><input type="text" name="add_line2" id="add_line2" value="<?php print $broker_data[0]['add_line2']?>" /></td>
	     
  </tr>
  <tr>
	    <td class="black11" >Address line 3</td>
	    <td class="black11"><input type="text" name="add_line3" id="add_line3" value="<?php print $broker_data[0]['add_line3']?>" /></td>
	     
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
		    	<option value="">Maharashtra</option>
		 	 </select>
	    </td>
	     
  </tr>
  
  <tr>
	    <td class="black11" >Country</td>
	    <td class="black11"><input type="text" name="country" id="country" value="India" /></td>
	     
  </tr>
 
 <?php if($mode!='Update') { ?>
   <tr>
	    <td class="black11" colspan="1"><input type="submit" name="addmore1" id="add_more1" value="AddMoreProperty" onClick="return prop_exist(this);">
	    <input type="hidden" name="addmore" value="">
	    
	    </td>
<?php } ?>	    
 
  </tr>
  <tr>
	    <td class="black11" colspan="1">Note:</td>
	    <td class="black11" colspan="3">Note will come here.</td>
	    
  </tr>
  
     
  <tr>
    <td>&nbsp;</td>
    <td class="black11"><input type="submit" name="submit12" value="<?=$mode;?>" onClick="return prop_exist(this);"/>&nbsp;<!--<input type="reset" name="reset"  value="Reset" />&nbsp;<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=static_pages';" value="Cancel" />-->
    <div class="loading" id="loading"></div>	
</td>
  </tr>
</table>

<?php } ?>

</form>

<script type="text/javascript">
/*function validate()
{
	if(document.getElementById('page_title').value == "")
	{
		alert("Please enter page title");
		document.getElementById('page_title').focus();
		return false;
	}
	return true;
}*/
</script>


        	
        	<div id="help" style="min-height: 130px;" class="white_content">
        	<div style="position:relative;">
        	<form  name="help"  >	
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr class="gray">
					<td>Serach:</td>
					
					<td><input type="text" class="input" placeholder="Search" name="b_id" id="b_id" value=""></td>
					<!--<td><input type="text" class="input" placeholder="Broker Name" name="b_name" id="b_name" value=""></td>
					<td><input type="text" class="input" placeholder="Pan Card No" name="pan_no" id="pan_no" value=""></td>
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
        	
        	

        	
        	<div id="help1" style="min-height: 130px;" class="white_content">
        	<div style="position:relative;">
        	<form  name="help1"  >	
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr class="gray">
					<td>Serach:</td>
					
					<td><input type="text" class="input" placeholder="Search" name="c_id" id="c_id" value=""></td>
					<!--<td><input type="text" class="input" placeholder="Owner Name" name="c_name" id="c_name" value=""></td>
					
					<td><input type="text" class="input" placeholder="Mobile No" name="mob_no" id="mob_no" value=""></td>-->
				
				<td><input type="button" name="help1" id="help22" class="btn submit" value="search" ></td>
				 </tr>	
				
				
				
			</table>
			
			
		</form>
		
		
		<div id="responsebroker1">
		
		</div>
		 <a href = "javascript:void(0)"  onclick = "document.getElementById('help1').style.display='none';document.getElementById('fade').style.display='none'"><span class="close1" id="close2" ></span></a>
        	
        	</div>
        	</div>   
        	<div id="fade" class="black_overlay"></div>    	
 <script language="JavaScript" type="text/javascript">
function showhidediv(){

	if (document.getElementById('residential').checked)
	{
	
	document.getElementById('apartment1').style.display = 'block';
	document.getElementById('furn').style.display = 'block';
	document.getElementById('cell').style.display = 'none';
	}
	else
	{
	document.getElementById('apartment1').style.display = 'none';
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
	else if(document.getElementById('transaction').value=='rent')
	{
		
		document.getElementById('price_exp').style.display = 'none';
		document.getElementById('price_rent').style.display = 'block';
		
		
		
		document.getElementById('price_type1').innerHTML = '<option value="">Select</option><option value="laks" <?php if($value1[0]> 0 ) { ?> selected <?php } ?> >Lac</option>';
		document.getElementById('price_type2').innerHTML = '<option value="">Select</option><option value="thousand" <?php if($c1 === '000') { ?> selected <?php } ?> >Thousand</option>';
	}
	


}

$(document).ready(function(){
	
	$( "#type_owner" ).change(function() {
		var val = $(this).val();
		$('#user_type').val(val);
	});
	
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
$( document ).ready(function() {
  	autopopulate();
});
function autopopulate()
{
	var table_name = 'broker';
	var vals = 'broker_id,broker_name,mobile1_no,pan_card_num';
	var url = 'search_result.php?col_name='+vals+'&table_name='+table_name;
	$( "#b_id" ).autocomplete({
		source: url,
	});
}

$( document ).ready(function() {
  	autopopulate1();
});
function autopopulate1()
{
	var table_name = 'client_personal_details';
	var vals = 'client_id,f_name,l_name,email1,mobile_no';
	var url = 'search_result.php?col_name='+vals+'&table_name='+table_name+'&where=owner';
	$( "#c_id" ).autocomplete({
		source: url,
	});
}

</script>
<?php 
## condition for display the form for adding the brokers property detail from property listing page.
if(isset($_GET['brokerID']) && $_GET['brokerID']!=''){?>
	<script type="text/javascript">
	$("#bro_own_id").val(<?=$_GET['brokerID'];?>);
	$('#bro_own_id').prop('readonly',true);
	$('#bro_own_id').css('background-color','#DEDEDE');
	$("#table1").css("display","block");
	$("#table2").css("display","block");
	$("#brokerdiv").css("display","block");
	$("#ownerdiv").css("display","none");

	$("#brokertype").css("display","block");
	$("#ownertype").css("display","none");


	$("#brokermob").css("display","block");
	$("#ownermob").css("display","none");
	</script>
<?php } ?>

<script type="text/javascript">
function prop_exist(elem)
{
	var id = $(elem).attr("id");
	if(id == 'add_more1' || id == 'add_more2')
	{
		//alert(id+"sasa");
		$("input[name='addmore']").val("AddMoreProperty");
	}
	//alert(id);
	//alert("sasa"); return false;
	$("#loading").html('<img src="images/loader.gif">');
	var str = $("#register-form").serialize(); 
	$.ajax({

		type: "POST",
		url: "check_property.php?"+str,
		success: function(html){
		//alert(html); return false;
			if(html.trim() == '1')
			{
				
				$("#loading").html('<font style="color:red">Property already exist..</font>'); return false;
			}
			else if(html.trim() == '0')
			{
				//alert(html); return false;
				$("#register-form").submit();
			}
		}
    	});
    	return false;
}
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
            $("#register-form1").validate({
                rules: {
                   /* transaction_type: "required",
                    residential: "required",
                   
                    scaleble: {
                        required: true,
                        number: true
                        
                    },
                     furnished: "required",
                     transaction: "required",
                     warm_cell: "required",
                     
                     
                    price1: {
                        required:addmore2 true,
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
                    add_line1:"required",
                    add_line2:"required",
                    add_line3:"required",
                    city:"required",
                   
                   zip_code: {
                        required: true,
                        number: true
                        
                    },
                    state: "required",
                    
                    */
                    
                    
                },
                messages: {
                /*    transaction_type: "Please Select  Transaction Type",
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
                     add_line1:"Please enter  Address 1",
                     add_line2:"Please enter  Address 2",
                     add_line3:"Please enter  Address 3",
                     city:"Please enter  City",
                     zip_code: {
                        required: "Please enter Pin Code ",
                        number: "Please enter Pin Code Numeric",
                      }, 
                      state:"Please Select  State",	
                      
                     */
                    
                },
                submitHandler: function(form) {
                	$("#loading").html('<img src="images/loader.gif">');
			var str = $("#register-form").serialize();  
			$.ajax({
		
				type: "POST",
				url: "check_property.php?"+str,
				success: function(html){
			
								
				
					if(html.trim() == '1')
					{
						//alert(html);
						$("#loading").html('<font style="color:red">Property already exist..</font>'); return false;
					}
					else if(html.trim() == '0')
					{
						form.submit();
					}
				}
		    	});
		    	
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
