<?php
 /**
 * Get Payment Methods
 *
 * Optionally the payment method selection page can be skipped, so the shopper
 * starts directly on the payment details entry page. This is done by calling
 * details.shtml instead of select.shtml. A further parameter, brandCode,
 * should be supplied with the payment method chosen (see Payment Methods section
 * for more details, but note that the group values are not valid).
 *
 * The directory service can also be used to request which payment methods
 * are available for the shopper on your specific merchant account.
 * This is done by calling directory.shtml with a normal payment request.
 * This file provides a code example showing how to retreive the
 * payment methods enabled for the specified merchant account.
 *
 * Please note that the countryCode field is mandatory to receive
 * back the correct payment methods.
 *
 * @link	6.PaymentMethods/Library/get-payment-methods.php
 * @author	Created by Adyen - Payments Made Easy
 */

 /**
 * Client settings
 * - Client
 *      ->setEnvironment        : The Environment you are using (\Adyen\Environment::TEST or \Adyen\Environment::LIVE)
 */
 $client = new \Adyen\Client();
 $client->setEnvironment(\Adyen\Environment::TEST);

 $service = new Adyen\Service\DirectoryLookup($client);

/**
 * Payment Request
 * The following fields are required for the directory
 * service.
 */
 $request = array(
    "paymentAmount" => "1000",
    "currencyCode" => "EUR",
    "merchantReference" => "Get Payment methods",
    "skinCode" => "YourSkinCode",
    "merchantAccount" => "YourMerchantAccount",
    "sessionValidity"   => date("c",strtotime("+1 days")),
    "countryCode"       => "NL",
    "shopperLocale" => "nl_NL"
 );

 $hmacKey = "YourHMACKey";

 $request["merchantSig"] = Adyen\Util\Util::calculateSha256Signature($hmacKey, $request);

 $result = $service->directoryLookup($request);

 /**
 * The $result contains a JSON array containing
 * the available payment methods for the merchant account.
 */
print_r($result);
