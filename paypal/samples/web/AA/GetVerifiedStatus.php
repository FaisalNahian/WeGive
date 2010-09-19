<?php

/********************************************
GetVerifiedStatus.php

Called by index.html
Calls  CreateAccountReceipt.php,and APIError.php.
********************************************/
require_once 'web_constants.php';
?>
<html>
<head>
<title>PayPal Platform SDK - Adaptive Accounts</title>
<link href="sdk.css" rel="stylesheet" type="text/css">
</head>
<body>
<form method="POST" action="GetVerifiedStatusReceipt.php">
<center>
 
        <h2>Adaptive Accounts - Get Account Verified Status</h2>
   
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
        <td class="field">Email ID:</td>
        <td><input type="text" size="30" maxlength="50" name="emailid"
            value="platfo@paypal.com" /></td>
    </tr>
   
    <tr>
        <td class="field">First Name:</td>
        <td><input type="text" size="30" maxlength="32"
            name="firstName" value="Bonzop" /></td>
    </tr>
    <tr>
        <td class="field">Last Name:</td>
        <td><input type="text" size="30" maxlength="10" name="lastname"
            value="Zaius" /></td>
    </tr>
    <tr>
        <td class="field">Match Criteria:</td>
        <td><input type="text" size="30" maxlength="30" name="city"
            value="NAME" /></td>
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
