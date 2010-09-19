<?php

/********************************************
GetVerifiedStatus.php


Called by calls.html
Calls  AdaptiveAccounts.php,and APIError.php.
********************************************/

require_once '../../../lib/AdaptiveAccounts.php';
require_once '../../../lib/Stub/AA/AdaptiveAccountsProxy.php' ;
require_once 'web_constants.php';
session_start();

		try {
		
		       $emailid = $_REQUEST["emailid"];
		       $firstName=$_REQUEST["firstName"];
		       $lastname=$_REQUEST["lastname"];
		       $city=$_REQUEST["city"];
		     		       
		       /* Make the call to PayPal to get the status of an account
		        If an error occured, show the resulting errors
		        */
		       	$VstatusRequest = new GetVerifiedStatusRequest();
		       
		
		       	$VstatusRequest->emailAddress = $emailid;
		       	$VstatusRequest->matchCriteria = $city;
		       	$VstatusRequest->firstName = $firstName;
		       	$VstatusRequest->lastName = $lastname;
		      
		       	$rEnvelope = new RequestEnvelope();
				$rEnvelope->errorLanguage = "en_US";
		       	$VstatusRequest->requestEnvelope = $rEnvelope ;
		     
		       	$serverName = $_SERVER['SERVER_NAME'];
		        $serverPort = $_SERVER['SERVER_PORT'];
		       
		        $aa = new AdaptiveAccounts();
		       	//$aa->sandBoxEmailAddress = $sandboxEmail;
				$response=$aa->GetVerifiedStatus($VstatusRequest);
				
				if(strtoupper($aa->isSuccess) == 'FAILURE')
				{
					$_SESSION['FAULTMSG']=$aa->getLastError();
					$location = "APIError.php";
					header("Location: $location");
				
				}
				else {
					
										
					$location = $response->redirectURL;
					if(!empty($location)) {
						$_SESSION['AddBankFundingSource'] = $response;
						header("Location: $location");	
					}
					
				}
		
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
<html>
<body>
<center><font size=2 color=black face=Verdana><b>Account Verified Status</b></font> <br>
<br>

<br>
<table width=400>
    <tr>
        <td>accountStatus:</td>
        <td><?php echo $response->accountStatus ?></td>
    </tr>
   
</table>

</center>
<a id="CallsLink" href="Calls.html">Home</a>
</body>
</html>