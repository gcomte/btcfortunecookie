<?php

if (!defined('ABSPATH')) {
    die;
}

require_once(dirname(__FILE__, 2) . '/BfcConstants.php');
require_once(dirname(__FILE__, 2) . '/model/Invoices.php');

class SettingsPage {

    const BTCPAY_SECTION_KEY = 'btcpay_section';
    const INVOICES_SECTION_KEY = 'invoices_section';
    const BACKEND_CSS_LABEL = 'bitcoin-fortune-cookie-backend';
    const BACKEND_CSS_FILE = 'bitcoin-fortune-cookie-backend.css';

    public function __construct(){
        // Allow page to call options.php and write settings to options table
        register_setting(BfcConstants::SETTINGS_PAGE_SLUG, BfcConstants::DB_STORAGE_KEY_BTCPAY_APP_URL);
        register_setting(BfcConstants::SETTINGS_PAGE_SLUG, BfcConstants::DB_STORAGE_KEY_BTCPAY_INVOICE_URL);
        register_setting(BfcConstants::SETTINGS_PAGE_SLUG, BfcConstants::DB_STORAGE_KEY_BTCPAY_API_KEY);

        add_action('admin_init', array($this, 'addBackendCSS'));
    }

    public function injectPluginSettingsPage() {
        // Hook into the admin menu
        add_action('admin_menu', array($this, 'createPluginSettingsPage'));
        add_action('admin_init', array($this, 'setupSections'));
        add_action('admin_init', array($this, 'setupBTCPayFields'));
        add_action('admin_init', array($this, 'setupInvoicesFields'));
    }

    public function createPluginSettingsPage() {

        // Add the menu item and page
        $capability = 'manage_options';
        $callback = array( $this, 'pluginSettingsPageContent' );

        add_menu_page(
            BfcConstants::SETTINGS_PAGE_BROWSER_TITLE,
            BfcConstants::SETTINGS_PAGE_MENU_TITLE,
            $capability,
            BfcConstants::SETTINGS_PAGE_SLUG,
            $callback,
            BfcConstants::SETTINGS_PAGE_DASHICON_SYMBOL,
            BfcConstants::SETTINGS_PAGE_POSITION
        );
    }

    public function setupSections(){
        add_settings_section(self::BTCPAY_SECTION_KEY, BfcConstants::SETTINGS_PAGE_BTCPAY_SECTION_TITLE, array($this, 'btcpaySectionCallback'), BfcConstants::SETTINGS_PAGE_SLUG);
        add_settings_section(self::INVOICES_SECTION_KEY, BfcConstants::SETTINGS_PAGE_INVOICES_SECTION_TITLE, null, BfcConstants::SETTINGS_PAGE_SLUG);
    }

    public function pluginSettingsPageContent() {
        ?>
        <div class="wrap">
            <h2><?php echo BfcConstants::SETTINGS_PAGE_TITLE ?></h2>
            <form method="POST" action="options.php">
                <?php
                settings_fields(BfcConstants::SETTINGS_PAGE_SLUG);
                do_settings_sections(BfcConstants::SETTINGS_PAGE_SLUG);
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function btcpaySectionCallback(){
        echo BfcConstants::SETTINGS_PAGE_BTCPAY_SECTION_DESCRIPTION;
    }

    public function setupBTCPayFields() {
        add_settings_field(BfcConstants::DB_STORAGE_KEY_BTCPAY_APP_URL, BfcConstants::SETTINGS_PAGE_BTCPAY_APP_URL_FIELD_DESCRIPTION, array($this, 'btcpayAppUrlFieldCallback'), BfcConstants::SETTINGS_PAGE_SLUG, self::BTCPAY_SECTION_KEY);
        add_settings_field(BfcConstants::DB_STORAGE_KEY_BTCPAY_INVOICE_URL, BfcConstants::SETTINGS_PAGE_BTCPAY_INVOICES_URL_FIELD_DESCRIPTION, array($this, 'btcpayInvoiceUrlFieldCallback'), BfcConstants::SETTINGS_PAGE_SLUG, self::BTCPAY_SECTION_KEY);
        add_settings_field(BfcConstants::DB_STORAGE_KEY_BTCPAY_API_KEY, BfcConstants::SETTINGS_PAGE_BTCPAY_API_KEY_FIELD_DESCRIPTION, array($this, 'btcpayApiKeyFieldCallback'), BfcConstants::SETTINGS_PAGE_SLUG, self::BTCPAY_SECTION_KEY);
    }

    public function btcpayAppUrlFieldCallback($arguments){
        echo '<input name="' . BfcConstants::DB_STORAGE_KEY_BTCPAY_APP_URL . '" id="' . BfcConstants::DB_STORAGE_KEY_BTCPAY_APP_URL . '" type="text" value="' . get_option(BfcConstants::DB_STORAGE_KEY_BTCPAY_APP_URL) . '" />';
    }

    public function btcpayInvoiceUrlFieldCallback($arguments){
        echo '<input name="' . BfcConstants::DB_STORAGE_KEY_BTCPAY_INVOICE_URL . '" id="' . BfcConstants::DB_STORAGE_KEY_BTCPAY_INVOICE_URL . '" type="text" value="' . get_option(BfcConstants::DB_STORAGE_KEY_BTCPAY_INVOICE_URL) . '" />';
    }

    public function btcpayApiKeyFieldCallback($arguments){
        echo '<input name="' . BfcConstants::DB_STORAGE_KEY_BTCPAY_API_KEY . '" id="' . BfcConstants::DB_STORAGE_KEY_BTCPAY_API_KEY . '" type="text" value="' . get_option(BfcConstants::DB_STORAGE_KEY_BTCPAY_API_KEY) . '" />';
    }

    public function setupInvoicesFields() {
        add_settings_field(BfcConstants::DB_STORAGE_KEY_BTCPAY_APP_URL, BfcConstants::SETTINGS_PAGE_INVOICES_FIELD_DESCRIPTION, array($this, 'getInvoicesCount'), BfcConstants::SETTINGS_PAGE_SLUG, self::INVOICES_SECTION_KEY);

    }

    public function getInvoicesCount() {
        $invoices = Invoices::getInstance();
        echo $invoices->getInvoicesCount();
    }

    public function getBTCPayAppURL() {
        return get_option(BfcConstants::DB_STORAGE_KEY_BTCPAY_APP_URL);
    }

    public function getBTCPayInvoiceURL() {
        return get_option(BfcConstants::DB_STORAGE_KEY_BTCPAY_INVOICE_URL);
    }

    public function getBTCPayApiKey() {
        return get_option(BfcConstants::DB_STORAGE_KEY_BTCPAY_API_KEY);
    }

    public function addBackendCSS() {
        wp_register_style(self::BACKEND_CSS_LABEL, $this->getBackendCssURL());
        wp_enqueue_style(self::BACKEND_CSS_LABEL);
    }

    private function getBackendCssURL(){
        $fullPath = dirname(__FILE__);
        $directory = substr($fullPath, strpos($fullPath, 'wp-content'));
        return get_site_url(null, '/' . $directory . '/' . self::BACKEND_CSS_FILE);
    }
}