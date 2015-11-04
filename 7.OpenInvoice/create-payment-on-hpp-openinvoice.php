<?php 
  $merchantReference = "Test open invoice transaction 1";
  $paymentAmount = "199";   
  $currencyCode = "EUR";  
  $shipBeforeDate = "15-08-2015" ;
  $skinCode = "[skin code]";
  $merchantAccount = "[merchant account]";
  $sessionValidity = date("c",strtotime("+2 days"));
  $merchantReturnData = "SecretReturnData!";
  $shopperLocale = ""; 
  $orderData = base64_encode(gzencode("This is just some test OrderData to test out the function"));
  $countryCode = ""; 
  $shopperEmail = "test@adyen.com";
  $shopperReference = "OpenInvoiceShopper 01"; 

  $shopperFirstName = "Testperson-nl"; 
  $shopperLastName = "Approved";
  $shopperDateOfBirthDayOfMonth = "10"; 
  $shopperDateOfBirthMonth = "07"; 
  $shopperDateOfBirthYear = "1970"; 
  $shopperGender = "MALE"; 
  $shopperTelephoneNumber = "0104691602"; 
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


/*Invoice lines (If extra lines are needed, just copy all 7 line for each block and replace e.g. 'line3' with e.g. line4  and change the total numberOfLines*/
  $invoicelines=array (
    "openinvoicedata.numberOfLines"=>"4",
    "openinvoicedata.refundDescription"=>"test data",

    "openinvoicedata.line1.currencyCode"=>"EUR",
    "openinvoicedata.line1.description"=>"Courgette",
    "openinvoicedata.line1.itemAmount"=>"5876",
    "openinvoicedata.line1.itemVatAmount"=>"1117",
    "openinvoicedata.line1.itemVatPercentage"=>"1900",
    "openinvoicedata.line1.numberOfItems"=>"1",
    "openinvoicedata.line1.vatCategory"=>"High",

    "openinvoicedata.line2.currencyCode"=>"EUR",
    "openinvoicedata.line2.description"=>"Onions",
    "openinvoicedata.line2.itemVatPercentage"=>"1900",
    "openinvoicedata.line2.numberOfItems"=>"1",
    "openinvoicedata.line2.itemAmount"=>"2500",
    "openinvoicedata.line2.itemVatAmount"=>"650",
    "openinvoicedata.line2.vatCategory"=>"High",

    "openinvoicedata.line3.currencyCode"=>"EUR",
    "openinvoicedata.line3.description"=>"Watermelons",
    "openinvoicedata.line3.itemVatPercentage"=>"1900",
    "openinvoicedata.line3.numberOfItems"=>"1",
    "openinvoicedata.line3.itemAmount"=>"5500",
    "openinvoicedata.line3.itemVatAmount"=>"650",
    "openinvoicedata.line3.vatCategory"=>"High",

    "openinvoicedata.line4.currencyCode"=>"EUR",
    "openinvoicedata.line4.description"=>"Steak",
    "openinvoicedata.line4.itemVatPercentage"=>"1900",
    "openinvoicedata.line4.numberOfItems"=>"1",
    "openinvoicedata.line4.itemAmount"=>"2500",
    "openinvoicedata.line4.itemVatAmount"=>"650",
    "openinvoicedata.line4.vatCategory"=>"High",

    );  


/* Sorting Open Invoice array alphabetically and prepping the merchant signature for the signing string */
ksort($invoicelines);
$openInvoiceSigningString_part1="merchantSig:";
$openInvoiceSigningString_part2=$merchantSig;
/* forming part one of signing string */
foreach ($invoicelines as $key => $val) {
    $openInvoiceSigningString_part1=$openInvoiceSigningString_part1.$key.":";
}
/* forming part two of signing string */
foreach ($invoicelines as $key => $val) {
    $openInvoiceSigningString_part2=$openInvoiceSigningString_part2.":".$val;
}
/* Concatenating everything into the final signing string for open invoice signature calculation*/
$openInvoiceSigningString=trim($openInvoiceSigningString_part1,":")."|".trim($openInvoiceSigningString_part2,":");

/* Open Invoice signature calculation */
 $openinvoicedata_sig = base64_encode(pack("H*",hash_hmac(
    'sha1',$openInvoiceSigningString, $hmacKey
  )));




?>

<p> <b>Test payment button </b></p>
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
  <input type="hidden" name="billingAddressSig" value="<?php echo $billingAddressSig ?>"/>

  <!-- Delivery address  -->
  <input type="hidden" name="deliveryAddress.street" value="<?php echo $shopperInfo["delivery"]["deliveryAddress.street"] ?>"/>
  <input type="hidden" name="deliveryAddress.houseNumberOrName" value="<?php echo $shopperInfo["delivery"]["deliveryAddress.houseNumberOrName"] ?>"/>
  <input type="hidden" name="deliveryAddress.city" value="<?php echo $shopperInfo["delivery"]["deliveryAddress.city"] ?>"/>
  <input type="hidden" name="deliveryAddress.postalCode" value="<?php echo $shopperInfo["delivery"]["deliveryAddress.postalCode"] ?>"/>
  <input type="hidden" name="deliveryAddress.stateOrProvince" value="<?php echo $shopperInfo["delivery"]["deliveryAddress.stateOrProvince"] ?>"/>
  <input type="hidden" name="deliveryAddress.country" value="<?php echo $shopperInfo["delivery"]["deliveryAddress.country"] ?>"/>
  <input type="hidden" name="deliveryAddressSig" value="<?php echo $deliveryAddressSig ?>"/>

  <!-- Klarna Invoice Line Specification-->
  <input type="hidden" name="openinvoicedata.sig" value="<?php echo $openinvoicedata_sig ?>"/>

  <?php
  foreach ($invoicelines as $key => $val) {
      echo '<input type="hidden" name="'.$key.'" value="'.$val.'" />';
    echo ("\r\n");
  }
  ?> 

  <input type="submit" value="Create Open Invoice payment through HPP" />


</form>
