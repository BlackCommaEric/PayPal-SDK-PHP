<?php
// 1. Autoload the SDK Package. This will include all the files and classes to your autoloader
// Used for composer based installation
require_once 'bootstrap.php';
// Use below for direct download installation
// require __DIR__  . '/PayPal-PHP-SDK/autoload.php';

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'ASi0-EhxUkf7fIAUMcP4Qt9wFmELBRaVJSni2znvIk2H-ZYtCmzzi7b2XH5zh0GpRDTf1Ot_1EhIohpe',     // ClientID
        'EKoZ4H3l2GmZeQfLnzy81IDv2c298yjftuGl_v1hV2ag7WGvV3TEqeMqPxC_s1vfwwqX3BnyHE4VaJx_'      // ClientSecret
    )
);

$creditCard = new \PayPal\Api\CreditCard();

$creditCard->setType("visa")
    ->setNumber("4417119669820331")
    ->setExpireMonth("11")
    ->setExpireYear("2019")
    ->setCvv2("012")
    ->setFirstName("Joe")
    ->setLastName("Shopper");

echo $creditCard;

// try {
//     $creditCard->create($apiContext);
//     echo $creditCard;
// }
// catch (\PayPal\Exception\PayPalConnectionException $ex) {
//     // This will print the detailed information on the exception. 
//     //REALLY HELPFUL FOR DEBUGGING
//     echo $ex->getData();
// }