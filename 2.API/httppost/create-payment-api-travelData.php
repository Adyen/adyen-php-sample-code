<?php
/**
 * Create Payment through the API (HTTP Post)
 * 
 * Payments can be created through our API, however this is only possible if you are
 * PCI Compliant. HTTP Post payments are submitted using the Payment.authorise action. 
 * We will explain a simple credit card submission. 
 * 
 * Please note: using our API requires a web service user. Set up your Webservice 
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit 
 *  
 * @link	2.API/httppost/create-payment-api.php 
 * @author	Created by Adyen - Payments Made Easy
 */ 
 
 /**
  * A payment can be submitted by sending a PaymentRequest 
  * to the authorise action of the web service, the request should 
  * contain the following variables:
  * 
  * - merchantAccount: The merchant account the payment was processed with.
  * - amount: The amount of the payment
  * 	- currency: the currency of the payment
  * 	- amount: the amount of the payment
  * - reference: Your reference
  * - shopperIP: The IP address of the shopper (optional/recommended)
  * - shopperEmail: The e-mail address of the shopper 
  * - shopperReference: The shopper reference, i.e. the shopper ID
  * - fraudOffset: Numeric value that will be added to the fraud score (optional)
  * - card
  * 	- billingAddress: we advice you to submit billingAddress data if available for risk checks;
  * 		- street: The street name
  * 		- postalCode: The postal/zip code.
  * 		- city: The city
  * 		- houseNumberOrName:
  * 		- stateOrProvince: The house number
  * 		- country: The country
  * 	- expiryMonth: The expiration date's month written as a 2-digit string, padded with 0 if required (e.g. 03 or 12).
  * 	- expiryYear: The expiration date's year written as in full. e.g. 2016.
  * 	- holderName: The card holder's name, aas embossed on the card.
  * 	- number: The card number.
  * 	- cvc: The card validation code. This is the the CVC2 code (for MasterCard), CVV2 (for Visa) or CID (for American Express).
  */
  
 $request = array(
  "merchantAccount" => "YourMerchantAccount",   
	"amount.currency" => "EUR",
	"amount.value" => "199",
	"reference" => "TEST-PAYMENT-" . date("Y-m-d-H:i:s"),
	"shopperIP" => "ShopperIPAddress",
	"shopperEmail" => "TheShopperEmailAddress",
	"shopperReference" => "YourReference",
	"fraudOffset" => "0",
	
	"card.billingAddress.street" => "Simon Carmiggeltstraat",
	"card.billingAddress.postalCode" => "1011 DJ",
	"card.billingAddress.city" => "Amsterdam",
	"card.billingAddress.houseNumberOrName" => "6-50",
	"card.billingAddress.stateOrProvince" => "",
	"card.billingAddress.country" => "NL",
	
	"card.expiryMonth" => "08",
	"card.expiryYear" => "2018",
	"card.holderName" => "The Holder Name Here",
	"card.number" => "5555444433331111",
	"card.cvc" => "737",
   
  /*Optional Airline Data*/
	  "airline.passenger_name" => "Kate Winslet",
	  "additionalData.airline.ticket_number" => "12311023213534",
	  "additionalData.airline.airline_code" => "123",
	  "additionalData.airline.travel_agency_code" => "65432346",
	  "additionalData.airline.travel_agency_name" => "UNKNOWN",
	  "additionalData.airline.customer_reference_number" => "JF7RED",
	  "additionalData.airline.ticket_issue_address" => "AMS",
	  "additionalData.airline.boarding_fee" => "12",
	  "additionalData.airline.airline_designator_code" => "AA",
	  "additionalData.airline.agency_plan_name" => "AA",
	  "additionalData.airline.agency_invoice_number" => "160170",
	  "additionalData.airline.flight_date" => "2018-02-19 00:00",
	  "additionalData.airline.passenger1.first_name" => "Kate",
	  "additionalData.airline.passenger1.last_name" => "Winslet",
	  "additionalData.airline.passenger1.traveller_type" => "ADT",
	  "additionalData.airline.passenger1.date_of_birth" => "1980-05-02",
	  "additionalData.airline.passenger1.phone_number" => "0031641212345",
	  "additionalData.airline.passenger2.first_name" => "Peter",
	  "additionalData.airline.passenger2.last_name" => "Pan",
	  "additionalData.airline.passenger2.traveller_type" => "ADT",
	  "additionalData.airline.passenger2.date_of_birth" => "1980-05-02",
	  "additionalData.airline.passenger2.phone_number" => "0031641212345",
	  "additionalData.airline.leg1.depart_airport" => "HKG",
	  "additionalData.airline.leg1.flight_number" => "364",
	  "additionalData.airline.leg1.carrier_code" => "AA",
	  "additionalData.airline.leg1.fare_base_code" => "EYRDST",
	  "additionalData.airline.leg1.class_of_travel" => "E",
	  "additionalData.airline.leg1.stop_over_code" => "0",
	  "additionalData.airline.leg1.destination_code" => "AMS",
	  "additionalData.airline.leg1.date_of_travel" => "2018-02-19 00:00",
	  "additionalData.airline.leg1.depart_tax" => "396.00",
	  "additionalData.airline.leg2.depart_airport" => "PVG",
	  "additionalData.airline.leg2.flight_number" => "369",
	  "additionalData.airline.leg2.carrier_code" => "AA",
	  "additionalData.airline.leg2.fare_base_code" => "EYRDST",
	  "additionalData.airline.leg2.class_of_travel" => "E",
	  "additionalData.airline.leg2.stop_over_code" => "0",
	  "additionalData.airline.leg2.destination_code" => "LTN",
	  "additionalData.airline.leg2.date_of_travel" => "2018-02-20 00:00",
	  "additionalData.airline.leg2.depart_tax" => "1000",
	  /* Optional Lodging Data fields */
	  "additionalData.lodging.checkInDate" => "20150607",
	  "additionalData.lodging.checkOutDate" => "20150607",
	  "additionalData.lodging.folioNumber" => "1234",
	  "additionalData.lodging.specialProgramCode" => "1",
	  "additionalData.lodging.renterName"=>"Peter Pan",
	  "additionalData.lodging.numberOfRoomRates" => "2",
	  "additionalData.lodging.room1.rate"=>"1220",
	  "additionalData.lodging.room1.numberOfNights" => "4",
	  "additionalData.lodging.room2.rate"=>"1220",
	  "additionalData.lodging.room2.numberOfNights" => "2",
   
 );
 
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, "https://pal-test.adyen.com/pal/servlet/Payment/v18/authorise");
 curl_setopt($ch, CURLOPT_HEADER, false); 
 curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC  );
 curl_setopt($ch, CURLOPT_USERPWD, "YourWSUser:YourWSUserPassword");   
 curl_setopt($ch, CURLOPT_POST,1);
 curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($request));
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
 $result = curl_exec($ch);
 
 if($result === false)
    echo "Error: " . curl_error($ch);
 else{
 	/**
	 * If the payment passes validation a risk analysis will be done and, depending on the
	 * outcome, an authorisation will be attempted. You receive a
	 * payment response with the following fields:
	 * - pspReference: The reference we assigned to the payment;
	 * - resultCode: The result of the payment. One of Authorised, Refused or Error;
	 * - authCode: An authorisation code if the payment was successful, or blank otherwise;
	 * - refusalReason: If the payment was refused, the refusal reason.
	 */ 
	 
 	parse_str($result,$result);
    print_r(($result));
 }
 
 curl_close($ch);
