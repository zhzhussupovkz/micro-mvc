<?php

//MException class
class MException extends Exception {

	protected $file;

	protected $line;

	public function __construct($message = null, $code = 0, $file = '', $line = '') {
		parent::__construct($message, $code);
		$this->file = $file;
		$this->line = $line;
		$this->logging();
	}

	public function getFileName() {
		return $this->file;
	}

	public function getErrorLine() {
		return $this->line;
	}

	private function logging() {
		$line = $this->message.' in '.$this->getFileName().' on line '.$this->getErrorLine();
		Logger::error($line);
	}
}

