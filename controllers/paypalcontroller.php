<?php

require_once "Log.php";
require_once "Log/file.php";
require_once "AdaptivePayments.php";

// app id 

// test buyer: buyer_1284871282_per@geekhood.net
// pass: buyerbuyer

/*
Test Account:	kornel_1284859794_biz@geekhood.net
API Username:	kornel_1284859794_biz_api1.geekhood.net
API Password:	1284859804
Signature:	 An5ns1Kso7MWUdW4ErQKJJJ4qi4-AoNmjdM3Rb9sdjZ1Lugtr9srqAoq
*/

define('PAYPAL_REDIRECT_URL', 'https://www.sandbox.paypal.com/webscr&cmd=');

class PaypalController extends Controller
{
    const MISSION_FISH_EMAIL = 'polfning@aol.com'; // FIXME: configurable
    
    const APP_ID = 'APP-80W284485P519543T'; // FIXME: configurable
    const CURRENCY = "GBP";
    
    function new_challenge($charity_id)
    {
        $charity = Charity::find_by_id($charity_id);
        if (!$charity) throw new PageNotFoundException();
        

        // FIXME: check for duplicates
        $challenge = new Challenge();
        $challenge->charity_id = $charity->id;
        $challenge->user_id = $this->logged_in_user()->id;
        $challenge->base_donation_pence = 1000;
        $challenge->matching_percentage = 10;
        $challenge->matching_upper_limit_pence = 5000;
        $challenge->save();

        return $this->do_prepay_challenge($challenge);
    }
    
    
    function donate()
    {
        
    }
    
    function cancel()
    {
    }
    
    function ok()
    {
        
    }
    
    protected function clientDetails()
    {
        $clientDetails = new ClientDetailsType();
		$clientDetails->applicationId = self::APP_ID;
		$clientDetails->deviceId = "PayPal_PHP_SDK"; // FIXME: user-agent or session_id
		$clientDetails->ipAddress = $_SERVER['REMOTE_ADDR'];
		$clientDetails->partnerName = "WeGive CharityHack";
		return $clientDetails;
    }
    
    function prepay_challenge($challenge_id)
    {
        $challenge = Challenge::find_by_id($challenge_id);
        if (!$challenge) throw new PageNotFoundException();
        
        return $this->do_prepay_challenge($challenge);
    }
    
    function do_prepay_challenge(Challenge $challenge)
    {
        // FIXME: check status of preapprovalKey (might be denied etc)
        if (!$challenge->paypal_preapproval_key) {
            
            $challenge->paypal_preapproval_key = $this->get_preapproval_key($challenge);            
            $challenge->save();
            
            return array(
                'redirect'=>PAYPAL_REDIRECT_URL . 
                    '_ap-preapproval&preapprovalkey=' . rawurlencode($challenge->paypal_preapproval_key),
            );
            
        } else if (!$challenge->paypal_sender_email_address) {
            $this->get_preapproval_details($challenge);
            die();
        } else {
            $this->get_donation_payment($challenge);
            
            die();            
            return array(
                'redirect'=>PAYPAL_REDIRECT_URL . 
                    '_ap-preapproval&preapprovalkey=' . rawurlencode($challenge->paypal_preapproval_key),
            );
        }
    }    

    private function amountFromPence($pence)
    {
        return round($pence/100,2);
    }
    
    function donate_challenge($challenge_id)
    {
        return array(
            'redirect'=>$this->abs_path('ok'),
        );
    }
    
    function get_preapproval_details(Challenge $challenge)
    {
        $request = new PreapprovalDetailsRequest();
        $request->preapprovalKey = $challenge->paypal_preapproval_key;
    }

    function get_donation_payment(Challenge $challenge)
    {
        
        error_reporting(E_ALL & ~E_STRICT);
        
        $payRequest = new PayRequest();
        $payRequest->actionType = "PAY";
		$payRequest->cancelUrl = $this->abs_url('cancel');
		$payRequest->returnUrl = $this->abs_url('ok');
		$payRequest->clientDetails = $this->clientDetails();
       	$payRequest->currencyCode = self::CURRENCY;
       	$payRequest->requestEnvelope = new RequestEnvelope();
       	$payRequest->requestEnvelope->errorLanguage = "en_US";       	
       	$payRequest->memo = "Starting donation to charity";
       	$payRequest->preapprovalKey = $challenge->paypal_preapproval_key;
       	
       	$receiver = new Receiver();
       	$receiver->amount = $this->amountFromPence($challenge->base_donation_pence);
       	$receiver->email = self::MISSION_FISH_EMAIL;
       	$receiver->invoiceId = $challenge->charity->missionfish_invoice_id();
       	
       	$payRequest->receiverList = array($receiver);
       	
       	$ap = new AdaptivePayments();
		$response = $ap->Pay($payRequest);
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
    
    function get_preapproval_key(Challenge $challenge)
    {   
        $amount = "50.00";
        
        error_reporting(E_ALL & ~E_STRICT);
        
		$token = '';

		$startDate = date('Y-m-d');
		$endDate = date('Y-m-d', time() + 3600*24*30*6); // FIXME: use real months

		$preapprovalRequest = new PreapprovalRequest();
		$preapprovalRequest->memo = "To be paid to charity if challenge is met";
		$preapprovalRequest->cancelUrl = $this->abs_url('cancel').'?preapprovalKey=${preapprovalKey}';
		$preapprovalRequest->returnUrl = $this->abs_url('ok').'?preapprovalKey=${preapprovalKey}';
		$preapprovalRequest->clientDetails = $this->clientDetails();
		$preapprovalRequest->currencyCode = self::CURRENCY;
		$preapprovalRequest->startingDate = $startDate;
		$preapprovalRequest->endingDate = $endDate;
//		$preapprovalRequest->maxNumberOfPayments = "10" ;
		$preapprovalRequest->maxTotalAmountOfAllPayments = $amount;
		$preapprovalRequest->requestEnvelope = new RequestEnvelope();
		$preapprovalRequest->requestEnvelope->errorLanguage = "en_US";//default it is en_US, which is the only language currently supported


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
