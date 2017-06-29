<?php
 /**
 * Create Client-Side Encryption Payment (PHP Library)
 *
 * Merchants that require more stringent security protocols or do not want the additional overhead
 * of managing their PCI compliance, may decide to implement Client-Side Encryption (CSE).
 * This is particularly useful for Mobile payment flows where only cards are being offered, as
 * it may result in faster load times and an overall improvement to the shopper flow.
 * The Adyen Hosted Payment Page (HPP) provides the most comprehensive level of PCI compliancy
 * and you do not have any PCI obligations. Using CSE reduces your PCI scope when compared to
 * implementing the API without encryption.
 *
 * If you would like to implement CSE, please provide the completed PCI Self Assessment Questionnaire (SAQ)
 * A to the Adyen Support Team (support@adyen.com). The form can be found here:
 * https://www.pcisecuritystandards.org/security_standards/documents.php?category=saqs
 *
 * Please note: using our API requires a web service user. Set up your Webservice
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit
 *
 * @link	2.API/Library/create-payment-cse.php
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
 * The payment can be submitted by sending a PaymentRequest
 * to the authorise action of the web service, the request should
 * contain the following variables:
 * - merchantAccount            : The merchant account the payment was processed with.
 * - amount
 * 	    - currency              : the currency of the payment
 * 	    - amount                : the amount of the payment
 * - reference                  : Your reference
 * - shopperIP                  : The IP address of the shopper (optional/recommended)
 * - shopperEmail               : The e-mail address of the shopper
 * - shopperReference           : The shopper reference, i.e. the shopper ID
 * - fraudOffset                : Numeric value that will be added to the fraud score (optional)
 * - additionalData
 *      - card.encrypted.json   : The encrypted card catched by the POST variables.
 */

 $amount = array(
    "value" => 1326,
    "currency"=> "EUR"
 );

 $additionalData = array(
     "card.encrypted.json" => "YourCSEToken"
 );

 $request = array(
    "merchantAccount" => "YourMerchantAccount",
    "browserInfo" => $browserInfo,
    "amount" => $amount,
    "reference" => "YourReference",
    "additionalData" => $additionalData
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