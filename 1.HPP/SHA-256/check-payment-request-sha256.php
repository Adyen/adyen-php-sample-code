<?php
/**
 * HPP payment response url
 * 
 * Whenever a payment is made, the shopper is redirected either to a default 
 * or custom result page. Parameters are appended to this url to provide 
 * a status and general infoamtion about the payment.  
 *
 *  
 * @link    1.HPP/check-payment-response-sha256.php 
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
  );

  // merchantReturnData used for the signature calculation only when available
  if (!empty($_GET['merchantReturnData']))
    $params["merchantReturnData"] = $_GET['merchantReturnData'];

  //  Function to escape character
  $escapeval = function($val) {
    return str_replace(':','\\:',str_replace('\\','\\\\',$val));
  };

  // Sort the array by key using SORT_STRING order
  ksort($params, SORT_STRING);

  // Generate the signing data string
  $signData = implode(":",array_map($escapeval,array_merge(array_keys($params),
    array_values($params))));

  // base64-encode the binary result of the HMAC computation
  $merchantSig = base64_encode(hash_hmac('sha256',$signData,pack("H*" , $hmacKey),true));

  // Compare the calculated signature with the signature from the URL parameters
  if ($merchantSig == $res_merchantSig)
    print "Correct merchant signature";
  else
    print "Incorrect merchant signature";

?>
