<?php

require_once "Log.php";
require_once "Log/file.php";
require_once "AdaptivePayments.php";

// app id 

/*
Test Account:	kornel_1284859794_biz@geekhood.net
API Username:	kornel_1284859794_biz_api1.geekhood.net
API Password:	1284859804
Signature:	 An5ns1Kso7MWUdW4ErQKJJJ4qi4-AoNmjdM3Rb9sdjZ1Lugtr9srqAoq
*/

define('PAYPAL_REDIRECT_URL', 'https://www.sandbox.paypal.com/webscr&cmd=');

class PaypalController extends Controller
{
    const APP_ID = 'APP-80W284485P519543T'; // FIXME: configurable
    const CURRENCY = "GBP";
    
    function test()
    {
        $preapprovalKey = $this->preapproval("foo@bar.example.com","50.00");

        return array(
            'redirect'=>PAYPAL_REDIRECT_URL.'_ap-preapproval&preapprovalkey='.rawurlencode($preapprovalKey),
        );
    }
    
    function cancel()
    {
    }
    
    function ok()
    {
    }
    
    function preapproval($senderEmail, $amount)
    {   
        error_reporting(E_ALL & ~E_STRICT);
        
		$token = '';

		$startDate = date('Y-m-d');
		$endDate = date('Y-m-d', time() + 3600*24*30*6); // FIXME: use real months

		$returnURL = 'http://www.paypal.com';
		$cancelURL = 'http://www.paypal.com';

		$preapprovalRequest = new PreapprovalRequest();
		$preapprovalRequest->memo = "To be paid to charity if challenge is met";
		$preapprovalRequest->cancelUrl = $this->abs_url('cancel').'?preapprovalKey=${preapprovalKey}';
		$preapprovalRequest->returnUrl = $this->abs_url('ok').'?preapprovalKey=${preapprovalKey}';
		$preapprovalRequest->clientDetails = new ClientDetailsType();
		$preapprovalRequest->clientDetails->applicationId = self::APP_ID;
		$preapprovalRequest->clientDetails->deviceId = "PayPal_PHP_SDK"; // FIXME: user-agent or session_id
		$preapprovalRequest->clientDetails->ipAddress = $_SERVER['REMOTE_ADDR'];
		$preapprovalRequest->clientDetails->partnerName = "WeGive CharityHack";
		$preapprovalRequest->currencyCode = self::CURRENCY;
		$preapprovalRequest->startingDate = $startDate;
		$preapprovalRequest->endingDate = $endDate;
//		$preapprovalRequest->maxNumberOfPayments = "10" ;
		$preapprovalRequest->maxTotalAmountOfAllPayments = $amount;
		$preapprovalRequest->requestEnvelope = new RequestEnvelope();
		$preapprovalRequest->requestEnvelope->errorLanguage = "en_US";//default it is en_US, which is the only language currently supported
//		$preapprovalRequest->senderEmail = $senderEmail;

		$ap = new AdaptivePayments();
		$response = $ap->Preapproval($preapprovalRequest);
		if(strtoupper($ap->isSuccess) == 'FAILURE')
		{
			$FaultMsg = $ap->getLastError();
			$error = is_array($FaultMsg->error) ? $FaultMsg->error[0] : $FaultMsg->error;
			
			throw new Exception("Transaction Preapproval Failed: error Id: " 
			                        . $error->errorId.", error message: " . $error->message);
		}
		else
		{
		    error_reporting(E_ALL | E_STRICT);
            
			return $response->preapprovalKey;
		}
    }
}
