<?php

//класс View - представление
class View {

	//разметка, общая для всех страниц
	private $layout = 'layout';

	//css стиль
	private $style = 'style';

	//title страницы
	private $title;

	//установка разметки для страницы
	public function setLayout($layout) {
		$this->layout = $layout;
	}

	//получение разметки страницы
	public function getLayout() {
		return $this->layout;
	}

	//вывод страницы $contentView, с передачей данных $data
	public function render($content, $data = null) {
		if (!is_null($data)) {
			extract($data);
		}
		$content = dirname(__FILE__).'/../views/'.$content.'.php';
		$layoutPath = dirname(__FILE__).'/../views/layout/'.$this->layout.'.php';
		include $layoutPath;
	}

	//базовый URL приложения
	public function baseUrl() {
		$url = MyApplication::get()->params('baseUrl');
		return $url;
	}

	//установка css стиля страницы
	public function setStyle($style) {
		$stylePath = $this->baseUrl().'/css/'.$style.'.css';
		$this->style = $stylePath;
	}

	//получение css стиля страницы
	public function getStyle() {
		return $this->style;
	}

	//установка title для страницы
	public function setTitle($title) {
		$this->title = $title;
	}

	//получение title страницы
	public function getTitle() {
		return $this->title;
	}
}