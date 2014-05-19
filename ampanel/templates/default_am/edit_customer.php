<?php
//include("../dbconfig.php");
$msg = $_GET['msg'];

if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
{
	$id = $_REQUEST['id'];
	
	$sel_que ="select * from client_personal_details where client_id= '".$id."' ";
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


$build1="select b_region_area  from building_database";
$build_data1 = am_select($build1);

$build_array1 = array();

for($i=0;$i<count($build_data1);$i++)
{
	
	
	$build_array1[]=$build_data1[$i]['b_region_area'];
}

$cnt1 = '["'.implode('","',$build_array1).'"]';


?>


<script language="JavaScript" type="text/javascript">
function showhidediv3(){
	
	
	
	if (document.getElementById('add_customer').value='Add Cutomer')
	{
	
	document.getElementById('customerinfo').style.display = 'block';
  	document.getElementById('property1').style.display = 'block';
    	document.getElementById('appart').style.display = 'block';
      	document.getElementById('property2').style.display = 'block';
        
	document.getElementById('customerinfo1').style.display = 'none';
	
	}
	else
	{
	document.getElementById('customerinfo').style.display = 'none';
  document.getElementById('property1').style.display = 'none';
  document.getElementById('appart').style.display = 'none';
  document.getElementById('property2').style.display = 'none';
  
	}
	
	
}

function showhidediv1(){
	
	
	
	if (document.getElementById('search_customer').value='Search Owner')
	{
	
	document.getElementById('customerinfo').style.display = 'none';
  document.getElementById('property1').style.display = 'none';
  document.getElementById('appart').style.display = 'none';
  document.getElementById('property2').style.display = 'none';
  
	
	
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
						$("a.propertylink").attr("href", "index.php?&rel=edit_property&customer_id="+client_id+"&mobile_no="+mobile_no);
						
						
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

   <script>
  $(function() {
    var availableTags = <?php echo $cnt1 ?>; 
    $( "#area1" ).autocomplete({
      source: availableTags,
      
      
    });
     $( "#area2" ).autocomplete({
      source: availableTags,
      
      
    });
     $( "#area3" ).autocomplete({
      source: availableTags,
      
      
    });
    $( "#area4" ).autocomplete({
      source: availableTags,
      
      
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

<form name="frm" method="post" id="register-form" action="index.php?rel=customer_action" enctype="multipart/form-data" >
<input type="hidden" name="mode" id="mode" value="<?=$mode;?>">
<input type="hidden" name="client_id" value="<?php print $client_data[0]['client_id']?>" />
<input type="hidden" name="property_id" value="<?php print $client_data[0]['property_id']?>" />
<input type="hidden" name="area_id" value="<?php print $client_data[0]['area_id']?>" />
	
<?php if($_GET['id']!='') { ?>
<h2> <?php echo $mode; ?> Customer </h2>	
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
	    <td class="black11"><input type="text" name="add_line1" id="add_line1" value="<?php print $client_data[0]['add_line1']?>" /></td>
	     
  </tr>
  <tr>
	    <td class="black11" >Address line 2</td>
	    <td class="black11"><input type="text" name="add_line2" id="add_line2" value="<?php print $client_data[0]['add_line2']?>" /></td>
	     
  </tr>
  <tr>
	    <td class="black11" >Address line 3</td>
	    <td class="black11"><input type="text" name="add_line3" id="add_line3" value="<?php print $client_data[0]['add_line3']?>" /></td>
	     
  </tr>
   <tr>
	    <td class="black11" >Pin Code</td>
	    <td class="black11"><input type="text" name="zip_code" id="zip_code" value="<?php print $client_data[0]['zip_code']?>" /></td>
</tr>	    
<tr>
	    
	     <td class="black11" >City Name</td>
	    <td class="black11"><input type="text" name="city" id="city" value="<?php print $client_data[0]['city']?>" /></td>
  </tr>
  <tr>
	    <td class="black11" >State</td>
	    <td class="black11">
	    	 <select name="state"  id="state"  value="">
		    	<option value="">Select State</option>
		    	<?php echo get_states_options($client_data[0]['state']); ?>
		 </select>
	    </td>
	     
  </tr>
  <tr>
	    <td class="black11" >Country</td>
	    <td class="black11"><input type="text" name="country" id="country" value="India" /></td>
	     
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
	    		<option value="">Select Category</option>
	    		<option value="platinum" <?php if($client_data[0]['client_cat']=='platinum') { ?> selected <?php } ?> >Platinum</option>
	    		<option value="gold" <?php if($client_data[0]['client_cat']=='gold') { ?> selected <?php } ?> >Gold</option>
	    		<option value="silver" <?php if($client_data[0]['client_cat']=='silver') { ?> selected <?php } ?> >Silver</option>
	    		<option value="bronze" <?php if($client_data[0]['client_cat']=='bronze') { ?> selected <?php } ?> >Bronze</option>
	    	</select>
	    
	    </td>
	    	
	   
	   
  </tr> 	
  
  <tr>
    	
	    <th colspan="4">Lead source</th>
    </tr>
     <tr>
	    
	    <td class="black11" colspan="2"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['internet']=='1'  ) { ?>  checked <?php } ?>  type="radio" name="internet" id="internet" value="1" />&nbsp;&nbsp;&nbsp;Internet/web</td>
	    
	    <td class="black11" colspan="2"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['internet']=='2' ) { ?>  checked <?php } ?> type="radio" name="internet" id="newspaper" value="2" />&nbsp;&nbsp;&nbsp;Newspaper Advertise</td>
	</tr>
	<tr>	    
	    <td class="black11" colspan="2"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['internet']=='3' ) { ?>  checked <?php } ?>  type="radio" name="internet" id="friends" value="3" />&nbsp;&nbsp;Friends/Relatives</td>
	     
	     <td class="black11" colspan="2"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['internet']=='4'  ) { ?>  checked <?php } ?>  type="radio" name="internet" id="other" value="4" />&nbsp;&nbsp;Other</td>
  </tr>

<?php if($_GET['id']=='') { ?>
  
  <tr>
  	<th class="black11" colspan="4">Terms and Conditions*</th>
  </tr>
   <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="aaa" id="aaa">&nbsp;&nbsp;&nbsp;1. I hereby agree to pay service charges of PropertyPlstol Incase BUY/RENT any property shown &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; to me by PropertyPlstol. (service charges are: 1% of agreement value in case of  sale /1 month &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; rent incase of rent subject to Minimum of INR15000/-).</td>  
	    
  </tr>
    <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="bbb" id="bbb">&nbsp;&nbsp;&nbsp;2. Service charges to be paid only by cheque in favour of 'PropertyPlstol Reality Pvt Ltd.</td>  
	    
  </tr>
    <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="ccc" id="ccc">&nbsp;&nbsp;&nbsp;3. I agree to pay 25% of total Service charges to PropertyPlstol at time of token in case of<br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; transaction both sale/rent. Remaining 75% will be payable upon signing/registration of<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; agreement.</td>  
	    
  </tr>	
  <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="ddd" id="ddd">&nbsp;&nbsp;&nbsp;4. I agree to give a copy of register agreement to PropertyPlstol in case of transaction<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (sale/Rent) on property shown by PropertyPistol.</td>  
	    
  </tr>	
  
  <?php } ?>
  
  
   <tr>
    	
	    <th colspan="4">Check Below Check box For Notification Via Multiple Options.</th>
    </tr>
     <tr>
	    
	    <td class="black11"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['calls_noti']=='1' ) { ?>  checked <?php } ?>  type="checkbox" name="calls" id="calls" value="1" />&nbsp;&nbsp;&nbsp;Calls</td>
	    
	</tr>
	<tr>	    
	    
	    <td class="black11"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['sms_noti']=='1' ) { ?>  checked <?php } ?> type="checkbox" name="sms" id="sms" value="1" />&nbsp;&nbsp;&nbsp;SMS's</td>
	     
  </tr>
  <tr>	    
	    
	    <td class="black11"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['email_noti']=='1'  ) { ?>  checked <?php } ?>  type="checkbox" name="email" id="email" value="1" />&nbsp;&nbsp;Email's</td>
	     
  </tr>
 
  <tr>
       <td class="black11">Customer Form: </td>
     <td class="black11"> 
     
      <input type="file" name="cust_form" id="cust_form" value="<?php print $client_data[0]['cust_form'];?>" /><br/>(eg- .docs,.pdf)<br/> (Max Upload Size Up To 5MB.)
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
	    
	    <td class="black11">Client Remark</td>
	    <td class="black11" colspan="3">
	    <textarea name="remark" id="remark" cols="50" rows="5" value=""><?php if($client_data[0]['remark'])
	    {
	    print $client_data[0]['remark'];
	    }
	  
	    ?></textarea> 
	    </td>
  </tr>
  
  <tr>	    
	    
	    <td class="black11">Executive Name</td>
	    <td class="black11" colspan="3">
	    
	  <?php echo 
    	$select = am_get_select('admin', 'admin_id', 'executive_id', $client_data[0]['executive_id'], 'admin_f_name', '','' );
    	//echo $select;
    ?>
	 
	    </td>
  </tr>	
  
  
  <tr>	    
	    
	    <td class="black11">Executive Remark</td>
	    <td class="black11" colspan="3">
	    <textarea name="executive_remark" id="executive_remark" cols="50" rows="5" value=""><?php if($client_data[0]['executive_remark'])
	    {
	    print $client_data[0]['executive_remark'];
	    }
	   
	    ?></textarea> 
	    </td>
  </tr>
  
  
  <tr>
    <td>&nbsp;</td>
    <td class="black11"><input type="submit" name="submit12"  value="<?=$mode;?>" />&nbsp;<!--<input type="reset" name="reset"  value="Reset" />&nbsp;<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=static_pages';" value="Cancel" />--></td>
  </tr>
</table>

<?php } else { ?>	
	
<!--<table width="80%" border="0" cellspacing="2" cellpadding="2" > 
<tr>
   <td>
	<h2><?php echo $mode; ?> Customer</h2>
  </td>
  <td>
    <a href="index.php?rel=common_listing&module=customer"><h4>Customer Listing</h4></a>
  </td>
</tr>	
  <tr>
	<td colspan="4"><h3>Do You Want to Add Property For Any Exsiting Customer?</h3></td>	
	</tr>
	<tr>
	<td colspan="1"><a href = "javascript:void(0)" onclick = "document.getElementById('help').style.display='block';document.getElementById('fade').style.display='block'" ><input type="button" name="search_customer" id="search_customer" value="Search Customer" onclick="showhidediv1(this);"></a></td>	
	
	<td colspan="1"><h3>OR</h3></td>	
	<td colspan="1"></td>
	<td colspan="1"><input type="button" name="add_customer" id="add_customer" value="Add Customer" onclick="showhidediv3(this);"></td>	
	
	</tr>

</table> 


<table width="80%" border="0" cellspacing="2" cellpadding="2" id="customerinfo1" > 
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



<h2> <?php echo $mode; ?> Customer </h2>	
<table width="80%" border="0" cellspacing="2" cellpadding="2" id="customerinfo" > 
 <tr>
 
  <tr>
  	 
  
  <?php  //$date=date('d/m/Y'); ?>
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
	    <td class="black11"><input type="text" name="add_line1" id="add_line1" value="<?php print $client_data[0]['add_line1']?>" /></td>
	     
  </tr>
  <tr>
	    <td class="black11" >Address line 2</td>
	    <td class="black11"><input type="text" name="add_line2" id="add_line2" value="<?php print $client_data[0]['add_line2']?>" /></td>
	     
  </tr>
  <tr>
	    <td class="black11" >Address line 3</td>
	    <td class="black11"><input type="text" name="add_line3" id="add_line3" value="<?php print $client_data[0]['add_line3']?>" /></td>
	     
  </tr>
   <tr>
	    <td class="black11" >Pin Code</td>
	    <td class="black11"><input type="text" name="zip_code" id="zip_code" value="<?php print $client_data[0]['zip_code']?>" /></td>
	 
</tr>
<tr>	    
	     <td class="black11" >City Name</td>
	    <td class="black11"><input type="text" name="city" id="city" value="<?php print $client_data[0]['city']?>" /></td>
  </tr>
  <tr>
	    <td class="black11" >State</td>
	    <td class="black11">
	    	 <select name="state"  id="state"  value="">
		    	<option value="">Select State</option>
		    	<?php echo get_states_options($client_data[0]['state']); ?>
		 </select>
	    </td>
	     
  </tr>
  <tr>
	    <td class="black11" >Country</td>
	    <td class="black11"><input type="text" name="country" id="country" value="India" /></td>
	     
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
	    <td class="black11">Transaction Time</td>
	    <td class="black11">
	    	
	    	<select name="trans_time" id="trans_time">
	    		<option value="">Select Time</option>
	    		<option value="7days" <?php if($client_data[0]['trans_time']=='7days'  ) { ?> selected <?php } ?> >Within 7 Days</option>
	    		<option value="15days" <?php if($client_data[0]['trans_time']=='15days' ) { ?> selected <?php } ?> >Within 15 Days</option>
	    		<option value="1month" <?php if($client_data[0]['trans_time']=='1month' ) { ?> selected <?php } ?> >Within 1 Month</option>
	    		<option value="more1month" <?php if($client_data[0]['trans_time']=='more1month' ) { ?> selected <?php } ?> >More than 1 Month</option>
	    	</select>
	    
	    </td>
	    	
	   
	   
  </tr>
  
  <tr>
	    <td class="black11">Client Category</td>
	    <td class="black11">
	    	
	    	<select name="client_cat" id="client_cat">
	    		<option value="">Select Category</option>
	    		<option value="platinum" <?php if($client_data[0]['client_cat']=='platinum' ) { ?> selected <?php } ?> >Platinum</option>
	    		<option value="gold" <?php if($client_data[0]['client_cat']=='gold' ) { ?> selected <?php } ?> >Gold</option>
	    		<option value="silver" <?php if($client_data[0]['client_cat']=='silver' ) { ?> selected <?php } ?> >Silver</option>
	    		<option value="bronze" <?php if($client_data[0]['client_cat']=='bronze' ) { ?> selected <?php } ?> >Bronze</option>
	    	</select>
	    
	    </td>
	    	
	   
	   
  </tr>
 
<tr>
    	
	    <th colspan="4">Lead source</th>
    </tr>
     <tr>
	    
	    <td class="black11" colspan="2"><input <?php  if($client_data[0]['internet']=='1'  ) { ?>  checked <?php } ?>  type="radio" name="internet" id="internet" value="1" />&nbsp;&nbsp;&nbsp;Internet/web</td>
	    
	    <td class="black11" colspan="2"><input  <?php  if($client_data[0]['internet']=='2' ) { ?>  checked <?php } ?> type="radio" name="internet" id="newspaper" value="2" />&nbsp;&nbsp;&nbsp;Newspaper Advertise</td>
	</tr>
	<tr>	    
	    <td class="black11" colspan="2"><input   <?php if($client_data[0]['internet']=='3'  ) { ?>  checked <?php } ?>  type="radio" name="internet" id="friends" value="3" />&nbsp;&nbsp;Friends/Relatives</td>
	     
	     <td class="black11" colspan="2"><input   <?php  if($client_data[0]['internet']=='4'  ) { ?>  checked <?php } ?>  type="radio" name="internet" id="other" value="4" />&nbsp;&nbsp;Other</td>
  </tr>
   
  
  <?php if($_GET['id']=='') { ?>
  
  <tr>
  	<th class="black11" colspan="4">Terms and Conditions*</th>
  </tr>
   <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="aaa" id="aaa">&nbsp;&nbsp;&nbsp;1. I hereby agree to pay service charges of PropertyPlstol Incase BUY/RENT any property shown &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; to me by PropertyPlstol. (service charges are: 1% of agreement value in case of  sale /1 month &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; rent incase of rent subject to Minimum of INR15000/-).</td>  
	    
  </tr>
    <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="bbb" id="bbb">&nbsp;&nbsp;&nbsp;2. Service charges to be paid only by cheque in favour of 'PropertyPlstol Reality Pvt Ltd.</td>  
	    
  </tr>
    <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="ccc" id="ccc">&nbsp;&nbsp;&nbsp;3. I agree to pay 25% of total Service charges to PropertyPlstol at time of token in case of<br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; transaction both sale/rent. Remaining 75% will be payable upon signing/registration of<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; agreement.</td>  
	    
  </tr>	
  <tr>	    
	 
	   <td class="black11" colspan="4"><input type="checkbox" name="ddd" id="ddd">&nbsp;&nbsp;&nbsp;4. I agree to give a copy of register agreement to PropertyPlstol in case of transaction<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (sale/Rent) on property shown by PropertyPistol.</td>  
	    
  </tr>	
  
  <?php } ?>
 
  <tr>
    	
	    <th colspan="4">Check Below Check box For Notification Via Multiple Options.</th>
    </tr>
     <tr>
	    
	    <td class="black11"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['calls_noti']=='1' ) { ?>  checked <?php } ?>  type="checkbox" name="calls" id="calls" value="1" />&nbsp;&nbsp;&nbsp;Calls</td>
	    
	</tr>
	<tr>	    
	    
	    <td class="black11"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['sms_noti']=='1' ) { ?>  checked <?php } ?> type="checkbox" name="sms" id="sms" value="1" />&nbsp;&nbsp;&nbsp;SMS's</td>
	     
  </tr>
  <tr>	    
	    
	    <td class="black11"><input <?php if($mode=="Add") { ?> checked <?php } if($client_data[0]['email_noti']=='1'  ) { ?>  checked <?php } ?>  type="checkbox" name="email" id="email" value="1" />&nbsp;&nbsp;Email's</td>
	     
  </tr>
 
  <tr>
       <td class="black11">Customer Form: </td>
     <td class="black11"> 
     
      <input type="file" name="cust_form" id="cust_form" value="<?php print $client_data[0]['cust_form'];?>" /><br/>(eg- .docs,.pdf)<br/> (Max Upload Size Up To 5MB.)
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
	    
	    <td class="black11">Client Remark</td>
	    <td class="black11" colspan="3">
	    <textarea name="remark" id="remark" cols="50" rows="5" value=""><?php if($client_data[0]['remark'])
	    {
	    print $client_data[0]['remark'];
	    }
	  
	    ?></textarea> 
	    </td>
  </tr>
  
  <tr>	    
	    
	    <td class="black11">Executive Name</td>
	    <td class="black11" colspan="3">
	    
	  <?php echo 
    	$select = am_get_select('admin', 'admin_id', 'executive_id', $client_data[0]['executive_id'], 'admin_f_name', '','' );
    	//echo $select;
    ?>
	 
	    </td>
  </tr>	
  
  
  <tr>	    
	    
	    <td class="black11">Executive Remark</td>
	    <td class="black11" colspan="3">
	    <textarea name="executive_remark" id="executive_remark" cols="50" rows="5" value=""><?php if($client_data[0]['executive_remark'])
	    {
	    print $client_data[0]['executive_remark'];
	    }
	   
	    ?></textarea> 
	    </td>
  </tr>
  </table>   
