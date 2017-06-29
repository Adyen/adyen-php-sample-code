<?php
 /**
 * Refund a Payment using PHP Library
 *
 * Settled payments can be refunded by sending a modifiction request
 * to the refund action. This file shows how a settled payment
 * can be refunded by sending a modification request using PHP Library.
 *
 * Please note: using our API requires a web service user. Set up your Webservice
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit
 *
 * @link	4.Modifications/Library/refund.php
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
 * Perform refund request by sending in a
 * modificationRequest. The following parameters are used:
 * - merchantAccount            : The merchant account the payment was processed with.
 * - modificationAmount         : The amount to refund
 * 	    - currency              : the currency must match the original payment
 *  	- value                 : the value must be the same or less than the original amount
 * - originalReference          : This is the pspReference that was assigned to the authorisation
 * - reference                  : If you wish, you can to assign your own reference or description to the modification.
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

 $result = $service->refund($request);

 /**
 * If the message was syntactically valid and merchantAccount is correct you will
 * receive a refundReceived response with the following fields:
 * - pspReference               : A new reference to uniquely identify this modification request.
 * - response                   : A confirmation indicating we received the request: [refund-received].
 *
 * Please note: The result of the refund is sent via a notification with eventCode REFUND.
 */
 print_r("Modification Result:\n");
 print_r("- pspReference: " . $result['pspReference'] . "\n");
 print_r("- response: " . $result['response'] . "\n");

?>