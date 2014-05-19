<?php
//include("../dbconfig.php");
$msg = $_GET['msg'];

if(isset($_REQUEST['id_call_log']) && is_numeric($_REQUEST['id_call_log']))
{
	$id = $_REQUEST['id_call_log'];
	
	$sel_que ="select cl.* from call_log as cl LEFT JOIN caller_type as ct ON ct.id_caller_type=cl.caller_type where id_call_log= '".$id."' ";
	$caller_data = am_select($sel_que);
	//my_print_R($caller_data);exit;
	$mode = "Update";
}
else
{
	$mode = "Add";
	
	
}

?>
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
<form name="frm" method="post" action="" id="phone_search">
<input type="hidden" name="mode" id="mode" value="<?=$mode;?>">
<h2> <?php echo $mode; ?> Call Log </h2>
<table width="80%" border="0" cellspacing="2" cellpadding="2"> 
  <tr>
    <td class="black11">Phone No: </td>
    <td class="black11"><input type="text" name="caller_phone" id="caller_phone" value="<?php print $caller_data[0]['caller_phone']?>" /></td>
    <td class="black11">Search For: </td>
    <td class="black11"><input type="radio" name="search_in" checked value="broker" />&nbsp;Broker &nbsp;&nbsp;<input type="radio" name="search_in" value="customer" />&nbsp;Customer</td>
    <td class="black11"><input type="submit" name="submit" onclick="return validate();" value="Search" />&nbsp;</td>
  </tr>
</table>
</form>

<div id="responsebroker" style="margin: 30px 0;">

</div>
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
            $("#phone_search").validate({
                rules: {
                    caller_phone: {
                        required: true,
                        number: true,
                        maxlength: 10
                    },
                    
                },
                messages: {
                    caller_phone: {
                        required: "Please enter valid phone No",
                        number: "Please enter phone No Numeric",
                        maxlength: "Your phone No more than 10 digit",
                    },
                    
                    
                },
                submitHandler: function(form) {
			var phone = $("#caller_phone").val(); 
			var search_in = $('input[name=search_in]:checked', '#phone_search').val();

			$("#responsebroker").html('<div style="position: relative;text-align: center;top: 40px;"><img src="images/ajax-loader.gif"></div>');
                 
        	           $.ajax({
				type: "POST",
				url: "phone_search.php",
				data: {phone:phone,search_in:search_in},
				success: function(html){
					$("#responsebroker").html(html);
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
