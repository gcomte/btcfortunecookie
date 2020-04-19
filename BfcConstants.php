<?php
class BfcConstants {

    // Basically the plugin's database.
    // All data is being serialized and stored in the table 'wp_options'.
    // These constants store the tags that are being used in the field wp_options.option_name .
    const DB_STORAGE_KEY_INVOICES = 'bitcoin-fortune-cookie-invoices';
    const DB_STORAGE_KEY_WP_PAGE_COOKIE = 'bitcoin-fortune-cookie-wp-page-for-cookie';
    const DB_STORAGE_KEY_BTCPAY_APP_URL = 'bitcoin-fortune-cookie-btcpay-app-url';
    const DB_STORAGE_KEY_BTCPAY_INVOICE_URL = 'bitcoin-fortune-cookie-btcpay-invoice-url';
    const DB_STORAGE_KEY_BTCPAY_API_KEY = 'bitcoin-fortune-cookie-btcpay-api-key';

    const FORTUNES_FILE_NAME = 'fortunes.txt';

    // HTML PAGES
    const CREATE_COOKIE_PAGE_RELATIVE_PATH = 'src/html/createCookie.html';
    const OPEN_COOKIE_PAGE_RELATIVE_PATH = 'src/html/openCookie.html';
    const INVALID_COOKIE_PAGE_RELATIVE_PATH = 'src/html/invalidCookie.html';

    const FRONTEND_CSS_HANDLE = 'fortuneCookieFrontendCSS';
    const FRONTEND_CSS_URL_PATH = 'wp-content/plugins/btcfortunecookie/src/css/fortuneCookie.css';

    const IMAGES_DIRECTORY_URL = 'wp-content/plugins/btcfortunecookie/src/images';
    const INVALID_COOKIE_IMAGE_FILENAME = '20200419-Cookie-404_Fortune_Not_Found.png';

    const INVALID_COOKIE_MESSAGE_PLACEHOLDER = '<invalid-cookie-message-placeholder />';
    const INVALID_COOKIE_IMAGE_PLACEHOLDER = 'INVALID_COOKIE_IMAGE_SOURCE_PLACEHOLDER';

    // GUI
    const BTCPAY_BUTTON_TEXT = 'Crack that Cookie Open ⚡';
    const INVALID_COOKIE_TEXT = 'This cookie is invalid.';
    const EXPIRED_COOKIE_TEXT = 'This cookie is expired. Cookies expire after 30 days.';

    // Settings page
    const SETTINGS_PAGE_TITLE = 'Bitcoin Fortune Cookie';
    const SETTINGS_PAGE_BROWSER_TITLE = 'Fortune Cookie Settings';
    const SETTINGS_PAGE_SLUG = 'bitcoin-fortune-cookie-settings'; // What's added to the URL to create the settings pages' own unique URL
    const SETTINGS_PAGE_DASHICON_SYMBOL = 'dashicons-star-half';
    const SETTINGS_PAGE_MENU_TITLE = 'Fortune Cookie';
    const SETTINGS_PAGE_POSITION = 66; // Just below the "Plugins" menu entry
    const SETTINGS_PAGE_WP_SECTION_TITLE = 'WordPress Settings';
    const SETTINGS_PAGE_WP_PAGE_FOR_COOKIE_DESCRIPTION = 'Container-page for the cookie';
    const SETTINGS_PAGE_BTCPAY_SECTION_TITLE = 'BTCPay Settings';
    const SETTINGS_PAGE_BTCPAY_SECTION_DESCRIPTION = 'Connection to BTCPay Server';
    const SETTINGS_PAGE_BTCPAY_APP_URL_FIELD_DESCRIPTION = 'BTCPay app URL';
    const SETTINGS_PAGE_BTCPAY_INVOICES_URL_FIELD_DESCRIPTION = 'BTCPay invoices URL';
    const SETTINGS_PAGE_BTCPAY_API_KEY_FIELD_DESCRIPTION = 'BTCPay Legacy API Key';
    const SETTINGS_PAGE_INVOICES_SECTION_TITLE = 'Past Fortune Cookie Requests';
    const SETTINGS_PAGE_INVOICES_FIELD_DESCRIPTION = 'Count of all paid invoices';
}