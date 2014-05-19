<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Property Pistol-Admin</title>

<style type="text/css">
<!--

body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>



<link href="<?php echo HTTP_ROOT_HOME; ?>css/healthcare.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?php echo HTTP_ROOT_HOME; ?>images/favicon.ico" />
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>	
<script type="text/javascript" src="<?php echo HTTP_ROOT_HOME; ?>js/ui.datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT_HOME; ?>css/jquery-ui1.css" media="screen" />


 

</head>

<body>
<?php
	if(isset($_GET['rel']))
	{
		/*
//		echo am_get_current_language().$_GET['rel'].'.php';exit;
		if (file_exists(am_get_current_language().$_GET['rel'].'.php'))
		{
			require(am_get_current_language().$_GET['rel'].'.php');
		}
		else
		{	
			require(am_get_current_language().'filenotfound.php');
		}
		*/
	}
	else
	{
		//require(am_get_current_language().'welcome.php');
	}
//print am_get_current_language()."fsfs";
?>

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top"><table  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" valign="top" background="<?php echo HTTP_ROOT; ?>/images/drop.jpg">
		<table width="1325" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
			
			
			<?php include(am_get_current_template().'comman/header.php');?>
            
            
			
          <tr>
            <td align="left"  bgcolor="#F5F5F5">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
              
              
              
                <?php include(am_get_current_template().'comman/left.php');?>
                  
                  
                  
                <td width="1" bgcolor="#c3c3c3"></td>
                <td width="25"></td>
                <td width="775" align="left" valign="top">
            
			<?php
			if(isset($_GET['rel']))
			{
				//echo"<pre>";print_r($_REQUEST);
				//echo'from home---'.am_get_current_template().$_GET['rel'].'.php';//exit;
				if (file_exists(am_get_current_template().$_GET['rel'].'.php'))
				{
					require(am_get_current_template().$_GET['rel'].'.php');
				}
				else
				{
//				echo am_get_current_template().'filenotfound.php';exit;
					require(am_get_current_template().'filenotfound.php');
						
				}
			}
			else
			{
				require(am_get_current_template().'welcome.php');
			}
			?>
            </td>
            
			</tr>
            </table></td>
          </tr>
          <tr bgcolor="#F5F5F5">
            <td height="36" bgcolor="#F5F5F5">&nbsp;</td>
          </tr>
          <tr>
            <td height="36" align="center" bgcolor="#F5F5F5">&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td height="18" align="center" valign="top" background="<?php echo HTTP_ROOT; ?>/images/bottom.jpg">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
