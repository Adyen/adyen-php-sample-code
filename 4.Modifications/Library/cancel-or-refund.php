<?php
/**
 * Cancel or Refund a Payment using PHP Library
 *
 * If you do not know if the payment is captured but you want to reverse
 * the authorisation you can send a modification request to the cancelOrRefund action
 * This file shows how a payment can be cancelled or refunded by a
 * modification request using PHP Library.
 *
 * Please note: using our API requires a web service user. Set up your Webservice
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit
 *
 * @link	4.Modifications/Library/cancel-or-refund.php
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

 $request = array(
    "merchantAccount" => "YourMerchantAccount",
    "originalReference" => "YourPspReference"
 );

 $result = $service->cancelOrRefund($request);

 /**
 * If the message was syntactically valid and merchantAccount is correct you will receive a
 * cancelOrRefundReceived response with the following fields:
 * - pspReference               : A new reference to uniquely identify this modification request.
 * - response                   : A confirmation indicating we received the request: [cancelOrRefund-received].
 *
 * If the payment is authorised, but not yet captured, it will be cancelled.
 * In other cases the payment will be fully refunded (if possible).
 *
 * Please note: The actual result of the cancel or refund is sent via a notification with eventCode CANCEL_OR_REFUND.
 */
 print_r("Modification Result:\n");
 print_r("- pspReference: " . $result['pspReference'] . "\n");
 print_r("- response: " . $result['response'] . "\n");