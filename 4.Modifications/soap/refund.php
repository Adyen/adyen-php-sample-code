<?php
/**
 * Refund a Payment using SOAP
 * 
 * Settled payments can be refunded by sending a modifiction request
 * to the refund action of the WSDL. This file shows how a settled payment 
 * can be refunded by a modification request using SOAP. 
 * 
 * Please note: using our API requires a web service user. Set up your Webservice 
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit 
 *  
 * @link	4.Modifications/soap/refund.php 
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
  * Perform refund request by sending in a 
  * modificationRequest, the protocol is defined 
  * in the WSDL. The following parameters are used:
  * - merchantAccount: The merchant account the payment was processed with.
  * - modificationAmount: The amount to refund
  * 	- currency: the currency must match the original payment
  * 	- value: the value must be the same or less than the original amount
  * - originalReference: This is the pspReference that was assigned to the authorisation
  * - reference: If you wish, you can to assign your own reference or description to the modification. 
  */
 try{
	 $result = $client->refund(array(
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
	 * receive a refundReceived response with the following fields:
	 * - pspReference: A new reference to uniquely identify this modification request. 
	 * - response: A confirmation indicating we received the request: [refund-received].
	 * 
	 * Please note: The result of the refund is sent via a notification with eventCode REFUND.
	 */
	print_r($result);
						
 }catch(SoapFault $ex){
	 print("<pre>");
	 print($ex);
	 print("<pre>");
 }
