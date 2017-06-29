<?php
 /**
 * Cancel a Payment using PHP Library
 *
 * In order to cancel an authorised (card) payment you send a modification
 * request to the cancel action. This file shows how an authorised payment
 * should be canceled by sending a modification request using PHP Library.
 *
 * Please note: using our API requires a web service user. Set up your Webservice
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit
 *
 * @link	4.Modifications/Library/cancel.php
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
 * Perform cancel request by sending in a
 * modificationRequest. The following parameters are used:
 * - merchantAccount            : The merchant account the payment was processed with.
 * - originalReference          : This is the pspReference that was assigned to the authorisation
 */
 $request = array(
    "merchantAccount" => "YourMerchantAccount",
    "originalReference" => "YourPspReference"
 );

 $result = $service->cancel($request);

 /**
 * If the message was syntactically valid and merchantAccount is correct you will
 * receive a cancelReceived response with the following fields:
 * - pspReference               : A new reference to uniquely identify this modification request.
 * - response                   : A confirmation indicating we received the request: [cancel-received].
 *
 * Please note: The result of the cancellation is sent via a notification with eventCode CANCELLATION.
 */
 print_r("Modification Result:\n");
 print_r("- pspReference: " . $result['pspReference'] . "\n");
 print_r("- response: " . $result['response'] . "\n");


?>