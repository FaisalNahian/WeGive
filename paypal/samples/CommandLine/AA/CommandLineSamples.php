<?php

/**
 * Copyright (C) 2009 PayPal Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */


 
  // Include all the required files
  require_once('../../../lib/AdaptiveAccounts.php');
  require_once('../../../lib/Stub/AA/AdaptiveAccountsProxy.php');

  RunAdaptivePaymentSamples();


  function RunAdaptivePaymentSamples() {
				
		try {
					
			echo  "Running AdaptiveAccounts Samples...\n";
			$tempReturn1=Array();		
			$tempReturn2=Array();
			$tempReturn1=CreateAccount();//Create Account personal and premium
			$tempReturn2=CreateAccountBusiness();	//business
			$fundingSourceKey=AddBankAccount();
			AddBankAccountDirect($tempReturn1);//AddBankAccount and AddBankAccountDirect are the two different usecase of the "AddBankAccount" API 
			AddPaymentCard();
			AddPaymentCardDirect($tempReturn2);	//AddPaymentCard and AddPaymentCardDirect are the two different usecase of the "AddPaymentCard" API
			SetFundingSourceConfirmed();
			GetVerifiedStatus()	;
			
		}
		catch(Exception $ex) {
			echo $ex->getMessage();
		}
		
		echo  "\n\n *****  Done. *****\n\n";
		
		//Reads enter key
		fread(STDIN, 1);

  }

	function CreateAccount() {
		
		$aa = new AdaptiveAccounts();
		
		$CARequest = new CreateAccountRequest();
       	$CARequest->accountType = 'PERSONAL';
       	       	
       	$address = new AddressType();
       	$address->city = 'Austin';
       	$address->countryCode = 'US';
       	$address->line1 = '1968 Ape Way';
       	$address->line2 = 'Apt 123';
       	$address->postalCode = '78750';
       	$address->state = 'TX' ;
       	$CARequest->address = $address;

       	$CARequest->citizenshipCountryCode = 'US';
       	$CARequest->clientDetails = new ClientDetailsType();
       	$CARequest->clientDetails->applicationId ="APP-80W284485P519543T";
        $CARequest->clientDetails->deviceId = "PayPal_PHP_SDK";
        $CARequest->clientDetails->ipAddress = "127.0.0.1";
           	
       	$CARequest->contactPhoneNumber = '512-691-4160';
       	$CARequest->currencyCode = 'USD';
       	$CARequest->dateOfBirth = '1968-01-01';
       	       	
       	$name = new NameType();
       	$name->firstName = 'Bonzop' ;
       	$name->middleName = 'Simore';
       	$name->lastName = 'Zaius';
       	$name->salutation = 'Dr.';
       	$CARequest->name = $name;
       	       	
       	$CARequest->notificationURL = 'http://stranger.paypal.com/cgi-bin/ipntest.cgi';
       	$CARequest->partnerField1 = 'p1';
       	$CARequest->partnerField2 = 'p2';
       	$CARequest->partnerField3 = 'p3';
       	$CARequest->partnerField4 = 'p4';
       	$CARequest->partnerField5 = 'p5';
       	$CARequest->preferredLanguageCode = "en_US";
       	
       	$rEnvelope = new RequestEnvelope();
		$rEnvelope->errorLanguage = "en_US";
       	$CARequest->requestEnvelope = $rEnvelope ;
       	
       	$CARequest->sandboxEmailAddress = 'Platform.sdk.seller@gmail.com';
       	$datetime = gettimeofday();
		$CARequest->emailAddress = 'testaccount' . $datetime['usec'] . '@paypal.com';
       	$CARequest->registrationType = "WEB";
		
       	$aa = new AdaptiveAccounts();
       	$aa->sandBoxEmailAddress = 'Platform.sdk.seller@gmail.com';
		$response=$aa->CreateAccount($CARequest);
		
  		if(strtoupper($aa->isSuccess) == 'FAILURE')
		{
			$FaultMsg = $aa->getLastError();
			echo "Transaction CreateAccount Failed: error Id: ";
			if(is_array($FaultMsg->error))
	        {
	        	echo $FaultMsg->error[0]->errorId . ", error message: " . $FaultMsg->error[0]->message ;
	        }
	        else
	        {
	        	echo $FaultMsg->error->errorId . ", error message: " . $FaultMsg->error->message ;
	        }
			
		}
		else
		{
			
			echo "CreateAccount Successful! \n";
			$tempReturn1['createAccountKey']=$response->createAccountKey;
			$tempReturn1['emailAddress']=$CARequest->emailAddress;
			return $tempReturn1;
		}
		
	}	
		
		
