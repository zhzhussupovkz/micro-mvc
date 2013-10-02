<?php

//Email - класс для отправки почты
class EmailHelper extends Helper {

	//имя отправителя
	public $name_from;

	//email отправителя
	public $email_from;

	//имя получателя
	public $name_to;

	//email получателя
	public $email_to;

	//кодировка переданных данных
	public $data_charset = 'UTF-8';

	//кодировка письма
	public $letter_charset = 'KOI8-R';

	//тема письма
	public $subject;

	//текст
	public $body;

	//static метод содержащий объект класса EmailHelper
	public static $instance;

	/*
	создаем объект EmailHelper и 
	сохраняем его в статичном методе $instance
	*/
	public static function create() {
		if(!isset(self::$instance)) {
			self::$instance = new self;
		}

		//возвращаем $instance
		return self::$instance;
	}

	//кодировка
	public function headerEncoding($str, $data_charset, $letter_charset)
	{
		if($data_charset != $letter_charset) 
		{
			$str = iconv($data_charset, $letter_charset, $str);
		}
		return '=?' . $letter_charset . '?B?' . base64_encode($str) . '?=';
	}

	//отправка письма
	public function send()
	{
		$from = $this->headerEncoding($this->name_from, $this->data_charset, $this->letter_charset).'<'.$this->email_from.'>';
		$to = $this->headerEncoding($this->name_to, $this->data_charset, $this->letter_charset).'<'.$this->email_to.'>';
		$subject = $this->headerEncoding($this->subject, $this->data_charset, $this->letter_charset);
		if($this->data_charset != $this->letter_charset)
		{
			$body = iconv($this->data_charset, $this->letter_charset, $this->body);
		}
		$myemail = $this->email_from;
		$headers="From: {$from}\r\n".
			"Reply-To: {$myemail}\r\n".
			"MIME-Version: 1.0\r\n".
			"Content-type: text/plain; charset={$this->letter_charset}";
		return mail($to, $subject, $body, $headers);
	}
}