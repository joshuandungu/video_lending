<?php
session_start();
include '../includes/db.php';
require 'vendor/autoload.php'; // PayPal SDK

use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

// Payment details
if (isset($_GET['rental_id'])) {
    $rental_id = $_GET['rental_id'];
    $user_id = $_SESSION['user_id'];
    $late_fee = $_GET['late_fee'];

    $payer = new Payer();
    $payer->setPaymentMethod("paypal");

    $item = new Item();
    $item->setName("Late Fee")
        ->setCurrency("USD")
        ->setQuantity(1)
        ->setPrice($late_fee);

    $itemList = new ItemList();
    $itemList->setItems([$item]);

    $amount = new Amount();
    $amount->setCurrency("USD")->setTotal($late_fee);

    $transaction = new Transaction();
    $transaction->setAmount($amount)
                ->setItemList($itemList)
                ->setDescription("Payment for late fee")
                ->setInvoiceNumber(uniqid());

    $redirectUrls = new RedirectUrls();
    $redirectUrls->setReturnUrl("http://yourwebsite.com/success.php")
                 ->setCancelUrl("http://yourwebsite.com/cancel.php");

    $payment = new Payment();
    $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

    try {
        $payment->create($apiContext);
        header("Location: " . $payment->getApprovalLink());
        exit();
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
        exit(1);
    }
}
?>
