<?php
/**
 * Create Payment URL
 * 
 * The Adyen Hosted Payment Pages (HPPs) provide a flexible, secure 
 * and easy way to allow shoppers to pay for goods or services. This
 * example shows a page which creates a payment by a URL. The link provided
 * by this example can for instance be send by e-mail to create a payment. 
 * 
 * @link  1.HPP/create-payment-url.php 
 * @author  Created by Adyen - Payments Made Easy
 */
 
 /**
  * Defining variables
  * The HPP requires certain variables to be posted in order to create
  * a payment possibility for the shopper.   
  * 
  * The variables that you can post to the HPP are the following:
  * 
  * $merchantReference  : The merchant reference is your reference for the payment
  * $paymentAmount    : Amount specified in minor units EUR 1,00 = 100
  * $currencyCode   : The three-letter capitalised ISO currency code to pay in i.e. EUR
  * $shipBeforeDate   : The date by which the goods or services are shipped.
  *             Format: YYYY-MM-DD;
  * $skinCode     : The skin code that should be used for the payment
  * $merchantAccount  : The merchant account you want to process this payment with.
  * $sessionValidity  : The final time by which a payment needs to have been made. 
  *             Format: YYYY-MM-DDThh:mm:ssTZD
  * $shopperLocale    : A combination of language code and country code to specify 
  *             the language used in the session i.e. en_GB.
  * $orderData      : A fragment of HTML/text that will be displayed on the HPP (optional)
  * $countryCode    : Country code according to ISO_3166-1_alpha-2 standard  (optional)
  * $shopperEmail   : The e-mailaddress of the shopper (optional)
  * $shopperReference : The shopper reference, i.e. the shopper ID (optional)
  * $allowedMethods   : Allowed payment methods separeted with a , i.e. "ideal,mc,visa" (optional)
  * $blockedMethods   : Blocked payment methods separeted with a , i.e. "ideal,mc,visa" (optional)
  * $offset       : Numeric value that will be added to the fraud score (optional)
  * $merchantSig    : The HMAC signature used by Adyen to test the validy of the form;
  */
 
  $request = array(  
  "merchantReference" => "TEST-PAYMENT-" . date("Y-m-d-H:i:s"),
  "paymentAmount" => "199",
  "currencyCode" => "EUR",  
  "shipBeforeDate" => date("Y-m-d",strtotime("+3 days")),
  "skinCode" => "YourSkinCode", 
  "merchantAccount" => "YourMerchantAccount",
  "sessionValidity" => date("c",strtotime("+1 days")),
  "shopperLocale" => "en_US",
  "orderData" => base64_encode(gzencode("Orderdata to display on the HPP can be put here")),
  "countryCode" => "NL",
  "shopperEmail" => "",
  "shopperReference" => "", 
  "allowedMethods" => "",
  "blockedMethods" => "", 
  "offset" => "",
  "merchantSig" => ""
  );

  /**
   * Signing the form
   * 
   * The merchant signature is used by Adyen to verify if the posted data is not
   * altered by the shopper. The signature must be encrypted according to the procedure below.
   * If you're running PHP 5 >= 5.1.2, PECL hash >= 1.1 you can use hash_hmac(), if you don't
   * you can use HMAC Pear (http://pear.php.net/package/Crypt_HMAC/download)
   * 
   * Please note: the signature does contain more variables, in this example
   * they are NOT required since they are empty. Please have a look at the
   * advanced HPP example.
   */ 
  
  // HMAC Key is a shared secret KEY used to encrypt the signature. Set up the HMAC 
  // key: Adyen Test CA >> Skins >> Choose your Skin >> Edit Tab >> Edit HMAC key for Test and Live 
  $hmacKey = "YourHmacSecretKey";  
  
  $request["merchantSig"] = base64_encode(pack("H*",hash_hmac(
    'sha1',
  $request["paymentAmount"] . $request["currencyCode"] . $request["shipBeforeDate"] . $request["merchantReference"] . 
  $request["skinCode"] . $request["merchantAccount"] . $request["sessionValidity"] . $request["shopperEmail"] . 
  $request["shopperReference"] . $request["allowedMethods"] . $request["blockedMethods"] . $request["offset"],
  $hmacKey
  )));
   
  $url = "https://test.adyen.com/hpp/pay.shtml?";
  foreach($request as $field => $value)
  $url .= "&".$field."=".urlencode($value);
  
  // Please note that printing $url in the browser does some encoding to the URL causing 
  // it not to work, it should work putting $url in a link.
?>
<a href="<?php echo $url ?>" target="_blank">
  Pay!
</a>

