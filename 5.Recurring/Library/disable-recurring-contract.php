<?php
/**
 * Disable recurring contract using PHP Library
 *
 * Disabling a recurring contract (detail) can be done by calling the disable action
 * on the Recurring service with a request. This file shows how you can disable
 * a recurring contract using PHP Library.
 *
 * Please note: using our API requires a web service user. Set up your Webservice
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit
 *
 * @link	5.Recurring/Library/disable-recurring-contract.php
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

 $service = new Adyen\Service\Recurring($client);

 /**
 * The request should contain the following variables:
 * - merchantAccount            : The merchant account the payment was processed with.
 * - shopperReference           : The reference to the shopper. This shopperReference must be the same as the
 *                              shopperReference used in the initial payment.
 * - recurringDetailReference   : The recurringDetailReference of the details you wish to
 *                              disable. If you do not supply this field all details for the shopper will be disabled
 *                              including the contract! This means that you can not add new details anymore.
 */
 $request = array(
    "merchantAccount" => "YourMerchantAccount",
    "shopperReference" => "TheShopperreference",
    "recurringDetailReference" => "TheReferenceToTheContract"
 );

 $result = $service->disable($request);

 /**
 * The response will be a result object with a single field response. If a single detail was
 * disabled the value of this field will be [detail-successfully-disabled] or, if all
 * details are disabled, the value is [all-details-successfully-disabled].
 */
 print_r($result);