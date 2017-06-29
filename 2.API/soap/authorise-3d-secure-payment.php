<?php
/**
 * Authorise 3D Secure payment (SOAP)
 * 
 * 3D Secure (Verifed by VISA / MasterCard SecureCode™) is an additional authentication
 * protocol that involves the shopper being redirected to their card issuer where their
 * identity is authenticated prior to the payment proceeding to an authorisation request.
 * 
 * In order to start processing 3D Secure transactions, the following changes are required:
 * 1. Your Merchant Account needs to be confgured by Adyen to support 3D Secure. If you would
 *    like to have 3D Secure enabled, please submit a request to the Adyen Support Team (support@adyen.com).
 * 2. Your integration should support redirecting the shopper to the card issuer and submitting
 *    a second API call to complete the payment.
 *
 * This example demonstrates the second API call to complete the payment using SOAP.
 * See the API Manual for a full explanation of the steps required to process 3D Secure payments.
 * 
 * Please note: using our API requires a web service user. Set up your Webservice user:
 * Adyen CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit
 * 
 * @link	2.API/soap/authorise-3d-secure-payment.php
 * @author	Created by Adyen
 */

 /**
  * Create SOAP Client = new SoapClient($wsdl,$options)
  * - $wsdl points to the wsdl you are using;
  * - $options[login] = Your WS user;
  * - $options[password] = Your WS user's password.
  * - $options[cache_wsdl] = WSDL_CACHE_BOTH, we advice 
  *   to cache the WSDL since we usually never change it.
  */
 $client = new SoapClient(
	"https://pal-test.adyen.com/pal/servlet/Payment/v25?wsdl", array(
		"login" => "YourWSUser",  
		"password" => "YourWSUserPassword",  
		"style" => SOAP_DOCUMENT,
		"encoding" => SOAP_LITERAL,
		"cache_wsdl" => WSDL_CACHE_BOTH,
		"trace" => 1
	)
 );
 
 /**
  * After the shopper's identity is authenticated by the issuer, they will be returned to your
  * site by sending an HTTP POST request to the TermUrl containing the MD parameter and a new
  * parameter called PaRes (see API manual). These will be needed to complete the payment.
  *
  * To complete the payment, a PaymentRequest3d should be submitted to the authorise3d action
  * of the web service. The request should contain the following variables:
  * 
  * - merchantAccount: This should be the same as the Merchant Account used in the original authorise request.
  * - browserInfo:     It is safe to use the values from the original authorise request, as they
  *                    are unlikely to change during the course of a payment.
  * - md:              The value of the MD parameter received from the issuer.
  * - paResponse:      The value of the PaRes parameter received from the issuer.
  * - shopperIP:       The IP address of the shopper. We recommend that you provide this data, as
  *                    it is used in a number of risk checks, for example, the number of payment
  *                    attempts and location based checks.
  */
  
try {
	$result = $client->authorise3d(array(
			"paymentRequest3d" => array(
				"merchantAccount" => "[YourMerchantAccount]",
				"browserInfo" => array(
					"userAgent" => $_SERVER['HTTP_USER_AGENT'],
					"acceptHeader" => $_SERVER['HTTP_ACCEPT']
				),
				"md" => $_POST['MD'],
				"paResponse" => $_POST['PaRes'],
				"shopperIP" => "123.123.123.123"
			)
		)
	);
	
	/**
	 * If the payment passes validation a risk analysis will be done and, depending on the
	 * outcome, an authorisation will be attempted. You receive a
	 * payment response with the following fields:
	 * - pspReference: The reference we assigned to the payment;
	 * - resultCode: The result of the payment. One of Authorised, Refused or Error;
	 * - authCode: An authorisation code if the payment was successful, or blank otherwise;
	 * - refusalReason: If the payment was refused, the refusal reason.
	 */ 
	print_r($result);

} catch(SoapFault $ex){
	print("<pre>");
	print($ex);
	print("<pre>");
}
