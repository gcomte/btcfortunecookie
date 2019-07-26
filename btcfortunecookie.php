<?php
/**
 * @package btcfortunecookie
 */
/*
Plugin Name: Bitcoin Fortune Cookies 
Plugin URI: http://bitcoinfortunecookie.com
Description: This plugin displays fortunes coming from within virtual fortune cookies
Version: 0.0.1
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

require_once(dirname(__FILE__) . '/BitcoinFortunes.php');

class BitcoinFortuneCookie {
	function displayFortune(){

		$bitcoinFortunes = new BitcoinFortunes();
		echo '<h1>' . $bitcoinFortunes->getFortune() . '</h1>';
	}
}

$bitcoinFortuneCookie = new BitcoinFortuneCookie();

add_action('the_content', array($bitcoinFortuneCookie, 'displayFortune'));
