<?php
/**
 * Submit Recurring Payment using PHP Library
 *
 * You can submit a recurring payment using a specific recurringDetails record or by using the last created
 * recurringDetails record. The request for the recurring payment is done using a paymentRequest.
 * This file shows how a recurring payment can be submitted using our PHP Library.
 *
 * Please note: using our API requires a web service user. Set up your Webservice
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit
 *
 * @link	5.Recurring/Library/submit-recurring-payment.php
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

 $service = new Adyen\Service\Payment($client);

 /**
 * A recurring payment can be submitted by sending a PaymentRequest
 * to the authorise action, the request should contain the following
 * variables:
 *
 * - selectedRecurringDetailReference       : The recurringDetailReference you want to use for this payment.
 *                                          The value LATEST can be used to select the most recently created recurring detail.
 * - recurring                              : This should be the same value as recurringContract in the payment where the recurring
 *                                          contract was created. However if ONECLICK,RECURRING was specified initially
 *                                          then this field can be either ONECLICK or RECURRING.
 * - merchantAccount                        : The merchant account the payment was processed with.
 * - amount                                 : The amount of the payment
 * 	    - currency                          : the currency of the payment
 * 	    - value                             : the amount of the payment
 * - reference                              : Your reference
 * - shopperEmail                           : The e-mail address of the shopper
 * - shopperReference                       : The shopper reference, i.e. the shopper ID
 * - shopperInteraction                     : ContAuth for RECURRING or Ecommerce for ONECLICK
 * - fraudOffset                            : Numeric value that will be added to the fraud score (optional)
 * - shopperIP                              : The IP address of the shopper (optional)
 * - shopperStatement                       : Some acquirers allow you to provide a statement (optional)
 */

 $recurring = array('contract' => \Adyen\Contract::RECURRING,
 );

 $amount = array(
    "value" => 2400,
    "currency"=> "EUR"
 );

 $request = array(
    "selectedRecurringDetailReference" => "LATEST",
    "merchantAccount" => "YourMerchantAccount",
    "amount" => $amount,
    "reference" => "123456",
    "card" => $card,
    "shopperEmail" => "test@test.nl",
    "shopperReference" => "TheShopperreference",
    "recurring" => $recurring,
    "shopperInteraction" => "ContAuth"
 );

 $result = $service->authorise($request);

 /**
 * If the recurring payment message passes validation a risk analysis will be done and, depending on the
 * outcome, an authorisation will be attempted. You receive a
 * payment response with the following fields:
 * - pspReference                           : The reference we assigned to the payment;
 * - resultCode                             : The result of the payment. One of Authorised, Refused or Error;
 * - authCode                               : An authorisation code if the payment was successful, or blank otherwise;
 * - refusalReason                          : If the payment was refused, the refusal reason.
 */
 print_r("Payment Result:\n");
 print_r("- pspReference: " . $result['pspReference'] . "\n");
 print_r("- resultCode: " . $result['resultCode']. "\n");
 print_r("- authCode: " . $result['authCode']. "\n");
 print_r("- refusalReason: " . $result['refusalReason']. "\n");

