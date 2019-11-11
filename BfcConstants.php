<?php
class BfcConstants {

    // Basically the plugin's database.
    // All data is being serialized and stored in the table 'wp_options'.
    // These constants store the tags that are being used in the field wp_options.option_name .
    const DB_STORAGE_KEY_INVOICES = 'bitcoin-fortune-cookie-invoices';
    const DB_STORAGE_KEY_BTCPAY_APP_LINK = 'bitcoin-fortune-cookie-btcpay-app-link';

    const FORTUNES_FILE_NAME = 'fortunes.txt';

    // Settings page
    const SETTINGS_PAGE_TITLE = 'Bitcoin Fortune Cookie';
    const SETTINGS_PAGE_BROWSER_TITLE = 'Fortune Cookie Settings';
    const SETTINGS_PAGE_SLUG = 'bitcoin-fortune-cookie-settings'; // What's added to the URL to create the settings pages' own unique URL
    const SETTINGS_PAGE_DASHICON_SYMBOL = 'dashicons-star-half';
    const SETTINGS_PAGE_MENU_TITLE = 'Fortune Cookie';
    const SETTINGS_PAGE_POSITION = 66; // Just below the "Plugins" menu entry
    const SETTINGS_PAGE_BTCPAY_SECTION_TITLE = 'BTCPay Settings';
    const SETTINGS_PAGE_BTCPAY_SECTION_DESCRIPTION = 'Connection to BTCPay Server';
    const SETTINGS_PAGE_BTCPAY_APP_LINK_FIELD_DESCRIPTION = 'BTCPay app URL';
}