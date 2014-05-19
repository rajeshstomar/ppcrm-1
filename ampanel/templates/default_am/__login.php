<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Puravida -Admin</title>
<style>
.loginTable
{
	border:solid;
	border-width:1px;
	border-color:#CC9966;
	font-family:Georgia, "Times New Roman", Times, serif;
	font-size:15px;
}
</style>
</head>
<body>
<?php
if(isset($_POST['action']))
{
	if($_SESSION['loginToken']!=$_POST['loginToken'])
	{
		session_unregister('isadmin');
		session_unregister('admin_name');
		session_unregister('admin_pass');
		session_unregister('admin_email');
		session_unregister('admin_level');
		echo "Hack Attempt";
		exit;
	}
	
	$sql="select * from ".TABLE_ADMIN." where admin_name ='".$_POST['username']."' and admin_pass = '".md5($_POST['password'])."' ";
	$rs=mysql_query($sql);
	if(mysql_num_rows($rs)==1)
	{
		$row=mysql_fetch_array($rs);
		$_SESSION['isadmin']=true;
		$_SESSION['admin_name']=$row['admin_name'];
		$_SESSION['admin_pass']=$row['admin_pass'];
		$_SESSION['admin_email']=$row['admin_email'];
		$_SESSION['admin_level']=$row['admin_level'];
		
		//am_goto_page(am_create_link(FILENAME_INDEX,'not'));
		am_goto_page(am_create_link(FILENAME_WELCOME,''));
		/*Done by sunny on 27-03-09*/
	}
	else
	{
		session_unregister('isadmin');
		session_unregister('admin_name');
		session_unregister('admin_pass');
		session_unregister('admin_email');
		session_unregister('admin_level');
		
		am_goto_page(am_create_link(FILENAME_LOGIN,''));
	}

	
}
$_SESSION['loginToken']=am_randomLoginToken(10);
?>
<form name="login" method="post">
<input type="hidden" name="loginToken" value="<?php echo $_SESSION['loginToken']; ?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="400">
  <tr>
    <td align="center" valign="middle">
		<table width="400" border="0" cellspacing="3" cellpadding="3" class="loginTable">
			<tr>
			  <td align="center" colspan="3"><strong>Administrator Login</strong></td>
			</tr>
			<tr>
			  <td width="132" align="right">Username</td>
			  <td width="10" align="center">:</td>
			  <td width="147"><input type="text" name="username" /></td>
			</tr>
			<tr>
			  <td align="right">Password</td>
			  <td width="10" align="center">:</td>
			  <td><input type="password" name="password" /></td>
			</tr>
			<tr>
			  <td height="3"></td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><input type="submit" name="action" value="Login"  /></td>
			</tr>
		</table>
	  </td>
  </tr>
</table>
</form>
</body>
</html>
