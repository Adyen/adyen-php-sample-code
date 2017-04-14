<?php
/**
 * Create Payment through the API (HTTP Post)
 * 
 * 
 * Please note: using our API requires a web service user. Set up your Webservice 
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit 
 *  
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
  * 	- expiryMonth: The expiration date's month written as a 2-digit string, padded with 0 if required (e.g. 03 or 12).
  * 	- expiryYear: The expiration date's year written as in full. e.g. 2016.
  * 	- holderName: The card holder's name, aas embossed on the card.
  * 	- number: The card number.
  * 	- cvc: The card validation code. This is the the CVC2 code (for MasterCard), CVV2 (for Visa) or CID (for American Express).
  * - billingAddress: we advice you to submit billingAddress data if available for risk checks;
  *   - street: The street name
  *   - postalCode: The postal/zip code.
  *   - city: The city
  *   - houseNumberOrName:
  *   - stateOrProvince: The house number
  *   - country: The country
  */
  
 $request =array(
  "merchantAccount" => "[YourMerchantAccount]",   
  "amount" => array(
    "currency" => "EUR",
  	"value" => "199"
  ),
  "reference" => "TEST-PAYMENT-" . date("Y-m-d-H:i:s"),
	"shopperIP" => "2.207.255.255",
	"shopperReference" => "YourReference",
  "billingAddress" => array(
    "street" => "Simon Carmiggeltstraat",
		"postalCode" => "1011DJ",
		"city" => "Amsterdam",
		"houseNumberOrName" => "6-60",
		"stateOrProvince" => "NH",
		"country" => "NL"
  ),
	"card" => array(
		"expiryMonth" => "08",
		"expiryYear" => "2018",
		"holderName" => "Test Card Holder",
		"number" => "4111111111111111",
		"cvc" => "737"
	),
	"browserInfo"=>array(
		"acceptHeader"=>$_SERVER['HTTP_USER_AGENT'],
		"userAgent"=>$_SERVER['HTTP_ACCEPT']
	)
);

 
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, "https://pal-test.adyen.com/pal/servlet/Payment/v25/authorise");
 curl_setopt($ch, CURLOPT_HEADER, false); 
 curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC  );
 curl_setopt($ch, CURLOPT_USERPWD, "YourWSUser:YourWSUserPassword");   
 curl_setopt($ch, CURLOPT_POST,count(json_encode($request)));
 curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($request));
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-type: application/json")); 
 
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
	 
print_r(json_decode($result));
 }
 
 curl_close($ch);
?>
