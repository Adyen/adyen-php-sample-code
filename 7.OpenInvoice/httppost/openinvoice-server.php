<?php
/**
 * Open Invoice Server using HTTP Post
 * 
 * Open Invoice lowers the barrier substantially for shoppers to buy products on a 
 * merchant's website. By providing their personal data, like address and date of birth, 
 * an assessment is made if we allow the shopper to receive the product before the payment 
 * is made. The invoice is shipped along with the product. When the invoice is not paid and 
 * the goods are not returned the merchant has the option to turn the invoice over to a 
 * debt collection agency. 
 *
 * Please note that the Open Invoice paymentmethod is available in a limited number 
 * of countries and not enabled by default. If you like to enable it, please contact Adyen Support.
 *
 * How does the Open Invoice process works?
 * 1. A payment is created by sending in delivery- and billing address. See 1.HPP/create-payment-on-hpp-advanced.php
 *    on how to provide that in advance. Adyen sends a request to your Open Invoice service to 
 *    retrieve the order lines associated with the payment. 
 * 2. The merchant's Open Invoice server returns the order lines;
 * 3. Adyen receives the order lines and once the shopper passes the risk checks, the payment will be Authorised.
 * 4. The merchant send the goods to the shopper and Captures the payment, by sending a regular capture
 *    request, see 4.Modifications/httppost/capture.php on how to do that.
 * 5. Adyen sends another request to the open invoice service to request the order lines; 
 * 
 * Please note: using our API requires a web service user. Set up your Webservice 
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit 
 *
 * @link	7.OpenInvoice/httppost/openinvoice-server.php 
 * @author	Created by Adyen - Payments Made Easy
 */

/**
 * $_POST
 * The variable $_POST will contain the following key/values:
 * $_POST[openInvoiceDetailRequest_amount_currency]: Currency of the payment
 * $_POST[openInvoiceDetailRequest_amount_value]: the value in minor units so EUR 1,00 = 100
 * $_POST[openInvoiceDetailRequest_merchantAccount]: The merchant account the payment was processed with;
 * $_POST[openInvoiceDetailRequest_reference]: The merchant reference of the payment, which should be used to
 * find the order in your system. 
 *
 * Implementation of the action retrieveDetail which will be called by Adyen. 
 * The action retrieveDetail will be called by Adyen in the following scenarios:
 * 1. Authorisation: When the initial payment is created Adyen will request the order lines.
 * 2. Capture: When the payment is captured Adyen will request the order lines, it is possible
 *    to capture less money than the initial payment.
 * 3. Refund: If the money is already collected but the shopper should be credited the refund 
 *    option refunds (part of) the transaction amount. If the money is already collected but the 
 *    shopper should be credited the refund option refunds (part of) the transaction amount. 
 *
 */
 
 // this needs to be an empty string as Adyen can fail with a 115 response.
 $orderLines = ''; 
 
 /**
  * Authorisation / Capture
  * Let's assume the shopper paid EUR 50,00 for 2 products, the retrieveDetail
  * action was called with and the following order lines were returned. Please note
  * that the total amount should be equal to $request->request->amount->value in 
  * the same currency. 
  */
 if($_POST[openInvoiceDetailRequest_amount_value] > 0){
 	
 	$orderLines .= "openInvoiceDetailResult.lines.0.itemPrice=2000&" .
 	$orderLines .= "openInvoiceDetailResult.lines.0.itemVAT=500&" .
 	$orderLines .= "openInvoiceDetailResult.lines.0.numberOfItems=1&" .
 	$orderLines .= "openInvoiceDetailResult.lines.0.description=Product1&" .
 	$orderLines .= "openInvoiceDetailResult.lines.0.currency=EUR&" .
 	$orderLines .= "openInvoiceDetailResult.lines.0.lineReference=1&" .
 	$orderLines .= "openInvoiceDetailResult.lines.0.vatCategory=High&" .
 	$orderLines .= "openInvoiceDetailResult.lines.1.itemPrice=2000&" .
 	$orderLines .= "openInvoiceDetailResult.lines.1.itemVAT=500&" .
 	$orderLines .= "openInvoiceDetailResult.lines.1.numberOfItems=1&" .
 	$orderLines .= "openInvoiceDetailResult.lines.1.description=Product2&" .
 	$orderLines .= "openInvoiceDetailResult.lines.1.currency=EUR&" .
 	$orderLines .= "openInvoiceDetailResult.lines.1.lineReference=2&" .
 	$orderLines .= "openInvoiceDetailResult.lines.1.vatCategory=None";
 
 }
 /**
  * Refund
  * The value of the $request is negative, this indicates a refund. Assuming the merchant 
  * knows which product the shopper wants to refund your open invoice service
  * knows how to respond to the request. In this case the shopper likes to receive a refund
  * for product 2, which requires the open invoice service to return the order line that 
  * specifies product 2. Please not numberOfItems is negative (-1). 
  */
 else{
 	$orderLines .= "openInvoiceDetailResult.lines.0.itemPrice=2000&" .
 	$orderLines .= "openInvoiceDetailResult.lines.0.itemVAT=500&" .
 	$orderLines .= "openInvoiceDetailResult.lines.0.numberOfItems=-1&" .
 	$orderLines .= "openInvoiceDetailResult.lines.0.description=Product2&" .
 	$orderLines .= "openInvoiceDetailResult.lines.0.currency=EUR&" .
 	$orderLines .= "openInvoiceDetailResult.lines.0.lineReference=1&" .
 	$orderLines .= "openInvoiceDetailResult.lines.0.vatCategory=High";
 }
 
 // trailing or leading whitespace can cause failure with a 115 error. 
 print trim($orderLines);
