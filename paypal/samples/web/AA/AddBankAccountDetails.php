<?php

/******************************************************
AddBankAccountDetails.php

This page is specified as the ReturnURL for the AddBankAccount Operation.
When returned from PayPal this page is called.

******************************************************/

require_once '../../../lib/AdaptivePayments.php';
require_once '../../../lib/Stub/AA/AdaptiveAccountsProxy.php';

session_start();
	
	try {	
			$ABFSdetail = new AddBankAccountResponse();
			$ABFSdetail=$_SESSION['BankAdded'];
			
	}
	catch(Exception $ex) {
		
		$fault = new FaultMessage();
		$errorData = new ErrorData();
		$errorData->errorId = $ex->getFile() ;
  		$errorData->message = $ex->getMessage();
  		$fault->error = $errorData;
		$_SESSION['FAULTMSG']=$fault;
		$location = "APIError.php";
		header("Location: $location");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
  <meta name="generator" content=
  "HTML Tidy for Windows (vers 14 February 2006), see www.w3.org">

  <title>PayPal PHP SDK -Add Bank Account Details</title>
  <link href="sdk.css" rel="stylesheet" type="text/css">
</head>

<body>
  <center>
    <font size="2" color="black" face="Verdana"><b>Add Bank Account
    Details</b></font><br>
    <br>

    <table width="400">
		<tr>
        <td>Status:</td>
        <td><?php echo $ABFSdetail->execStatus ?></td>

   
    </tr>   
		<tr>
        <td>Funding Source Key:</td>
        <td><?php echo $ABFSdetail->fundingSourceKey  ?></td>

   
    </tr>
    
		  
    
     </table>
  </center><a class="home" id="CallsLink" href="Calls.html" name=
  "CallsLink">Home</a>
</body>
</html>