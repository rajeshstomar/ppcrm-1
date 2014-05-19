<?php
//include("../dbconfig.php");
$msg = $_GET['msg'];

if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
{
	$id = $_REQUEST['id'];
	
	$sel_que ="select * from broker_firm left join operation ON broker_firm.operation_id=operation.operation_id left join building_database on broker_firm.near_buil_id=building_database.id_building   where company_id= '".$id."' ";
	//echo $sel_que;exit;
	
	$broker_data = am_select($sel_que);
	//my_print_R($broker_data);exit;
	if(isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'view')
	{
		$mode = "view";
	}
	else
	{
		$mode = "Save";
	}
	
	// Get all abroker of particular firm
	$broker = "select broker_id ,broker_id,broker_name,mobile1_no,email,pan_card_num from broker where 1=1 AND firm_id = '$id' order by broker_id";
	$all_broker = am_select($broker);
	//print_R($all_broker); exit;
}
else
{
	$mode = "Add";
}
//include(DIR_SCRIPT_ROOT."/fckeditor/fckeditor.php") ; 
//echo $mode; exit;

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
?>

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
		
		$("#add_line2_1").val(tmp1[3]); 
		$("#add_line2_2").val(tmp1[2]); 
		$("#add_line3").val(tmp1[4]); 
		
		

		
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
 
 <script type="text/javascript">
		function sendNotes()   {
			var $form = $(this); 
			  //alert('vxcbcv');
		    	var mobile_no=$("#mobile").val()
				//alert(mobile_no);	     
				       
			$.ajax({
				type: "POST",
				url: "uniquecompany_result.php",
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

<?php 
if($mode == 'view') { ?>
<h2>Broker Firm Details For:<?php print $broker_data[0]['company_name']?> </h2>
<table width="80%" border="0" cellspacing="2" cellpadding="2"> 
  <tr>
  <?php  //$date=date('d/m/Y'); ?>
    <td class="black11">Date:</td>
    <td class="black11"><label><?php if($broker_data[0]['firm_updated_date'] !='' ) { print $broker_data[0]['firm_updated_date']; } else {  echo $date;  } ?></label></td>
	
   <td class="black11">Location(Outlet):</td>
    <td class="black11" ><label><?php print $broker_data[0]['place']?></lable></td>

</tr>
<tr>
	
    <td class="black11">Form No:</td>
    <td class="black11"><label><?php print "FN".$broker_data[0]['form_no']?></lable></td>
  </tr>
  
 <tr>
    <td class="black11">Company/Firm Name:</td>
    <td class="black11" ><label><?php print $broker_data[0]['company_name']?></label></td>
	
    <td class="black11">Nature of Firm/Company:</td>
    <td class="black11">
    <?php
    $nature = '';
    if($broker_data[0]['nature_company']== 'sole_proprietor')
    	$nature = 'Sole Proprietor';
    else if($broker_data[0]['nature_company']== 'partnership')
    	$nature = 'Partnership';
    else if($broker_data[0]['nature_company']== 'pvtltd')
    	$nature = 'Pvt. LTD';
    else if($broker_data[0]['nature_company']== 'freelancer')
    	$nature = 'Freelancer';
    ?>
  	<label><?php echo $nature; ?></label>    
    </td>
  </tr>
   <tr>
    <td class="black11">Nearest Building:</td>
    <td class="black11"><label><?php print $broker_data[0]['b_name']?></label></td>
    
  </tr>
 <tr>
    <td class="black11">Address Line1:</td>
    <td class="black11"><label><?php print $broker_data[0]['add_line1']?></label></td>
  </tr>
   <tr>
    <td class="black11">Address Lineasa2:</td>
    <td class="black11"><label><?php print $broker_data[0]['add_line2_1']?></label></td>
    </tr>
    <tr>
     <td class="black11"></td>
    <td class="black11"><label><?php print $broker_data[0]['add_line2_2']?></label></td>
  </tr>
   <tr>
    <td class="black11">Address Line3:</td>
    <td class="black11"><label><?php print $broker_data[0]['add_line3']?></label></td>
  </tr>

<tr>
    <td class="black11">City Name:</td>
    <td class="black11"><label><?php print $broker_data[0]['city']?></label></td>
  </tr>

<tr>
    <td class="black11">Pin Code:</td>
    <td class="black11"><label><?php print $broker_data[0]['pin_code']?></label></td>
  </tr>
  <tr>
    <td class="black11">State</td>
    <td class="black11">
    	<label><?php echo get_states_name($broker_data[0]['state']); ?></label>
    </td>	
  </tr>
    <tr>
   <td class="black11">Country:</td>
    <td class="black11">India</td>
    
  </tr>
  
  
  
   <tr>
       <td class="black11">Firm Logo: </td>
     <td class="black11"> 
<?if( $broker_data[0]['company_logo'] != "")
    {?>
    <img src="<?php echo HTTP_ROOT_HOME.'/firm_images/'.$broker_data[0]['company_logo'];?>" width="100px" height="80px;"></td>
   <?php } else {  ?>	     
   No image Available
   <?php }?>

    </td>
  </tr>
  <tr>
        <td class="black11">No of Years into Business:</td>
    <td class="black11">
     <label><?php echo $broker_data[0]['no_of_years']; ?></label>
  </tr>
  
    <tr>
  
     <td class="black11">Area Of Operation:</td>
     <td class="black11">
     <label><?php print $broker_data[0]['operation_area']?></label>
     </td>
  </tr>
  
    <tr>
    
     <td class="black11">Specialization:</td>
     <td class="black11">
     <label><?php print $broker_data[0]['specialization']?></label>
     </td>
  </tr>
  
   <tr>
    <th class="black11">Contact</th>
    
  </tr>
      <tr>
     <td class="black11"> Mobile: </td>
     <td class="black11"><label><?php print $broker_data[0]['mobile_no']?></label></td>
     <td class="black11">Office: </td>
     <td class="black11"><label><?php print $broker_data[0]['office_no']?></label>
     </td>
  </tr>
 
  
  
  <tr>
    <td>&nbsp;</td>
    <td class="black11"><a href="index.php?rel=edit_broker&firm_id=<?php echo $_GET['id']; ?>"> <input type="button" value="Add Broker" name="addbroker"></a></td>
    <td class="black11"><a href="index.php?&rel=edit_company&id=<?php echo $_GET['id']; ?>"> <input type="button" name="edit"  value="Edit Firm" /></a>
    <!--<input type="reset" name="reset"  value="Reset" />&nbsp;<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=company';" value="Cancel" /> --></td>
  </tr>
</table>
<?php } else { ?>

<?php if($mode=='Add') { ?>

<h2>Create Broker Firm</h2>

<?php } else if($mode=='Save') { ?>

<h2>Edit Broker Firm For:<?php print $broker_data[0]['company_name']?>  </h2>

<?php } ?>
<form name="frm" id="register-form"   method="post" action="index.php?rel=company_action" enctype="multipart/form-data" >
<input type="hidden" name="mode" id="mode" value="<?=$mode;?>">
<input type="hidden" name="company_id" value="<?php print $broker_data[0]['company_id']?>" />
<input type="hidden" name="operation_id" value="<?php print $broker_data[0]['operation_id']?>" />
<table width="80%" border="0" cellspacing="2" cellpadding="2"> 
  <tr>
  <?php  //$date=date('d/m/Y'); ?>
    <td class="black11">Date:</td>
    <td class="black11"><input type="text" name="date" id="date" placeholder=""  value="<?php if($broker_data[0]['firm_updated_date'] !='' ) { print $broker_data[0]['firm_updated_date']; } else {  echo $date;  } ?>" /></td>
	
 <input type="hidden" name="firm_created_date" id="firm_created_date" value="<?php echo $broker_data[0]['firm_created_date'] ?>">
	
    <td class="black11">Location(Outlet):</td>
    <td class="black11">
     <select name="place"  id="place"  value="">
    	<option value="">Select Location</option>
    	<?php echo get_outlet_location_options($broker_data[0]['place']); ?>
    	</select>
    
</tr>	
<?php

	$lastid="SELECT MAX( company_id) FROM broker_firm";
	$get_lastid=am_select($lastid);
	$id_last=$get_lastid[0]['MAX( company_id)']+1;
	//print_R($get_lastid);exit;

?>


<tr>	
    <td class="black11">Form No:</td>
    <td class="black11"><input type="text" name="form_no" id="form_no" readonly value="<?php if($mode=='Add') { print 'FN'.$id_last;  } else if($mode=='Save') { print 'FN'.$broker_data[0]['form_no']; } ?>" /></td>
   
  </tr>
  
 <tr>
    <td class="black11">Company/Firm Name:</td>
    <td class="black11"><input type="text" name="company_name" id="company_name" value="<?php print $broker_data[0]['company_name']?>" /></td>



</tr>
<tr>

	
    <td class="black11">Nature of Firm/Company:</td>
    <td class="black11">
 
  
    <select name="nature_company"  id="nature_company"  value=" " >
    	<option <?php  if($broker_data[0]['nature_company'] == " ")  { ?> selected <?php } ?> value="" >Select Nature of Firm</option>
    	<option <?php if($broker_data[0]['nature_company'] == "sole_proprietor")  { ?> selected <?php } ?> value="sole_proprietor">Sole Proprietor</option>
    	<option <?php  if($broker_data[0]['nature_company'] == "partnership") {  ?> selected <?php } ?> value="partnership">Partnership</option>
    	<option <?php  if($broker_data[0]['nature_company'] == "pvtltd") { ?> selected <?php } ?> value="pvtltd">Pvt. LTD</option>
    	<option <?php  if($broker_data[0]['nature_company'] == "freelancer") {  ?> selected <?php } ?> value="freelancer">Freelancer</option>
    	
    </select>
    </td>
  </tr>
  


   
   <tr>
    <td class="black11">Nearest Building:</td>
    <td class="black11"><input type="text" name="nearest_building" id="nearest_building" value="<?php print $broker_data[0]['b_name']?>" /><input type="hidden" name="near_buil_id" id="near_buil_id" value="<?php print $broker_data[0]['near_buil_id']?>" /></td>
    
  </tr>
 <tr>
    <td class="black11">Address Line1:</td>
    <td class="black11"><input type="text" name="add_line1" id="add_line1" value="<?php print $broker_data[0]['add_line1']?>" /></td>
  </tr>
   <tr>
    <td class="black11">Address Line2:</td>
    <td class="black11"><input type="text" name="add_line2_1" id="add_line2_1" value="<?php print $broker_data[0]['add_line2_1']?>" /></td>
    </tr>
    <tr>
     <td class="black11"></td>
    <td class="black11"><input type="text" name="add_line2_2" id="add_line2_2" value="<?php print $broker_data[0]['add_line2_2']?>" /></td>
  </tr>
   <tr>
    <td class="black11">Address Line3:</td>
    <td class="black11"><input type="text" name="add_line3" id="add_line3" value="<?php print $broker_data[0]['add_line3']?>" /></td>
  </tr>

<tr>
    <td class="black11">City Name:</td>
    <td class="black11"><input type="text" name="city" id="city" value="<?php print $broker_data[0]['city']?>" /></td>
  </tr>

<tr>
    <td class="black11">Pin Code:</td>
    <td class="black11"><input type="text" name="pin_code" id="pin_code" value="<?php print $broker_data[0]['pin_code']?>" /></td>
  </tr>
  <tr>
    <td class="black11">State</td>
    <td class="black11">
       <select name="state"  id="state"  value="">
    	<option value="">Select State</option>
    	<?php echo get_states_options($broker_data[0]['state']); ?>
    	
    	
       </select>
    </td>	
  </tr>
    <tr>
   <td class="black11">Country:</td>
    <td class="black11"><input type="text" name="country" id="country" value="India" /></td>
    
  </tr>
  
  
  
   <tr>
       <td class="black11">Firm Logo: </td>
     <td class="black11"> 
     
      <input type="file" name="firm_scan" id="firm_scan" value="<?php print $broker_data[0]['firm_scan'];?>" />
     <br/> (eg- .docs,.pdf)
     <br/> (Max Upload Size Up To 5MB.)
     <br/><span id="firmmessage" style="display:none;color:red;" >Please Upload pdf or doc file.</span>	
    </td>
    <td class="black11">
    <?if( $broker_data[0]['company_logo'] != "")
    {?>
   <td> <a href="<?php echo HTTP_ROOT_HOME.'firm_images/'.$broker_data[0]['company_logo'];?>" ><?php echo$broker_data[0]['company_logo']; ?></a></td>
   <?php }  ?>	
    	</td>
    	<input type="hidden" name="old_logo" id="old_logo" value="<?php print $broker_data[0]['company_logo']; ?>" />
     
	</td>
  </tr>
  <tr>
        <td class="black11">No of Years into Business:</td>
    <td class="black11">
     <select name="no_of_years"  id="no_of_years"  value="">
    	<option value="">Select Years</option>
    	<?php echo am_get_years($broker_data[0]['no_of_years']); ?>
    	</select>
    </td>
  </tr>
  
    <tr>
  
     <td class="black11">Area Of Operation:</td>
     <td class="black11">
     <input type="text" name="operation" id="operation" value="<?php print $broker_data[0]['operation_area']?>" />
     </td>
  </tr>
  
    <tr>
    
     <td class="black11">Specialization:</td>
     <td class="black11">
     <input type="text" name="specialization" id="specialization" value="<?php print $broker_data[0]['specialization']?>" />
     </td>
  </tr>
  
   <tr>
    <th class="black11">Contact</th>
    
  </tr>
      <tr>
     <td class="black11"> Mobile: </td>
     <td class="black11"> <input type="text" name="mobile" id="mobile" value="<?php print $broker_data[0]['mobile_no']?>" onblur="sendNotes()" <?php if($mode=='Save') { ?> Readonly  <?php } ?> />
     			<?php if($mode=='Add') { ?>  <div id="message" style="position: relative;margin: 4px 0 0 5px;"></div><?php } ?>	
     </td>
     </tr>
     <tr>
     
     <td class="black11">Office: </td>
     <td class="black11"><input type="text" name="office" id="office" value="<?php print $broker_data[0]['office_no']?>" />
     </td>
  </tr>
 
  
  
  <tr>
    <td>&nbsp;</td>
    <td class="black11"><input type="submit" name="submit1"  value="<?=$mode;?>"  onClick="return a();"/>&nbsp;
   <?php /*if($mode=='Update') { ?><a href="index.php?rel=edit_broker&firm_id=<?php echo $_GET['id']; ?>"> <input type="button" name="addbroker"  value="Add Broker" /></a><?php } */?>
    <!--<input type="reset" name="reset"  value="Reset" />&nbsp;<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=company';" value="Cancel" /> --></td>
  </tr>
</table>
</form>
<?php } ?>

<?php if(!$mode=='Add') { ?>
<h4>List of Brokers in this firm</h4>
<input value="Add New Broker" name="addnew" id="addnew" onclick="javascript:window.location='index.php?&rel=edit_broker&firm_id=<?php echo $_GET['id']; ?>';" type="button">


<?php 
if(count($all_broker) == 0 ) { ?>
<h5>No Broker found:</h5>
<?php } else { ?>
<table width="100%" border="0" cellspacing="2" cellpadding="5" style="text-align: left;">
<tr>
	<th class="black11">ID</th>
	<th class="black11">Broker Name</th>
	<th class="black11">Mobile No.</th>
	<th class="black11">Email</th>
	<th class="black11">Pan Card</th>
</tr>
<?php for($i=0;$i<count($all_broker);$i++) { ?>
<tr>
	<td class="black11"><?php echo $all_broker[$i]['broker_id'];?></td>
	<td class="black11"><?php echo $all_broker[$i]['broker_name'];?></td>
	<td class="black11"><?php echo $all_broker[$i]['mobile1_no'];?></td>
	<td class="black11"><?php echo $all_broker[$i]['email'];?></td>
	<td class="black11"><?php echo $all_broker[$i]['pan_card_num'];?></td>
</tr>
<?php } ?>
</table>
<?php }  } ?>
</table>

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
   // alert(mode);
    

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            


            	$("#register-form").validate({
                rules: {
                    company_name: "required",
                    nature_company: "required",
                    city: "required",
                   
                    mobile: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
		    
                    
                },
                messages: {
                    company_name: "Please enter your Company/Firm Name",
                    nature_company: "Please Select Nature of Company/Firm Name",
                    city: "Please enter your City",
                    mobile: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },
		   
                },
                submitHandler: function(form) {
                 
                	var mobile = $("input[name*='mobile']").val();
                	
                	if(mode=='Add')
                	{
                	
                	
                	//alert(mobile);
                	$.ajax({
                			url : "uniquecompany_result.php",
                			data: {m:mobile},
                			type : "post",
                			success : function(html){
                				
                				var flg = html.split('$');
                				//alert(html);
                				//alert(flg);
                				
                				if( flg[0] == 0 || flg[0] == 2  ) {
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

function a()
{
	if($('#firm_scan').val() !='')
   	{
		var ext = $('#firm_scan').val().split('.').pop().toLowerCase();
			if($.inArray(ext, ['pdf','docx','doc']) == -1) {
	    		$("#firmmessage").css("display","block");
			return false;
	  		}	

	}

}
</script>
