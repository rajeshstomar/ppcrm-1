<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Property Pistol - Site Manager</title>
<style type="text/css">
<!--
@import url("<?php echo HTTP_ROOT_HOME; ?>css/healthcare.css");
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top">
    <table width="1026" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" valign="top" background="<?php echo HTTP_ROOT; ?>/images/drop.jpg"><table width="990" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
          <tr style="background:url('../images/bg.jpg'); background-position:center;">
            <td height="108" align="center"><img src="<?php echo HTTP_ROOT; ?>/images/logo.png" ></td>
          </tr>
          <tr>
            <td height="36" background="<?php echo HTTP_ROOT; ?>/images/linksbar.jpg" bgcolor="#3C3C3C" class="white13_bold" style="padding-left:36px">Property Pistol - Site Manager</td>
          </tr>
          <tr>
            <td height="27" bgcolor="#F68121" class="white12_bold" style="padding-left:36px">Login</td>
          </tr>
          <tr bgcolor="#F5F5F5">
            <td height="36">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" bgcolor="#F5F5F5">
            
<?php
if(isset($_POST['action']))
{
	/*if($_SESSION['loginToken']!=$_POST['loginToken'])
	{
		session_unregister('isadmin');
		session_unregister('admin_name');
		session_unregister('admin_pass');
		session_unregister('admin_email');
		session_unregister('admin_level');
		echo "Hack Attempt";
		exit;
	} */
	
	$sql="select * from ".TABLE_ADMIN." where admin_name ='".$_POST['username']."' and admin_pass = '".md5($_POST['password'])."' ";
	$rs=mysql_query($sql);
	if(mysql_num_rows($rs)==1)
	{
		$row=mysql_fetch_array($rs);
		$_SESSION['isadmin']=true;
		$_SESSION['user_id']=$row['admin_id'];
		$_SESSION['admin_name']=$row['admin_name'];
		$_SESSION['admin_pass']=$row['admin_pass'];
		$_SESSION['admin_email']=$row['admin_email'];
		$_SESSION['admin_level']=$row['admin_level'];
		
		//am_goto_page(am_create_link(FILENAME_INDEX,'not'));
		if($_SESSION['admin_level'] == '4') // caller_executive
			am_goto_page(am_create_link('edit_call_log_search'));
		else
			am_goto_page(am_create_link(FILENAME_WELCOME));
		/*Done by sunny on 27-03-09*/
	}
	else
	{
		session_unregister('isadmin');
		session_unregister('admin_name');
		session_unregister('admin_pass');
		session_unregister('admin_email');
		session_unregister('admin_level');
		
		am_goto_page(am_create_link(FILENAME_LOGIN,'mes=2'));
	}

	
}
$_SESSION['loginToken']=am_randomLoginToken(10);
?>
<form name="login" method="post" action="">
<input type="hidden" name="loginToken" value="<?php echo $_SESSION['loginToken']; ?>" />
<table width="918" border="0" cellpadding="0" cellspacing="0">
              <tr >
                <td width="225" valign="top">&nbsp;</td>
                <td width="1" bgcolor="#c3c3c3"></td>
                <td width="35"></td>
                <td width="657"><span class="black16_bold">Log in</span><br>
                  <br>
                  <span class="black11">
                  <strong>Please enter your details  to log in to the Site Manager:</strong>
                  <br>
                    <br>
                  <?php 
			if(isset($_REQUEST['mes']))
			{
					if($_REQUEST['mes'] == 2)
					{
				?>
                <font color="#FF0000"><strong>Please enter correct Username and Password </strong></font>
                <br>
                    <br>

                <?php		
						
					}
			}
				  ?>
                    
                      Username:<br>
                      <input name="username" type="text" class="black11" id="name" style="width:270px; height:21px; border:1px solid #c3c3c3;" maxlength="100" />
                      <br>
                      <br>
                      Password:<br>
                      <input name="password" type="password" class="black11" id="password" style="width:270px; height:21px; border:1px solid #c3c3c3;" maxlength="100" />
                      <br>
                      <br>
                      <input name="action" type="submit" class="black11_bold" value=" Login ">
                    
                  </span></td>
                </tr>
            </table>
</form>


  </td>
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