<table width="80%" border="0" cellspacing="2" cellpadding="2" id="property1" >
   
           <tr>
	    <th colspan="2">Property Looking For</th>
  </tr>
  
  <tr>
	    <td class="black11" style="width: 18%;">Transaction Type</td>
	    <td class="black11">
	    	<select name="transaction_type" id="transaction_type" value="" onchange="transaction1(this);">
	    		<option value="">Select Transaction</option>
	    		<option value="buy" <?php if($client_data[0]['main_property_type']=='buy') { ?> selected <?php } ?> >Buy</option>
	    		<!--<option value="sale" <?php if($client_data[0]['main_property_type']=='sale') { ?> selected <?php } ?>>Sale</option>-->
	    		<option value="rent" <?php if($client_data[0]['main_property_type']=='rent') { ?> selected <?php } ?>>Rent In </option>
	    		<!--<option value="rent_out" <?php if($client_data[0]['main_property_type']=='rent_out') { ?> selected <?php } ?>>Rent Out</option>-->
	    		
	    		
	    	</select>
	    </td>
	   
  </tr>
  
   <tr>
	   
	    <td class="black11" style="width: 18%;"><input <?php if($client_data[0]['property_type']=="residential") { ?>  checked="checked" <?php } ?>  type="radio" name="residential" id="residential" value="residential" onclick="showhidediv(this);"></td>
	     <td class="black11" style="width: 18%;">Residential</td>
	    	
	   
	    <td class="black11" style="width: 18%;"><input <?php if($client_data[0]['property_type']=="commercial") { ?>  checked="checked" <?php } ?>  type="radio" name="residential" id="commercial" value="commercial" onclick="showhidediv(this);"></td>
	      <td class="black11" style="width: 18%;">Commercial</td>
	   
  </tr>
  
    <tr id="appart" style="display:none;">
    <td>
  
  <table width="80%"  border="0" cellspacing="2" cellpadding="2" id="apartment1" <?php if($broker_data[0]['property_main_type']=="commercial") { ?>  style="display:none;" <?php } ?> >
   <tr>
	    <th class="black11" colspan="2">Type of Apartment:</th>
	    

	 <tr>
	 <td class="black11" style="width: 1%;"><input <?php if($client_data[0]['onerk']=='1') { ?>  checked <?php } ?>  type="checkbox" name="1rk" id="1rk" value="1"></td>
	    <td class="black11" style="width: 4%;">1RK</td>		
