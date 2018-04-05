<?php
/**
 * Create Payment through the API (PHP Library)
 *
 * Payments can be created through our API, however, if you want to submit unencrypted 
 * card information like the example in this file, you need to be PCI Compliant. PHP 
 * Library API payments are submitted using the authorise action. We will explain a 
 * simple credit card submission.
 *
 * Please note: using our API requires a web service user. Set up your Webservice
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit
 *
 * @link	2.API/Library/create-payment-api.php
 * @author	Created by Adyen
 */

 /**
 * Client settings
 * - Client
 *      ->setUsername           : your web service user
 *      ->setPassword           : your web service user's password
 *      ->setEnvironment        : The Environment you are using (\Adyen\Environment::TEST or \Adyen\Environment::LIVE)
 *      ->setApplicationName    : your application name
 */
 $client = new \Adyen\Client();
 $client->setUsername("YourWSUser");
 $client->setPassword("YourWSPassword");
 $client->setEnvironment(\Adyen\Environment::TEST);
 $client->setApplicationName("My Test Application");

 // initialize service
 $service = new Adyen\Service\Payment($client);

 /**
 * A payment can be submitted by sending a PaymentRequest
 * to the authorise action of the web service, the request should
 * contain the following variables:
 *
 * - merchantAccount            : The merchant account the payment was processed with.
 * - amount
 * 	    - currency              : the currency of the payment
 * 	    - amount                : the amount of the payment
 * - reference                  : Your reference
 * - shopperIP                  : The IP address of the shopper (optional/recommended)
 * - shopperEmail               : The e-mail address of the shopper
 * - shopperReference           : The shopper reference, i.e. the shopper ID
 * - fraudOffset                : Numeric value that will be added to the fraud score (optional)
 * - card
 * 	    - expiryMonth           : The expiration date's month written as a 2-digit string, padded with 0 if required (e.g. 03 or 12).
 *  	- expiryYear            : The expiration date's year written as in full. e.g. 2016.
 * 	    - holderName            : The card holder's name, aas embossed on the card.
 * 	    - number                : The card number.
 *  	- cvc                   : The card validation code. This is the the CVC2 code (for MasterCard), CVV2 (for Visa) or CID (for American Express).
 * - billingAddress (recommended)
 *     - street                 : The street name.
 *     - houseNumberOrName      : The house number (or name).
 *     - city                   : The city.
 *     - postalCode             : The postal/zip code.
 *     - stateOrProvince        : The state or province.
 *     - country                : The country in ISO 3166-1 alpha-2 format (e.g. NL).
 */

 $card = array(
    "number" =>  "5136333333333335",
    "expiryMonth" =>  "08",
    "expiryYear" =>  "2018",
    "cvc" =>  "737",
    "holderName" =>  "John Smith"
 );

 $amount = array(
    "value" => 1400,
    "currency"=> "EUR"
 );

 $request = array(
    "merchantAccount" => "YourMerchantAccount",
    "amount" => $amount,
    "reference" => "YourReference",
    "card" => $card
 );

 $result = $service->authorise($request);

 /**
  * If the payment passes validation a risk analysis will be done and, depending on the
  * outcome, an authorisation will be attempted. You receive a
  * payment response with the following fields:
  * - pspReference              : The reference we assigned to the payment;
  * - resultCode                : The result of the payment. One of Authorised, Refused or Error;
  * - authCode                  : An authorisation code if the payment was successful, or blank otherwise;
  * - refusalReason             : If the payment was refused, the refusal reason.
  */
 print_r("Payment Result:\n");
 print_r("- pspReference: " . $result['pspReference'] . "\n");
 print_r("- resultCode: " . $result['resultCode']. "\n");
 print_r("- authCode: " . $result['authCode']. "\n");
 print_r("- refusalReason: " . $result['refusalReason']. "\n");

?>
