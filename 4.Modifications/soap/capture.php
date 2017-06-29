<?php
/**
 * Capture a Payment using SOAP
 * 
 * Authorised (card) payments can be captured to get the money from the shopper. 
 * Payments can be automatically captured by our platform. A payment can
 * also be captured by performing an API call. In order to capture an authorised 
 * (card) payment you have to send a modification request. This file
 * shows how an authorised payment should be captured by sending 
 * a modification request using SOAP. 
 * 
 * Please note: using our API requires a web service user. Set up your Webservice 
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit 
 *  
 * @link	4.Modifications/soap/capture.php 
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
  * Perform capture request by sending in a 
  * modificationRequest, the protocol is defined 
  * in the WSDL. The following parameters are used:
  * - merchantAccount: The merchant account the payment was processed with.
  * - modificationAmount: The amount to capture
  * 	- currency: the currency must match the original payment
  * 	- value: the value must be the same or less than the original amount
  * - originalReference: This is the pspReference that was assigned to the authorisation
  * - reference: If you wish, you can assign your own reference or description to the modification.
  */
 try{
	 $result = $client->capture(array(
		"modificationRequest" => array(
			"merchantAccount" => "YourMerchantAccount",
			"modificationAmount" => array(
				"currency" => "EUR",
				"value" => "199",
			),
			"originalReference" => "PspReferenceOfTheAuthorisedPayment",
			"reference" => "YourReference"
		)
	));
	
	/**
	 * If the message was syntactically valid and merchantAccount is correct you will 
	 * receive a captureResult response with the following fields:
	 * - pspReference: A new reference to uniquely identify this modification request. 
	 * - response: A confirmation indicating we received the request: [capture-received].
	 * 
	 * Please note: The result of the capture is sent via a notification with eventCode CAPTURE.
	 */
	print_r($result);
						
 }catch(SoapFault $ex){
	 print("<pre>");
	 print($ex);
	 print("<pre>");
 }
