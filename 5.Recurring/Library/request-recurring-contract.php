<?php
/**
 * Request recurring contract details using PHP Library
 *
 * Once a shopper has stored RECURRING details with Adyen you are able to process
 * a RECURRING payment. This file shows you how to retrieve the RECURRING contract(s)
 * for a shopper using PHP Library.
 *
 * Please note: using our API requires a web service user. Set up your Webservice
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit
 *
 * @link	5.Recurring/Library/request-recurring-contract.php
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
 * - recurring->contract        : This should be the same value as recurringContract in the payment where the recurring
 *                              contract was created. However if ONECLICK,RECURRING was specified initially
 *                              then this field can be either ONECLICK or RECURRING.
 */

 $recurring = array('contract' => \Adyen\Contract::RECURRING);

 $request = array(
    "merchantAccount" => "YourMerchantAccount",
    "shopperReference" => "ref",
    "recurring" => $recurring
 );

 $result = $service->listRecurringDetails($request);

 /**
 * The response will be a result with a list of zero or more details containing at least the following:
 * - recurringDetailReference   : The reference the details are stored under.
 * - variant                    : The payment method (e.g. mc, visa, elv, ideal, paypal)
 * - creationDate               : The date when the recurring details were created.
 *
 * The recurring contracts are stored in the same object types as you would have
 * submitted in the initial payment.
 */
 print_r($result);