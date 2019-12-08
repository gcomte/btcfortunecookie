<?php

// load wordpress
require(dirname(__FILE__, 5) . '/wp-load.php' );

require_once(dirname(__FILE__, 2) . '/BfcConstants.php');
require_once(dirname(__FILE__, 2) . '/model/Invoices.php');
require_once(dirname(__FILE__, 2) . '/BitcoinFortunes.php');
require_once(dirname(__FILE__, 2) . '/wp-backend/SettingsPage.php');

$btcPayNotification = new BTCPayNotification();
$btcPayNotification->processNotification();

class BTCPayNotification {

    const BTCPAY_INVOICE_NEW = 'NEW';
    const BTCPAY_INVOICE_CONFIRMED = 'CONFIRMED';
    const BTCPAY_INVOICE_COMPLETE = 'COMPLETE';
    const DB_INVOICE_STATUS_PAID = 'PAID';
    const BTCPAY_INTERFACE_FILENAME = 'BTCPayInterface.log';

    private $settingsPage;

    public function __construct(){
        $this->settingsPage = new SettingsPage();
    }

    // After an invoice has been paid, BTCPay sends notification information to this script
    public function processNotification(){
        $notificationData = json_decode(file_get_contents('php://input'));
        $btcPayInvoiceId = ($notificationData->data->id ? $notificationData->data->id : $notificationData->id);

        // make request to BTCPay to verify the invoice is valid and paid
        $btcPayInvoiceData = $this->requestVerificationData($btcPayInvoiceId);

        if($this->isInvoiceNew($btcPayInvoiceData)){
            // Notification that announces a new but not yet paid invoice, can be ignored.
            $this->logInfo('A new invoice has been created. Id: ' . $btcPayInvoiceId);
            return;
        }

        if(!$this->isInvoiceValid($btcPayInvoiceData, $btcPayInvoiceId, $_GET['cookie'])){
            $this->writeErrorLogAndDie($btcPayInvoiceData, $btcPayInvoiceId, $_GET['cookie']);
        }

        $this->logInfo('Invoice paid! Id: ' . $btcPayInvoiceId . ', Status: ' . $btcPayInvoiceData->data->status);
        $this->storePaidInvoice($btcPayInvoiceData);
    }

    private function requestVerificationData($btcPayInvoiceId){
        $options = array(
            'http'=>array(
                'method'=>'GET',
                'header'=>'Authorization: Basic ' . $this->settingsPage->getBTCPayApiKey() . "\r\n" .
                    "Content-Type: application/json\r\n"
            )
        );

        $context = stream_context_create($options);
        return json_decode(file_get_contents($this->settingsPage->getBTCPayInvoiceURL() . '/' . $btcPayInvoiceId, false, $context));
    }

    private function isInvoiceNew($btcPayInvoiceData){
        return strtoupper($btcPayInvoiceData->data->status) == self::BTCPAY_INVOICE_NEW;
    }

    private function isInvoiceValid($btcPayInvoiceData, $btcPayInvoiceId, $cookieId){
        $btcPayInvoiceIsValid = $btcPayInvoiceData->data->id == $btcPayInvoiceId;
        $cookieIdIsValid = $btcPayInvoiceData->data->orderId == $cookieId;
        $invoiceIsPaid = strtoupper($btcPayInvoiceData->data->status) == self::BTCPAY_INVOICE_CONFIRMED || strtoupper($btcPayInvoiceData->data->status) == self::BTCPAY_INVOICE_COMPLETE;

        return $btcPayInvoiceIsValid && $cookieIdIsValid && $invoiceIsPaid;
    }

    private function storePaidInvoice($btcPayInvoiceData){
        $bitcoinFortunes = new BitcoinFortunes();
        $invoice = Invoices::getInstance();

        $invoice->storeInvoice($btcPayInvoiceData->data->orderId, $btcPayInvoiceData->data->id, self::DB_INVOICE_STATUS_PAID, time(), $bitcoinFortunes->getFortune());
    }

    private function writeErrorLogAndDie($btcPayInvoiceData, $btcPayInvoiceId, $cookieId){
        $prefix2 = '[Invalid Invoice] ';

        $this->logError($prefix2 . 'BtcPay Invoice Id = ' . var_export($btcPayInvoiceId, true));
        $this->logError($prefix2 . 'Cookie Id = ' . var_export($cookieId, true));
        $this->logError($prefix2 . 'Invoice Data -> Status = ' . var_export($btcPayInvoiceData->data->status, true));
        $this->logError($prefix2 . 'Invoice Data = ' . var_export($btcPayInvoiceData, true));

        die();
    }

    private function logEvent($message, $prefix) {
        $logFile = dirname(__FILE__, 2) . '/' . self::BTCPAY_INTERFACE_FILENAME;
        $now = date('d.m.Y H:i:s', time());

        if($prefix){
            $prefix = "$now [$prefix] ";
        }

        file_put_contents($logFile, "\n" . $prefix . $message, FILE_APPEND);
    }

    private function logError($message) {
        $this->logEvent($message, 'ERROR');
    }

    private function logInfo($message) {
        $this->logEvent($message, 'INFO');
    }
}