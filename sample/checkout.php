<?php
require_once('bootstrap.php');
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentCard;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;

$apiContext = new PayPal\Rest\ApiContext(
    new PayPal\Auth\OAuthTokenCredential(
        'ASi0-EhxUkf7fIAUMcP4Qt9wFmELBRaVJSni2znvIk2H-ZYtCmzzi7b2XH5zh0GpRDTf1Ot_1EhIohpe',     // ClientID
        'EKoZ4H3l2GmZeQfLnzy81IDv2c298yjftuGl_v1hV2ag7WGvV3TEqeMqPxC_s1vfwwqX3BnyHE4VaJx_'      // ClientSecret
    )
);



$payer = new Payer();

$payer->setPaymentMethod('paypal');


$item1 = new Item();
$item1->setName('Ground Coffee 40 oz')
    ->setCurrency('USD')
    ->setQuantity(1)
    ->setSku("123123") // Similar to `item_number` in Classic API
    ->setPrice(7.5);
$item2 = new Item();
$item2->setName('Granola bars')
    ->setCurrency('USD')
    ->setQuantity(5)
    ->setSku("321321") // Similar to `item_number` in Classic API
    ->setPrice(2);


$itemList = new ItemList();
$itemList->setItems(array($item1, $item2));

$details = new Details();
$details->setShipping(1.2)
    ->setTax(1.3)
    ->setSubtotal(17.50);

$amount = new Amount();
$amount->setCurrency("USD")
    ->setTotal(20.00)
    ->setDetails($details);


$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription("Payment description")
    ->setInvoiceNumber(uniqid());

$baseUrl = getBaseUrl();
$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("$baseUrl/confirm-transaction.php?success=true")
    ->setCancelUrl("$baseUrl/confirm-transaction.php?success=false");

$payment = new Payment();
$payment->setIntent("sale")
    ->setPayer($payer)
    ->setRedirectUrls($redirectUrls)
    ->setTransactions(array($transaction));

$request = clone $payment;

try {
    $payment->create($apiContext);
    } catch (Exception $ex) {
        ResultPrinter::printError("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", null, $request, $ex);
        exit(1);
    }

$approvalUrl = $payment->getApprovalLink();

ResultPrinter::printResult("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $payment);

return $payment;


?>