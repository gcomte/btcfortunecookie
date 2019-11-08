<?php
class BfcConstants {

    // Basically the plugin's database.
    // All data is being serialized and stored in the table 'wp_options'.
    // These constants store the tags that are being used in the field wp_options.option_name .
    const DB_STORAGE_KEY_SETTINGS = 'bitcoin-fortune-cookie';
    const DB_STORAGE_KEY_INVOICES = 'bitcoin-fortune-cookie-invoices';
}