
<?php

/********************************************
SetFundingSourceConfirmed.php

Called by index.html
Calls  SetFundingSourceConfirmedReceipt.php,and APIError.php.
********************************************/
require_once 'web_constants.php';
?>
<html>
<head>
<title>PayPal Platform SDK - Adaptive Accounts</title>
<link href="sdk.css" rel="stylesheet" type="text/css">
</head>
<body>
<form method="POST" action="SetFundingSourceConfirmedReceipt.php">
<center>
 
        <h2>Adaptive Accounts - Set Funding Source Confirmed</h2>
   
            <center>
              <br>
              You must be logged into <a href=
              "<?php echo DEVELOPER_PORTAL ?>" id=
              "PayPalDeveloperCentralLink" target="_blank" name=
              "PayPalDeveloperCentralLink">Developer
              Central<br></a><br>
            </center>
       
  <table >  
 
  <tr>
        <td class="field"> email Id:</td>
        <td><input type="text" size="30" maxlength="50" name=" emailid"
            value="wchai-seller-usd1@paypal.com" /></td>
    </tr>
 
    
    
<tr>
        <td class="field">Funding Source Key:</td>
        <td><input type="text" size="30" maxlength="50" name="fundingSourceKey"
            value="" /></td>
     </tr>
    <tr>
        <td class="thinfield" width="52"></td>
        <td colspan="5"><input type="submit" value="Submit"></td>
    </tr>
</table>
</center>
<a class="home" href="Calls.html">Home</a></form>
</body>
</html>

