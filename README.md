Adyen PHP Integration
==============
The code examples in this repository help you integrate with the [Adyen platform](https://www.adyen.com) using PHP. Please go through these code examples and read the documentation in the files itself. 

Each code example requires you to change some parameters to connect to your Adyen account (such as a merchant account and skin code).    


## PHP API Library
We have made a library available that contains all of these APIs to make the integration easier. The Library is open-source and available [here](https://github.com/Adyen/adyen-php-api-library).

## Code structure
```
1. HPP (Hosted Payment Page)
  - check-payment-request-sha256.php    : Check the calculated signature with the signature from the URL parameters
  - create-payment-on-HPP-SHA256.php    : Simple form creating a payment on our HPP
  - create-payment-on-HPP-SHA256_advanced.php    : Advanced form creating a payment on our HPP
  - create-payment-on-HPP-SHA256_openinvoice.php : Open Invoice form creating a payment on our HPP
  - create-payment-on-HPP-SHA256_travelData.php  : Airline travel data form creating a payment on our HPP
  - generate-payment-url-for-HPP-SHA256.php      : Generate a HPP payment link, based on a simple form
2. API
  - JSON
    - authorise-3d-secure-payment.php   : Authorise a 3D Secure payment using JSON
    - create-3d-secure-payment.php      : Create a 3D Secure payment using JSON
  	- create-payment-api.php            : Create a payment via our API using JSON
  	- create-payment-api-travelData.php : Create a payment via our API, including travel data, using JSON
  	- create-payment-cse.php            : Create a Client-Side Encrypted payment using JSON
  - Library
    - authorise-3d-secure-payment.php   : Authorise a 3D Secure payment using PHP Library
    - create-3d-secure-payment.php      : Create a 3D Secure payment using PHP Library
    - create-payment-api.php            : Create a payment via our API using PHP Library
   	- create-payment-api-travelData.php : Create a payment via our API, including travel data, using PHP Library
   	- create-payment-cse.php            : Create a Client-Side Encrypted payment using PHP Library
  - soap
    - authorise-3d-secure-payment.php   : Authorise a 3D Secure payment using SOAP
    - create-3d-secure-payment.php      : Create a 3D Secure payment using SOAP
   	- create-payment-api.php            : Create a payment via our API using SOAP
   	- create-payment-api-travelData.php : Create a payment via our API, including travel data, using SOAP
   	- create-payment-cse.php            : Create a Client-Side Encrypted payment using SOAP
 - js
    - adyen.encrypt.min.js              : JavaScript file required for encrypting card data
3. Notifications
  - httppost
    - notification-server.php           : Receive our notifications using HTTP Post
  - soap
    - notification-server.php           : Receive our notifications using SOAP
4. Modifications  
  - Library
    - cancel-or-refund.php              : Cancel or refund a payment using PHP Library
    - cancel.php                        : Cancel a payment using PHP Library
    - capture.php                       : Capture a payment using PHP Library
    - refund.php                        : Request a refund using PHP Library
  - soap
    - cancel-or-refund.php              : Cancel or refund a payment using SOAP
    - cancel-soap.php                   : Cancel a payment using SOAP
    - capture-soap.php                  : Capture a payment using SOAP
    - refund-soap.php                   : Request a refund using SOAP
5. Recurring
  - Library
    - create-recurring-payment.php      : Create a recurring payment
    - disable-recurring-contract.php    : Disable a recurring contract for a shopper
    - request-recurring-contract.php    : Request a recurring contact for a shopper
  - soap
    - create-recurring-payment.php      : Create a recurring payment
    - disable-recurring-contract.php    : Disable a recurring contract for a shopper
    - request-recurring-contract.php    : Request a recurring contact for a shopper
6. PaymentMethods
  -JSON
    - get-payment-methods-SHA-256.php   : Get payment methods available for merchant account
  -Library
    - get-payment-methods.php           : Get payment methods available for merchant account using PHP Library
7. OpenInvoice
  - httppost
    - openinvoice-server.php            : Implementation of Open Invoice service
  - soap
    - openinvoice-server.php            : Implementation of Open Invoice service
8. Customfields
  - httppost
    - customfields-server.php           : Custom fields service
  - soap
    - customfields-server.php           : Custom fields service
```
## Documentation
The code examples are based on our developer documentation, which provides comprehensive information on how the Adyen platform works. For more information, refer to the [Adyen Documentation](https://docs.adyen.com/). 

## Questions?
If you have any questions or suggestions regarding this repository, please contact us at support@adyen.com.
