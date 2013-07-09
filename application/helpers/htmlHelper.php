<?php

//Html - класс для работы с html
class HtmlHelper extends Helper {

	//базовый URL приложения
	public static function baseUrl() {
		return MyApplication::get()->params('baseUrl');
	}

	//создает URL
	public static function newUrl($string = '') {
		$newUrl = self::baseUrl().''.$string;
		return $newUrl;
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

	//html опции
	public static function htmlOptions($options = array()) {
		$opt = '';
		if (!is_null($options)) {
			foreach ($options as $key => $value) {
				$opt.= $key.' = "'.$value.'"';
			}
		}
		return $opt;
	}

	//создает ссылку
	public static function link($href, $label, $options = array()) {
		$htmlLink = self::baseUrl().'/'.$href;
		$link = '<a href = '.$htmlLink.' '.self::htmlOptions($options).'>'.$label.'</a>';
		return $link;
	}

	//создает текстовое поле
	public static function textInput($name = '', $options = array()) {
		$input = '<input type = "text" name = "'.$name.'" '.self::htmlOptions($options).'/>';
		return $input;
	}

	//создает поле для ввода пароля
	public static function passInput($name = '', $options = array()) {
		$input = '<input type = "password" name = "'.$name.'" '.self::htmlOptions($options).'/>';
		return $input;
	}

	//создает скрытое поле
	public static function hiddenInput($name = '', $options = array()) {
		$input = '<input type = "hidden" name = "'.$name.'" '.self::htmlOptions($options).'/>';
		return $input;
	}

	//создает кнопку
	public static function button($value = '', $options = array()) {
		$button = '<button type = "button" '.self::htmlOptions($options).'>'.$value.'</button>';
		return $button;
	}

	//создает кнопку отправки формы
	public static function buttonSubmit($value = '', $options = array()) {
		$button = '<button type = "submit" '.self::htmlOptions($options).'>'.$value.'</button>';
		return $button;
	}

	//создает поле для ввода текста
	public static function textArea($name = '', $options = array()) {
		$textarea = '<textarea name = "'.$name.'" '.self::htmlOptions($options).'></textarea>';
		return $textarea;
	}

	//создает картинку
	public static function image($src, $alt = '', $options = array()) {
		$img = '<img src = "'.$src.'" alt = "'.$alt.'" '.self::htmlOptions($options).'/>';
		return $img;
	}

	//создает ссылку отправки письма
	public static function mailTo($mail, $string, $options = array()) {
		$mail = '<a href = "mailto:'.$mail.'" '.self::htmlOptions($options).'>'.$string.'</a>';
		return $mail;
	}

	//открывающий тег form
	public static function formOpen($action, $method = 'POST', $options = array()) {
		$action = self::baseUrl().'/'.$action;
		$form = '<form action = "'.$action.'" method = "'.$method.'" '.self::htmlOptions($options).'>';
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
	public static function buttonAjax($value = '', $ajaxOptions = array(), $options = array()) {
		$script = '<script type = "text/javascript">
		$(document).ready(function() {
			$("#'.$id.'").click(function(){
				$.ajax('.json_encode($ajaxOptions).')
			});
		});
		</script>';
		echo $script;
		$button = '<button type = "button" '.self::htmlOptions($options).'>'.$value.'</button>';
		return $button;
	}
}