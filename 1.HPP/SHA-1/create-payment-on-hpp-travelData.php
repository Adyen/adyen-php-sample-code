<?php 
  $merchantReference = "Test travel payment with additional travel data";
  $paymentAmount = "199"; 	
  $currencyCode = "EUR";	
  $shipBeforeDate = "15-08-2015" ;
  $skinCode = "[skin code]";
  $merchantAccount = "[merchant account]";
  $sessionValidity = date("c",strtotime("+2 days"));
  $merchantReturnData = "SecretReturnData";
  $shopperLocale = ""; 
  $orderData = base64_encode(gzencode("This is just some test OrderData to test out the function"));
  $countryCode = ""; 
  $shopperEmail = "test2@adyen.com";
  $shopperReference = "Test traveller 001"; 
  $shopperIP = "62.128.7.69";
 
  $allowedMethods = ""; 
  $blockedMethods = ""; 
  $offset = ""; 
  $shopperStatement = "";
  $recurringContract = "";
  $billingAddressType = "";
  $deliveryAddressType = "";
  $offerEmail = "";
  $brandCode = ""; 
  $issuerID= "";
  $resURL= "";
  $additionalAmount="100";
/*Billing and delivery addresses */
$shopperInfo= array(
	"billing" =>array(
		"billingAddress.street" =>"Neherkade",
		"billingAddress.houseNumberOrName" => "1",
		"billingAddress.city" => "Gravenhage",
		"billingAddress.postalCode" => "2521VA",
		"billingAddress.stateOrProvince" => "NH",
		"billingAddress.country" => "NL",
	),
	"delivery" => array(
		"deliveryAddress.street" => "Neherkade",
		"deliveryAddress.houseNumberOrName" => "1",
		"deliveryAddress.city" => "Gravenhage",
		"deliveryAddress.postalCode" => "2521VA",
		"deliveryAddress.stateOrProvince" => "NH",
		"deliveryAddress.country" => "NL",
		"deliveryAddressType" => "",
)
);
  $hmacKey = "[HMAC key]";
	/*Merchant signature calculation */
	  $merchantSig = base64_encode(pack("H*",hash_hmac(
	  	'sha1',
	  	$paymentAmount . $currencyCode . $shipBeforeDate . $merchantReference . $skinCode . $merchantAccount . 
		$sessionValidity . $shopperEmail . $shopperReference . $recurringContract.$allowedMethods . $blockedMethods .$shopperStatement.$merchantReturnData.$billingAddressType.$deliveryAddressType.$shopperType. $offset , $hmacKey
	  )));
	// Compute the billingAddressSig
  $billingAddressSig = base64_encode(pack("H*",hash_hmac(
  	'sha1',
  	$shopperInfo["billing"]["billingAddress.street"] .
  	$shopperInfo["billing"]["billingAddress.houseNumberOrName"] .
  	$shopperInfo["billing"]["billingAddress.city"] .
  	$shopperInfo["billing"]["billingAddress.postalCode"] .
  	$shopperInfo["billing"]["billingAddress.stateOrProvince"] .
  	$shopperInfo["billing"]["billingAddress.country"],
	$hmacKey
  )));
 	 // Compute the deliveryAddressSig
  $deliveryAddressSig = base64_encode(pack("H*",hash_hmac(
  	'sha1',
	$shopperInfo["delivery"]["deliveryAddress.street"] .
	$shopperInfo["delivery"]["deliveryAddress.houseNumberOrName"] .
	$shopperInfo["delivery"]["deliveryAddress.city"] .
	$shopperInfo["delivery"]["deliveryAddress.postalCode"] .
	$shopperInfo["delivery"]["deliveryAddress.stateOrProvince"] .
	$shopperInfo["delivery"]["deliveryAddress.country"],
	$hmacKey
)));

