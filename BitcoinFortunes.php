<?php

if(!defined('ABSPATH')) {
	die;
}

require_once(dirname(__FILE__) . '/BfcConstants.php');

class BitcoinFortunes {
	protected function getFortunes(){

		if(!isset($this->loadedFortunes)){
		    $filename = dirname(__FILE__) . '/' . BfcConstants::FORTUNES_FILE_NAME;
			$this->loadedFortunes = file($filename, FILE_IGNORE_NEW_LINES);
		}

		return $this->loadedFortunes;
	}
	
	public function getFortune() {
		$fortunes = $this->getFortunes();
		return $fortunes[array_rand($fortunes)];
	}
}

