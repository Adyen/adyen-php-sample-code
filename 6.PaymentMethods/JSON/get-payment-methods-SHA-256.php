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
 * @link	6.PaymentMethods/JSON/get-payment-methods-SHA-256.php
 * @author	Created by Adyen - Payments Made Easy
 */

 /**
  * Payment Request
  * The following fields are required for the directory 
  * service. 
  */
$skinCode        = "YourSkinCode";
$merchantAccount = "YourMerchantAccount";
$hmacKey         = "YourHMACKey";

$request = array(
                "paymentAmount"     => "199",
                "currencyCode"      => "EUR",
                "merchantReference" => "Unique Merchant Reference",
                "skinCode"          =>  $skinCode,
                "merchantAccount"   =>  $merchantAccount,
                "sessionValidity"   => date("c",strtotime("+1 days")),
                "countryCode"       => "NL",
);
 
// Calculation of SHA-256

// The character escape function
$escapeval = function($val) {
    return str_replace(':','\\:',str_replace('\\','\\\\',$val));
};

// Sort the array by key using SORT_STRING order
ksort($request, SORT_STRING);

// Generate the signing data string
$signData = implode(":",array_map($escapeval,array_merge(array_keys($request), array_values($request))));

// base64-encode the binary result of the HMAC computation
$merchantSig = base64_encode(hash_hmac('sha256',$signData,pack("H*" , $hmacKey),true));
$request["merchantSig"] = $merchantSig;

 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, "https://test.adyen.com/hpp/directory.shtml");
 curl_setopt($ch, CURLOPT_HEADER, false);
 curl_setopt($ch, CURLOPT_POST,count($request));
 curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($request));
 curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
 
 $result = curl_exec($ch);
 
 if($result === false)
	echo "Error: " . curl_error($ch);
 else{
	/**
	 * The $result contains a JSON array containing
	 * the available payment methods for the merchant account.
	 */ 
	print_r($result);
 }
 
 curl_close($ch);

?>
