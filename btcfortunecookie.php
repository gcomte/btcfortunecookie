<?php
/**
 * @package btcfortunecookie
 */
/*
Plugin Name: Bitcoin Fortune Cookies 
Plugin URI: http://bitcoinfortunecookie.com
Description: This plugin displays fortunes coming from within virtual fortune cookies
Version: 0.0.3
Author: Gabriel Comte
Author URI: https://gcomte.github.io
License: MIT
Text Domain: bitcoin-fortune-cookie
 */

/*
 Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

if(!defined('ABSPATH')) {
	die;
}

require_once(dirname(__FILE__) . '/wp-backend/SettingsPage.php');
require_once(dirname(__FILE__) . '/btcPayInterface/BTCPayRequest.php');
require_once(dirname(__FILE__) . '/model/Invoices.php');
require_once(dirname(__FILE__) . '/BfcConstants.php');


class BitcoinFortuneCookie {

    private $settingsPage;
    private $invoices;

    public function overwritePageWithCookiePage() {
        add_action('the_content', array($this, 'insertCookieToCookiePage'));
    }

    public function __construct() {
        $this->settingsPage = new SettingsPage();
        $this->settingsPage->injectPluginSettingsPage();
        $this->invoices = Invoices::getInstance();

        // Remove all Invoices that are older than 1 year
        // $invoices->purgeOldInvoices(time() - 60 * 60 * 24 * 365);
    }

    public function insertCookieToCookiePage() {
        $pageWhereCookieShouldBeDisplayed = get_option(BfcConstants::DB_STORAGE_KEY_WP_PAGE_COOKIE);
        if(is_page($pageWhereCookieShouldBeDisplayed)) {
            $this->displayFortuneCookiePage();
        }
    }

	private function displayFortuneCookiePage(){
        if (!isset($_GET['cookie'])) {
            $btcPayRequest = new BTCPayRequest($this->settingsPage->getBTCPayAppURL());
            echo $btcPayRequest->getDisplayBTCPayButtonHTML();
            return;
        } elseif (empty($this->invoices->getInvoiceById($_GET['cookie']))) {
            echo '<p>' . BfcConstants::INVALID_COOKIE_TEXT . '</p>';
        } elseif ($this->invoices->isInvoiceOlderThan($_GET['cookie'], time() - 60 * 60 * 24 * 30)) {
            echo '<p>' . BfcConstants::EXPIRED_COOKIE_TEXT . '</p>';
        } else {
            $this->displayFortune($_GET['cookie']);
        }
	}

    public function displayFortune($cookieId) {
        $quote = $this->invoices->getQuoteByCookieId($cookieId);
        echo '<h1>' . $quote . '</h1>';
    }
}

$bitcoinFortuneCookie = new BitcoinFortuneCookie();
$bitcoinFortuneCookie->overwritePageWithCookiePage();