<td class="black11" style="width: 1%;"><input  <?php if($client_data[0]['onebhk']=='1') { ?>  checked <?php } ?>  type="checkbox" name="1bhk" id="1bhk" value="1"></td>
	<td class="black11" style="width: 18%;">1BHK</td>		

	  </tr>  
	  <tr>
<td class="black11" ><input <?php if($client_data[0]['twobhk']=='1') { ?>  checked <?php } ?>  type="checkbox" name="2bhk" id="2bhk" value="1"></td>
	    <td class="black11">2BHK</td>		
<td class="black11"><input <?php if($client_data[0]['threebhk']=='1') { ?>  checked <?php } ?>  type="checkbox" name="3bhk" id="3bhk" value="1"></td>
	<td class="black11">3BHK</td>		

	  </tr>  
	  <tr>
<td class="black11"><input <?php if($client_data[0]['fourbhk']=='1') { ?>  checked <?php } ?>  type="checkbox" name="4bhk+" id="4bhk+" value="1"></td>
	    <td class="black11">4BHK+</td>		

	<td class="black11"></td>		
<td class="black11"></td>
	  </tr>  
	   
   </table>  
   </td>
   </tr>
     </table>
  <table  width="80%" border="0" cellspacing="2" cellpadding="2"  id="property2" >
  

  
     
    
    <!-- <tr>
	    <td class="black11">Specify Area:</td>
	    <td class="black11">
	    	<input type="text" name="specify_area" id="specify_area" value="<?php print $client_data[0]['specify_area']?>" />
	    </td>
    </tr>-->
    
   <!--<tr>
	    <td class="black11">Carpet:</td>
	    <td class="black11">
	    	<input type="text" name="carpet" id="carpet" value="<?php print $client_data[0]['carpet']?>" />
	    </td>
    </tr>-->
  
   <tr id="off_ret" <?php if($broker_data[0]['property_main_type']=="residential") { ?>  style="display:none;" <?php } ?>>
	    <td class="black11">Office/Retail</td>
	    <td class="black11">
	    	
	    	<select name="office_check" id="office_check" onchange="off_retfun(this);">
	    		<option value="">Select Type</option>
	    		<option value="1" <?php if($client_data[0]['office']== '1') { ?> selected <?php } ?> >Office</option>
	    		<option value="2" <?php if($client_data[0]['office']== '2') { ?> selected <?php } ?> >Retail</option>
	    	</select>
	    
	    </td>
	    	
	   
	   
  </tr>
  
   <tr>
	    <td class="black11">Approximate Area (SQFT):</td>
	    <td class="black11">
	    	<input type="text" name="scaleble" id="scaleble" value="<?php print $client_data[0]['scaleble']?>" />
	    </td>
    </tr>
  
     <tr id="furn">
       <td class="black11"><input <?php if($client_data[0]['furnished']=='1') { ?>  checked <?php } ?>  type="radio" name="furnished" id="furnished" value="1"></td>
	    <td class="black11">Furnished</td>
	    
	    <td class="black11"><input <?php if($client_data[0]['furnished']=='2') { ?>  checked <?php } ?>  type="radio" name="furnished" id="unfurnished" value="2"></td>
	    	     <td class="black11">Unfurnished</td>
	  
	   <td class="black11"><input <?php if($client_data[0]['furnished']=='3') { ?>  checked <?php } ?>  type="radio" name="furnished" id="any" value="3"></td>	
	    <td class="black11">Any</td>
	   
	   
	   
  </tr>
     <tr id="cell" style="width:110%;" <?php if($broker_data[0]['property_main_type']=="residential") { ?>  style="display:none;" <?php } ?>>
	    
	    <td class="black11"><input <?php if($client_data[0]['warm_cell']=='1') { ?>  checked <?php } ?>  type="radio" name="warm_cell" id="warm_cell" value="1"></td>
	    <td class="black11" id="warm" title="Flooring & Wall finish available, Toilets are available">Warm Cell ?</td>
	    	
	    
	    <td class="black11"><input <?php if($client_data[0]['warm_cell']=='2') { ?>  checked <?php } ?>  type="radio" name="warm_cell" id="cold_cell" value="2"></td>
	     <td class="black11" title="flooring, wall finish etc not yet finished">Cold Cell ?</td>
	   
  </tr>
  <tr>
	    <th>Area Looking For</th>
  </tr>

  
  <tr>
	    <td class="black11" >Area 1</td>
