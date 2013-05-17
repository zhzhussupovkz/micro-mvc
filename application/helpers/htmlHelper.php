<?php

//Html - класс для работы с html
class HtmlHelper extends Helper {

	//базовый URL приложения
	public static function baseUrl() {
		return MyApplication::get()->params('baseUrl');
	}

	//загружает js файл
	public static function scriptFile($filename) {
		$scriptFile = self::baseUrl().'/scripts/js/'.$filename;
		$script = '<script type = "text/javascript" src = "'.$scriptFile.'"></script>';
		return $script;
	}

	//загружает css файл
	public static function cssFile($filename) {
		$cssFile = self::baseUrl().'/scripts/css/'.$filename;
		$css = '<link rel="stylesheet" type="text/css" href="'.$cssFile.'"/>';
		return $css;
	}

	//создает ссылку
	public static function link($href, $label) {
		$htmlLink = self::baseUrl().'/'.$href;
		$link = '<a href = '.$htmlLink.'>'.$label.'</a>';
		return $link;
	}

	//создает текстовое поле
	public static function textInput($id, $name = '', $value = '') {
		$input = '<input id = "'.$id.'" type = "text" name = "'.$name.'" value = "'.$value.'"/>';
		return $input;
	}

	//создает поле для ввода пароля
	public static function passInput($id, $name = '') {
		$input = '<input id = "'.$id.'" type = "password" name = "'.$name.'"/>';
		return $input;
	}

	//создает скрытое поле
	public static function hiddenInput($id, $name = '', $value = '') {
		$input = '<input id = "'.$id.'" type = "hidden" name = "'.$name.'" value = "'.$value.'"/>';
		return $input;
	}

	//создает кнопку
	public static function button($id, $value = '') {
		$button = '<input id = "'.$id.'" type = "button" value = "'.$value.'"/>';
		return $button;
	}

	//создает кнопку отправки формы
	public static function buttonSubmit($id, $value = '') {
		$button = '<input id = "'.$id.'" type = "submit" value = "'.$value.'"/>';
		return $button;
	}

	//создает поле для ввода текста
	public static function textArea($id, $name, $rows = '10', $cols = '30') {
		$textarea = '<textarea id = "'.$id.'" name = "'.$name.'" rows = "'.$rows.'" cols = "'.$cols.'"></textarea>';
		return $textarea;
	}

	//создает картинку
	public static function image($id, $src, $alt = '', $width, $height) {
		$img = '<img src = "'.$src.'" alt = "'.$alt.'" width = '.$width.' height = '.$height.'/>';
		return $img;
	}

	//создает ссылку отправки письма
	public static function mailTo($mail, $string) {
		$mail = '<a href = "mailto:'.$mail.'">'.$string.'</a>';
		return $mail;
	}

	//открывающий тег form
	public static function formOpen($id, $action, $method = 'POST') {
		$action = self::baseUrl().'/'.$action;
		$form = '<form id = "'.$id.'" action = "'.$action.'" method = "'.$method.'">';
		return $form;
	}

	//закрывающий тег form
	public static function formClose() {
		return '</form>';
	}

	//генерирует переключатель
	public static function radio($name, $value, $label) {
		$radio = '<input type = "radio" name = "'.$name.'" value = "'.$value.'">'.$label;
		return $radio;
	}

	//генерирует галочки
	public static function checkbox($name, $value, $label, $checked = false) {
		if ($checked == true)
			$checkbox = '<input type = "checkbox" name = "'.$name.'" value = "'.$value.'" checked>'.$label;
		else
			$checkbox = '<input type = "checkbox" name = "'.$name.'" value = "'.$value.'">'.$label;
		return $checkbox;
	}

	//генерирует выпадающий список
	public static function dropDown($array) {
		$str = '<select>';
		foreach ($array as $key => $value) {
			$str.= '<option value = "'.$key.'">'.$value.'</option>';
		}
		$str.= '</select>';
		return $str;
	}

	//генерация AJAX-кнопки
	public static function buttonAjax($id, $value = '', $ajaxOptions = array()) {
		$script = '<script type = "text/javascript">
		$(document).ready(function() {
			$("#'.$id.'").click(function(){
				$.ajax('.json_encode($ajaxOptions).')
			});
		});
		</script>';
		echo $script;
		$button = '<input id = "'.$id.'" type = "button" value = "'.$value.'"/>';
		return $button;
	}
}