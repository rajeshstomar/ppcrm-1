<?php
//include("../dbconfig.php");
$msg = $_GET['msg'];

if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
{
	$id = $_REQUEST['id'];
	
	$sel_que ="select * from comment  where likeid= '".$id."' ";
	$page_data = am_select($sel_que);
	//my_print_R($page_data);exit;
	$mode = "Update";
}
else
{
	$mode = "Add";
}
//include(DIR_SCRIPT_ROOT."/fckeditor/fckeditor.php") ; 
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

<div align="center" style="width:80%; margin-bottom:5px;"><font color="#FF0000"><?php print $msg; ?></font></div>
<h1>Sales Team Rating</h1>
<form name="frm" method="post" action="index.php?rel=company_action" >
<input type="hidden" name="mode" id="mode" value="<?=$mode;?>">
<input type="hidden" name="likeid" value="<?php print $page_data[0]['likeid']?>" />
<table width="80%" border="0" cellspacing="2" cellpadding="2"> 
 
  <tr>
	    <td class="black11">Date:</td>
	    <td class="black11"><input type="text" name="date" id="date" value="<?php print $page_data[0]['comment']?>" /></td>
	
	    <td class="black11">Form No:</td>
	    <td class="black11"><input type="text" name="form_no" id="form_no" value="<?php print $page_data[0]['comment']?>" /></td>
  </tr>
   <tr>
	    <td class="black11">Employee:</td>
	    <td class="black11"><input type="text" name="employee" id="employee" value="<?php print $page_data[0]['comment']?>" /></td>
	
  </tr>
    <tr>
	    <th class="black11" colspan="4" >Transaction</th>
   </tr>
    <tr>
	    <td class="black11">Client ID:</td>
	    <td class="black11"><input type="text" name="client_id" id="client_id" value="<?php print $page_data[0]['comment']?>" /></td>
	
	   
  </tr>
    <tr>
	    <td class="black11">Listing ID:</td>
	    <td class="black11"><input type="text" name="listing_id" id="listing_id" value="<?php print $page_data[0]['comment']?>" /></td>
</tr>
<tr>	
	    <td class="black11">Broker:</td>
	    <td class="black11"><input type="text" name="broker" id="broker" value="<?php print $page_data[0]['comment']?>" /></td>
  </tr>
 
   
 
   
   <tr>
	    <th class="black11" colspan="4" >Rating Of PP team on Member Broker:</th>
   </tr>
   
   <tr>
	    <td class="black11" colspan="4" >Listing Quality</td>
   </tr>
   <tr>
	    <td class="black11" colspan="2">highly satisfactory</td>
	    <td class="black11" colspan="1"><input type="radio" name="service_property_pistol" value="1"></td>
	   
   </tr>
   <tr>
    	    <td class="black11" colspan="2">satisfactory</td>
	    <td class="black11" colspan="1"><input type="radio" name="service_property_pistol" value="2"></td>
  </tr>
  <tr>
	    <td class="black11" colspan="2">unsatisfactory</td>
	    <td class="black11" colspan="1"><input type="radio" name="service_property_pistol" value="3"></td>
   </tr>
   
   <tr>
	    <td class="black11" colspan="4" >Broker's Rating</td>
   </tr>
   <tr>
	    <td class="black11" colspan="2">highly satisfactory</td>
	    <td class="black11" colspan="1"><input type="radio" name="professionalism_broker" value="1"></td>
	   
   </tr>
   <tr>
    	    <td class="black11" colspan="2">satisfactory</td>
	    <td class="black11" colspan="1"><input type="radio" name="professionalism_broker" value="2"></td>
  </tr>
  <tr>
	    <td class="black11" colspan="2">unsatisfactory</td>
	    <td class="black11" colspan="1"><input type="radio" name="professionalism_broker" value="3"></td>
   </tr>
    
  <tr>
	   
	     <td class="black11" colsapan="4"><textarea name="executive_comment" id="executive_comment" cols="45" rows="4" /></textarea></td>
	    
   </tr>
    
  
  <tr>
    <td>&nbsp;</td>
    <td class="black11"><input type="submit" name="submit" onclick="return validate();" value="<?=$mode;?>" />&nbsp;<input type="reset" name="reset"  value="Reset" />&nbsp;<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=static_pages';" value="Cancel" /></td>
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
