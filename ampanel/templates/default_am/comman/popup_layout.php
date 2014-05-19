<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
	if(isset($_GET['rel']))
	{
		if (file_exists(am_get_current_language().$_GET['rel'].'.php'))
		{
			require(am_get_current_language().$_GET['rel'].'.php');
		}
		else
		{
			require(am_get_current_language().'filenotfound.php');
		}
	}
	else
	{
		require(am_get_current_language().'home.php');
	}
?>
<title>EHG</title>
<style type="text/css">
<!--
body {
	background-image: url(images/bk12.jpg);
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-repeat: repeat;
}
-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="22"></td>
  </tr>
  <tr>
    <td height="22"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td><div align="right"><a href="javascript:this.close()">Close</a></div></td>
          </tr>
          <tr>
            <td height="4"></td>
          </tr>
          <tr>
            <td valign="top">
			<?
			if(isset($_GET['rel']))
			{
				if (file_exists(am_get_current_template().$_GET['rel'].'.php'))
				{
					require(am_get_current_template().$_GET['rel'].'.php');
				}
				else
				{
					require(am_get_current_template().'filenotfound.php');
				}
			}
			else
			{
				require(am_get_current_template().'home.php');
			}
			?>
			</td>
          </tr>
          <tr>
            <td height="5"></td>
          </tr>
          
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>