function CreateAccountBusiness(){
	

      		 	$bizName ='Bonzop' ;
				$bizAddressline1 = '1968 Ape Way';
				$bizAddressline2 ='Apt 123';
				$bizcity = 'Austin';
				$bizZIP = '78750';
				$bizCountryCode = 'US';
				$biz_address_state = 'TX' ;
				$bizWorkPhone = '512-691-4160';
				$bizCategoryCode= '1001';
				$bizSubCategory = '2002';
				$bizCustomerServicePhone = '512-691-4160';
				  	$datetime = gettimeofday();
				$bizCustomerServiceEmail = 'testaccount1' . $datetime['usec'] . '@paypal.com';
				$bizWebSite = 'https://www.x.com';
				$bizDateOfEstablishment = '1968-01-01';
				$businessType = 'INDIVIDUAL';
				$averagePrice = '100';
				$averageMonthlyVolume = '100';
				$percentageRevenueFromOnline = '100';
				$salesVenue = 'WEB';
				

				
		       /* Make the call to PayPal to create Account on behalf of the caller
		        If an error occured, show the resulting errors
		        */
		       	$CARequest = new CreateAccountRequest();
		       	$CARequest->accountType = 'BUSINESS';
		       	       	
		       	$address = new AddressType();
		       	$address->city = 'Austin';
		       	$address->countryCode = 'US';
		        $address->line1 = '1968 Ape Way';
             	$address->line2 = 'Apt 123';
		       	$address->postalCode = '78750';
            	$address->state = 'TX' ;
            	$CARequest->address = $address;
            	
		       	$CARequest->citizenshipCountryCode = 'US';
		       	$CARequest->clientDetails = new ClientDetailsType();
		        $CARequest->clientDetails->applicationId ="APP-80W284485P519543T";
		      
		       
		        $CARequest->clientDetails->ipAddress = "127.0.0.1";
		           	
		       	$CARequest->contactPhoneNumber = '512-691-4160';
		       	$CARequest->currencyCode = 'USD';
		       	$CARequest->dateOfBirth = '1968-01-01';
		       	       	
		       
		        $name = new NameType();
            	$name->firstName = 'Bonzop' ;
            	$name->middleName = 'Simore';
            	$name->lastName = 'Zaius';
             	$name->salutation = 'Dr.';
            	$CARequest->name = $name;
		       	       	
		       	$CARequest->notificationURL = 'http://stranger.paypal.com/cgi-bin/ipntest.cgi';
		       	$CARequest->partnerField1 = 'p1';
	       		$CARequest->partnerField2 = 'p2';
		       	$CARequest->partnerField3 ='p3';
		       	$CARequest->partnerField4 ='p4';
		       	$CARequest->partnerField5 ='p5';
		       	$CARequest->preferredLanguageCode = "en_US";
		       	
		       	//only required for business account
		       	$bizInfo = new BusinessInfoType();
		       	$bizInfo->businessName = $bizName;
		       	$bizAddress = new AddressType();
		       	$bizAddress->city = $bizcity;
		       	$bizAddress->countryCode = $bizCountryCode;
		       	$bizAddress->line1 = $bizAddressline1;
		       	$bizAddress->line2 = $bizAddressline2;
		       	$bizAddress->postalCode = $bizZIP;
		       	$bizAddress->state = $biz_address_state ;
		       	$bizInfo->businessAddress = $bizAddress;
		       			       	
				$bizInfo->workPhone = $bizWorkPhone;
				$bizInfo->category = $bizCategoryCode;
				$bizInfo->subCategory = $bizSubCategory;
				$bizInfo->customerServicePhone = $bizCustomerServicePhone;
				$bizInfo->customerServiceEmail = $bizCustomerServiceEmail;
				$bizInfo->webSite = $bizWebSite;
				$bizInfo->dateOfEstablishment = $bizDateOfEstablishment;
				$bizInfo->businessType = $businessType;
				$bizInfo->averagePrice = $averagePrice;
				$bizInfo->averageMonthlyVolume = $averageMonthlyVolume;
				$bizInfo->percentageRevenueFromOnline = $percentageRevenueFromOnline;
				$bizInfo->salesVenue = $salesVenue;
				$CARequest->businessInfo = $bizInfo;
		       	
		       	$rEnvelope = new RequestEnvelope();
				$rEnvelope->errorLanguage = "en_US";
		       	$CARequest->requestEnvelope = $rEnvelope ;
		       	
		       	$CARequest->createAccountWebOptions = new CreateAccountWebOptionsType();
		      
		
		   
				$CARequest->registrationType = "WEB";
		       	
				$CARequest->sandboxEmailAddress = 'Platform.sdk.seller@gmail.com';
            	$datetime = gettimeofday();
		        $CARequest->emailAddress = 'testaccount' . $datetime['usec'] . '@paypal.com';
		       	
		       	$aa = new AdaptiveAccounts();
		       	$aa->sandBoxEmailAddress = 'Platform.sdk.seller@gmail.com';
				$response=$aa->CreateAccount($CARequest);	
		
		
		
		
		
		
  		if(strtoupper($aa->isSuccess) == 'FAILURE')
		{
			$FaultMsg = $aa->getLastError();
			echo "Transaction CreateAccount Business Failed: error Id: ";
			if(is_array($FaultMsg->error))
	        {
	        	echo $FaultMsg->error[0]->errorId . ", error message: " . $FaultMsg->error[0]->message ;
	        }
	        else
	        {
	        	echo $FaultMsg->error->errorId . ", error message: " . $FaultMsg->error->message ;
	        }
			
		}
		else
		{
			echo "CreateAccount Business API call Successful! \n";
			$tempReturn2['createAccountKey']=$response->createAccountKey;
			$tempReturn2['emailAddress']=$CARequest->emailAddress;
			return $tempReturn2;
		}
			
}		
		
		
function AddBankAccount(){
	 $bankCountryCode = 'US';
		       $bankName='Huntington Bank';
		       $routingNumber='021473030';
		       $bankAccountNumber=(string)rand(160000,169999);
		     	$confirmationType = 'WEB';
		     	$emailid ='pbehara-seller@paypal.com';
		     	$accounttype='CHECKING';
		     	   
		       /* Make the call to PayPal to create Account on behalf of the caller
		        If an error occured, show the resulting errors
		        */
		
		       	$ABARequest = new AddBankAccountRequest();
		       
		
		       	$ABARequest->bankCountryCode = $bankCountryCode;
		       	$ABARequest->bankName = $bankName;
		       	$ABARequest->routingNumber = $routingNumber;
		       	$ABARequest->bankAccountNumber = $bankAccountNumber;
		        $ABARequest->confirmationType = $confirmationType;
		        $ABARequest->bankAccountType=$accounttype;
		        $ABARequest->emailAddress = $emailid;
		       	$rEnvelope = new RequestEnvelope();
				$rEnvelope->errorLanguage = "en_US";
		       	$ABARequest->requestEnvelope = $rEnvelope ;
		      
		       	
		     	$serverName = 'localhost';
		        $serverPort = '8082';
		        $url=dirname('http://'.$serverName.':'.$serverPort.'/REQUEST_URI/');
		        $returnURL = $url."/AddBankAccountDetails.php";
				$cancelURL = $url. "/AddBankAccount.php" ;
				$cancelUrlDescription ='cancelurl';
		 	    $returnUrlDescription ='returnurl';
				$weboptions= new WebOptionsType();
		       $weboptions->returnUrl = $returnURL;
		       $weboptions->cancelUrl = $cancelURL;
		       $weboptions->returnUrlDescription =$returnUrlDescription;
		       $weboptions->cancelUrlDescription =$cancelUrlDescription;
		       $ABARequest->webOptions = $weboptions;
		       
		        $aa = new AdaptiveAccounts();
		       	$aa->sandBoxEmailAddress = 'Platform.sdk.seller@gmail.com';
				$response=$aa->AddBankAccount($ABARequest);
		if(strtoupper($aa->isSuccess) == 'FAILURE')
		{
			$FaultMsg = $aa->getLastError();
			echo "Transaction add bank: error Id: ";
			if(is_array($FaultMsg->error))
	        {
	        	echo $FaultMsg->error[0]->errorId . ", error message: " . $FaultMsg->error[0]->message ;
	        }
	        else
	        {
	        	echo $FaultMsg->error->errorId . ", error message: " . $FaultMsg->error->message ;
	        }
			
		}
		else
		{
			echo "Add bank AccountAPI call Successful! \n";
			$fundingSourceKey=$response->fundingSourceKey;
			return $fundingSourceKey;
		}
	
}		
		
