<?php 

    $merchantReference = "TEST-PAYMENT-" . date("Y-m-d-H:i:s");
    $paymentAmount = 199;
    $currencyCode = "EUR";
    $shipBeforeDate = date("Y-m-d",strtotime("+3 days"));
    $skinCode = "[skinCode]]";
    $merchantAccount = "[merchantAccount]]";
    $sessionValidity = date("c",strtotime("+1 days"));
    $shopperLocale = "nl";
    $orderData = base64_encode(gzencode("Orderdata to display on the HPP can be put here"));
    $countryCode = "NL";
    $shopperEmail = "test@adyen.com";
    $shopperReference = "TestShopper-1";
    $recurringContract = "RECURRING";
    $allowedMethods = "";
    $blockedMethods = "";
    $shopperStatement = "";
    $merchantReturnData = "";
    $offset = "";
    
    // By providing the brandCode and issuerId the HPP will redirect the shopper
    // directly to the redirect payment method. Please note: the form should be posted
    // to https://test.adyen.com/hpp/details.shtml rather than pay.shtml. While posting
    // to details.shtml countryCode becomes a required as well.
    $brandCode = "";
    $issuerId = "";
    
    /**
     * Collecting Shopper Information
     *
     * Address Verification System (AVS) is a security feature that verifies the billing address and/or
     * delivery address and/or shopper information of the card holder. To enable AVS the Billing Address Fields
     * (AVS) field must be checked under Skin Options for each skin you wish to use. The following variables
     * can be send to the HPP:
     *
     * 1. Billing address;
     * - billingAddress.street: The street name
     * - billingAddress.houseNumberOrName: The house number
     * - billingAddress.city: The city.
     * - billingAddress.postalCode: The postal/zip code.
     * - billingAddress.stateOrProvince: The state or province.
     * - billingAddress.country: The country in ISO 3166-1 alpha-2 format i.e. NL.
     * - billingAddressType: You can specify whether the shopper is allowed to view and/or modify these personal details.
     * - billingAddressSig: A separate merchant signature that is required for these fields.
     *
     * 2. Delivery address;
     * - deliveryAddress.street: The street name
     * - deliveryAddress.houseNumberOrName: The house number
     * - deliveryAddress.city: The city.
     * - deliveryAddress.postalCode: The postal/zip code.
     * - deliveryAddress.stateOrProvince: The state or province.
     * - deliveryAddress.country: The country in ISO 3166-1 alpha-2 format i.e. NL.
     * - deliveryAddressType: You can specify whether the shopper is allowed to view and/or modify these personal details.
     * - deliveryAddressSig: A separate merchant signature that is required for these fields.
     *
     * 3. Shopper information
     * - shopper.firstName: First name of the shopper.
     * - shopper.infix: The shopper infix.
     * - shopper.lastName: The shopper lastname.
     * - shopper.gender: The shopper gender: MALE/FEMALE
     * - shopper.dateOfBirthDayOfMonth: The day of the month of the shopper's birth.
     * - shopper.dateOfBirthMonth: The month of the shopper's birth.
     * - shopper.dateOfBirthYear: The year of the shopper's birth.
     * - shopper.telephoneNumber: The shopper's telephone number.
     * - shopperType: This field can be used if validation of the shopper fiels are desired.
     * - shopperSig: A separate merchant signature that is required for these fields.
     *
     * Please note: billingAddressType, deliveryAddressType and shopperType
     * can have the following values:
     * - Not supplied: modifiable / visible;
     * - 1: unmodifiable / visible
     * - 2: unmodifiable / invisible
     */
    
    $shopperInfo = array(
                         "billing" => array(
                                            "billingAddress.street" => "Simon Carmiggeltstraat",
                                            "billingAddress.houseNumberOrName" => "6-50",
                                            "billingAddress.city" => "Amsterdam",
                                            "billingAddress.postalCode" => "1011 DJ",
                                            "billingAddress.stateOrProvince" => "",
                                            "billingAddress.country" => "NL",
                                            "billingAddressType" => "1",
                                            ),
                         "delivery" => array(
                                             "deliveryAddress.street" => "Simon Carmiggeltstraat",
                                             "deliveryAddress.houseNumberOrName" => "6-50",
                                             "deliveryAddress.city" => "Amsterdam",
                                             "deliveryAddress.postalCode" => "1011 DJ",
                                             "deliveryAddress.stateOrProvince" => "",
                                             "deliveryAddress.country" => "NL",
                                             "deliveryAddressType" => "1",
                                             ),
                         "shopper" => array(
                                            "shopper.firstName" => "John",
                                            "shopper.infix" => "",
                                            "shopper.lastName" => "Doe",
                                            "shopper.gender" => "MALE",
                                            "shopper.dateOfBirthDayOfMonth" => "05",
                                            "shopper.dateOfBirthMonth" => "10",
                                            "shopper.dateOfBirthYear" => "1990",
                                            "shopper.telephoneNumber" => "+31612345678",
                                            "shopperType" => "1",
                                            )
                         );
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
    




    /**
     * Signing the form
     *
     * The signatures are used by Adyen to verify if the posted data is not
     * altered by the shopper. The signature must be encrypted according to the procedure below.
     * If you're running PHP 5 >= 5.1.2, PECL hash >= 1.1 you can use hash_hmac(), if you don't
     * you can use HMAC Pear (http://pear.php.net/package/Crypt_HMAC/download)
     *
     * Please note: the signature does contain more variables, in this example
     * they are NOT required since they are empty. Please have a look at the
     * advanced HPP example.
     */
    
    // HMAC Key is a shared secret KEY used to encrypt the signature. Set up the HMAC
    // key: Adyen Test CA >> Skins >> Choose your Skin >> Edit Tab >> Edit HMAC key for Test and Live
    $hmacKey = "[skin SHA-1 HMAC Key]]";
    
    // Compute the merchantSig
    $merchantSig = base64_encode(pack("H*",hash_hmac(
                                                     'sha1',
                                                     $paymentAmount . $currencyCode . $shipBeforeDate . $merchantReference . $skinCode . $merchantAccount .
                                                     $sessionValidity . $shopperEmail . $shopperReference . $recurringContract .
                                                     $allowedMethods . $blockedMethods . $shopperStatement . $merchantReturnData .
                                                     $shopperInfo["billing"]["billingAddressType"] . $shopperInfo["delivery"]["deliveryAddressType"] .
                                                     $shopperInfo["shopper"]["shopperType"] . $offset,
                                                     $hmacKey
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
    
    // Compute the shopperSig
    $shopperSig = base64_encode(pack("H*",hash_hmac(
                                                    'sha1',
                                                    $shopperInfo["shopper"]["shopper.firstName"] .
                                                    $shopperInfo["shopper"]["shopper.infix"] .
                                                    $shopperInfo["shopper"]["shopper.lastName"] .
                                                    $shopperInfo["shopper"]["shopper.gender"] .
                                                    $shopperInfo["shopper"]["shopper.dateOfBirthDayOfMonth"] .
                                                    $shopperInfo["shopper"]["shopper.dateOfBirthMonth"] .
                                                    $shopperInfo["shopper"]["shopper.dateOfBirthYear"] .
                                                    $shopperInfo["shopper"]["shopper.telephoneNumber"],
                                                    $hmacKey
                                                    )));
    
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
<form method="POST" action="https://test.adyen.com/hpp/select.shtml" target="_blank">
<input type="hidden" name="merchantReference" value="<?=$merchantReference ?>"/>
<input type="hidden" name="paymentAmount" value="<?=$paymentAmount ?>"/>
<input type="hidden" name="currencyCode" value="<?=$currencyCode ?>"/>
<input type="hidden" name="shipBeforeDate" value="<?=$shipBeforeDate ?>"/>
<input type="hidden" name="skinCode" value="<?=$skinCode ?>"/>
<input type="hidden" name="merchantAccount" value="<?=$merchantAccount ?>"/>
<input type="hidden" name="sessionValidity" value="<?=$sessionValidity ?>"/>
<input type="hidden" name="shopperLocale" value="<?=$shopperLocale ?>"/>
<input type="hidden" name="orderData" value="<?=$orderData ?>"/>
<input type="hidden" name="countryCode" value="<?=$countryCode ?>"/>
<input type="hidden" name="shopperEmail" value="<?=$shopperEmail ?>"/>
<input type="hidden" name="shopperReference" value="<?=$shopperReference ?>"/>
<input type="hidden" name="recurringContract" value="<?=$recurringContract ?>"/>
<input type="hidden" name="allowedMethods" value="<?=$allowedMethods ?>"/>
<input type="hidden" name="blockedMethods" value="<?=$blockedMethods ?>"/>
<input type="hidden" name="shopperStatement" value="<?=$shopperStatement ?>"/>
<input type="hidden" name="merchantReturnData" value="<?=$merchantReturnData ?>"/>
<input type="hidden" name="offset" value="<?=$offset ?>"/>
<input type="hidden" name="brandCode" value="<?=$brandCode ?>"/>
<input type="hidden" name="issuerId" value="<?=$issuerId ?>"/>

<!-- Billing address -->
<input type="hidden" name="billingAddress.street" value="<?=$shopperInfo["billing"]["billingAddress.street"] ?>"/>
<input type="hidden" name="billingAddress.houseNumberOrName" value="<?=$shopperInfo["billing"]["billingAddress.houseNumberOrName"] ?>"/>
<input type="hidden" name="billingAddress.city" value="<?=$shopperInfo["billing"]["billingAddress.city"] ?>"/>
<input type="hidden" name="billingAddress.postalCode" value="<?=$shopperInfo["billing"]["billingAddress.postalCode"] ?>"/>
<input type="hidden" name="billingAddress.stateOrProvince" value="<?=$shopperInfo["billing"]["billingAddress.stateOrProvince"] ?>"/>
<input type="hidden" name="billingAddress.country" value="<?=$shopperInfo["billing"]["billingAddress.country"] ?>"/>
<input type="hidden" name="billingAddressType" value="<?=$shopperInfo["billing"]["billingAddressType"] ?>"/>

<!-- Delivery address -->
<input type="hidden" name="deliveryAddress.street" value="<?=$shopperInfo["delivery"]["deliveryAddress.street"] ?>"/>
<input type="hidden" name="deliveryAddress.houseNumberOrName" value="<?=$shopperInfo["delivery"]["deliveryAddress.houseNumberOrName"] ?>"/>
<input type="hidden" name="deliveryAddress.city" value="<?=$shopperInfo["delivery"]["deliveryAddress.city"] ?>"/>
<input type="hidden" name="deliveryAddress.postalCode" value="<?=$shopperInfo["delivery"]["deliveryAddress.postalCode"] ?>"/>
<input type="hidden" name="deliveryAddress.stateOrProvince" value="<?=$shopperInfo["delivery"]["deliveryAddress.stateOrProvince"] ?>"/>
<input type="hidden" name="deliveryAddress.country" value="<?=$shopperInfo["delivery"]["deliveryAddress.country"] ?>"/>
<input type="hidden" name="deliveryAddressType" value="<?=$shopperInfo["delivery"]["deliveryAddressType"] ?>"/>

<!-- Shopper -->
<input type="hidden" name="shopper.firstName" value="<?=$shopperInfo["shopper"]["shopper.firstName"] ?>"/>
<input type="hidden" name="shopper.infix" value="<?=$shopperInfo["shopper"]["shopper.infix"] ?>"/>
<input type="hidden" name="shopper.lastName" value="<?=$shopperInfo["shopper"]["shopper.lastName"] ?>"/>
<input type="hidden" name="shopper.gender" value="<?=$shopperInfo["shopper"]["shopper.gender"] ?>"/>
<input type="hidden" name="shopper.dateOfBirthDayOfMonth" value="<?=$shopperInfo["shopper"]["shopper.dateOfBirthDayOfMonth"] ?>"/>
<input type="hidden" name="shopper.dateOfBirthMonth" value="<?=$shopperInfo["shopper"]["shopper.dateOfBirthMonth"] ?>"/>
<input type="hidden" name="shopper.dateOfBirthYear" value="<?=$shopperInfo["shopper"]["shopper.dateOfBirthYear"] ?>"/>
<input type="hidden" name="shopper.telephoneNumber" value="<?=$shopperInfo["shopper"]["shopper.telephoneNumber"] ?>"/>
<input type="hidden" name="shopperType" value="<?=$shopperInfo["shopper"]["shopperType"] ?>"/>

<!-- Klarna Invoice Line Specification-->
<input type="hidden" name="openinvoicedata.sig" value="<?php echo $openinvoicedata_sig ?>"/>

<?php
    foreach ($invoicelines as $key => $val) {
        echo '<input type="hidden" name="'.$key.'" value="'.$val.'" />';
        echo ("\r\n");
        }
?> 

<!-- Signatures -->
<input type="hidden" name="billingAddressSig" value="<?=$billingAddressSig ?>"/>
<input type="hidden" name="deliveryAddressSig" value="<?=$deliveryAddressSig ?>"/>
<input type="hidden" name="shopperSig" value="<?=$shopperSig ?>"/>
<input type="hidden" name="merchantSig" value="<?=$merchantSig ?>"/>

<input type="submit" value="Create payment" />
</form>
