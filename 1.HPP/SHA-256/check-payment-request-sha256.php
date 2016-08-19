<?php
/**
 * HPP payment response url
 *
 * Whenever a payment is made, the shopper is redirected either to a default
 * or custom result page. Parameters are appended to this url to provide
 * a status and general information about the payment.
 *
 *
 * @link	1.HPP/check-payment-response-sha256.php
 * @author	Created by Adyen - Payments Made Easy
 */

/**
 * We recommend you to check the consistency of the URL parameters to ensure
 * that the data has not been tampered with, especially when you show
 * customer/order specific information on the result page, or make updates
 * to a back office system based on this data.
 * For this purpose, an HMAC is added to the query string parameters and can be
 * used to verify the data. The HMAC key which is set on the skin (used for
 * the initial payment request) is also used for the calculation of this result
 * URL parameter.
 * The two HMAC's are then compared in constant-time to prevent timing attacks.
 * Note that hash_equals is available from PHP >= 5.6.0. A secure polyfill can be
 * found on https://github.com/sarciszewski/php-future/
 *
 * Note:
 * When special characters are returned in the url, PHP automatically replace
 * them with underscores such as dots.
 * In some use cases, additional data is returned in the URL and contain dots
 * such as additionalData.acquirerReference when using klarna. These special
 * characters must be taken as it is for the merchant signature calculation.
 *
 */

  $hmacKey = "[Your shared Hmac key]";

  /*
    Function definition
  */

  // Function to preserve the original special character
  function fix($source) {
    $source = preg_replace_callback(
      '/(^|(?<=&))[^=[&]+/',
      function($key) {
        return bin2hex(urldecode($key[0]));
      },
      $source
    );

    parse_str($source, $post);
    return array_combine(array_map('hex2bin', array_keys($post)), $post);
  }

  //  Function to escape character
  $escapeval = function ($val) {
    return str_replace(':','\\:',str_replace('\\','\\\\',$val));
  };

  /*
    Extract the merchant signature and compare it with the one calculated
    based on the URL parameters
  */
  // Get and store all the URL parameters
  $params = fix($_SERVER['QUERY_STRING']);

  // Retrieve the merchantSig from the URL parameters
  $res_merchantSig = $params['merchantSig'];

  // Remove the merchantSig field for the signature calculation
  unset($params['merchantSig']);

  // Sort the array by key using SORT_STRING order
  ksort($params, SORT_STRING);

  // Generate the signing data string
  $signData = implode(":",array_map($escapeval,array_merge(array_keys($params),
    array_values($params))));

 /*
   Base64-encode the binary result of the HMAC computation
   Use constant-time comparison to compare the calculated signature with the signature from the URL parameters
 */
  if (hash_equals(base64_encode(hash_hmac('sha256', $signData, pack('H*', $hmacKey), true)), $res_merchantSig))
    print "Correct merchant signature";
  else
    print "Incorrect merchant signature";

?>
