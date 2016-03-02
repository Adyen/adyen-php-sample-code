Adyen PHP Integration
==============
The code examples in this reposity help you integrate with the Adyen platform using PHP. Please go through the code examples and read the documentation in the files itself. Each code example requires you to change some parameters to connect to your Adyen account such as merchant account and skincode.    


## PHP API Library
We have made a Library available that contains all of these APIs to make the integration easier.
[The Library is open-source and availabel here](https://github.com/Adyen/adyen-php-api-library) 

## Code structure
```
1.HPP (Hosted Payment Page)
  - create-payment-on-hpp.php           : Simple form creating a payment on our HPP;
  - create-payment-on-hpp-advanced.php  : Advanced form creating a payment on our HPP;
2. API
  - httppost
  	- create-payment-api.php            : Create a payment via our API;
  	- create-payment-cse.php            : Create a Client-Side Encrypted payment;
  - soap
  	- create-payment-api.php            : Create a payment via our API;
  	- create-payment-cse.php            : Create a Client-Side Encrypted payment;
  - js
    - adyen.encrypt.min.js              : JavaScript file required for encrypting card data;
3.Notifications
  - httppost
    - notification-server.php           : Receive our notifications using HTTP Post;
  - soap
    - notification-server.php           : Receive our notification using SOAP;
4.Modifications  
  - httppost
    - cancel-or-refund.php              : Cancel or refund a payment using HTTP Post;
    - cancel.php                        : Cancel a payment using HTTP Post;
    - capture.php                       : Capture a payment using HTTP Post;
    - refund.php                        : Request a refund using HTTP Post;
  - soap
    - cancel-or-refund.php              : Cancel or refund a payment using SOAP;
    - cancel-soap.php                   : Cancel a payment using SOAP;
    - capture-soap.php                  : Capture a payment using SOAP;
    - refund-soap.php                   : Request a refund using SOAP;
5.Recurring
  - httppost
    - create-recurring-payment.php      : Create a recurring payment;
    - disable-recurring-contract.php    : Disable a recurring contract for a shopper;
    - request-recurring-contract.php    : Request a recurring contact for a shopper;
  - soap
    - create-recurring-payment.php      : Create a recurring payment;
    - disable-recurring-contract.php    : Disable a recurring contract for a shopper;
    - request-recurring-contract.php    : Request a recurring contact for a shopper;
6.PaymentMethods
  - get-payment-methods.php             : Get payment methods available for merchant account.
7.OpenInvoice
  - httppost
    - openinvoice-server.php            : Implementation of Open Invoice service.
  - soap
    - openinvoice-server.php            : Implementation of Open Invoice service.
8.Customfields
  - httppost
    - customfields-server.php           : Custom fields service.
  - soap
    - customfields-server.php           : Custom fields service.
```
## Manuals
The code examples are based on our Integration manual and the API manual which provides rich information on how our platform works. Please find our manuals on the Developers section at www.adyen.com. 

## Support
If you do have any suggestions or questions regarding the code examples please send an e-mail to support@adyen.com.
