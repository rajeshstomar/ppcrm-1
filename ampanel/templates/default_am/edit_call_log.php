<?php
//include("../dbconfig.php");
$msg = $_GET['msg'];

if( $_REQUEST['customer_id'] != '' && $_REQUEST['shortlist_id'] != '' )
{
	$user_is = "customer";
	$id_broker_customer = $_REQUEST['customer_id'];
	$shortlist_id = $_REQUEST['shortlist_id'];
	
	$sql_data = "SELECT CONCAT(f_name,' ',l_name) as caller_name,mobile_no as caller_phone FROM client_personal_details WHERE client_id=".$id_broker_customer;
	
	$caller_data = am_select($sql_data);
}

if(isset($_REQUEST['phone_search']) && isset($_REQUEST['id_broker_customer']))
{
	$user_is = $_POST['user_is'];
	$caller_phone = $_POST['caller_phone'];
	$id_broker_customer = $_POST['id_broker_customer'];
	if($user_is == 'customer')
	{
		$sql_data = "SELECT CONCAT(f_name,' ',l_name) as caller_name,mobile_no as caller_phone FROM client_personal_details WHERE client_id=".$id_broker_customer;
	}			
	else if($user_is == 'broker')
	{
		$sql_data = "SELECT broker_name as caller_name,mobile1_no as caller_phone FROM broker WHERE broker_id=".$id_broker_customer;
	}
	
	$caller_data = am_select($sql_data);

	//print_r($caller_data); exit;
}
if(isset($_REQUEST['submit']))
{
	//print_R($_POST); exit;
	$id_broker_customer = $_POST['id_broker_customer'];
	$user_is = $_POST['user_is'];
	$caller_name = $_POST['caller_name'];
	$caller_phone = $_POST['caller_phone'];
	$description = $_POST['description'];
	$caller_type = $_POST['caller_type'];
	$call_category = $_POST['call_category'];
	$priority = $_POST['priority'];
	$pp_executive_id = $_SESSION['user_id'];
	$is_shortlisted = $_POST['is_shortlisted'];
	$shortlist_id = $_POST['shortlist_id'];
	$status_id = $_POST['status_id'];
	$next_call_date = date("Y-m-d", strtotime($_POST['next_call_date']));
	$add_date = date("Y-m-d H:i:s");
	
	$data = array(
		'caller_name' => $caller_name,
		'caller_phone' => $caller_phone,
		'description' => $description,
		'caller_type' => $caller_type,
		'call_category' => $call_category,
		'priority' => $priority,
		'user_is' => $user_is,
		'id_broker_customer' => $id_broker_customer,
		'pp_executive_id' => $pp_executive_id,
		'is_shortlisted' => $is_shortlisted,
		'shortlist_id' => $shortlist_id,
		'status_id' => $status_id,
		'next_call_date' => $next_call_date,
		'add_date' => $add_date,
	);
	//print_R($data); exit;
	
	if($_REQUEST['mode'] == "Add")
	{
		am_insertupdate($data,'call_log');
	
		$msg = "Call log Added Successfully!";
		if($id_broker_customer != '' && $shortlist_id != '')
			am_goto_page("index.php?rel=common_listing&module=call_log&id_customer=".$id_broker_customer."&shortlist_id=".$shortlist_id."&msg=".$msg);
		else if($caller_type == '1')
			am_goto_page("index.php?&rel=edit_owner&msg=".$msg);
		else if($caller_type == '2')
			am_goto_page("index.php?rel=common_listing&module=customer&msg=".$msg);
		else if($caller_type == '3' || $caller_type == '4' || $caller_type == '5')
			am_goto_page("index.php?rel=common_listing&module=company&msg=".$msg);
		else
			am_goto_page(am_create_link(FILENAME_WELCOME));
	}
	else
	{
		am_insertupdate($data,'call_log','id_call_log',$_POST['id_call_log']);
	
		$msg = "Call log Updated Successfully!";
		if($id_broker_customer != '' && $shortlist_id != '')
			am_goto_page("index.php?rel=common_listing&module=call_log&id_customer=".$id_broker_customer."&shortlist_id=".$shortlist_id."&msg=".$msg);
		else
			am_goto_page("index.php?rel=common_listing&module=call_log&msg=".$msg);
	}
	
}

