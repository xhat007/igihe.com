<!DOCTYPE html>
<html>
    <head>
		<title>IGIHE Android multicast messenger</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
		<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
    <body>
        <div data-role="header" data-position="fixed"> 
	        <h1>IGIHE Android multicast messenger</h1> 
        </div> 
		<div class="mainForm">
        	<form action="gcm2.php" method="post" name="multicast">
				<fieldset>
					<legend>Feel up the form please</legend>
					<span id="sprytextfield1">
						<label for="articleTitre">Id</label>
						<input name="articleId" type="text" id="articleId" size="5" maxlength="5">
						<span class="textfieldRequiredMsg">A value is required.</span> 
						<span class="textfieldInvalidFormatMsg">Invalid format.</span>
						<span class="textfieldMinCharsMsg">Minimum number of characters not met.</span>
						<span class="textfieldMaxCharsMsg">Exceeded maximum number of characters.</span>
						<span class="textfieldMinValueMsg">The entered value is less than the minimum required.</span>
						<span class="textfieldMaxValueMsg">The entered value is greater than the maximum allowed.</span>
					</span>
					<br/>
					<span id="sprytextfield2">
						<label for="articleTitre">Titre</label>
						<input name="articleTitre" type="text" id="articleTitre" size="70">
						<span class="textfieldRequiredMsg">A value is required.</span> 
						<span class="textfieldMinCharsMsg">Minimum number of characters not met.</span>
					</span>		
					<br/>
					<input name="request" type="submit" value="Submit">	
			  </fieldset>
              
       	  </form>
        </div>
		<div data-role="footer" data-position="fixed"> 
			<h4>&copy;2014 IGIHE Mob'IT.</h4> 
		</div>
		<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["change"], hint:"Art ID", minChars:1, maxChars:5});
			var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {hint:"Article Title", minChars:6, validateOn:["change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
        </script>
    </body>
</html>