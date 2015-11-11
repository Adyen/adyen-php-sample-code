<?php
/**
 * HPP payment response url
 * 
 * Whenever a payment is made, the shopper is redirected either to a default 
 * or custom result page. Parameters are appended to this url to provide 
 * a status and general infoamtion about the payment.  
 *
 *  
 * @link    1.HPP/check-payment-response.php 
 * @author	Created by Adyen - Payments Made Easy
 */
 
/**
 * The variabele $_GET contains an array including 
 * the following keys when avaialble:
 * 
 * $_GET['authResult']
 * $_GET['merchantReference']
 * $_GET['paymentMethod']
 * $_GET['pspReference']
 * $_GET['shopperLocale']
 * $_GET['skinCode']
 * $_GET['merchantReturnData']
 * 
 * 
 * We recommend you to check the consistency of the URL parameters to esure
 * that the data has not been tampered with. 
 * The merchantSig parameter allows you to check it since it is computed using
 * the URL parameters and the HMAC key, same key you used to make the original
 * payment request on our HPP.
 *
 */

  $hmacKey = "[Your shared Hmac key]"; 

  // Retrieve the URL parameters
  $res_merchantSig = $_GET['merchantSig'];
  $params = array(
    "authResult" => $_GET['authResult'],
    "merchantReference" => $_GET['merchantReference'],
    "paymentMethod" => $_GET['paymentMethod'],
    "pspReference" => $_GET['pspReference'],
    "shopperLocale" => $_GET['shopperLocale'],
    "skinCode" => $_GET['skinCode'],
    "merchantReturnData" => $_GET['merchantReturnData'],
  );

  // Calculate the expected merchant signature using these URL parameters
  $merchantSig = base64_encode(pack("H*",hash_hmac('sha1',
  	$params['authResult'] . $params['pspReference'] . $params['merchantReference'] . 
  	$params['skinCode'] . $params['merchantReturnData'], 
  	$hmacKey)));

  // Compare the calculated signature with the signature from the URL parameters
  if ($merchantSig == $res_merchantSig)
    print "Correct merchant signature";
  else
    print "Incorrect merchant signature";

?>
