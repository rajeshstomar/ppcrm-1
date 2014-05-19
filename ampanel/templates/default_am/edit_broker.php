<?php
//include("../dbconfig.php");


//print_R($_SESSION); exit;

$msg = $_GET['msg'];

if(isset($_REQUEST['submit1']))
{
	//print_R($_POST); exit;
	$id = $_POST['firm_id'];
	$mode = $_POST['mode'];
	$counter  = $_POST['counter'];
	$counter1  = $_POST['counter1'];
	$firm_id = $_POST['name_firm1'];
	$folder = DIR_BROKER_IMAGES;
	$is_single = $_POST['is_single'];
	if($is_single)
		$id_broker = $_POST['broker_id_1'];
	//print_R($_POST); exit;
	for($i=0; $i<$counter; $i++)
	{
		$broker_id = $_POST['broker_id_'.($i+1)];
		$broker_type = $_POST['broker_type_'.($i+1)];
		$broker_name = $_POST['name_'.($i+1)];
		$pan_card_num = $_POST['pan_card_number_'.($i+1)];
		$mobile1_no = $_POST['mobile1_'.($i+1)];
		$mobile2_no = $_POST['mobile2_'.($i+1)];
		$email = $_POST['main_email_'.($i+1)];
		$calls_noti = isset($_POST['calls_'.($i+1)]) ? $_POST['calls_'.($i+1)] : 0;
		$sms_noti = isset($_POST['sms_'.($i+1)]) ? $_POST['sms_'.($i+1)] : 0;
		$email_noti = isset($_POST['email_'.($i+1)]) ? $_POST['email_'.($i+1)] : 0;
		$broker_category=$_POST['broker_cat_'.($i+1)];
		// Images
		$pan_card_scan = $_FILES['pan_card_scan_'.($i+1)]['name'];
		$old_pan_card_scan = $_POST['old_pan_card_scan_'.($i+1)];
		$photo_scan = $_FILES['photo_scan_'.($i+1)]['name']; 
		$old_photo_scan = $_POST['old_photo_scan_'.($i+1)];
		//$firm_scan = $_FILES['firm_scan_'.($i+1)]['name'];
		//$old_firm_card_scan = $_POST['old_firm_card_scan_'.($i+1)];
		// Images
		if($pan_card_scan != "")
		{
			$pan_card_scan = imageupload($folder."/", $_FILES['pan_card_scan_'.($i+1)]['tmp_name'], $pan_card_scan,"");
			$pan_card = $pan_card_scan[0];
			
			if($old_pan_card_scan != "")
			{
				unlink($folder."/".$old_pan_card_scan);
			}
		}
		else
		{
			$pan_card = $old_pan_card_scan;
		}
		if($photo_scan != "")
		{
			$photo_scan = imageupload($folder."/", $_FILES['photo_scan_'.($i+1)]['tmp_name'], $photo_scan,"");
			$photo = $photo_scan[0];
			
			if($old_photo_scan != "")
			{
				unlink($folder."/".$old_photo_scan);
			}
		}
		else
		{
			$photo = $old_photo_scan;
		}
		/*if($firm_scan != "")
		{
			$firm_scan = imageupload($folder."/", $_FILES['firm_scan_'.($i+1)]['tmp_name'], $firm_scan,"");
			$firm = $firm_scan[0];
			
			if($old_firm_scan != "")
			{
				unlink($folder."/".$old_firm_scan);
			}
		}*/
		$c_date = date('Y-m-d H:i:s');
		if($broker_id != '')
		{
			$modify_date = $c_date;
			$created_date = $_POST['broker_created_date_'.($i+1)];
			$executive_id_created = $_POST['executive_id'];
			//echo "sasa"; exit;
			
		}
		else
		{
			$modify_date = $c_date;
			$created_date = $c_date;
			$executive_id_created = $_SESSION['user_id'];
			//echo $broker_id."qwqw"; exit;
		}
		
		$data = array(	
			'firm_id'=> $firm_id,
			'broker_type'=> $broker_type,
			'broker_name' => $broker_name,
			'pan_card_num' => $pan_card_num,
			'mobile1_no' => $mobile1_no,
			'mobile2_no' => $mobile2_no,
			'email' => $email,
			'pan_scan_file' => $pan_card,
			'photo_scan_file' => $photo,
			'calls_noti' => $calls_noti,
			'sms_noti' => $sms_noti,
			'email_noti' => $email_noti,
			'broker_category' => $broker_category,
			'executive_id_created'=>$executive_id_created,
			'broker_created_date' => $created_date,
			'broker_modify_date'=>$modify_date
		);
		//print_R($data); exit;
		if($broker_id != '')
		{
			am_insertupdate($data, 'broker','broker_id', $broker_id); 
		}
		else
		{
			am_insertupdate($data, 'broker');
		}
	}
	
	if($_POST['asso_name_1']!='' && $_POST['asso_mobile1_1']!='' && $_POST['asso_pan_card_number_1'] !='' )
    {	
	for($j=0; $j<$counter1; $j++)
	{
		$asso_broker_id = $_POST['asso_broker_id_'.($j+1)];
		$asso_broker_type = $_POST['asso_broker_type_'.($j+1)];
		$asso_broker_name = $_POST['asso_name_'.($j+1)];
		$asso_pan_card_number = $_POST['asso_pan_card_number_'.($j+1)];
		$asso_mobile1 = $_POST['asso_mobile1_'.($j+1)];
		$asso_mobile2 = $_POST['asso_mobile2_'.($j+1)];
		$asso_email_add = $_POST['asso_email_add_'.($j+1)];
		
		
		$asso_calls_noti = isset($_POST['asso_calls_'.($j+1)]) ? $_POST['asso_calls_'.($j+1)] : 0;
		$asso_sms_noti = isset($_POST['asso_sms_'.($j+1)]) ? $_POST['asso_sms_'.($j+1)] : 0;
		$asso_email_noti = isset($_POST['asso_email_'.($j+1)]) ? $_POST['asso_email_'.($j+1)] : 0;
		
		$asso_broker_category=$_POST['asso_broker_cat_'.($j+1)];
		// Images
		$asso_pan_card_scan = $_FILES['asso_pan_card_scan_'.($j+1)]['name'];
		$asso_old_pan_card_scan = $_POST['asso_old_pan_card_scan_'.($j+1)];
		$asso_photo_scan = $_FILES['asso_photo_scan_'.($j+1)]['name']; 
		$asso_old_photo_card_scan = $_POST['asso_old_photo_scan_'.($j+1)];
		
		if($asso_pan_card_scan != "")
		{
			$asso_pan_card_scan = imageupload($folder."/", $_FILES['asso_pan_card_scan_'.($j+1)]['tmp_name'], $asso_pan_card_scan,"");
			$asso_pan_card = $asso_pan_card_scan[0];
			
			if($asso_old_pan_card_scan != "")
			{
				unlink($folder."/".$asso_old_pan_card_scan);
			}
		}
		else
		{
			$asso_pan_card = $asso_old_pan_card_scan;
		}
		if($asso_photo_scan != "")
		{
			$asso_photo_scan = imageupload($folder."/", $_FILES['asso_photo_scan_'.($j+1)]['tmp_name'], $asso_photo_scan,"");
			$asso_photo = $asso_photo_scan[0];
			
			if($asso_old_photo_card_scan != "")
			{
				unlink($folder."/".$asso_old_photo_card_scan);
			}
		}
		else
		{
			$asso_photo = $asso_old_photo_card_scan;
		}
		$c_date = date('Y-m-d H:i:s');
		if($asso_broker_id != '')
		{
			$modify_date = $c_date;
			$created_date = $_POST['asso_broker_created_date_'.($j+1)];
				$executive_id_created = $_POST['executive_id'];	
		}
		else
		{
			$modify_date = $c_date;
			$created_date = $c_date;
		
			$executive_id_created = $_SESSION['user_id'];
		}
		
		$data1 = array(	
			'firm_id'=> $firm_id,
			'broker_type'=> $asso_broker_type,
			'broker_name' => $asso_broker_name,
			'pan_card_num' => $asso_pan_card_number,
			'mobile1_no' => $asso_mobile1,
			'mobile2_no' => $asso_mobile2,
			'email' => $asso_email_add,
			'pan_scan_file' => $asso_pan_card,
			'photo_scan_file' => $asso_photo,
			'calls_noti' => $asso_calls_noti,
			'sms_noti' => $asso_sms_noti,
			'email_noti' => $asso_email_noti,
			'broker_category' => $asso_broker_category,
			'executive_id_created'=>$executive_id_created,
			'broker_created_date' => $created_date,
			'broker_modify_date'=>$modify_date
		);
		//print_R($data1); 
		if($asso_broker_id != '')
		{
			am_insertupdate($data1, 'broker','broker_id', $asso_broker_id); 
		}
		else
		{
			am_insertupdate($data1, 'broker');
		}
	}
	
    }	
	$msg = "Record ".$mode."d Successfully";
	if($is_single)
		am_goto_page("index.php?rel=edit_broker&id=".$id_broker."&msg=".$msg);
	else
		$msg = "Record ".$mode."d Successfully"; 
	//am_goto_page("index.php?rel=edit_broker&firm_id=".$id."&msg=".$msg);
	echo $msg; exit;
	
}

