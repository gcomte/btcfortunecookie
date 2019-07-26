<?php

if(!defined('ABSPATH')) {
	die;
}

define('FORTUNES_FILE', dirname(__FILE__) . '/fortunes.txt');

class BitcoinFortunes {
	protected function getFortunes(){

		if(!isset($this->loadedFortunes)){
			$this->loadedFortunes = file(FORTUNES_FILE, FILE_IGNORE_NEW_LINES);
		}

		return $this->loadedFortunes;
	}
	
	public function getFortune() {
		$fortunes = $this->getFortunes();
		return $fortunes[array_rand($fortunes)];
      	}

}

