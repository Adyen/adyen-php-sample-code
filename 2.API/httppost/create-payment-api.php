<?php
/**
 * Create Payment through the API (HTTP Post)
 * 
 * Payments can be created through our API, however this is only possible if you are
 * PCI Compliant. HTTP Post payments are submitted using the Payment.authorise action. 
 * We will explain a simple credit card submission. 
 * 
 * Please note: using our API requires a web service user. Set up your Webservice 
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit 
 *  
 * @link	2.API/httppost/create-payment-api.php 
 * @author	Created by Adyen - Payments Made Easy
 */ 
 
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
  * 	- billingAddress: we advice you to submit billingAddress data if available for risk checks;
  * 		- street: The street name
  * 		- postalCode: The postal/zip code.
  * 		- city: The city
  * 		- houseNumberOrName:
  * 		- stateOrProvince: The house number
  * 		- country: The country
  * 	- expiryMonth: The expiration date's month written as a 2-digit string, padded with 0 if required (e.g. 03 or 12).
  * 	- expiryYear: The expiration date's year written as in full. e.g. 2016.
  * 	- holderName: The card holder's name, aas embossed on the card.
  * 	- number: The card number.
  * 	- cvc: The card validation code. This is the the CVC2 code (for MasterCard), CVV2 (for Visa) or CID (for American Express).
  */
  
 $request = array(
    "action" => "Payment.authorise",
    "paymentRequest.merchantAccount" => "YourMerchantAccount",   
	"paymentRequest.amount.currency" => "EUR",
	"paymentRequest.amount.value" => "199",
	"paymentRequest.reference" => "TEST-PAYMENT-" . date("Y-m-d-H:i:s"),
	"paymentRequest.shopperIP" => "ShopperIPAddress",
	"paymentRequest.shopperEmail" => "TheShopperEmailAddress",
	"paymentRequest.shopperReference" => "YourReference",
	"paymentRequest.fraudOffset" => "0",
	
	"paymentRequest.card.billingAddress.street" => "Simon Carmiggeltstraat",
	"paymentRequest.card.billingAddress.postalCode" => "1011 DJ",
	"paymentRequest.card.billingAddress.city" => "Amsterdam",
	"paymentRequest.card.billingAddress.houseNumberOrName" => "6-50",
	"paymentRequest.card.billingAddress.stateOrProvince" => "",
	"paymentRequest.card.billingAddress.country" => "NL",
	
	"paymentRequest.card.expiryMonth" => "06",
	"paymentRequest.card.expiryYear" => "2016",
	"paymentRequest.card.holderName" => "The Holder Name Here",
	"paymentRequest.card.number" => "5555444433331111",
	"paymentRequest.card.cvc" => "737",
 );
 
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, "https://pal-test.adyen.com/pal/adapter/httppost");
 curl_setopt($ch, CURLOPT_HEADER, false); 
 curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC  );
 curl_setopt($ch, CURLOPT_USERPWD, "YourWSUser:YourWSUserPassword");   
 curl_setopt($ch, CURLOPT_POST,1);
 curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($request));
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
 $result = curl_exec($ch);
 
 if($result === false)
    echo "Error: " . curl_error($ch);
 else{
 	/**
	 * If the payment passes validation a risk analysis will be done and, depending on the
	 * outcome, an authorisation will be attempted. You receive a
	 * payment response with the following fields:
	 * - pspReference: The reference we assigned to the payment;
	 * - resultCode: The result of the payment. One of Authorised, Refused or Error;
	 * - authCode: An authorisation code if the payment was successful, or blank otherwise;
	 * - refusalReason: If the payment was refused, the refusal reason.
	 */ 
	 
 	parse_str($result,$result);
    print_r(($result));
 }
 
 curl_close($ch);
