<script language="javascript" type="text/javascript">

function checkpassword()
{
	if(document.frmchangepassword.newpassword.value =="")
	{
		document.frmchangepassword.newpassword.focus();
		alert("Please Enter the value");
		return false;
	}
	if(document.frmchangepassword.confirmnewpassword.value =="")
	{
		document.frmchangepassword.confirmnewpassword.focus();
		alert("Please Enter the value");
		return false;
	}
	
	if(document.frmchangepassword.newpassword.value != document.frmchangepassword.confirmnewpassword.value)
	{
		alert("Password & Confirm Password must be same.");
		document.frmchangepassword.confirmnewpassword.focus();
		return false;
	}
}
</script>
<?php
if(isset($_REQUEST['submit']))
{
	if($_POST['newpassword'] == $_POST['confirmnewpassword'])
	{
		$Adminpassword = md5($_POST['newpassword']);
		$adminEmail	   = $_SESSION['admin_email'];
		$q = "update am_admin set admin_pass = '$Adminpassword' WHERE admin_email='$adminEmail'";

		mysql_query($q) or die(mysql_error());
		am_goto_page("index.php?rel=change_password&mes=ok");
		exit;
	}
	else 
	{ 
		$msg = "Password & Confirm password must be same.";
	}
}
?>

                
                <span class="black16_bold">Change Password:</span><br>
                  	<?php
						
						if(isset($_REQUEST['mes'])&& $_REQUEST['mes']=='ok')
						{
							print "<font color='#ff0000'><br>Password Updated Successfully!</font><br>";
						}
					?>	
                  <br>
                  <span class="black11">Please enter your new password:<br>
                    <br>
                    <form action="" name="frmchangepassword" method="post" onsubmit="return checkpassword();">
                      Password:<br>
                      <input name="newpassword" type="password" class="black11" id="newpassword" style="width:270px; height:21px; border:1px solid #c3c3c3;" maxlength="100" />
                      <br>
                      <br>
                      Confirm Password:<br>
                      <input name="confirmnewpassword" type="password" class="black11" id="password" style="width:270px; height:21px; border:1px solid #c3c3c3;" maxlength="100" />
                      <br>
                      <br>
                      <input name="submit" type="submit" class="black11_bold" value=" Submit ">
                      </form>
                  </span>
                  
                  
    