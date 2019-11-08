<?php

if(!defined('ABSPATH')) {
    die;
}

require_once(dirname(__FILE__, 2) . '/BfcConstants.php');

// Singleton: ensures $cachedInvoices is always at up-to-date
class Invoices {

    const INVOICES_ARRAY_KEY_BTCPAY_ID = 'btcPay_id';
    const INVOICES_ARRAY_KEY_STATUS = 'status';
    const INVOICES_ARRAY_KEY_DATE = 'date';
    const INVOICES_ARRAY_KEY_QUOTE = 'quote';

    private static $instance = null;
    private $cachedInvoices;

    private function __construct() {
        // Make constructor private --> singleton pattern
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Invoices();
        }

        return self::$instance;
    }

    public function storeInvoice($cookieId, $btcPayId, $status, $date, $quote) {
        $invoices = $this->getInvoices();
        $invoices[$cookieId] = array (
            self::INVOICES_ARRAY_KEY_BTCPAY_ID => $this->sanitizeData($btcPayId),
            self::INVOICES_ARRAY_KEY_STATUS => $this->sanitizeData($status),
            self::INVOICES_ARRAY_KEY_DATE => $this->sanitizeData($date),
            self::INVOICES_ARRAY_KEY_QUOTE => $this->sanitizeData($quote),
        );

        $this->cachedInvoices = $invoices;
        update_option(bfcConstants::DB_STORAGE_KEY_INVOICES, serialize($invoices));
    }

    private function getInvoices () {
        if ($this->cachedInvoices == null) {
            $this->cachedInvoices = unserialize(get_option(bfcConstants::DB_STORAGE_KEY_INVOICES));
        }

        return $this->cachedInvoices;
    }

    public function getInvoiceById ($cookieId) {
        $invoices = $this->getInvoices();

        if (!array_key_exists($cookieId, $invoices)) {
            return array();
        }

        return $invoices[$cookieId];
    }

    /**
     * @param $unixTimestamp: Delete all invoices that are older than this timestamp
     */
    public function purgeOldInvoices($unixTimestamp) {
        foreach ($this->getInvoices() as $cookieId => $invoiceData) {
            if ($invoiceData[self::INVOICES_ARRAY_KEY_DATE] < $unixTimestamp) {
                unset($this->cachedInvoices[$cookieId]);
            }
        }

        update_option(bfcConstants::DB_STORAGE_KEY_INVOICES, serialize($this->cachedInvoices));
    }

    private function sanitizeData($data) {
        return strip_tags(stripslashes($data));
    }

}