function AddBankAccountDirect($tempReturn1){
	 $bankCountryCode = 'US';
		       $bankName='Huntington Bank';
		       $routingNumber='021473030';
		       $bankAccountNumber= (string)rand(160000,169999);
		     	$confirmationType = 'NONE';
		     	$emailid =$tempReturn1['emailAddress'];
		     	$accounttype='CHECKING';
		     	   
		       /* Make the call to PayPal to Add Bank as funding source
		        If an error occured, show the resulting errors
		        */
		
		       	$ABARequest = new AddBankAccountRequest();
		       
		
		       	$ABARequest->bankCountryCode = $bankCountryCode;
		       	$ABARequest->bankName = $bankName;
		       	$ABARequest->routingNumber = $routingNumber;
		       	$ABARequest->bankAccountNumber = $bankAccountNumber;
		        $ABARequest->confirmationType = $confirmationType;
		        $ABARequest->bankAccountType=$accounttype;
		        $ABARequest->emailAddress = $emailid;
		        $ABARequest->createAccountKey =$tempReturn1['createAccountKey'];
		       	$rEnvelope = new RequestEnvelope();
				$rEnvelope->errorLanguage = "en_US";
		       	$ABARequest->requestEnvelope = $rEnvelope ;
		      
		       	
		     	$serverName = 'localhost';
		        $serverPort = '8082';
		        $url=dirname('http://'.$serverName.':'.$serverPort.'/REQUEST_URI/');
		        $returnURL = $url."/AddBankAccountDetails.php";
				$cancelURL = $url. "/AddBankAccount.php" ;
				$cancelUrlDescription ='cancelurl';
		 	    $returnUrlDescription ='returnurl';
				$weboptions= new WebOptionsType();
		       $weboptions->returnUrl = $returnURL;
		       $weboptions->cancelUrl = $cancelURL;
		       $weboptions->returnUrlDescription =$returnUrlDescription;
		       $weboptions->cancelUrlDescription =$cancelUrlDescription;
		       $ABARequest->webOptions = $weboptions;
		       
		        $aa = new AdaptiveAccounts();
		       	$aa->sandBoxEmailAddress = 'Platform.sdk.seller@gmail.com';
				$response=$aa->AddBankAccount($ABARequest);
		if(strtoupper($aa->isSuccess) == 'FAILURE')
		{
			$FaultMsg = $aa->getLastError();
			echo "Transaction add bank direct: error Id: ";
			if(is_array($FaultMsg->error))
	        {
	        	echo $FaultMsg->error[0]->errorId . ", error message: " . $FaultMsg->error[0]->message ;
	        }
	        else
	        {
	        	echo $FaultMsg->error->errorId . ", error message: " . $FaultMsg->error->message ;
	        }
			
		}
		else
		{
			echo "Add bank Account - Direct API call Successful! \n";
		}
	
}		

