<?php

/*
Security - содержит методы, которые помогают создавать 
безопасные приложения, обрабатывая данные для безопасности
*/
class Security {

	//одностороннее хэширование на основе crypt
	public static function useCrypt($string, $salt = '', $hash = CRYPT_SHA256) {
		if ($hash == 1) {
			return crypt($string);
		}
	}

	//генерация хэш-кода на основе hash
	public static function useHash($string, $algo = 'md5') {
		switch ($algo) {
			case 'md5':
				return md5($string);
				break;
			
			case 'sha1':
				return sha1($string);
				break;

			case 'sha256';
				return hash('sha256', $string);
				break;

			case 'sha512';
				return hash('sha512', $string);
				break;

			default:
				return md5($string);
				break;
		}
	}

	//функция генерации паролей
	public static function passGenerator($length, $mode = 'all') {

		//допустимые символы
		switch ($mode) {

			//только буквы
			case 'letter':
				$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
				break;

			//только числа
			case 'number':
				$chars = "0123456789";
				break;

			//числа и буквы
			case 'all':
				$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
				break;

			default:
				$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
				break;
		}

		//возврат случайной строки заданной длины
		return substr(str_shuffle($chars),0, $length);
	}

	//xss фильтрация данных
	/*
	Более подробно - http://ha.ckers.org/xss.html
	*/
	public static function xssFilter($data) {

		//entities
		$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
		$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
		$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
		$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

		//удаление всех "on" или xmlns атрибутов
		$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

		//удаление javascript vbscript
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

		//IE: <span style="width: expression(alert('Ping!'));"></span>
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

		$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

		do {
			//удаление нежелательных тегов
			$old_data = $data;
			$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
		}
		while ($old_data !== $data);

		//возвращаем обработанные данные
		return $data;
	}

	//фильтр php тегов
	public static function phpFilter($data) {
		$data = str_replace(array('<?php', '<?PHP', '<?', '?>'),  array('&lt;?php', '&lt;?PHP', '&lt;?', '?&gt;'), $data);
		return $data;
	}
}