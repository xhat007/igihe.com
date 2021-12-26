<?php
	 session_start();
 
     
	 function loged_in(){
	    return isset($_SESSION['userid']);
	 }
	 
	 
    function confirm_logged_in(){
	if(!loged_in()){
   redirect_to("login.php?errormsg=1");
   }
 }
	//if the form has been submitted 
		   if(isset($_POST['submit'])){
			$errors=array();
			//perform the data validation
			$required_fields=array('login','password');
			foreach($required_fields as $fieldname)	{
				if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])){
				   $errors[]=$fieldname;
				}
			}//end of:  foreach

		 $login=trim(thesql_rep($_POST['login']));
		 $password=trim(thesql_rep($_POST['password']));
		 $hashed_password=sha1($password);
		 if(empty($errors)){
         //check if the user exist in the database
		 $query=mysql_query("SELECT * 
		                       FROM users
							   WHERE login='$login'
							   AND hashed_password='$hashed_password'
							   LIMIT 1");
							   
		 
							   
				if(mysql_num_rows($query)==1){
				
				   $found_user=mysql_fetch_array($query);
				   $_SESSION['userid']=$found_user['id'];
				   $_SESSION['login']=$found_user['login'];
				   $_SESSION['name']=$found_user['name'];
				   $_SESSION['level']=$found_user['level'];
				   $id=$found_user['id'];
				   $timestamp=time();
				   mysql_query("UPDATE users SET last_login='$timestamp' WHERE id='$id'");
				   redirect_to("manageLyrics.php");
;
				  
				 
				}
				else{
				  $message="<img src=\"icons/s_warn.png\" /> Login and password combination incorrect .<br/>
				         Make sure that your caps lock is turned off and try again!!";
				}
		 }//end of :if(empty($errors))
		 else{
		   if(count($errors)==1){
		     $message="there was 1 error in the form";
		   }
		   else{
		     $message="there were ".count($errors)." errors in the form";
		   }
		 }
	   }
	   //if the form has not been submited
	   else{
		 
		 $login="";
		 $password="";
	   }
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php include("includes/title.php");?>
<link href="css/adminstyle.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div id="wrapper">
    <div id="header">
    <img src="icons/logo.gif" alt="igihe.com" width="197" height="87" id="homelink" />
    </div>
  <div id="welcome">
        <span class="name">
        welcome <?php 
		          if(isset($_SESSION['name'])){
		            echo $_SESSION['name'];
					}
					else{
					  echo " visitor";
					  }
				?>
        </span>
        <span class="todaydate">
         <?php 
		  $today = date("D j, Y");
		  echo date('l jS \of F Y ');
		 ?>
        </span></div>
    <div id="content">
        <h1><b>here you are at :</b> login</h1>
        <h2><span class="errors">
		<?php if(isset($_GET['errormsg'])){echo "<img src=\"icons/s_warn.png\" alt=\"error\" />&nbsp;&nbsp;&nbsp;&nbsp;Sign in first!!!";}?>
		<?php  //output message given
	               if(!empty($message)){ 
	               echo $message;
	                   }
			   ?>
               <?php //output list of errors
			   if(!empty($errors)){
			   
			   echo "please review the folowing fields :<br/>";
			   foreach($errors as $error){
			     echo " - " .$error ." <br/>";
				 
			   }
			   }
               
			   ?></span></h2>
      <div id="table">
        <form id="form1" name="form1" method="post" action="index.php">
          <fieldset id="logininfo">
          <legend>login info</legend>
<table width="560" height="105" cellpadding="0" cellspacing="0">
      <tr>
              <td width="105" rowspan="3" align="center" valign="middle"><label><img src="icons/login.png" alt="login" width="100" height="100" /></label></td>
              <td width="86" align="right">login : &nbsp; </td>
            <td colspan="2"><span id="sprytextfield1">
            <label>
            <input name="login" type="text" id="login" size="25" />
            </label>
            <span class="textfieldRequiredMsg">*The login is required.</span><span class="textfieldMinCharsMsg">Minimum 2 characters.</span><span class="textfieldMaxCharsMsg">Maximum 30 characters.</span></span> </td>
          </tr>
            <tr>
              <td align="right">password : &nbsp;</td>
              <td colspan="2"><span id="sprytextfield2">
            <label>
            <input name="password" type="password" id="password" size="25" />
            </label>
            <span class="textfieldRequiredMsg">*The password is required.</span><span class="textfieldMinCharsMsg">Minimum 2 characters.</span><span class="textfieldMaxCharsMsg"> Maximum 30 characters.</span></span></td>
          </tr>
            <tr>
              <td align="center">&nbsp;</td>
              <td width="114" align="center"><input name="submit" type="submit" class="button" id="submit" value="login"/></td>
              <td width="208" align="center">&nbsp;</td>
          </tr>
          </table>
</fieldset>
        </form>
      </div>
    </div>
<?php require_once("includes/sidebar.php");?>
    <div id="clear"></div>
<?php require_once("includes/footer.php");?>
    </div>

    <script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:2, maxChars:30});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {minChars:2, maxChars:30});
//-->
</script>
</body>
</html>