function AddPaymentCard()
{
				$emailid = 'pbehara-seller@paypal.com'; 
		     	$cardtype='Visa';  
		     	$cardNumber ='4943871033202264';  
		        $confirmationType='WEB';
		      
		        $expirationDate= new CardDateType();
		        $expirationDate->month ='01';
		        $expirationDate->year='2014';
		        
		        $nameOnCard= new NameType();
		        $nameOnCard->firstName=  'John';
		        $nameOnCard->lastName=   'Deo';
		        
		         $bAddress = new AddressType();
		        $bAddress->line1='1 Main St';
		        $bAddress->line2='2nd cross';
		        $bAddress->city='San Jose';
		        $bAddress->state='CA';
		        $bAddress->postalCode='95131';
		        $bAddress->countryCode='US';
		        
				$APCRequest = new AddPaymentCardRequest();
		       	$APCRequest->cardNumber = $cardNumber;
		        $APCRequest->confirmationType = $confirmationType;
		    
		        $APCRequest->emailAddress = $emailid;
		        $APCRequest->cardType=$cardtype;
		        $APCRequest->expirationDate= $expirationDate;
		       
		  
		       
		        
		        $APCRequest->billingAddress=$bAddress;
		        $APCRequest->nameOnCard=$nameOnCard;
		       	$rEnvelope = new RequestEnvelope();
				$rEnvelope->errorLanguage = "en_US";
		       	$APCRequest->requestEnvelope = $rEnvelope ;
		      
		       	
		       	$serverName = 'localhost';
		        $serverPort = '8082';
		        $url=dirname('http://'.$serverName.':'.$serverPort.'/REQUEST_URI/');
		        $returnURL = $url."/AddPaymentCardDetails.php";
				$cancelURL = $url. "/AddPaymentCard.php" ;
				$cancelUrlDescription ="cancelurl";
		 	    $returnUrlDescription ="returnurl";
				$weboptions= new WebOptionsType();
		        $weboptions->returnUrl = $returnURL;
		        $weboptions->cancelUrl = $cancelURL;
		        $weboptions->returnUrlDescription =$returnUrlDescription;
		        $weboptions->cancelUrlDescription =$cancelUrlDescription;
		        $APCRequest->webOptions = $weboptions;
		        
		        $aa = new AdaptiveAccounts();
		       	//$aa->sandBoxEmailAddress = $sandboxEmail;
				$response=$aa->AddPaymentCard($APCRequest);
				
			if(strtoupper($aa->isSuccess) == 'FAILURE')
		{
			$FaultMsg = $aa->getLastError();
			echo "Transaction Add Payment Card Failed: error Id: ";
			if(is_array($FaultMsg->error))
	        {
	        	echo $FaultMsg->error[0]->errorId . ", error message: " . $FaultMsg->error[0]->message ;
	        }
	        else
	        {
	        	echo $FaultMsg->error->errorId . ", error message: " . $FaultMsg->error->message ;
	        }
			
		}
else
		{
			echo "AddPaymentCard  API call Successful! \n";
		}
     	
}

