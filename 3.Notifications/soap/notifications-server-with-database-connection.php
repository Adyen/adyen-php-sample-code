<?php
/**
 * Receive notifcations from Adyen using SOAP
 * 
 * Whenever a payment is made, a modification is processed or a report is
 * available we will notify you. The notifications tell you for instance if
 * an authorisation was performed successfully. 
 * Notifications should be used to keep your backoffice systems up to date with
 * the status of each payment and modification. Notifications are sent 
 * using a SOAP call or using HTTP POST to a server of your choice. 
 * This file describes how SOAP notifcations can be received in PHP.
 * 
 * Security:
 * We recommend you to secure your notification server. You can secure it
 * using a username/password which can be configured in the CA. The username
 * and password will be available in the request in: $_SERVER['PHP_AUTH_USER'] and 
 * $_SERVER['PHP_AUTH_PW']. Alternatively, is to allow only traffic that
 * comes from Adyen servers. 
 * 
 * @link	3.Notifications/soap/notification_server.php 
 * @author	Created by Adyen - Payments Made Easy
 */
  
 /**
  * Create a SoapServer which implements the SOAP protocol used by Adyen and 
  * implement the sendNotification action in order to call a function handling
  * the notification.
  * 
  * new SoapServer($wsdl,$options)
  * - $wsdl points to the wsdl you are using;
  * - $options[cache_wsdl] = WSDL_CACHE_BOTH, we advice 
  *   to cache the WSDL since we usually never change it.
  */  

/*
This file shows you how Adyen SOAP notifications can be easily parsed and saved into a MySQL database. 
All you have to do is to fill in the host, database name, password and username for the MySQL database you want to connect to. 
The table 'adyen_notifications' will be created automatically for you if it does not exist yet. 
Take note that the additionalData and operations containers are saved as JSON due to variable number of fields that can come in them.

You can then pull the information you need from the MySQL database yourselves based on any parameter you want. 
*/



 $server = new SoapServer(
	"https://ca-test.adyen.com/ca/services/Notification?wsdl", array(
		"style" => SOAP_DOCUMENT,
		"encoding" => SOAP_LITERAL,
		"cache_wsdl" => WSDL_CACHE_BOTH,
		"trace" => 1,
	)
 ); 
 // Add authentication yourself if desired. 

 $server->addFunction("sendNotification"); 
 $server->handle();

 function sendNotification($request) {
 	global $ipaddress_client;
 		/**
	 * In SOAP it's possible that we send you multiple notifications
	 * in one request. First we verify if the request the SOAP envelopes.
	 */
	if(isset($request->notification->notificationItems) && count($request->notification->notificationItems) >0)
		$live=$request->notification->live;		
		foreach($request->notification->notificationItems as $notificationRequestItem){
				//FILL IN THE MYSQL SERVER CREDENTIALS HERE
				$mysqli = new mysqli("host", "user", "password", "database");
				if ($mysqli->connect_errno) {
				    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
				}			



				$tableCreatequery="CREATE TABLE IF NOT EXISTS `adyen_notifications` (
				  `recordid` MEDIUMINT NOT NULL AUTO_INCREMENT,
				  `live` boolean,
				  `amount_currency` TINYTEXT,
				  `amount_value` integer,
				  `eventCode` TINYTEXT,
				  `eventDate` DATETIME,
				  `merchantAccountCode` MEDIUMTEXT,
				  `merchantReference` MEDIUMTEXT,
				  `originalReference` MEDIUMTEXT,
				  `pspReference` MEDIUMTEXT,
				  `reason` TEXT,
				  `success` boolean,
				  `paymentMethod` TINYTEXT,
				  `operations` TEXT, 
				  `additionalData` TEXT, 
				  `TimeStamp` TimeStamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  PRIMARY KEY (recordid)
				) ";
				// You can change data type of 'operations' and 'additionalData' from TEXT to JSON if your PHP version is higher or equal to 5.7.8 

				$result=mysqli_query($mysqli,$tableCreatequery);
				if (!$result) {
				    printf("Errormessage: %s\n", $mysqli->error);
				}

				$sql="INSERT INTO `adyen_notifications`
					(`live`,
					`amount_currency`,
					`amount_value`,
					`eventCode`,
					`eventDate`,
					`merchantAccountCode`,
					`merchantReference`,
					`originalReference`,
					`pspReference`,
					`reason`,
					`success`,
					`paymentMethod`,
					`operations`,
					`additionalData`)
					VALUES('"
					.$live."','"					
					.$notificationRequestItem->amount->currency."','"
					.$notificationRequestItem->amount->value."','"
					.$notificationRequestItem->eventCode."','"
					.$notificationRequestItem->eventDate."','"
					.$notificationRequestItem->merchantAccountCode."','"
					.$notificationRequestItem->merchantReference."','"
					.$notificationRequestItem->originalReference."','"
					.$notificationRequestItem->pspReference."','"
					.$notificationRequestItem->reason."','"
					.$notificationRequestItem->success."','"
					.$notificationRequestItem->paymentMethod."','"
					.json_encode($notificationRequestItem->operations)."','"
					.json_encode($notificationRequestItem->additionalData)
					."')";

				$result=mysqli_query($mysqli,$sql);
				if (!$result) {
				    printf("Errormessage: %s\n", $mysqli->error);
				}

				mysqli_close($mysqli);

		}

		
	 
	 /**
	  * Returning [accepted], please make sure you always
	  * return [accepted] to us, this is essential to let us 
	  * know that you received the notification. If we do NOT receive
	  * [accepted] we try to send the notification again which
	  * will put all other notification in a queue.
	  */
	  return array("notificationResponse" => "[accepted]");
 } 
