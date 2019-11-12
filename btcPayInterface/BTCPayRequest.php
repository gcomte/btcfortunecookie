<?php

if (!defined('ABSPATH')) {
    die;
}

require_once(dirname(__FILE__, 2) . '/BfcConstants.php');

class BTCPayRequest{

    const BTCPAY_NOTIFICATIONS_PAGE = 'BTCPayNotification.php';

    private $btcPayAppURL;
    private $btcPayNotificationsPage;

    public function __construct($btcPayAppURL){
        $this->btcPayAppURL = $btcPayAppURL;
        $this->btcPayNotificationsPage = $this->getScriptUrl();
    }

    public function getDisplayBTCPayButtonHTML() {
        global $wp;
        $orderId = uniqid();
        $thisUrl = home_url(add_query_arg(array(), $wp->request));

        return $this->getButtonHTML($this->btcPayAppURL, $orderId, $this->btcPayNotificationsPage, $thisUrl, BfcConstants::BTCPAY_BUTTON_TEXT);
    }

    private function getButtonHTML($btcPayAppUrl, $orderId, $notificationUrl, $redirectUrl, $buttonText) {
        return '
        <form method="POST" action="' . $btcPayAppUrl . '">
            <input type="hidden" name="orderId" value="' . $orderId . '" />
            <input type="hidden" name="notificationUrl" value="' . $notificationUrl . '?cookie=' . $orderId . '" />
            <input type="hidden" name="redirectUrl" value="' . $redirectUrl . '?cookie=' . $orderId . '" />
            <button type="submit" name="choiceKey" value="virtual cookie">' . $buttonText . '</button>
        </form>
        ';
    }

    private function getScriptUrl(){
        $fullPath = dirname(__FILE__);
        $directory = substr($fullPath, strpos($fullPath, 'wp-content'));
        return get_site_url(null, '/' . $directory . '/' . self::BTCPAY_NOTIFICATIONS_PAGE);
    }

}