function AddPaymentCardDirect($tempReturn2)
{
				$emailid = $tempReturn2['emailAddress']; 
		     	$cardtype='Visa';  
		     	$cardNumber = Cardnumbergenerator();       
		     	
		        $confirmationType='NONE';
		      
		        $expirationDate= new CardDateType();
		        $expirationDate->month ='01';
		        $expirationDate->year='2014';
		        
		        $nameOnCard= new NameType();
		        $nameOnCard->firstName=  'John';
		        $nameOnCard->lastName=   'Deo';
		        
		         $bAddress = new AddressType();
		        $bAddress->line1='1 Main St';
		        $bAddress->line2='2nd cross';
		        $bAddress->city='San Jose';
		        $bAddress->state='CA';
		        $bAddress->postalCode='95131';
		        $bAddress->countryCode='US';
		        
				$APCRequest = new AddPaymentCardRequest();
		       	$APCRequest->cardNumber = $cardNumber;
		       	$APCRequest->cardVerificationNumber ='956';
		        $APCRequest->confirmationType = $confirmationType;
		    
		        $APCRequest->emailAddress = $emailid;
		        $APCRequest->cardType=$cardtype;
		        $APCRequest->expirationDate= $expirationDate;
		       
		  		        
		        $APCRequest->billingAddress=$bAddress;
		        $APCRequest->nameOnCard=$nameOnCard;
		        $APCRequest->createAccountKey=$tempReturn2['createAccountKey'] ;
		       	$rEnvelope = new RequestEnvelope();
				$rEnvelope->errorLanguage = "en_US";
		       	$APCRequest->requestEnvelope = $rEnvelope ;
		      
		       	
		       	$serverName = 'localhost';
		        $serverPort = '8082';
		        $url=dirname('http://'.$serverName.':'.$serverPort.'/REQUEST_URI/');
		        $returnURL = $url."/AddPaymentCardDetails.php";
				$cancelURL = $url. "/AddPaymentCard.php" ;
				$cancelUrlDescription ="cancelurl";
		 	    $returnUrlDescription ="returnurl";
				
		        
		        $aa = new AdaptiveAccounts();
		       	//$aa->sandBoxEmailAddress = $sandboxEmail;
				$response=$aa->AddPaymentCard($APCRequest);
				
			if(strtoupper($aa->isSuccess) == 'FAILURE')
		{
			$FaultMsg = $aa->getLastError();
			echo "Transaction Add Payment Card direct Failed: error Id: ";
			if(is_array($FaultMsg->error))
	        {
	        	echo $FaultMsg->error[0]->errorId . ", error message: " . $FaultMsg->error[0]->message ;
	        }
	        else
	        {
	        	echo $FaultMsg->error->errorId . ", error message: " . $FaultMsg->error->message ;
	        }
			
		}
else
		{
			echo "AddPaymentCard -Direct - Direct API call Successful! \n";
		}
     	
}

