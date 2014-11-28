<?php
/**
 * Receive notifcations from Adyen using HTTP Post
 * 
 * Whenever a payment is made, a modification is processed or a report is
 * available we will notify you. The notifications tell you for instance if
 * an authorisation was performed successfully. 
 * Notifications should be used to keep your backoffice systems up to date with
 * the status of each payment and modification. Notifications are sent 
 * using a SOAP call or using HTTP POST to a server of your choice. 
 * This file describes how HTTP Post notifcations can be received in PHP.
 *  
 * @link	3.Notifications/httppost/notification_server.php 
 * @author	Created by Adyen - Payments Made Easy
 */
 
/**
 * The variabele $_POST contains an array including 
 * the following keys.
 * 
 * $_POST['currency']
 * $_POST['value']
 * $_POST['eventCode']
 * $_POST['eventDate']
 * $_POST['merchantAccountCode']
 * $_POST['merchantReference']
 * $_POST['originalReference']
 * $_POST['pspReference']
 * $_POST['reason']
 * $_POST['success']
 * $_POST['paymentMethod']
 * $_POST['operations']
 * $_POST['additionalData']
 * 
 * 
 * We recommend you to handle the notifications based on the
 * eventCode types available, please refer to the integration
 * manual for a comprehensive list. For debug purposes we also
 * recommend you to store the notification itself.
 * 
 * Security:
 * We recommend you to secure your notification server. You can secure it
 * using a username/password which can be configured in the CA. The username
 * and password will be available in the request in: $_SERVER['PHP_AUTH_USER'] and 
 * $_SERVER['PHP_AUTH_PW']. Alternatively, is to allow only traffic that
 * comes from Adyen servers.
 */
 
 switch($_POST['eventCode']){
	
	case 'AUTHORISATION':
			// Handle AUTHORISATION notification.
			// This doesn't necessarily mean that the authorisation is successful. 
			// The authorisation is successful if the success feld has the value “true”. In case of an error or a refusal, it will be “false” and the
			// reason feld should be consulted for the cause of the authorisation failure.
		break;
		
	case 'CANCELLATION':
			// Handle CANCELLATION notification.
			// Confirms that the payment was cancelled successfully. 
		break;
		
	case 'REFUND':
			// Handle REFUND notification.
			// Confirms that the payment was refunded successfully. 
		break;
		
	case 'CANCEL_OR_REFUND':
			// Handle CANCEL_OR_REFUND notification.
			// Confirms that the payment was refunded or cancelled successfully. 
		break;
		
	case 'CAPTURE':
			// Handle CAPTURE notification.
			// Confirms that the payment was successfully captured. 
		break;
		
	case 'REFUNDED_REVERSED':
			// Handle REFUNDED_REVERSED notification.
			// Tells you that the refund for this payment was successfully reversed. 
		break;
		
	case 'CAPTURE_FAILED':
			// Handle AUTHORISATION notification.
			// Tells you that the capture on the authorised payment failed. 
		break;
				
	case 'REQUEST_FOR_INFORMATION':
			// Handle REQUEST_FOR_INFORMATION notification.
			// Information requested for this payment .
		break;
		
	case 'NOTIFICATION_OF_CHARGEBACK':
			// Handle NOTIFICATION_OF_CHARGEBACK notification.
			// Chargeback is pending, but can still be defended 
		break;
		
	case 'CHARGEBACK':
			// Handle CHARGEBACK notification.
			// Payment was charged back. This is not sent if a REQUEST_FOR_INFORMATION or
			// NOTIFICATION_OF_CHARGEBACK notification has already been sent.
		break;
	
	case 'CHARGEBACK_REVERSED':
			// Handle CHARGEBACK_REVERSED notification.
			// Chargeback has been reversed (cancelled).
		break;
	
	case 'REPORT_AVAILABLE':
			// Handle REPORT_AVAILABLE notification.
			// There is a new report available, the URL of the report is in the "reason" field.
		break;
 }
		
 
 /**
  * Returning [accepted], please make sure you always
  * return [accepted] to us, this is essential to let us 
  * know that you received the notification. If we do NOT receive
  * [accepted] we try to send the notification again which
  * will put all other notification in a queue.
  */
 print "[accepted]";

 
 