<td class="black11"><input type="text" name="area[]" id="area1" value="<?php print $client_area[0]['area_name']?>" /></td>
  </tr>
    <tr>
	     <td class="black11" >Area 2</td>
	    <td class="black11"><input type="text" name="area[]" id="area2" value="<?php print $client_area[1]['area_name']?>" /></td>
  </tr>
  <tr>
	    <td class="black11" >Area 3</td>
	    <td class="black11"><input type="text" name="area[]" id="area3" value="<?php print $client_area[2]['area_name']?>" /></td>
	     </tr> 
	  <tr>    
	     <td class="black11" >Area 4</td>
	    <td class="black11"><input type="text" name="area[]" id="area4" value="<?php print $client_area[3]['area_name']?>" /></td>
  </tr>
 
  <tr>
	    <td class="black11" >Approx Budget:</td>
 </tr>
 
 <?php if($mode=='Add') { ?>
 
  <tr id="min_price_exp">
	    <td class="black11" colspan="2" >Min Budget Price:</td>

 </tr>
 
 
 
 <tr id="min_price_rent" style="display:none;">
	    <td class="black11" colspan="2" >Min Expected Rent Per Month:</td>

	   
 </tr>
 
 <?php } else if($mode=='Update') { ?>
 
 <?php if($client_data[0]['main_property_type']=='buy') { ?>
 <tr id="min_price_exp">
	    <td class="black11" colspan="2" >Min Budget Price:</td>

 </tr>
  <tr id="min_price_rent" style="display:none;">
	    <td class="black11" colspan="2" >Min Expected Rent Per Month:</td>

	   
 </tr>
 
 <?php } else if($client_data[0]['main_property_type']=='rent') { ?>
 
 <tr id="min_price_exp" style="display:none;">
	    <td class="black11" colspan="2" >Min Budget Price:</td>

	   
 </tr>
 
 <tr id="min_price_rent" >
	    <td class="black11" colspan="2" >Min Expected Rent Per Month:</td>

	    
 </tr>
 
 <?php }
 	
  } ?>
 
 <tr>	    
 	<?php    $min_price=$client_data[0]['min_price'];
 	       
 	      	if(strpos($min_price, '0000000'))
 	      	{
 	      		$c1='0000000';
 	      	}	
 	     	else if(strpos($min_price, '00000'))
 	        {
 	       		$c1='00000';
 	        }
 	        else if(strpos($min_price, '000'))
 	        {
 	       		$c1='000';
 	        }
 	      
 	       // echo $c1;
 	        $price1=str_replace($c1,'' ,$min_price);
 	        if($price1>100)
		{
	 	      	$value1=($price1/100);
			$value1=explode(".",$value1);
		
			//print_R($value1);exit;
		
			$value2=($price1%100);
		}	      
 	        else 
 	        {
 	          if($c1==='0000000' && $client_data[0]['main_property_type']=='buy' )
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
 	          else if($c1==='00000' && $client_data[0]['main_property_type']=='buy' )
 	          {
 	          	if($c1==='00000')
 	        	{
 	        		$value2=$price1;
 	        	}
 	          }
 	           
 	          else if($c1==='00000' && $client_data[0]['main_property_type']=='rent')
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
 	          else if($c1==='000' && $client_data[0]['main_property_type']=='rent')
 	          { 	
 	        	if($c1==='000')
 	        	{
 	        		$value2=$price1;
 	        	}
 	          }
 	        	
 	        	
 	        	
 	        }
 	       
 	 ?>
	    
	    <td class="black11"><input type="text" name="min_price1" id="min_price1" value="<?php print $value1[0]; ?>" /></td> 
	     <td class="black11" >
	     <select name="min_price_type1" id="min_price_type1" value="">
	   
	     	<option value="">Select</option>
	     	<option value="crores" <?php if($value1[0]> 0 ) { ?> selected <?php } ?> >Crore</option>
	     	
	     </select>
	    
	     </td>