if(isset($_REQUEST['firm_id']) && is_numeric($_REQUEST['firm_id']))
{
	$firm_id = $_REQUEST['firm_id'];
//	echo $firm_id; exit;

	$firm = "SELECT `company_id`, `company_name` FROM `broker_firm` WHERE company_id = '".$firm_id."' ";
	$firm_data = am_select($firm);

	$main = "SELECT * FROM `broker` WHERE firm_id = '".$firm_id."' AND broker_type = 'main' ";
	$assoc = "SELECT * FROM `broker` WHERE firm_id = '".$firm_id."' AND broker_type = 'associate' ";
	
	$main_broker = am_select($main);
	$assoc_broker = am_select($assoc);
	//my_print_R($main_broker);
	//my_print_R($assoc_broker);exit;
	if(count($main_broker) > 0 || count($assoc_broker) > 0)
	{
		if(count($main_broker) > 0)
			$counter = count($main_broker);
		else
			$counter = 1;
		if(count($assoc_broker) > 0)
			$counter1 = count($assoc_broker);
		else
			$counter1 = 1;
		$limit=5;
		$total_broker=5;
		$mode = "Save";
		$text = "Update";
	}
	else
	{
		$counter = 1;
		$counter1 = 1;
		$limit=5;
		$total_broker=5;
		$mode = "Save";
		$text = "Add";
	
	}
}
if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
{
	$id = $_REQUEST['id'];
//	echo $firm_id; exit;

	$broker = "SELECT * FROM `broker` WHERE broker_id = '".$id."'";
	$single_broker = am_select($broker);
	//print_R($single_broker); exit;
	$firm = "SELECT `company_id`, `company_name` FROM `broker_firm` WHERE company_id = '".$single_broker[0]['company_id']."' ";
	$firm_data = am_select($firm);
	$mode = "Update";
	$text = "Update";
}
/*else
{
	$mode = "Add";
	$counter = 1;
	$counter1 = 1;
	$limit=5;
	$total_broker=5;	
	
}*/
//include(DIR_SCRIPT_ROOT."/fckeditor/fckeditor.php") ; 

$broker="select company_name,company_id from broker_firm";
$broker_data = am_select($broker);
//print_R($broker_data);exit;

$build_array = array();


for($i=0;$i<count($broker_data);$i++)
{
	
	
	$build_array[]='{'.'"label":"'.$broker_data[$i]['company_name'].'","val":"'.$broker_data[$i]['company_id'].'"'.'}';
	
}

 $cnt = '['.implode(',',$build_array).']';
//print_R($cnt);exit;

?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script>
  
  
  $(function() {
    var availableTags = <?php echo $cnt; ?>;
    $( "#name_firm" ).autocomplete({
      source: availableTags,
      
      select: function(event, ui) {
                var selectedObj = ui.item;
		var tmp1 = selectedObj.val;
		$("#name_firm1").val(tmp1); 
		
		
		

		
	}
      
    });
  });
  </script>
  
   <script type="text/javascript">
		function sendNotes(id)   {
			var $form = $(this); 
			
		    	var mobile_no=$('#'+id).val();
		    	var col_name=$('#'+id).attr('ref');
		    	var no = id;
		    	
		    	
		    	
		    	//alert(no[3]);
		    	
		    	//alert(col_name);
		    	//var pan_card_number_1=$("$pan_card_number_1").val();
				//alert(mobile_no);	     
				       
			$.ajax({
				type: "POST",
				url: "uniquebroker_result.php",
				data: {m:mobile_no,c:col_name},
				success: function(html){
					
					
					
					var flg = html.split('$');
					
						//alert(id);
					
						if(flg[0] == 1 || flg[0] == 3)
						{
							$('#'+id+'_msg').html(flg[1]);
							return false;
						}
						else
						{
							$('#'+id+'_msg').html(flg[1]);
							return true;
						}
				    }
			    }); 
		return false;
}
		
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
  
<div align="center" style="width:100%; margin-bottom:5px;"><font color="#FF0000"><?php print $msg; ?></font></div>
<h2><?php echo $text;?> Broker For: <?php echo $firm_data[0]['company_name'];?></h2>
<form name="frm" id="register-form" method="post" action="index.php?rel=edit_broker" enctype="multipart/form-data" >
<input type="hidden" name="mode" id="mode" value="<?=$mode;?>">
<table width="100%" border="0" cellspacing="2" cellpadding="2"> 
  
  
  <tr>
        <td class="black11">Firm Name:</td>
    	<td class="black11">
     	
    	
    	<?php if($_GET['firm_id']!='' || $_REQUEST['id'] != '') { ?>
    	<label><?php echo $firm_data[0]['company_name']; ?></label>
    	<!--<input type="text" readonly name="name_firm" id="name_firm" value="<?php echo $firm_data[0]['company_name']; ?>" />-->
    	<?php } else { ?>
    	<label><?php echo $firm_data[0]['company_name']; ?></label>
    	<!--<input type="text" name="name_firm" id="name_firm" value="<?php echo $firm_data[0]['company_name']; ?>" />-->
    	<?php } ?>
    	
    	<?php if($mode=='Save') { ?>
    	<input type="hidden" name="name_firm1" id="name_firm1" value="<?php echo $_GET['firm_id']; ?>" />	
    	<?php } else { ?>
    	<input type="hidden" name="name_firm1" id="name_firm1" value="<?php echo $firm_data[0]['firm_id']; ?>" />
    	<?php } ?>
    	</td>
    	
  </tr>
 
  <?php
  	
