<?php
/**
 * Create Payment through the API (SOAP)
 * 
 * Payments can be created through our API, however this is only possible if you are
 * PCI Compliant. SOAP API payments are submitted using the authorise action. 
 * We will explain a simple credit card submission. 
 * 
 * Please note: using our API requires a web service user. Set up your Webservice 
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit 
 *  
 * @link	2.API/soap/create-payment-api.php 
 * @author	Created by Adyen
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
	"https://pal-test.adyen.com/pal/servlet/Payment/v25?wsdl", array(
		"login" => "YourWSUser",  
		"password" => "YourWSUserPassword",  
		"style" => SOAP_DOCUMENT,
		"encoding" => SOAP_LITERAL,
		"cache_wsdl" => WSDL_CACHE_BOTH,
		"trace" => 1
	)
 );
 
 /**
  * A payment can be submitted by sending a PaymentRequest 
  * to the authorise action of the web service, the request should 
  * contain the following variables:
  * 
  * - merchantAccount: The merchant account the payment was processed with.
  * - amount: The amount of the payment
  * 	- currency: the currency of the payment
  * 	- amount: the amount of the payment
  * - reference: Your reference
  * - shopperIP: The IP address of the shopper (optional/recommended)
  * - shopperEmail: The e-mail address of the shopper 
  * - shopperReference: The shopper reference, i.e. the shopper ID
  * - fraudOffset: Numeric value that will be added to the fraud score (optional)
  * - card
  * 	- expiryMonth: The expiration date's month written as a 2-digit string, padded with 0 if required (e.g. 03 or 12).
  * 	- expiryYear: The expiration date's year written as in full. e.g. 2016.
  * 	- holderName: The card holder's name, aas embossed on the card.
  * 	- number: The card number.
  * 	- cvc: The card validation code. This is the the CVC2 code (for MasterCard), CVV2 (for Visa) or CID (for American Express).
  * - billingAddress: we advice you to submit billingAddress data if available for risk checks;
  * 	- street: The street name
  * 	- postalCode: The postal/zip code.
  * 	- city: The city
  * 	- houseNumberOrName:
  * 	- stateOrProvince: The house number
  * 	- country: The country
  */
  
 try{
 	$result = $client->authorise(
 		array(
 			"paymentRequest" => array(
				"merchantAccount" => "[YourMerchantAccount]", 
				"amount" => array(
					"currency" => "EUR",
					"value" => "199"
				),
				"reference" => "TEST-PAYMENT-" . date("Y-m-dH:i:s"),
				"shopperIP" => "ShopperIPAddress",
				"shopperEmail" => "TheShopperEmailAddress",
				"shopperReference" => "YourReference",
				"fraudOffset" => "0",
				"card" => array(
					"expiryMonth" => "06",
					"expiryYear" => "2016",
					"holderName" => "The Holder Name Here",
					"number" => "5555444433331111",
					"cvc" => "737"
				),
				"billingAddress" => array(
					"street" => "Simon Carmiggeltstraat",
					"postalCode" => "1011 DJ",
					"city" => "Amsterdam",
					"houseNumberOrName" => "6-50",
					"stateOrProvince" => "",
					"country" => "NL"
				)
			)
		)
	);
	
	/**
	 * If the payment passes validation a risk analysis will be done and, depending on the
	 * outcome, an authorisation will be attempted. You receive a
	 * payment response with the following fields:
	 * - pspReference: The reference we assigned to the payment;
	 * - resultCode: The result of the payment. One of Authorised, Refused or Error;
	 * - authCode: An authorisation code if the payment was successful, or blank otherwise;
	 * - refusalReason: If the payment was refused, the refusal reason.
	 */ 
	print_r($result);
						
 }catch(SoapFault $ex){
	 print("<pre>");
	 print($ex);
	 print("<pre>");
 }
