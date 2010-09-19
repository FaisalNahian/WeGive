<?php

/********************************************
AddBankAccount.php

Called by index.html
Calls  AddBankAccountReceipt.php,and APIError.php.
********************************************/
require_once 'web_constants.php';
?>
<html>
<head>
<title>PayPal Platform SDK - Adaptive Accounts</title>
<link href="sdk.css" rel="stylesheet" type="text/css">
</head>
<body>
<form method="POST" action="AddBankAccountReceipt.php">
<center>
 
        <h2>Adaptive Accounts - Add Bank Account</h2>
   
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
            value="pbehara-seller@paypal.com" /></td>
    </tr>
     <tr>
        <td class="field">Bank Country Code:</td>
        <td><input type="text" size="30" maxlength="10" name="bankCountryCode"
            value="US" /></td>
    </tr>
   
    <tr>
        <td class="field">Bank Name:</td>
        <td><input type="text" size="30" maxlength="32"
            name="bankName" value="Huntington Bank" /></td>
    </tr>
    <tr>
        <td class="field">Routing Number:</td>
        <td><input type="text" size="30" maxlength="10" name="routingNumber"
            value="021473030" /></td>
    </tr>
    <tr>
        <td class="field">Bank Account Number:</td>
        <td><input type="text" size="30" maxlength="10" name="bankAccountNumber"
            value="162951" /></td>
     </tr>
     <tr>
        <td class="field">Account type:</td>
      <td> <select   name="accounttype">
        
        <option  value="CHECKING">CHECKING</option>
         <option  value="SAVING">SAVINGS</option>
         <option  value="BUSINESS_CHECKING">BUSINESS_CHECKING</option>
         <option  value="BUSINESS_SAVING">BUSINESS_SAVING</option>
         <option  value="NORMAL">NORMAL</option>
         <option  value="UNKNOWN">UNKNOWN</option>
          </select></td> 
     </tr>
            
   
      <tr>
        <td class="field">confirmationType:</td>
      <td> <select name="confirmationType">
        <option  value="WEB">WEB</option>
         <option  value="MOBILE">MOBILE</option>
          </select></td> 
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
