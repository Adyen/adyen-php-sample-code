<?php
/**
 * Cancel a Payment using SOAP
 *
 * In order to cancel an authorised (card)  payment you send a modification 
 * request to the cancel action. This file shows how an authorised payment 
 * should be canceled by sending a modification request using SOAP. 
 * 
 * Please note: using our API requires a web service user. Set up your Webservice 
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit 
 *  
 * @link	4.Modifications/soap/cancel.php 
 * @author	Created by Adyen - Payments Made Easy
 */
 
 /**
  * Create SOAP Client = new SoapClient($wsdl,$options)
  * - $wsdl points to the wsdl you are using;
  * - $options[login] = Your WS user;
  * - $options[password] = Your WS user's password.
  * - $options[cache_wsdl] = WSDL_CACHE_BOTH, we advice 
  *   to cache the WSDL since we usually never change it.
  */  
  $client = new SoapClient(
	"https://pal-test.adyen.com/pal/Payment.wsdl", array(
		"login" => "YourWSUser",   
		"password" => "YourWSUserPassword",   
		"style" => SOAP_DOCUMENT,
		"encoding" => SOAP_LITERAL,
		"cache_wsdl" => WSDL_CACHE_BOTH,
		"trace" => 1
	)
 );
 
 /**
  * Perform cancel request by sending in a 
  * modificationRequest, the protocol is defined
  * in the WSDL. The following parameters are used:
  * - merchantAccount: The merchant account the payment was processed with.
  * - originalReference: This is the pspReference that was assigned to the authorisation
  */
 try{
	 $result = $client->cancel(array(
		"modificationRequest" => array(
			"merchantAccount" => "YourMerchantAccount",
			"originalReference" => "PspReferenceOfTheAuthorisedPayment",
		)
	));
	
	/**
	 * If the message was syntactically valid and merchantAccount is correct you will 
	 * receive a cancelReceived response with the following fields:
	 * - pspReference: A new reference to uniquely identify this modification request. 
	 * - response: A confirmation indicating we received the request: [cancel-received].
	 * 
	 * Please note: The result of the cancellation is sent via a notification with eventCode CANCELLATION.
	 */
	print_r($result);
						
 }catch(SoapFault $ex){
	 print("<pre>");
	 print($ex);
	 print("<pre>");
 }