/*Airline Data lines (If extra lines are needed, just copy all 7 line for each block and replace e.g. 'line3' with e.g. line4  and change the total numberOfLines*/
	$airlineDataLines=array (
					
					"airline.passenger_name" => "Kate Winslet",
					"airline.ticket_number" => "XC123", 
					"airline.airline_code" => "111",
					"airline.travel_agency_code" => "000000",
					"airline.travel_agency_name" => "UNKNOWN",
					"airline.customer_reference_number" => "******5837",
					"airline.ticket_issue_address" => "YREWX08AA",
					"airline.boarding_fee" => "12",
					"airline.airline_designator_code" => "AA",
					"airline.agency_plan_name" => "AA",
					"airline.agency_invoice_number" => "222",
					"airline.flight_date" => "2015-02-19 00:00",

					"airline.passenger1.first_name" => "Kate",
					"airline.passenger1.last_name" => "Winslet",
					"airline.passenger1.traveller_type" => "ADT",
					"airline.passenger1.date_of_birth" => "1980-05-02",
					"airline.passenger1.phone_number" => "0031641212345",
					

					"airline.passenger2.first_name" => "Peter",
					"airline.passenger2.last_name" => "Pan",
					"airline.passenger2.traveller_type" => "ADT",
					"airline.passenger2.date_of_birth" => "1981-05-02",
					"airline.passenger2.phone_number" => "0031641212345",
					

					"airline.leg1.depart_airport" => "HKG", 
					"airline.leg1.flight_number" => "364",
					"airline.leg1.carrier_code" => "AA", 
					"airline.leg1.fare_base_code" => "E",
					"airline.leg1.class_of_travel" => "E",
					"airline.leg1.stop_over_code" => "X",
					"airline.leg1.destination_code" => "AMS",
					"airline.leg1.date_of_travel" => "2015-02-19 00:00",
					"airline.leg1.depart_tax" => "396",

					"airline.leg2.depart_airport" => "PVG",
					"airline.leg2.flight_number" => "369",
					"airline.leg2.carrier_code" => "AA",
					"airline.leg2.fare_base_code" => "E",
					"airline.leg2.class_of_travel" => "E",
					"airline.leg2.stop_over_code" => "X",
					"airline.leg2.destination_code" => "LTN",
					"airline.leg2.date_of_travel" => "2015-02-20 00:00",
					"airline.leg2.depart_tax" => "0",
		);

//Optional lodging data can be specified in this array
$lodgingDataLines=array (
					"lodging.checkInDate" => "20150607",
					"lodging.checkOutDate" => "20150607",
					"lodging.folioNumber" => "1234",
					"lodging.specialProgramCode" => "1",
					"lodging.renterName"=>"Peter Pan",
					"lodging.numberOfRoomRates" => "2",

					"lodging.room1.rate"=>"1220",
					"lodging.room1.numberOfNights" => "4",

					"lodging.room2.rate"=>"1220",
					"lodging.room2.numberOfNights" => "2",
		);	


$airlinedata_sig=additionalDataSigCalc($airlineDataLines);
$lodgingdata_sig=additionalDataSigCalc($lodgingDataLines);



function additionalDataSigCalc($additionalDataArray) {

global $merchantSig;
global $hmacKey;

ksort($additionalDataArray);
$additionalDataSigningString_part1=":merchantSig";
$additionalDataSigningString_part2=$merchantSig;
/* forming part one of signing string */
foreach (array_reverse($additionalDataArray) as $key => $val) {
    $additionalDataSigningString_part1=":".$key.$additionalDataSigningString_part1;
}

/* forming part two of signing string */
foreach (array_reverse($additionalDataArray) as $key => $val) {
    $additionalDataSigningString_part2=$val.":".$additionalDataSigningString_part2;
}
/* Concatenating everything into the final signing string for Airline data calculation*/
$additionalDataSigningString=trim($additionalDataSigningString_part1,":")."|".$additionalDataSigningString_part2;
/* Airline Data signature calculation */

 $additionalData_sig = base64_encode(pack("H*",hash_hmac(
  	'sha1',$additionalDataSigningString, $hmacKey
  )));

return $additionalData_sig;

}


?>

