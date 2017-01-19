<?php
    /*
     This PHP code provides a payment form for the Adyen Hosted Payment Pages
     */
    
    /*
     account details
     $skinCode:        the skin to be used
     $merchantAccount: the merchant account we want to process this payment with.
     $sharedSecret:    the shared HMAC key.
     */
    
    $skinCode        = "[skin code e.g. GBIMwmE4]";
    $merchantAccount = "[merchant Account e.g. TestCompanyCOM]";
    $hmacKey         = "[HMAC key e.g. D21EB2ASD44BA234C8A0AF13CF0BCACA3D4727C6162630D712C857124B213270]";
    
    
    /*
     payment-specific details
     */
    
    $params = array(
                    "merchantReference" => "SKINTEST-1435226439255",
                    "merchantAccount"   =>  $merchantAccount,
                    "currencyCode"      => "EUR",
                    "paymentAmount"     => "199",
                    "sessionValidity"   => "2020-12-25T10:31:06Z",
                    "shipBeforeDate"    => "2017-07-01",
                    "shopperLocale"     => "en_GB",
                    "skinCode"          => $skinCode,
                    "brandCode"         => "",
                    "shopperEmail"      => "test@adyen.com",
                    "shopperReference"  => "123",
                    
                    // Shopper information
                    "shopper.firstName"=> "Testperson-nl",
                    "shopper.fastName"=> "Approved",
                    "shopper.dateOfBirthDayOfMonth"=> "10",
                    "shopper.dateOfBirthMonth"=> "07",
                    "shopper.dateOfBirthYear"=> "1970",
                    "shopper.gender"=> "MALE",
                    "shopper.telephoneNumber"=> "0104691602", 
                    "shopperIP"=> "62.128.7.69",
                    
                    // Billing Address fields (used for AVS checks)
                    "billingAddress.street" =>"Neherkade",
                    "billingAddress.houseNumberOrName" => "1",
                    "billingAddress.city" => "Gravenhage",
                    "billingAddress.postalCode" => "2521VA",
                    "billingAddress.stateOrProvince" => "NH",
                    "billingAddress.country" => "NL",
                    
                    // Delivery/Shipping Address fields
                    "deliveryAddress.street" => "Neherkade",
                    "deliveryAddress.houseNumberOrName" => "1",
                    "deliveryAddress.city" => "Gravenhage",
                    "deliveryAddress.postalCode" => "2521VA",
                    "deliveryAddress.stateOrProvince" => "NH",
                    "deliveryAddress.country" => "NL",
                    "deliveryAddressType" => "",

                    // Optional airline data lines. supports up to 4 legs and 10 passengers.
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
                    "airline.passenger1.phone_number" => "0031634323232",
                    "airline.passenger1.date_of_birth" => "2011-04-31",
    
                    "airline.leg1.depart_airport" => "HKG",
                    "airline.leg1.flight_number" => "364",
                    "airline.leg1.carrier_code" => "AA",
                    "airline.leg1.fare_base_code" => "E",
                    "airline.leg1.class_of_travel" => "E",
                    "airline.leg1.stop_over_code" => "X",
                    "airline.leg1.destination_code" => "AMS",
                    "airline.leg1.date_of_travel" => "2015-02-19 00:00",
                    "airline.leg1.depart_tax" => "396",
                    
                    // Optional lodging data lines
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
    
    /*
     process fields
     */
    
    // The character escape function
    $escapeval = function($val) {
        return str_replace(':','\\:',str_replace('\\','\\\\',$val));
    };
    
    // Sort the array by key using SORT_STRING order
    ksort($params, SORT_STRING);
    
    // Generate the signing data string
    $signData = implode(":",array_map($escapeval,array_merge(array_keys($params), array_values($params))));
    
    // base64-encode the binary result of the HMAC computation
    $merchantSig = base64_encode(hash_hmac('sha256',$signData,pack("H*" , $hmacKey),true));
    $params["merchantSig"] = $merchantSig;
    
    ?>


<!-- Complete submission form -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Adyen Payment</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
</head>
<body>
<form name="adyenForm" action="https://test.adyen.com/hpp/select.shtml" method="post">

<?php
    foreach ($params as $key => $value){
        echo '        <input type="hidden" name="' .htmlspecialchars($key,   ENT_COMPAT | ENT_HTML401 ,'UTF-8').
        '" value="' .htmlspecialchars($value, ENT_COMPAT | ENT_HTML401 ,'UTF-8') . '" />' ."\n" ;
    }
    ?>
<input type="submit" value="Submit" />
</form>
</body>
</html>