if(isset($_REQUEST['id_call_log']) && is_numeric($_REQUEST['id_call_log']))
{
	$id = $_REQUEST['id_call_log'];
	
	$sel_que ="select cl.* from call_log as cl LEFT JOIN caller_type as ct ON ct.id_caller_type=cl.caller_type where id_call_log= '".$id."' ";
	$caller_data = am_select($sel_que);
	
	$id_broker_customer = $caller_data[0]['id_broker_customer'];
	$shortlist_id = $caller_data[0]['shortlist_id'];
	$user_is = $caller_data[0]['user_is'];
	//my_print_R($caller_data);exit;
	$mode = "Update";
}
else
{
	$mode = "Add";
	
	
}

?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
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
 <script>
$(function() {
	$( "#next_call_date" ).datepicker({
		dateFormat: 'dd-mm-yy',
		showOn: "button",
		buttonImage: "images/calendar.gif",
		buttonImageOnly: true,
	});
});
</script>  
  
<div align="center" style="width:80%; margin-bottom:5px;"><font color="#FF0000"><?php print $msg; ?></font></div>
<form name="call_log" id="call_log" method="post" action="" >
<input type="hidden" name="mode" id="mode" value="<?=$mode;?>">
<input type="hidden" name="id_call_log" id="id_call_log" value="<?php print $caller_data[0]['id_call_log']?>">
<input type="hidden" name="id_broker_customer" id="id_broker_customer" value="<?php print $id_broker_customer; ?>">
<input type="hidden" name="is_shortlisted" value="<?php if($shortlist_id!=''){?>yes<?php } else{ ?>no<?php } ?>">
<input type="hidden" name="shortlist_id" value="<?php print $shortlist_id; ?>">
<h2> <?php echo $mode; ?> Call Log </h2>
<table width="80%" border="0" cellspacing="2" cellpadding="2"> 
  <tr>
    <td class="black11">Caller Name </td>
    <td class="black11">
    <?php if( (isset($_REQUEST['phone_search']) && isset($_REQUEST['id_broker_customer'])) || ($id_broker_customer != '' && $shortlist_id != '')) { 
    	if($user_is == 'customer')
	{
		$link = 'index.php?&rel=view_customer&id='.$id_broker_customer;
	}			
	else if($user_is == 'broker')
	{
		$link = 'index.php?&rel=edit_broker&id='.$id_broker_customer;
	}
    ?>
    <label><a href="<?php echo $link; ?>"><?php echo $caller_data[0]['caller_name']; ?></a></label>
    &nbsp;&nbsp;<label>( <?php echo ucfirst($user_is); ?> )</label>
    <input type="hidden" name="caller_name" id="caller_name" value="<?php echo $caller_data[0]['caller_name']; ?>" />
    <input type="hidden" name="user_is" id="user_is" value="<?php print $user_is; ?>">
    <?php } else { ?>
    	<input type="text" name="caller_name" id="caller_name" value="<?php print $caller_data[0]['caller_name']?>" />
    	<input type="hidden" name="user_is" id="user_is" value="new">
    <?php } ?>
	</td>
  </tr>
  <tr>
    <td class="black11">Phone No </td>
    <td class="black11">
    <?php if( (isset($_REQUEST['phone_search']) && isset($_REQUEST['id_broker_customer'])) || ($id_broker_customer != '' && $shortlist_id != '')) { ?>
    <label><?php print $caller_data[0]['caller_phone']?></label>
    <input type="hidden" name="caller_phone" id="caller_phone" value="<?php print $caller_data[0]['caller_phone']?>" />
    <?php } else { ?>
    <input type="text" name="caller_phone" id="caller_phone" value="<?php if(isset($_REQUEST['phone_search'])) { print $_POST['caller_phone']; } else { print $caller_data[0]['caller_phone']; } ?>" />
    <?php } ?>
    </td>
  </tr>
  <tr>
    <td class="black11">Description</td>
    <td class="black11">
    <textarea name="description" id="description" rows="5" cols="60"><?php print $caller_data[0]['description']?></textarea>
    </td>
  </tr>
  <tr>
    <td class="black11">Caller Type </td>
    <td class="black11">
    <?php
    $where = array();
    if($user_is == 'broker')
    	$where[] = " ( caller_type_name NOT LIKE '%Customer%' OR caller_type_name NOT LIKE '%customer%' ) ";
    if($user_is == 'customer')
    	$where[] = " ( caller_type_name NOT LIKE '%broker%' OR caller_type_name NOT LIKE '%Broker%' ) ";
    
    $sel = am_get_select('caller_type' , 'id_caller_type', 'caller_type', $caller_data[0]['caller_type'], 'caller_type_name', '' , $where );
    echo $sel;
    ?>
    </td>
  </tr>
  <tr>
    <td class="black11">Call Category </td>
    <td class="black11">
    		<select name="call_category" id="caller_action">
    			<option value="">Select Call Category</option>
    			<option value="new"  <?php if($caller_data[0]['call_category']=='new') { ?> selected <?php } ?> >New</option>
    			<option value="old" <?php if($caller_data[0]['call_category']=='old') { ?> selected <?php } ?> >Old</option>

    		</select>
    </td>
  </tr>
    <tr>
    <td class="black11">Priority </td>
    <td class="black11">
    		<select name="priority" id="priority">
    			<option value="">Select Priority</option>
    			<option value="high"  <?php if($caller_data[0]['priority']=='high') { ?> selected <?php } ?> >High</option>
    			<option value="medium" <?php if($caller_data[0]['priority']=='medium') { ?> selected <?php } ?> >Medium</option>
    			<option value="low"  <?php if($caller_data[0]['priority']=='low') { ?> selected <?php } ?> >Low</option>

    		</select>
    </td>
  </tr>
  <tr>
    <td class="black11">Next Call Date </td>
    <td class="black11">
    	<input type="text" name="next_call_date" id="next_call_date" value="<?php if($caller_data[0]['next_call_date']!='') { echo date('d-m-Y',strtotime($caller_data[0]['next_call_date'])); } else { echo date('d-m-Y');}?>" />	
    </td>
  </tr>
  <tr>
  <?php if($shortlist_id !='')  { ?>
  <tr>
    <td class="black11">Status</td>
    <td class="black11"><?php echo 
    	$select = am_get_select('shortlist_status', 'status_id', 'status_id', $caller_data[0]['status_id'], 'status_name', '','' );
    	//echo $select;
    ?></td>
  </tr>
  <?php } ?>
    <td>&nbsp;</td>
    <td class="black11"><input type="submit" name="submit" value="<?=$mode;?>" />&nbsp;</td>
  </tr>
</table>
</form>
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
            $("#call_log").validate({
                rules: {
                    caller_type: "required",
                    call_category: "required",
                    priority: "required",
		    status_id: "required",
                },
                messages: {
                    caller_type: "Please Select Caller Type",
                    call_category: "Please Select Call Category",
                    priority: "Please Select Priority",
                    status_id: "Please Select Status",
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
<!--<script type="text/javascript">
function validate()
{
	if(Trim(document.getElementById('user_name').value) == "")
	{
		alert("Please Enter User Name");
		document.getElementById('user_name').focus();
		return false;
	}
	
	if(Trim(document.getElementById('user_email').value) == "")
	{
		alert("Please Enter User Email");
		document.getElementById('user_email').focus();
		return false;
	}
	if(!validate_email(Trim(document.getElementById('user_email').value)))
	{
		alert("Please Enter Valid Email Address");
		return false;
	}
	if(Trim(document.getElementById('user_password').value) == "")
	{
		alert("Please Enter User Password");
		document.getElementById('user_password').focus();
		return false;
	}
	
	if(Trim(document.getElementById('user_type').value) == "")
	{
		alert("Please Select User Type");
		document.getElementById('user_type').focus();
		return false;
	}
	
	return true;
}
</script>-->
