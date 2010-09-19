<?php

/******************************************************
SetFundingSourceConfirmedDetails.php

This page is specified as the ReturnURL for the SetFundingSourceConfirmed Operation.
When returned from PayPal this page is called.

******************************************************/

require_once '../../../lib/AdaptivePayments.php';
require_once '../../../lib/Stub/AA/AdaptiveAccountsProxy.php';

session_start();
	
	try {	
			$SFSCdetail = new SetFundingSourceConfirmedResponse();
			$SFSCdetail=$_SESSION['FundingSourceConfirmed'];
			
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


  <title>PayPal PHP SDK -SetFundingSourceConfirmed Details</title>
  <link href="sdk.css" rel="stylesheet" type="text/css">
</head>

<body>
  <center>
    <font size="2" color="black" face="Verdana"><b>SetFundingSourceConfirmed
    Details</b></font><br>
    <br>

    <table width="400">
		<tr>
        <td>Status:</td>
        <td><?php echo $SFSCdetail->responseEnvelope->ack ?></td>

   
    </tr>   
		<tr>
        <td>timestamp:</td>
        <td><?php echo $SFSCdetail->responseEnvelope->timestamp  ?></td>

   
    </tr>
   
		<tr>
        <td>correlationId:</td>
        <td><?php echo $SFSCdetail->responseEnvelope->correlationId ?></td>

   
    </tr>   
 
		<tr>
        <td>build:</td>
        <td><?php echo $SFSCdetail->responseEnvelope->build ?></td>

   
    </tr>   
		  
    
     </table>
  </center><a class="home" id="CallsLink" href="Calls.html" name=
  "CallsLink">Home</a>
</body>
</html>