<p> <b>Test airline payment button, posting Adyen Skin with Airline data </b></p>
<form method="POST" action="https://test.adyen.com/hpp/pay.shtml" target="_blank">
	<input type="hidden" name="merchantReference" value="<?php echo $merchantReference ?>"/>
	<input type="hidden" name="paymentAmount" value="<?php echo $paymentAmount ?>"/>
	<input type="hidden" name="currencyCode" value="<?php echo $currencyCode ?>"/>
        <input type="hidden" name="shipBeforeDate" value="<?php echo $shipBeforeDate ?>"/>
	<input type="hidden" name="skinCode" value="<?php echo $skinCode ?>"/>
	<input type="hidden" name="merchantAccount" value="<?php echo $merchantAccount ?>"/>
	<input type="hidden" name="sessionValidity" value="<?php echo $sessionValidity ?>"/>
	<input type="hidden" name="merchantReturnData" value="<?php echo $merchantReturnData ?>"/>
	<input type="hidden" name="shopperLocale" value="<?php echo $shopperLocale ?>"/>
	<input type="hidden" name="orderData" value="<?php echo $orderData ?>"/>
	<input type="hidden" name="countryCode" value="<?php echo $countryCode ?>"/>
	<input type="hidden" name="shopperEmail" value="<?php echo $shopperEmail ?>"/>
	<input type="hidden" name="shopperReference" value="<?php echo $shopperReference ?>"/>
	<input type="hidden" name="allowedMethods" value="<?php echo $allowedMethods ?>"/>
	<input type="hidden" name="blockedMethods" value="<?php echo$blockedMethods ?>"/>
	<input type="hidden" name="offset" value="<?php echo $offset ?>"/>
	<input type="hidden" name="merchantSig" value="<?php echo $merchantSig ?>"/>
        <input type="hidden" name="shopperStatement" value="<?php echo $shopperStatement ?>"/>
	<input type="hidden" name="recurringContract" value="<?php echo $recurringContract ?>"/>
	<input type="hidden" name="billingAddressType" value="<?php echo $billingAddressType ?>"/>
	<input type="hidden" name="deliveryAddressType" value="<?php echo $deliveryAddressType ?>"/>
	<input type="hidden" name="offerEmail" value="<?php echo $offerEmail ?>"/>
	<input type="hidden" name="brandCode" value="<?php echo $brandCode ?>"/>
	<input type="hidden" name="issuerID" value="<?php echo $issuerID ?>"/>
	<input type="hidden" name="resURL" value="<?php echo $resURL ?>"/>
	<input type="hidden" name="additionalAmount" value="<?php echo $additionalAmount ?>"/>

	<input type="hidden" name="shopper.firstName" value="<?php echo $shopperFirstName ?>"/>
	<input type="hidden" name="shopper.lastName" value="<?php echo $shopperLastName ?>"/>
	<input type="hidden" name="shopper.dateOfBirthDayOfMonth" value="<?php echo $shopperDateOfBirthDayOfMonth ?>"/>
	<input type="hidden" name="shopper.dateOfBirthMonth" value="<?php echo $shopperDateOfBirthMonth ?>"/>
	<input type="hidden" name="shopper.dateOfBirthYear" value="<?php echo $shopperDateOfBirthYear ?>"/>
	<input type="hidden" name="shopper.gender" value="<?php echo $shopperGender ?>"/>
	<input type="hidden" name="shopper.telephoneNumber" value="<?php echo $shopperTelephoneNumber ?>"/>
	<input type="hidden" name="shopperIP" value="<?php echo $shopperIP ?>"/>

	<!-- Billing address -->
	<input type="hidden" name="billingAddress.street" value="<?php echo $shopperInfo["billing"]["billingAddress.street"] ?>"/>
	<input type="hidden" name="billingAddress.houseNumberOrName" value="<?php echo $shopperInfo["billing"]["billingAddress.houseNumberOrName"] ?>"/>
	<input type="hidden" name="billingAddress.city" value="<?php echo $shopperInfo["billing"]["billingAddress.city"] ?>"/>
	<input type="hidden" name="billingAddress.postalCode" value="<?php echo $shopperInfo["billing"]["billingAddress.postalCode"] ?>"/>
	<input type="hidden" name="billingAddress.stateOrProvince" value="<?php echo $shopperInfo["billing"]["billingAddress.stateOrProvince"] ?>"/>
	<input type="hidden" name="billingAddress.country" value="<?php echo $shopperInfo["billing"]["billingAddress.country"] ?>"/>
	<input type="hidden" name="billingAddressSig" value="<?=$billingAddressSig ?>"/>

	<!-- Delivery address  -->
	<input type="hidden" name="deliveryAddress.street" value="<?php echo $shopperInfo["delivery"]["deliveryAddress.street"] ?>"/>
	<input type="hidden" name="deliveryAddress.houseNumberOrName" value="<?php echo $shopperInfo["delivery"]["deliveryAddress.houseNumberOrName"] ?>"/>
	<input type="hidden" name="deliveryAddress.city" value="<?php echo $shopperInfo["delivery"]["deliveryAddress.city"] ?>"/>
	<input type="hidden" name="deliveryAddress.postalCode" value="<?php echo $shopperInfo["delivery"]["deliveryAddress.postalCode"] ?>"/>
	<input type="hidden" name="deliveryAddress.stateOrProvince" value="<?php echo $shopperInfo["delivery"]["deliveryAddress.stateOrProvince"] ?>"/>
	<input type="hidden" name="deliveryAddress.country" value="<?php echo $shopperInfo["delivery"]["deliveryAddress.country"] ?>"/>
	<input type="hidden" name="deliveryAddressSig" value="<?php echo $deliveryAddressSig ?>"/>

	<!-- Airline Data Line Specification-->
	<input type="hidden" name="airline.sig" value="<?php echo $airlinedata_sig ?>"/>

	<?php
	foreach ($airlineDataLines as $key => $val) {
	    echo '	<input type="hidden" name="'.$key.'" value="'.$val.'" />';
		echo ("\n");
	}
	?> 

	
	<!-- Lodging Data Line Specification-->
	<input type="hidden" name="lodging.sig" value="<?php echo $lodgingdata_sig ?>"/>

	<?php
	foreach ($lodgingDataLines as $key => $val) {
	    echo '	<input type="hidden" name="'.$key.'" value="'.$val.'" />';
		echo ("\r\n");
	}
	?> 

	<input type="submit" value="Create travel payment through HPP" />


</form>
