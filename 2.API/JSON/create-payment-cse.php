<?php
/**
 * Create Client-Side Encryption Payment (HTTP Post)
 * 
 * Merchants that require more stringent security protocols or do not want the additional overhead 
 * of managing their PCI compliance, may decide to implement Client-Side Encryption (CSE). 
 * This is particularly useful for Mobile payment flows where only cards are being offered, as 
 * it may result in faster load times and an overall improvement to the shopper flow.
 * The Adyen Hosted Payment Page (HPP) provides the most comprehensive level of PCI compliancy 
 * and you do not have any PCI obligations. Using CSE reduces your PCI scope when compared to 
 * implementing the API without encryption.
 * 
 * If you would like to implement CSE, please provide the completed PCI Self Assessment Questionnaire (SAQ) 
 * A to the Adyen Support Team (support@adyen.com). The form can be found here: 
 * https://www.pcisecuritystandards.org/security_standards/documents.php?category=saqs
 * 
 * Please note: using our API requires a web service user. Set up your Webservice 
 * user: Adyen Test CA >> Settings >> Users >> ws@Company. >> Generate Password >> Submit 
 *  
 * @link	2.API/httppost/create-payment-cse.php 
 * @author	Created by Adyen - Payments Made Easy
 */ 
 
 if(isset($_POST['adyen-encrypted-data'])){
	 /**
	  * The payment can be submitted by sending a PaymentRequest 
	  * to the authorise action of the web service, the request should 
	  * contain the following variables:
	  * - action: Specifies the action on the web service.
	  * - merchantAccount: The merchant account the payment was processed with.
	  * - amount: The amount of the payment
	  * 	- currency: the currency of the payment
	  * 	- amount: the amount of the payment
	  * - reference: Your reference
	  * - shopperIP: The IP address of the shopper (optional/recommended)
	  * - shopperEmail: The e-mail address of the shopper 
	  * - shopperReference: The shopper reference, i.e. the shopper ID
	  * - fraudOffset: Numeric value that will be added to the fraud score (optional)
	  * - paymentRequest.additionalData.card.encrypted.json: The encrypted card caught by the POST variables.
	  */
	$request = array(
		"merchantAccount" => "[YourMerchantAccount]",    
		"amount" => array(
				"value"=>100,
				"currency"=>"EUR"),
		"reference" => "TEST-PAYMENT-" . date("Y-m-d-H:i:s"),
		"shopperIP" => "ShopperIPAddress",
		"shopperEmail" => "TheShopperEmailAddress",
		"shopperReference" => "YourReference", 
		"fraudOffset" => "0",
    		"additionalData"=>array(
    			"card.encrypted.json" => $_POST['adyen-encrypted-data']

    		),
		"browserInfo"=>array(
			"acceptHeader"=>$_SERVER['HTTP_USER_AGENT'],
			"userAgent"=>$_SERVER['HTTP_ACCEPT']
	)		
	 );
	 
	 $ch = curl_init();
	 curl_setopt($ch, CURLOPT_URL, "https://pal-test.adyen.com/pal/servlet/Payment/v25/authorise");
	 curl_setopt($ch, CURLOPT_HEADER, false); 
	 curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC  );
	 curl_setopt($ch, CURLOPT_USERPWD, "YourWSUser:YourWSUserPassword");   
	 curl_setopt($ch, CURLOPT_POST,count(json_encode($request)));
	 curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($request));
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  	 curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-type: application/json")); 
   
	  
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
		print_r(json_decode($result));
	 }
	 
	 curl_close($ch);
 }
 
?>
 <html>
	 <head>
		 <title>Adyen - Client-Side Encryption Example</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	 </head>
	 <body>
		<form method="POST" action="[insert the (localhost) URL of this PHP file here]" id="adyen-encrypted-form">
			<fieldset>
				<legend>Card Details</legend>
					<label for="adyen-encrypted-form-number">
						Card Number
						<input type="text" id="adyen-encrypted-form-number" value="5555444433331111" size="20" autocomplete="off" data-encrypted-name="number" />
                    </label>
                    <label for="adyen-encrypted-form-holder-name">
						Card Holder Name
						<input type="text" id="adyen-encrypted-form-holder-name" value="John Doe" size="20" autocomplete="off" data-encrypted-name="holderName" />
					</label>
					<label for="adyen-encrypted-form-cvc">
						CVC
						<input type="text" id="adyen-encrypted-form-cvc" value="737" size="4" autocomplete="off" data-encrypted-name="cvc" />
					</label>
					<label for="adyen-encrypted-form-expiry-month">
						Expiration Month (MM)
						<input type="text" value="08"   id="adyen-encrypted-form-expiry-month" size="2"  autocomplete="off" data-encrypted-name="expiryMonth" /> /
					</label>
					<label for="adyen-encrypted-form-expiry-year">Expiration Year (YYYY)
						<input type="text" value="2018" id="adyen-encrypted-form-expiry-year"  size="4"  autocomplete="off" data-encrypted-name="expiryYear" />
					</label>
					
					<input type="hidden" id="adyen-encrypted-form-expiry-generationtime" value="<?php date_default_timezone_set('Europe/Amsterdam'); echo date("c")?>" data-encrypted-name="generationtime" />
					<input type="submit" value="Create payment" />
			</fieldset>	
		</form>
		
		<script type="text/javascript" src="../../lib/adyen.encrypt.min.js"></script>
		<script type="text/javascript">
			var form    = document.getElementById('adyen-encrypted-form');
			/* Put your WS users' CSE key here */
			/* Adyen CA -> Settings -> Users -> Choose the WS user -> Copy CSE key */
			var key = "YOUR-KEY-HERE-YOUR-KEY-HERE-YOUR-KEY-HERE-YOUR-KEY-HERE"
					 + "YOUR-KEY-HERE-YOUR-KEY-HERE-YOUR-KEY-HERE-YOUR-KEY-HERE"
					 + "YOUR-KEY-HERE-YOUR-KEY-HERE-YOUR-KEY-HERE-YOUR-KEY-HERE"
					 + "YOUR-KEY-HERE-YOUR-KEY-HERE-YOUR-KEY-HERE-YOUR-KEY-HERE"
					 + "YOUR-KEY-HERE-YOUR-KEY-HERE-YOUR-KEY-HERE-YOUR-KEY-HERE"
					 + "YOUR-KEY-HERE-YOUR-KEY-HERE-YOUR-KEY-HERE-YOUR-KEY-HERE"
					 + "YOUR-KEY-HERE-YOUR-KEY-HERE-YOUR-KEY-HERE-YOUR-KEY-HERE"
					 + "YOUR-KEY-HERE-YOUR-KEY-HERE-YOUR-KEY-HERE-YOUR-KEY-HERE"
					 + "YOUR-KEY-HERE-YOUR-KEY-HERE-YOUR-KEY-HERE-YOUR-KEY-HERE";
			 adyen.encrypt.createEncryptedForm( form, key, {});
		</script>
	 </body>
 </html> 