if(count($single_broker) > 0)
{
?>
<tr>
<td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" bgcolor="<?php if($single_broker[0]['broker_type'] == 'main') { ?>#c5dbe5<?php } else { ?>#c0c6be<?php } ?>" style="margin-top: 15px;"> 
   <tr>
    <th class="black11"><?php if($single_broker[0]['broker_type'] == 'main') { ?>Member<?php } else { ?>Associate<?php } ?> broker</th>
  </tr>
  <tr id="name_tr_1">
   
     <td class="black11"> Name: </td>
     <td class="black11"> 
	    <input type="text" name="name_1" id="name_1" value="<?php echo $single_broker[0]['broker_name']; ?>" /></td>
	    <input type="hidden" name="broker_id_1" id="broker_id_1" value="<?php echo $single_broker[0]['broker_id']; ?>" />
	    <input type="hidden" name="broker_type_1" id="broker_type_1" value="<?php if($single_broker[0]['broker_type'] == 'main') { ?>main<?php } else { ?>associate<?php } ?>" />
	    <input type="hidden" name="is_single" id="is_single" value="1" />
	    <input type="hidden" name="counter" id="counter" value="1" />
	    <input type="hidden" name="counter1" id="counter1" value="0" />
	    <input type="hidden" name="broker_created_date_1" id="broker_created_date_1" value="<?php echo $single_broker[0]['broker_created_date']; ?>" />
     <td class="black11">Pan Card Number:  </td>
      <td class="black11"> <input type="text" name="pan_card_number_1" id="pan_card_number_1" value="<?php echo $single_broker[0]['pan_card_num']; ?>" onblur="sendNotes(this.id);" class="sendNotes"/></td>
  </tr>
  
  
    <tr >
    <th class="black11">Contact</th>
  </tr>
  
   <tr >
   
     <td class="black11">Mobile No1: </td>
     <td class="black11"> <input type="text" name="mobile1_1" id="mobile1_1" value="<?php echo $single_broker[0]['mobile1_no']; ?>" onblur="sendNotes(this.id);" class="sendNotes"/></td>
     <td class="black11">Mobile No2: </td>
      <td class="black11"> <input type="text" name="mobile2_1" id="mobile2_1" value="<?php echo $single_broker[0]['mobile2_no']; ?>" /></td>
  </tr>
  
  <tr >
       <td class="black11">Email ID: </td>
     <td class="black11" colspan="3"> <input type="text" name="main_email_1" id="main_email_1" value="<?php echo $single_broker[0]['email']; ?>" />
     	
     </td>
  </tr>
  
  <tr >
       <td class="black11">Pan Card Scan: </td>
     <td class="black11" colspan="3"> <input type="file" name="pan_card_scan_1" id="pan_card_scan_1" value="" />
     	<br>(eg- .docs,.pdf)<br/> (Max Upload Size Up To 5MB.)
     	<?php if($single_broker[0]['pan_scan_file'] !=''){ ?>
     	<input type="hidden" name="old_pan_card_scan_1" value="<?php echo $single_broker[0]['pan_scan_file']; ?>" />
     	<img src="<?php echo BROKER_IMAGES_URL.$single_broker[0]['pan_scan_file']; ?>" width="100">
     	<?php } ?>
     </td>
  </tr>
  <tr>
       <td class="black11">Photo Scan: </td>
     <td class="black11" colspan="3"> <input type="file" name="photo_scan_1" id="photo_scan_1" value="" />
     	<br>(eg- .docs,.pdf)<br/> (Max Upload Size Up To 5MB.)
    	<?php if($single_broker[0]['photo_scan_file'] !=''){ ?>
		<input type="hidden" name="old_photo_scan_1" value="<?php echo $single_broker[0]['photo_scan_file']; ?>" />
		<img src="<?php echo BROKER_IMAGES_URL.$single_broker[0]['photo_scan_file']; ?>" width="100">
	<?php } ?>
     </td>
  </tr>
  <!--<tr>
       <td class="black11">Firm Scan: </td>
     <td class="black11"> <input type="file" name="firm_scan_1" id="firm_scan_1" value="" /></td>
  </tr>-->
  <tr>
  	<td class="black11">Note: </td>
  	<td class="black11">Check This Check box For notification via multiple options.   </td>
   </tr>
   
   
    <tr >
  	<td class="black11"><input type="checkbox" value="1" name="calls_1" id="calls_1" <?php if($single_broker[0]['calls_noti'] == 1) { ?>checked<?php } ?> >Call</td>
  	<td class="black11"><input type="checkbox" value="1" name="sms_1" id="sms_1" <?php if($single_broker[0]['sms_noti'] == 1) { ?>checked<?php } ?>>SMS</td>
  	<td class="black11"><input type="checkbox" value="1" name="email_1" id="email_1" <?php if($single_broker[0]['email_noti'] == 1) { ?>checked<?php } ?>>Email </td>
   </tr>
   
   
   
   <tr>
	    <td class="black11">Broker Category</td>
	    <td class="black11">
	    	
	    	<select name="broker_cat_1" id="broker_cat_1">
	    		<option value="">Select Category</option>
	    		<option value="4" <?php if($single_broker[0]['broker_category']=='4') { ?> selected <?php } ?> >Platinum</option>
	    		<option value="3" <?php if($single_broker[0]['broker_category']=='3') { ?> selected <?php } ?> >Gold</option>
	    		<option value="2" <?php if($single_broker[0]['broker_category']=='2') { ?> selected <?php } ?> >Silver</option>
	    		<option value="1" <?php if($single_broker[0]['broker_category']=='1') { ?> selected <?php } ?> >Bronze</option>
	    	</select>
	    
	    </td>
	    	
	   
	   
  </tr>
   
   
  <tr>
    <td>&nbsp;</td>
    <td class="black11"><input type="submit" name="submit1"  value="<?=$mode;?>" />&nbsp;<input type="button" name="call_log" onclick="javascript:window.location='index.php?rel=common_listing&module=call_log&id=<?php echo $single_broker[0]['broker_id']?>&user_is=broker';" value="Call Log" /><!--<input type="reset" name="reset"  value="Reset" />&nbsp;<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=static_pages';" value="Cancel" />--></td>
  </tr>
</table>  
</td>
</tr>

<?
}
else
{  
   for($i=0; $i<$counter; $i++)
	{ ?>
  <tr>
  <td colspan="2">	
  <table  width="100%" border="0" cellspacing="2" cellpadding="2" bgcolor="#c5dbe5" style="margin-top: 15px;"> 
   <tr>
    <th class="black11">Member broker<input type="hidden" name="broker_type_<?php echo $i+1 ?>" id="broker_type_<?php echo $i+1 ?>" value="main" /></th>
  </tr>
  
  
   <tr id="name_tr_<?php echo $i ?>">
   
     <td class="black11"> Name: </td>
     <td class="black11"> 
	    <input type="text" name="name_<?php echo $i+1 ?>" id="name_<?php echo $i+1 ?>" value="<?php echo $main_broker[$i]['broker_name']; ?>" /></td>
	    <input type="hidden" name="broker_id_<?php echo $i+1; ?>" id="broker_id_<?php echo $i+1 ?>" value="<?php echo $main_broker[$i]['broker_id']; ?>" />
	    <input type="hidden" name="broker_created_date_<?php echo $i+1; ?>" id="broker_created_date_<?php echo $i+1 ?>" value="<?php echo $main_broker[$i]['broker_created_date']; ?>" />
     <td class="black11">Pan Card Number:  </td>
      <td class="black11"> <input type="text" name="pan_card_number_<?php echo $i+1 ?>" id="pan_card_number_<?php echo $i+1 ?>" value="<?php echo $main_broker[$i]['pan_card_num']; ?>" onblur="sendNotes(this.id);" class="sendNotes" ref="pan_card_num" />
      		 <div id="pan_card_number_<?php echo $i+1 ?>_msg" style="position: relative;margin: 4px 0 0 5px;"></div>
      </td>
  </tr>
  
  
    <tr >
    <th class="black11">Contact </th>
  </tr>
  
   <tr >
   
     <td class="black11">Mobile No1: </td>
     <td class="black11"> <input type="text" name="mobile1_<?php echo $i+1 ?>" id="mobile1_<?php echo $i+1 ?>" value="<?php echo $main_broker[$i]['mobile1_no']; ?>" onblur="sendNotes(this.id);" class="sendNotes" ref="mobile1_no"/>
     		  <div id="mobile1_<?php echo $i+1 ?>_msg" style="position: relative;margin: 4px 0 0 5px;"></div>
     </td>
     <td class="black11">Mobile No2: </td>
      <td class="black11"> <input type="text" name="mobile2_<?php echo $i+1 ?>" id="mobile2_<?php echo $i+1 ?>" value="<?php echo $main_broker[$i]['mobile2_no']; ?>" /></td>
  </tr>
  
  <tr >
       <td class="black11">Email ID: </td>
     <td class="black11" colspan="3"> <input type="text" name="main_email_<?php echo $i+1 ?>" id="main_email_<?php echo $i+1 ?>" value="<?php echo $main_broker[$i]['email']; ?>" />
     	
     </td>
  </tr>
  
  <tr >
       <td class="black11">Pan Card Scan: </td>
     <td class="black11" colspan="3"> <input type="file" name="pan_card_scan_<?php echo $i+1 ?>" id="pan_card_scan_<?php echo $i+1 ?>" value="" />
     	<br>(eg- .docs,.pdf)<br/> (Max Upload Size Up To 5MB.)
     	<?php if($main_broker[$i]['pan_scan_file'] !=''){ ?>
     	<input type="hidden" name="old_pan_card_scan_<?php echo $i+1; ?>" value="<?php echo $main_broker[$i]['pan_scan_file']; ?>" />
     	<img src="<?php echo BROKER_IMAGES_URL.$main_broker[$i]['pan_scan_file']; ?>" width="100">
     	<?php } ?>
     </td>
  </tr>
  <tr>
       <td class="black11">Photo Scan: </td>
     <td class="black11" colspan="3"> <input type="file" name="photo_scan_<?php echo $i+1 ?>" id="photo_scan_<?php echo $i+1 ?>" value="" />
     	<br>(eg- .docs,.pdf)<br/> (Max Upload Size Up To 5MB.)
    	<?php if($main_broker[$i]['photo_scan_file'] !=''){ ?>
		<input type="hidden" name="old_photo_scan_<?php echo $i+1; ?>" value="<?php echo $main_broker[$i]['photo_scan_file']; ?>" />
		<img src="<?php echo BROKER_IMAGES_URL.$main_broker[$i]['photo_scan_file']; ?>" width="100">
	<?php } ?>
     </td>
  </tr>
  <!--<tr>
       <td class="black11">Firm Scan: </td>
     <td class="black11"> <input type="file" name="firm_scan_<?php echo $i+1 ?>" id="firm_scan_<?php echo $i+1 ?>" value="" /></td>
  </tr>-->
  <tr>
  	<td class="black11">Note: </td>
  	<td class="black11">Check This Check box For notification via multiple options.   </td>
   </tr>
   
   
    <tr >
  	<td class="black11"><input type="checkbox" value="1" name="calls_<?php echo $i+1 ?>" id="calls_<?php echo $i+1 ?>" <?php if($main_broker[$i]['calls_noti'] == 1) { ?>checked<?php } ?> >Call</td>
  	<td class="black11"><input type="checkbox" value="1" name="sms_<?php echo $i+1 ?>" id="sms_<?php echo $i+1 ?>" <?php if($main_broker[$i]['sms_noti'] == 1) { ?>checked<?php } ?>>SMS</td>
  	<td class="black11"><input type="checkbox" value="1" name="email_<?php echo $i+1 ?>" id="email_<?php echo $i+1 ?>" <?php if($main_broker[$i]['email_noti'] == 1) { ?>checked<?php } ?>>Email </td>
   </tr>
   
   <tr>
	    <td class="black11">Broker Category</td>
	    <td class="black11">
	    	
	    	<select name="broker_cat_<?php echo $i+1 ?>" id="broker_cat_<?php echo $i+1 ?>">
	    		<option value="">Select Category</option>
	    		<option value="4" <?php if($main_broker[$i]['broker_category']=='4') { ?> selected <?php } ?> >Platinum</option>
	    		<option value="3" <?php if($main_broker[$i]['broker_category']=='3') { ?> selected <?php } ?> >Gold</option>
	    		<option value="2" <?php if($main_broker[$i]['broker_category']=='2') { ?> selected <?php } ?> >Silver</option>
	    		<option value="1" <?php if($main_broker[$i]['broker_category']=='1') { ?> selected <?php } ?> >Bronze</option>
	    	</select>
	    <?php if($main_broker[$i]['broker_id'] != '') { ?>
	    	&nbsp;<input type="button" name="call_log" onclick="javascript:window.location='index.php?rel=common_listing&module=call_log&id=<?php echo $main_broker[$i]['broker_id'];?>&user_is=broker';" value="Call Log" />
	    <?php } ?>
	    </td>
	    	
	   
	   
  </tr>
   
   
    </table>
   </td>
   </tr>
  <?php } ?>
 
  <input type="hidden" name="counter" id="counter" value="<?php echo $i ?>" />
  <tr id="add_more_tr">
  <td class="black11">
  <input type="button" name="add_more" id="add_more" value="Add Member broker Up To 5" /></td>  <td class="black11"><input type="button" name="remove" id="remove" title="" value="Remove" style="display:none;" />
  </td>
   </tr>
   
  <?php
  	
  
   for($i=0; $i<$counter1; $i++)
	{ ?>
  <tr>
  <td colspan="2">	
  <table width="100%" border="0" cellspacing="2" cellpadding="2" bgcolor="#c0c6be" style="margin-top: 15px;"> 
   <tr>
    <th class="black11">Associate Broker <input type="hidden" name="asso_broker_type_<?php echo $i+1 ?>" id="asso_broker_type_<?php echo $i+1 ?>" value="associate" /></th>
  </tr>
  
  
   <tr id="name_tr_<?php echo $i ?>">
   
     <td class="black11"> Name:  </td>
     <td class="black11"> 
     	<input type="text" name="asso_name_<?php echo $i+1 ?>" id="asso_name_<?php echo $i+1 ?>" value="<?php echo $assoc_broker[$i]['broker_name']; ?>" />
     	<input type="hidden" name="asso_broker_id_<?php echo $i+1 ?>" id="asso_broker_id_<?php echo $i+1 ?>" value="<?php echo $assoc_broker[$i]['broker_id']; ?>" />
     	<input type="hidden" name="asso_broker_created_date_<?php echo $i+1; ?>" id="asso_broker_created_date_<?php echo $i+1 ?>" value="<?php echo $assoc_broker[$i]['broker_created_date']; ?>" />	
     </td>
     	
     <td class="black11">Pan Card Number:  </td>
      <td class="black11"> <input type="text" name="asso_pan_card_number_<?php echo $i+1 ?>" id="asso_pan_card_number_<?php echo $i+1 ?>" value="<?php echo $assoc_broker[$i]['pan_card_num']; ?>"  />
      		 <div id="asso_pan_card_number_<?php echo $i+1 ?>_msg" style="position: relative;margin: 4px 0 0 5px;"></div>
      </td>
  </tr>
  
  
    <tr >
    <th class="black11">Contact</th>
  </tr>
  
   <tr >
   
     <td class="black11">Mobile No1: </td>
     <td class="black11"> <input type="text" name="asso_mobile1_<?php echo $i+1 ?>" id="asso_mobile1_<?php echo $i+1 ?>" value="<?php echo $assoc_broker[$i]['mobile1_no']; ?>"  />
     		 <div id="asso_mobile1_<?php echo $i+1 ?>_msg" style="position: relative;margin: 4px 0 0 5px;"></div>
     
     </td>
     <td class="black11">Mobile No2: </td>
      <td class="black11"> <input type="text" name="asso_mobile2_<?php echo $i+1 ?>" id="asso_mobile2_<?php echo $i+1 ?>" value="<?php echo $assoc_broker[$i]['mobile2_no']; ?>" /></td>
  </tr>
  <tr >
       <td class="black11">Email ID: </td>
     <td class="black11" colspan="3"> <input type="text" name="asso_email_add_<?php echo $i+1 ?>" id="asso_email_add_<?php echo $i+1 ?>" value="<?php echo $assoc_broker[$i]['email']; ?>" />
     	
     </td>
  </tr>
  <tr >
       <td class="black11">Pan Card Scan: </td>
     <td class="black11" colspan="3"> <input type="file" name="asso_pan_card_scan_<?php echo $i+1 ?>" id="asso_pan_card_scan_<?php echo $i+1 ?>" value="" />
     <br>(eg- .docs,.pdf)<br/> (Max Upload Size Up To 5MB.)
     <?php if($assoc_broker[$i]['pan_scan_file'] !=''){ ?>
	<input type="hidden" name="asso_old_pan_card_scan_<?php echo $i+1; ?>" value="<?php echo $assoc_broker[$i]['pan_scan_file']; ?>" />
	<img src="<?php echo BROKER_IMAGES_URL.$assoc_broker[$i]['pan_scan_file']; ?>" width="100">
<?php } ?>
     </td>
  </tr>
  <tr>
       <td class="black11">Photo Scan: </td>
     <td class="black11" colspan="3"> <input type="file" name="asso_photo_scan_<?php echo $i+1 ?>" id="asso_photo_scan_<?php echo $i+1 ?>" value="" /> 
     <br>(eg- .docs,.pdf)<br/> (Max Upload Size Up To 5MB.)
     <?php //echo $assoc_broker[$i]['pan_scan_file'].'--'.$assoc_broker[$i]['photo_scan_file']."sas"; 
     if($assoc_broker[$i]['photo_scan_file'] !=''){ ?>
	<input type="hidden" name="asso_old_photo_scan_<?php echo $i+1; ?>" value="<?php echo $assoc_broker[$i]['photo_scan_file']; ?>" />
	<img src="<?php echo BROKER_IMAGES_URL.$assoc_broker[$i]['photo_scan_file']; ?>" width="100">
<?php } ?>
     </td>
  </tr>
<!--  <tr>
       <td class="black11">Firm Scan: </td>
     <td class="black11"> <input type="file" name="asso_firm_scan_<?php echo $i+1 ?>" id="asso_firm_scan_<?php echo $i+1 ?>" value="" /></td>
  </tr>-->
  <tr>
  	<td class="black11">Note: </td>
  	<td class="black11">Check This Check box For notification via multiple options.   </td>
   </tr>
   
   
    <tr >
  	<td class="black11"><input type="checkbox" value="1" name="asso_calls_<?php echo $i+1 ?>" id="asso_calls_<?php echo $i+1 ?>" <?php if($assoc_broker[$i]['calls_noti'] == 1) { ?>checked<?php } ?>>Call</td>
  	<td class="black11"><input type="checkbox" value="1" name="asso_sms_<?php echo $i+1 ?>" id="asso_sms_<?php echo $i+1 ?>" <?php if($assoc_broker[$i]['sms_noti'] == 1) { ?>checked<?php } ?>>SMS</td>
  	<td class="black11"><input type="checkbox" value="1" name="asso_email_<?php echo $i+1 ?>" id="asso_email_<?php echo $i+1 ?>" <?php if($assoc_broker[$i]['email_noti'] == 1) { ?>checked<?php } ?>>Email </td>
   </tr>
   
   
   <tr>
	    <td class="black11">Broker Category</td>
	    <td class="black11">
	    	
	    	<select name="asso_broker_cat_<?php echo $i+1 ?>" id="asso_broker_cat_<?php echo $i+1 ?>">
	    		<option value="">Select Category</option>
	    		<option value="4" <?php if($assoc_broker[$i]['broker_category']=='4') { ?> selected <?php } ?> >Platinum</option>
	    		<option value="3" <?php if($assoc_broker[$i]['broker_category']=='3') { ?> selected <?php } ?> >Gold</option>
	    		<option value="2" <?php if($assoc_broker[$i]['broker_category']=='2') { ?> selected <?php } ?> >Silver</option>
	    		<option value="1" <?php if($assoc_broker[$i]['broker_category']=='1') { ?> selected <?php } ?> >Bronze</option>
	    	</select>
	    <?php if($assoc_broker[$i]['broker_id'] != '') { ?>
	    	&nbsp;<input type="button" name="call_log" onclick="javascript:window.location='index.php?rel=common_listing&module=call_log&id=<?php echo $assoc_broker[$i]['broker_id'];?>&user_is=broker';" value="Call Log" />
	    <?php } ?>
	    </td>
	    	
	   
	   
  </tr>
  
   </table>
   </td>
   </tr>
  <?php } ?>
 
  <input type="hidden" name="counter1" id="counter1" value="<?php echo $i ?>" />
  <tr id="add_more_tr1">
    <td class="black11">
  <input type="button" name="add_more1" id="add_more1" value="Add More Associate Broker Up To 5" /></td>  <td class="black11"><input type="button" name="remove1" id="remove1" title="" value="Remove" style="display:none;" />
  </td>
   </tr>
   
   <?php if($_GET['id']=='') { ?>
  
  <tr>
  	<th class="black11" colspan="2">Terms and Conditions*</th>
  </tr>
   <tr>	    
	 
	   <td class="black11" colspan="2"><input type="checkbox" name="c" id="c">&nbsp;&nbsp;&nbsp;1. I undertake to update PropertyPistol In case of transaction (sale/rent) on any of the property listed by me.</td>  
	    
  </tr>
    <tr>	    
	 
	   <td class="black11" colspan="2"><input type="checkbox" name="c" id="c">&nbsp;&nbsp;&nbsp;2. I agree to payment terms of PropertyPistol (side-by-side). I will not share my brokerage with PropertyPistol & <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; neither shall expect any sharing from PropertyPistol.</td>  
	    
  </tr>
  <tr>	    
	 
	   <td class="black11" colspan="2"><input type="checkbox" name="c" id="c">&nbsp;&nbsp;&nbsp;3. I agree to share my contact details to any of member broker/Builders associated with PropertyPistol Reality<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pvt Ltd.</td>  
	    
  </tr>	
  
  <?php } ?>
   
   
   
  <!--<tr>
  	
  	<td class="black11">Executive&nbsp;&nbsp;&nbsp;<input type="text" name="executive" id="executive" value="" /> </td>
  	
  	<td class="black11">Broker Name&nbsp;&nbsp;&nbsp;<input type="text" name="broker_name" id="broker_name" value="" /> </td>
   </tr>-->
   
    <tr> 
	   <td class="black11" colspan="1" style="width: 100px;">Executive Name</td> 
	   <td class="black11" colspan="1"> <?php echo $select = am_get_select('admin', 'admin_id', 'executive_id', $main_broker[0]['executive_id_created'], 'admin_f_name', '','' );  ?>
	   </td>
   </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td class="black11"><input type="submit" name="submit1"  value="<?=$mode;?>" />&nbsp;<!--<input type="reset" name="reset"  value="Reset" />&nbsp;<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=static_pages';" value="Cancel" />--></td>
  </tr>

</table>

<?php
}
?>
</form>



<script>
		
		$(document).ready(function(){
		var counter = $("#counter").val();
		var limit = parseInt("<?php echo $limit ?>");
		if(counter >= limit)
			$("#add_more").hide();

		$("#add_more").click(function(){
			if(counter < limit)
			{
  			
				$("#add_more_tr").before('<tr id="table1_tr_'+counter+'"><td colspan="2"><table width="100%" border="0" style="margin-top: 15px;" cellspacing="2" cellpadding="2" bgcolor="#c5dbe5"> <tr id="main_broker_tr_'+counter+'"><th class="black11">Member broker :<input type="hidden" name="broker_type_'+(parseInt(counter)+1)+'" id="broker_type_'+(parseInt(counter)+1)+'" value="main" ></th></tr><tr id="name_tr_'+counter+'" ><td class="black11">Name :</td><td class="black11"><input type="text" name="name_'+(parseInt(counter)+1)+'" id="name_'+(parseInt(counter)+1)+'" ></td><td class="black11">Pan Card Number:</td><td class="black11"><input type="text" name="pan_card_number_'+(parseInt(counter)+1)+'" id="pan_card_number_'+(parseInt(counter)+1)+'" onblur="sendNotes(this.id);" class="sendNotes" ref="pan_card_num" ><div id="pan_card_number_'+(parseInt(counter)+1)+'_msg" style="position: relative;margin: 4px 0 0 5px;"></div></td></tr><tr id="contact_tr_'+counter+'"><th class="black11">Contact : </th></tr><tr id="mobile_tr_'+counter+'"><td class="black11">Mobile No1</td><td classs="black11"><input type="text" name="mobile1_'+(parseInt(counter)+1)+'" id="mobile1_'+(parseInt(counter)+1)+'" onblur="sendNotes(this.id);" class="sendNotes" ref="mobile1_no" > <div id="mobile1_'+(parseInt(counter)+1)+'_msg" style="position: relative;margin: 4px 0 0 5px;"></div></td><td class="black11">Mobile No2</td><td classs="black11"><input type="text" name="mobile2_'+(parseInt(counter)+1)+'" id="mobile2_'+(parseInt(counter)+1)+'" ></td></tr><tr id="email_tr_'+counter+'"><td class="black11">Email ID: </td><td class="black11"><input type="text" name="main_email_'+(parseInt(counter)+1)+'" id="main_email_'+(parseInt(counter)+1)+'"></td></tr><tr id="pan_card_tr_'+counter+'"><td class="black11">Pan Card Scan:</td><td class="black11"><input type="file" name="pan_card_scan_'+(parseInt(counter)+1)+'" id="pan_card_scan_'+(parseInt(counter)+1)+'"><br>(eg- .docs,.pdf)<br/> (Max Upload Size Up To 5MB.)</td></tr><tr id="photo_scan_tr_'+counter+'"><td class="black11">Photo Scan:</td><td class="black11"><input type="file" name="photo_scan_'+(parseInt(counter)+1)+'" id="photo_scan_'+(parseInt(counter)+1)+'"><br>(eg- .docs,.pdf)<br/> (Max Upload Size Up To 5MB.)</td></tr><!--<tr id="firm_scan_tr_'+counter+'"><td class="black11">Firm Scan: '+(parseInt(counter)+1)+' :</td><td class="black11"><input type="file" name="firm_scan_'+(parseInt(counter)+1)+'" id="firm_scan_'+(parseInt(counter)+1)+'"></td></tr>--><tr id="note_tr_'+counter+'"><td class="black11">Note:</td><td class="black11">Check This Check box For notification via multiple options.</td></tr><tr id="noteifi_tr_'+counter+'"><td class="black11"><input type="checkbox" name="call_'+(parseInt(counter)+1)+'" id="calls_'+(parseInt(counter)+1)+'">Call  </td><td class="black11"><input type="checkbox" name="sms_'+(parseInt(counter)+1)+'" id="sms_'+(parseInt(counter)+1)+'">SMS  </td><td class="black11"><input type="checkbox" name="email_'+(parseInt(counter)+1)+'" id="email_'+(parseInt(counter)+1)+'">Email </td></tr><tr id="category_tr_'+counter+'"><td class="black11">Broker Category</td><td class="black11"><select name="broker_cat_'+(parseInt(counter)+1)+'" id="broker_cat_'+(parseInt(counter)+1)+'"><option value="">Select Category</option><option value="4" <?php if($client_data[0]['broker_category']=='4') { ?> selected <?php } ?> >Platinum</option><option value="3" <?php if($client_data[0]['broker_category']=='3') { ?> selected <?php } ?> >Gold</option><option value="2" <?php if($client_data[0]['broker_category']=='2') { ?> selected <?php } ?> >Silver</option><option value="1" <?php if($client_data[0]['broker_category']=='1') { ?> selected <?php } ?> >Bronze</option> </select></td></tr></table></td></tr>');
			
		
			
			
				
				$("#remove").attr('title',counter);
				$("#remove").show();
				counter++;
				$("#counter").val(counter);
				
				if(counter >= limit)
				{
					$("#add_more").hide();
				}
			}
		});
		
		$("#remove").click(function(){
		
			//var total_broker = <?php echo $total_broker ?>;
			
			var id = $("#remove").attr("title");
			//alert(id + total_broker);
			
			$("#main_broker_tr_"+id).remove();
			$("#name_tr_"+id).remove();
			$("#contact_tr_"+id).remove();
			$("#mobile_tr_"+id).remove();
			$("#email_tr_"+id).remove();
			$("#pan_card_tr_"+id).remove();
			$("#photo_scan_tr_"+id).remove();
			//$("#firm_scan_tr_"+id).remove();
			$("#note_tr_"+id).remove();
			$("#noteifi_tr_"+id).remove();
			$("#category_tr_"+id).remove();
			$("#table1_tr_"+id).remove();
			//$("#executive_tr_"+id).remove();
		
			$("#counter").val(id);
			id--;
			$("#remove").attr('title',id);
			
			if(id < 1)
			{
				$("#remove").hide();
			}
			
			$("#add_more").show();
		});
		
		
	})
	
	
	
	$(document).ready(function(){
		var counter1 = $("#counter1").val();
		var limit = parseInt("<?php echo $limit ?>");
		if(counter1 >= limit)
			$("#add_more1").hide();

		$("#add_more1").click(function(){
		
			if(counter1 < limit)
			{
				$("#add_more_tr1").before('<tr id="table2_tr_'+counter1+'" ><td colspan="2"><table width="100%" style="margin-top: 15px;" border="0" cellspacing="2" cellpadding="2" bgcolor="#c0c6be"> <tr id="asso_broker_tr_'+counter1+'"><th class="black11">Associate Broker  :<input type="hidden" name="asso_broker_type_'+(parseInt(counter1)+1)+'" id="asso_broker_type_'+(parseInt(counter1)+1)+'" value="associate" ></th></tr><tr id="asso_name_tr_'+counter1+'" ><td class="black11">Name :</td><td class="black11"><input type="text" name="asso_name_'+(parseInt(counter1)+1)+'" id="asso_name_'+(parseInt(counter1)+1)+'" ></td><td class="black11">Pan Card Number  :</td><td class="black11"><input type="text" name="asso_pan_card_number_'+(parseInt(counter1)+1)+'" id="asso_pan_card_number_'+(parseInt(counter1)+1)+'"  ><div id="asso_pan_card_number_'+(parseInt(counter1)+1)+'_msg" style="position: relative;margin: 4px 0 0 5px;"></div></td></tr><tr id="asso_contact_tr_'+counter1+'"><th class="black11">Contact : </th></tr><tr id="asso_mobile_tr_'+counter1+'"><td class="black11">Mobile No1</td><td classs="black11"><input type="text" name="asso_mobile1_'+(parseInt(counter1)+1)+'" id="asso_mobile1_'+(parseInt(counter1)+1)+'" > <div id="asso_mobile1_'+(parseInt(counter1)+1)+'_msg" style="position: relative;margin: 4px 0 0 5px;"></div></td><td class="black11">Mobile No2</td><td classs="black11"><input type="text" name="asso_mobile2_'+(parseInt(counter1)+1)+'" id="asso_mobile2_'+(parseInt(counter1)+1)+'" ></td></tr><tr id="asso_email_add_tr_'+counter1+'"><td class="black11">Email ID :</td><td class="black11"><input type="text" name="asso_email_add_'+(parseInt(counter1)+1)+'" id="asso_email_add_'+(parseInt(counter1)+1)+'"></td></tr><tr id="asso_pan_card_tr_'+counter1+'"><td class="black11">Pan Card Scan:</td><td class="black11"><input type="file" name="asso_pan_card_scan_'+(parseInt(counter1)+1)+'" id="asso_pan_card_scan_'+(parseInt(counter1)+1)+'"><br>(eg- .docs,.pdf)<br/> (Max Upload Size Up To 5MB.)</td></tr><tr id="asso_photo_scan_tr_'+counter1+'"><td class="black11">Photo Scan:</td><td class="black11"><input type="file" name="asso_photo_scan_'+(parseInt(counter1)+1)+'" id="asso_photo_scan_'+(parseInt(counter1)+1)+'"><br>(eg- .docs,.pdf)<br/> (Max Upload Size Up To 5MB.)</td></tr><!--<tr id="asso_firm_scan_tr_'+counter1+'"><td class="black11">Firm Scan: '+(parseInt(counter1)+1)+' :</td><td class="black11"><input type="file" name="asso_firm_scan_'+(parseInt(counter1)+1)+'" id="asso_firm_scan_'+(parseInt(counter1)+1)+'"></td></tr>--><tr id="asso_note_tr_'+counter1+'"><td class="black11">Note:</td><td class="black11">Check This Check box For notification via multiple options.</td></tr><tr id="asso_noteifi_tr_'+counter1+'"><td class="black11"><input type="checkbox" name="asso_call_'+(parseInt(counter1)+1)+'" id="asso_calls_'+(parseInt(counter1)+1)+'">Call  </td><td class="black11"><input type="checkbox" name="asso_sms_'+(parseInt(counter1)+1)+'" id="asso_sms_'+(parseInt(counter1)+1)+'">SMS  </td><td class="black11"><input type="checkbox" name="asso_email_'+(parseInt(counter1)+1)+'" id="asso_email_'+(parseInt(counter1)+1)+'">Email  </td></tr><tr id="asso_category_tr_'+counter1+'"><td class="black11">Broker Category</td><td class="black11"><select name="asso_broker_cat_'+(parseInt(counter1)+1)+'" id="asso_broker_cat_'+(parseInt(counter1)+1)+'"><option value="">Select Category</option><option value="4" <?php if($client_data[0]['broker_category']=='4') { ?> selected <?php } ?> >Platinum</option><option value="3" <?php if($client_data[0]['broker_category']=='3') { ?> selected <?php } ?> >Gold</option><option value="2" <?php if($client_data[0]['broker_category']=='2') { ?> selected <?php } ?> >Silver</option><option value="1" <?php if($client_data[0]['broker_category']=='1') { ?> selected <?php } ?> >Bronze</option> </select></td></tr></table></td></tr>');
				
				$("#remove1").attr('title',counter1);
				$("#remove1").show();
				counter1++;
				$("#counter1").val(counter1);
				
				if(counter1 >= limit)
				{
					$("#add_more1").hide();
				}
			}
		});
		
		$("#remove1").click(function(){
		
			//var total_broker = <?php echo $total_broker ?>;
			
			var id = $("#remove1").attr("title");
			//alert(id + total_broker);
			
			$("#asso_broker_tr_"+id).remove();
			$("#asso_name_tr_"+id).remove();
			$("#asso_contact_tr_"+id).remove();
			$("#asso_mobile_tr_"+id).remove();
			$("#asso_email_add_tr_"+id).remove();
			$("#asso_pan_card_tr_"+id).remove();
			$("#asso_photo_scan_tr_"+id).remove();
			//$("#asso_firm_scan_tr_"+id).remove();
			$("#asso_note_tr_"+id).remove();
			$("#asso_noteifi_tr_"+id).remove();
			$("#asso_category_tr_"+id).remove();
			$("#table2_tr_"+id).remove();
			$("#counter1").val(id);
			//$("#ass_executive_tr_"+id).remove();
			id--;
			$("#remove1").attr('title',id);
			
			if(id < 1)
			{
				$("#remove1").hide();
			}
			
			$("#add_more1").show();
		});
		
		
	})
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
                
                    name_1: "required",
                /*    pan_card_number_1: "required",*/
               	    mobile1_1: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                   /* mobile2_1: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                    main_email_1: {
                        required: true,
                        email: true,
                    },*/
                    
                    
                    name_2: "required",
               /*     pan_card_number_2: "required",*/
               	    mobile1_2: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                  /*   mobile2_2: {
                        required: true,
                        number: true,
                        maxlength: 10
                    }, 
                    main_email_2: {
                        required: true,
                        email: true,
                    },*/
                    
                    
                    name_3: "required",
                  /*  pan_card_number_3: "required",*/
               	    mobile1_3: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                   /*  mobile2_3: {
                        required: true,
                        number: true,
                        maxlength: 10
                    }, 
                    main_email_3: {
                        required: true,
                        email: true,
                    },*/
                    
                    
                    name_3: "required",
                 /*  pan_card_number_3: "required",*/
               	    mobile1_3: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                 /*    mobile2_3: {
                        required: true,
                        number: true,
                        maxlength: 10
                    }, 
                    main_email_3: {
                        required: true,
                        email: true,
                    },*/
                    
                     name_4: "required",
                   /* pan_card_number_4: "required",*/
               	    mobile1_4: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                  /*   mobile2_4: {
                        required: true,
                        number: true,
                        maxlength: 10
                    }, 
                    main_email_4: {
                        required: true,
                        email: true,
                    },*/
                    
                    
                    
                     name_5: "required",
                /*    pan_card_number_5: "required",*/
               	    mobile1_5: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                    /* mobile2_5: {
                        required: true,
                        number: true,
                        maxlength: 10
                    }, 
                    main_email_5: {
                        required: true,
                        email: true,
                    },*/
                    
                    
                    /*asso_name_1: "required",
                    asso_pan_card_number_1: "required",
               	    asso_mobile1_1: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                    asso_mobile2_1: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                    asso_email_add_1: {
                        required: true,
                        email: true,
                    },
                    
                    
                    asso_name_2: "required",
                    asso_pan_card_number_2: "required",
               	    asso_mobile1_2: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                    asso_mobile2_2: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                    asso_email_add_2: {
                        required: true,
                        email: true,
                    },
                    
                    
                    asso_name_3: "required",
                    asso_pan_card_number_3: "required",
               	    asso_mobile1_3: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                    asso_mobile2_3: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                    asso_email_add_3: {
                        required: true,
                        email: true,
                    },
                    
                    
                    asso_name_4: "required",
                    asso_pan_card_number_4: "required",
               	    asso_mobile1_4: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                    asso_mobile2_4: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                    asso_email_add_4: {
                        required: true,
                        email: true,
                    },
                    
                    
                    asso_name_5: "required",
                    asso_pan_card_number_5: "required",
               	    asso_mobile1_5: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                    asso_mobile2_5: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                    asso_email_add_5: {
                        required: true,
                        email: true,
                    }, */
                    
                    
                    
                    
                },
                messages: {
                    name_1: "Please enter your Broker Name",
               /*     pan_card_number_1: "Please enter Pan Card Number",*/
                    mobile1_1: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },
                   /* mobile2_1: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },*/
                    main_email_1: {
                        required: "Please enter Email Id",
                        email: "Please enter Valide Email Id",
                    },
                    
                    
                    name_2: "Please enter your Broker Name",
               /*    pan_card_number_2: "Please enter Pan Card Number", */
                    mobile1_2: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },
                    mobile2_2: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },
                    main_email_2: {
                        required: "Please enter Email Id",
                        email: "Please enter Valide Email Id",
                    },
                    
                    
                    
                     name_3: "Please enter your Broker Name",
                /*    pan_card_number_3: "Please enter Pan Card Number", */
                    mobile1_3: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },
                   /*  mobile2_3: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    }, */
                    main_email_3: {
                        required: "Please enter Email Id",
                        email: "Please enter Valide Email Id",
                    },
                    
                    
                     name_4: "Please enter your Broker Name",
                 /*   pan_card_number_4: "Please enter Pan Card Number",*/
                    mobile1_4: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },
                 /*    mobile2_4: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    }, */
                    main_email_4: {
                        required: "Please enter Email Id",
                        email: "Please enter Valide Email Id",
                    },
                    
                    
                    name_5: "Please enter your Broker Name",
                   /* pan_card_number_5: "Please enter Pan Card Number", */
                    mobile1_5: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },
                    /* mobile2_5: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    }, */
                    main_email_5: {
                        required: "Please enter Email Id",
                        email: "Please enter Valide Email Id",
                    },
                    
                    
                    
                   /* asso_name_1: "Please enter your Broker Name",
                    asso_pan_card_number_1: "Please enter Pan Card Number",
                    asso_mobile1_1: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },
                    asso_mobile2_1: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },
                    asso_email_add_1: {
                        required: "Please enter Email Id",
                        email: "Please enter Valide Email Id",
                    },
                    
                    
                    
                    asso_name_2: "Please enter your Broker Name",
                    asso_pan_card_number_2: "Please enter Pan Card Number",
                    asso_mobile1_2: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },
                    asso_mobile2_2: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },
                    asso_email_add_2: {
                        required: "Please enter Email Id",
                        email: "Please enter Valide Email Id",
                    },
                    
                    
                    asso_name_3: "Please enter your Broker Name",
                    asso_pan_card_number_3: "Please enter Pan Card Number",
                    asso_mobile1_3: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },
                    asso_mobile2_3: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },
                    asso_email_add_3: {
                        required: "Please enter Email Id",
                        email: "Please enter Valide Email Id",
                    },
                    
                    
                    asso_name_4: "Please enter your Broker Name",
                    asso_pan_card_number_4: "Please enter Pan Card Number",
                    asso_mobile1_4: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },
                    asso_mobile2_4: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },
                    asso_email_add_4: {
                        required: "Please enter Email Id",
                        email: "Please enter Valide Email Id",
                    },
                    
                    
                    asso_name_5: "Please enter your Broker Name",
                    asso_pan_card_number_5: "Please enter Pan Card Number",
                    asso_mobile1_5: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },
                    asso_mobile2_5: {
                        required: "Please enter Mobile No",
                        number: "Please enter Mobile No Numeric",
                        maxlength: "Your Mobile No more than 10 digit",
                    },
                    asso_email_add_5: {
                        required: "Please enter Email Id",
                        email: "Please enter Valide Email Id",
                    }, */
                    
                    
                },
                submitHandler: function(form) {
			$(".sendNotes").each(function() {
				var new_id = $(this).attr('id');
				//alert(new_id);
				
					sendNotes(new_id);
				
					form.submit();
				
				 
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