</tr>
<tr>	    
	    <td class="black11"><input type="text" name="min_price2" id="min_price2" value="<?php print $value2; ?>" /></td>
	     <td class="black11" >
	     <select name="min_price_type2" id="min_price_type2" value="">
	        <option value="">Select</option>
	     	<option value="crores" <?php if($c1 === '0000000')  { ?> selected <?php } ?> >Crore</option>
	     	
	     </select>
	     
	     </td>
  </tr>
  
  
  <?php if($mode=='Add') { ?>
 
  <tr id="max_price_exp">
	    <td class="black11" colspan="2" >Max Budget Price:</td>

 </tr>
 
 
 
 <tr id="max_price_rent" style="display:none;">
	    <td class="black11" colspan="2" >Max Expected Rent Per Month:</td>

	   
 </tr>
 
 <?php } else if($mode=='Update') { ?>
 
 <?php if($client_data[0]['main_property_type']=='buy') { ?>
 <tr id="max_price_exp">
	    <td class="black11" colspan="2" >Max Budget Price:</td>

 </tr>
  <tr id="max_price_rent" style="display:none;">
	    <td class="black11" colspan="2" >Max Expected Rent Per Month:</td>

	   
 </tr>
 
 <?php } else if($client_data[0]['main_property_type']=='rent') { ?>
 
 <tr id="max_price_exp" style="display:none;">
	    <td class="black11" colspan="2" >Max Budget Price:</td>

	   
 </tr>
 
 <tr id="max_price_rent" >
	    <td class="black11" colspan="2" >Max Expected Rent Per Month:</td>

	    
 </tr>
 
 <?php }
 	
  } ?>
  
  <tr>	    
 	<?php   $max_price=$client_data[0]['max_price'];
 	       
 	       if(strpos($max_price, '0000000'))
 	       {
 	       		$c2='0000000';
 	       }
 	       else if(strpos($max_price, '00000'))
 	       {
 	       		$c2='00000';
 	       }
 	       else if(strpos($max_price, '000'))
 	       {
 	       		$c2='000';
 	       }
 		
 	    		    
  	       $price2=str_replace($c2,'' ,$max_price);
 	       if($price2>100)
		{
 	       $value3=($price2/100);
		$value3=explode(".",$value3);
		//print_R($value3);
		$value4=($price2%100);
 	       }
 	       else
 	       {
 	       
	 	       	 if($c2==='0000000' && $client_data[0]['main_property_type']=='buy' )
	 	          { 	
	 	        	if($c2==='0000000')
	 	        	{
	 	        		$value3[0]=$price2;
	 	        	}
	 	        	else if($c2==='00000')
	 	        	{
	 	        		$value4=$price2;
	 	        	}
	 	          }
	 	          else if($c2==='00000' && $client_data[0]['main_property_type']=='buy' )
	 	          {
	 	          	if($c2==='00000')
	 	        	{
	 	        		$value4=$price2;
	 	        	}
	 	          }
	 	           
	 	          else if($c2==='00000' && $client_data[0]['main_property_type']=='rent')
	 	          { 	
	 	        	if($c2==='00000')
	 	        	{
	 	        		$value3[0]=$price2;
	 	        	}
	 	        	else if($c2==='000')
	 	        	{
	 	        		$value4=$price2;
	 	        	}
	 	          }
	 	          else if($c2==='000' && $client_data[0]['main_property_type']=='rent')
	 	          { 	
	 	        	if($c2==='000')
	 	        	{
	 	        		$value4=$price2;
	 	        	}
	 	          }
 	        
 	       }
 	    
 	 ?>
	    
	    <td class="black11"><input type="text" name="max_price1" id="max_price1" value="<?php print $value3[0]; ?>" /></td> 
	     <td class="black11" >
	     <select name="max_price_type1" id="max_price_type1" value="">
		<option value="">Select</option>	   
	     	<option value="crores" <?php if($c2 === "0000000" ) { ?> selected <?php } ?> >Crore</option>
	     	
	     </select>
	     
	      
	     </td>
	</tr>
	<tr>    
	    <td class="black11"><input type="text" name="max_price2" id="max_price2" value="<?php print $value4; ?>" /></td>
	     <td class="black11" >
	     <select name="max_price_type2" id="max_price_type2" value="">
		<option value="">Select</option>	  
	     	<option value="crores" <?php if($value3[0] > 0)  { ?> selected <?php } ?>  >Crore</option>
	     	
	     </select>
	  
	     </td>
  </tr>
     
    <tr>
	<td class="black11">Status</td>
	<td class="black11">
		 <select name="status" id="status" value="">
			<option value="">Select Status</option>	  
	     		<option value="1">New</option>
			<option value="2">Information awaited from broker/owner</option>
			<option value="3">Contacted – Answered</option>
			<option value="4">Contacted – Un-Answered</option>
			<option value="5">Follow-up</option>
			<option value="6">Property Details Shared</option>
			<option value="7">Property Shortlisted</option>
			<option value="8">Property disqualified</option>
			<option value="9">Request for more options</option>
			<option value="10">Site Visit Planned</option>
			<option value="11">Site Visit Rescheduled</option>
			<option value="12">Site Visit Done</option>
			<option value="13">Site Re-Visit</option>
			<option value="14">Owner/Broker Meeting Scheduled</option>
			<option value="15">Negotiation</option>
			<option value="16">Token Given</option>
			<option value="17">Registration/Agreement Status</option>
			<option value="18">Transaction Successful</option>
			<option value="19">Lead Dead</option>	
	     	
	     	</select>	
	</td>	
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
	
	document.getElementById('appart').style.display = 'block';
	document.getElementById('furn').style.display = 'block';
	document.getElementById('cell').style.display = 'none';
	}
	else
	{
	document.getElementById('appart').style.display = 'none';
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

function transaction1(val){
	
	//alert(document.getElementById('transaction_type').value);
	
	
	if (document.getElementById('transaction_type').value=='buy')
	{
		//alert('<?php echo $c1; ?>');
		document.getElementById('min_price_exp').style.display = 'block';
		document.getElementById('min_price_rent').style.display = 'none';
		
		document.getElementById('max_price_exp').style.display = 'block';
		document.getElementById('max_price_rent').style.display = 'none';
		
		document.getElementById('min_price_type1').innerHTML = '<option value="">Select</option><option value="crores" <?php if($value1[0]> 0 ) { ?> selected <?php } ?> >Crore</option>';
		document.getElementById('min_price_type2').innerHTML = '<option value="">Select</option><option value="laks" <?php if($c2 === '00000') { ?> selected <?php } ?> >Lac</option>';
		
		document.getElementById('max_price_type1').innerHTML = '<option value="">Select</option><option value="crores" <?php if($value3[0]>0 ) { ?> selected <?php } ?> >Crore</option>';
		document.getElementById('max_price_type2').innerHTML = '<option value="">Select</option><option value="laks" <?php if($c2 === '00000') { ?> selected <?php } ?> >Lac</option>';
		
		
		
	
	}
	else if(document.getElementById('transaction_type').value=='rent')
	{
		document.getElementById('min_price_exp').style.display = 'none';
		document.getElementById('min_price_rent').style.display = 'block';
		
		document.getElementById('max_price_exp').style.display = 'none';
		document.getElementById('max_price_rent').style.display = 'block';

		document.getElementById('min_price_type1').innerHTML = '<option value="">Select</option><option value="laks" <?php if($value1[0]> 0 ) { ?> selected <?php } ?> >Lac</option>';
		document.getElementById('min_price_type2').innerHTML = '<option value="">Select</option><option value="thousand" <?php if($c2 === '000') { ?> selected <?php } ?> >Thousand</option>';
		
		document.getElementById('max_price_type1').innerHTML = '<option value="">Select</option><option value="laks" <?php if($value3[0]> 0 ) { ?> selected <?php } ?> >Lac</option>';
		document.getElementById('max_price_type2').innerHTML = '<option value="">Select</option><option value="thousand" <?php if($c2 === '000') { ?> selected <?php } ?> >Thousand</option>';		
		

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
                    },
                    email1: {
                        required: true,
                        email: true
                    }, */
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
                     office_check: "required",
                     warm_cell: "required",
                     
                    'area[]': { required: true },
                     
                    min_price1: {
                        required: true,
                        number: true
                        
                    },
                    min_price_type1: "required",
                    
                     min_price2: {
                        required: true,
                        number: true
                        
                    },
                    min_price_type2: "required",
                    
                    
                    max_price1: {
                        required: true,
                        number: true
                        
                    },
                    max_price_type1: "required",
                    
                     max_price2: {
                        required: true,
                        number: true
                        
                    },
                    max_price_type2: "required",
                    
                    
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
                    },
                     email1: {
                        required: "Please enter email Address",
                        email: "Please enter valid email Address",
                      
                    },  */
                    
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
                    office_check:"Please Select Office/Retail",
                     warm_cell:"Please Select Cell",
                   area:"Please Enter Area",
                    min_price1: {
                        required: "Please enter Min Price ",
                        number: "Please enter Min Price Numeric",
                       
                    }, 	
                    
                     min_price_type1: "Please Select Min Price Type",
                    
                    min_price2: {
                        required: "Please enter Min Price ",
                        number: "Please enter Min Price Numeric",
                       
                    }, 	
                    
                     min_price_type2: "Please Select Min Price Type",
                     
                     
                      max_price1: {
                        required: "Please enter Max Price ",
                        number: "Please enter Max Price Numeric",
                       
                    }, 	
                    
                     max_price_type1: "Please Select Max Price Type",
                    
                    max_price2: {
                        required: "Please enter Max Price ",
                        number: "Please enter Max Price Numeric",
                       
                    }, 	
                    
                     max_price_type2: "Please Select Max Price Type",
                   
                    
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
   