function SetFundingSourceConfirmed()
{
	echo"SetFundingSourceConfirmed - one of the input parameters require web flow";
}
	function GetVerifiedStatus(){
		  $emailid = 'platfo@paypal.com';
		       $firstName= 'Bonzop' ;
       	
    
		       $lastname=   'Zaius';
		       
		     		       
		      
		       	$VstatusRequest = new GetVerifiedStatusRequest();
		       
		
		       	$VstatusRequest->emailAddress = $emailid;
		       	$VstatusRequest->matchCriteria = 'NAME';
		       	$VstatusRequest->firstName = $firstName;
		       	$VstatusRequest->lastName = $lastname;
		      
		       	$rEnvelope = new RequestEnvelope();
				$rEnvelope->errorLanguage = "en_US";
		       	$VstatusRequest->requestEnvelope = $rEnvelope ;
		     
		       	
		       
		        $aa = new AdaptiveAccounts();
		       	//$aa->sandBoxEmailAddress = $sandboxEmail;
				$response=$aa->GetVerifiedStatus($VstatusRequest);
	if(strtoupper($aa->isSuccess) == 'FAILURE')
		{
			$FaultMsg = $aa->getLastError();
			echo "Transaction get status error Id: ";
			if(is_array($FaultMsg->error))
	        {
	        	echo $FaultMsg->error[0]->errorId . ", error message: " . $FaultMsg->error[0]->message ;
	        }
	        else
	        {
	        	echo $FaultMsg->error->errorId . ", error message: " . $FaultMsg->error->message ;
	        }
			
		}
		else
		{
			echo "Get Verified Status  Successful! \n";
		}
				
	}	
		
function Cardnumbergenerator()
{
	$cc_number =Array(16);
		 $cc_len = 16;
		 $start = 0;
	     $cc_number[$start++] = 4;
         for ($i = $start; $i < ($cc_len - 1); $i++) 
	            $cc_number[$i] = mt_rand(0,9);
         $sum = 0;
		 for ($j = 0; $j < ($cc_len - 1); $j++) {
			$digit = $cc_number[$j];
			if (($j & 1) == ($cc_len & 1)) $digit *= 2;
			if ($digit > 9) $digit -= 9;
			 $sum += $digit;
		    }

		 $check_digit = Array(0, 9, 8, 7, 6, 5, 4, 3, 2, 1);
		 $cc_number[$cc_len - 1] = $check_digit[$sum % 10];
         $cardnumber=null;
         for ($i=0; $i<16;$i++)
	     $cardnumber.=$cc_number[$i];
	     return $cardnumber;
	
}	
	
?>
