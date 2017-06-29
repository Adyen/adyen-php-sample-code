<?php
/**
 * Create 3D Secure payment (PHP Library)
 *
 * 3D Secure (Verifed by VISA / MasterCard SecureCode™) is an additional authentication
 * protocol that involves the shopper being redirected to their card issuer where their
 * identity is authenticated prior to the payment proceeding to an authorisation request.
 *
 * In order to start processing 3D Secure transactions, the following changes are required:
 * 1. Your Merchant Account needs to be confgured by Adyen to support 3D Secure. If you would
 *    like to have 3D Secure enabled, please submit a request to the Adyen Support Team (support@adyen.com).
 * 2. Your integration should support redirecting the shopper to the card issuer and submitting
 *    a second API call to complete the payment.
 *
 * This example demonstrates the initial API call to create the 3D secure payment using PHP Library,
 * and shows the redirection the the card issuer.
 * See the API Manual for a full explanation of the steps required to process 3D Secure payments.
 *
 * @link	2.API/Library/create-3d-secure-payment.php
 * @author	Created by Adyen
 */

 /**
 * Client settings
 * - Client
 *      ->setUsername            : your web service user
 *      ->setPassword            : your web service user's password
 *      ->setEnvironment         : The Environment you are using (\Adyen\Environment::TEST or \Adyen\Environment::LIVE)
 *      ->setApplicationName     : your application name
 */
 $client = new \Adyen\Client();
 $client->setUsername("YourWSUser");
 $client->setPassword("YourWSPassword");
 $client->setEnvironment(\Adyen\Environment::TEST);
 $client->setApplicationName("My Test Application");

 // initialize service
 $service = new Adyen\Service\Payment($client);

 /**
 * A payment can be submitted by sending a PaymentRequest to the authorise action of the web service.
 * The initial API call for both 3D Secure and non-3D Secure payments is almost identical.
 * However, for 3D Secure payments, you must supply the browserInfo object as a sub-element of the payment request.
 * This is a container for the acceptHeader and userAgent of the shopper's browser.
 *
 * The request should contain the following variables:
 *
 * - merchantAccount           : The merchant account for which you want to process the payment
 * - amount
 *     - currency              : The three character ISO currency code.
 *     - value                 : The transaction amount in minor units (e.g. EUR 1,00 = 100).
 * - reference                 : Your reference for this payment.
 * - shopperIP                 : The shopper's IP address. (recommended)
 * - shopperEmail              : The shopper's email address. (recommended)
 * - shopperReference          : An ID that uniquely identifes the shopper, such as a customer id. (recommended)
 * - fraudOffset               : An integer that is added to the normal fraud score. (optional)
 * - card
 *     - expiryMonth           : The expiration date's month written as a 2-digit string,
 *                               padded with 0 if required (e.g. 03 or 12).
 *     - expiryYear            : The expiration date's year written as in full (e.g. 2016).
 *     - holderName            : The card holder's name, as embossed on the card.
 *     - number                : The card number.
 *     - cvc                   : The card validation code, which is the CVC2 (MasterCard),
 *                               CVV2 (Visa) or CID (American Express).
 * - billingAddress (recommended)
 *     - street                : The street name.
 *     - houseNumberOrName     : The house number (or name).
 *     - city                  : The city.
 *     - postalCode            : The postal/zip code.
 *     - stateOrProvince       : The state or province.
 *     - country               : The country in ISO 3166-1 alpha-2 format (e.g. NL).
 * - browserInfo
 *     - userAgent             : The user agent string of the shopper's browser (required).
 *     - acceptHeader          : The accept header string of the shopper's browser (required).
 */

 $card = array(
    "number" =>  "6731012345678906",
    "expiryMonth" =>  "08",
    "expiryYear" =>  "2018",
    "cvc" =>  "737",
    "holderName" =>  "John Doe"
 );

 $amount = array(
    "value" => 1400,
    "currency"=> "EUR"
 );

 $browserInfo = array(
    "userAgent" => $_SERVER['HTTP_USER_AGENT'],
    "acceptHeader" => $_SERVER['HTTP_ACCEPT']
 );

 $request = array(
    "merchantAccount" => "YourMerchantAccount",
    "amount" => $amount,
    "reference" => "YourReference",
    "card" => $card,
    "browserInfo" => $browserInfo
 );

 $result = $service->authorise($request);

 /**
 * Once your account is confgured for 3-D Secure, the Adyen system performs a directory
 * inquiry to verify that the card is enrolled in the 3-D Secure programme.
 * If it is not enrolled, the response is the same as a normal API authorisation.
 * If, however, it is enrolled, the response contains these fields:
 *
 * - paRequest     : The 3-D request data for the issuer.
 * - md            : The payment session.
 * - issuerUrl     : The URL to direct the shopper to.
 * - resultCode    : The resultCode will be RedirectShopper.
 *
 * The paRequest and md fields should be included in an HTML form, which needs to be submitted
 * using the HTTP POST method to the issuerUrl. You must also include a termUrl parameter
 * in this form, which contains the URL on your site that the shopper will be returned to
 * by the issuer after authentication. In this example we are redirecting to another example
 * which completes the 3D Secure payment.
 *
 * @see  2.API/Library/authorise-3d-secure-payment.php
 *
 * We recommend that the form is "self-submitting" with a fallback in case javascript is disabled.
 * A sample form is shown below.
 */
 print_r("3d Payment Request:\n");
 print_r("- paRequest: " . $result['paRequest'] . "\n");
 print_r("- md: " . $result['md'] . "\n");
 print_r("- issuerUrl: " . $result['issuerUrl'] . "\n");
 print_r("- resultCode: " . $result['resultCode'] . "\n");


?>