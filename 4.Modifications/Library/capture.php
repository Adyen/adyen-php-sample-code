<?php
 /**
 * Capture a Payment using PHP Library
 *
 * Authorised (card) payments can be captured to get the money from the shopper.
 * Payments can be automatically captured by our platform. A payment can
 * also be captured by performing an API call. In order to capture an authorised
 * (card) payment you have to send a modification request. This file
 * shows how an authorised payment should be captured by sending
 * a modification request using PHP Library.
 *
 * Please note: using our API requires a web service user. Set up your Webservice
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit
 *
 * @link	4.Modifications/Library/capture.php
 * @author	Created by Adyen - Payments Made Easy
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
 $service = new Adyen\Service\Modification($client);

/**
 * Perform capture request by sending in a
 * modificationRequest. The following parameters are used:
 * - merchantAccount            : The merchant account the payment was processed with.
 * - modificationAmount         : The amount to capture
 * 	    - currency              : the currency must match the original payment
 * 	    - value                 : the value must be the same or less than the original amount
 * - originalReference          : This is the pspReference that was assigned to the authorisation
 * - reference                  : If you wish, you can assign your own reference or description to the modification.
 */

 $modificationAmount = array(
    "value" => 1400,
    "currency"=> "EUR"
 );

 $request = array(
    "modificationAmount" => $modificationAmount,
    "merchantAccount" => "YourMerchantAccount",
    "originalReference" => "YourPspReference"
 );

 $result = $service->capture($request);

/**
 * If the message was syntactically valid and merchantAccount is correct you will
 * receive a captureResult response with the following fields:
 * - pspReference               : A new reference to uniquely identify this modification request.
 * - response                   : A confirmation indicating we received the request: [capture-received].
 *
 * Please note: The result of the capture is sent via a notification with eventCode CAPTURE.
 */

 print_r("Modification Result:\n");
 print_r("- pspReference: " . $result['pspReference'] . "\n");
 print_r("- response: " . $result['response'] . "\n");


?>