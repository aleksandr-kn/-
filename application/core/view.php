<?php

class View
{


	//public $template_view; // здесь можно указать общий вид по умолчанию.

	/*
	$content_file - виды отображающие контент страниц;
	$template_file - общий для всех страниц шаблон;
	$data - массив, содержащий элементы контента страницы. Обычно заполняется в модели.
	*/
	function generate($content_view, $template_view, $data = null)
	{

		$assets_folder_path = "/public/assets";

		$content_view_name = explode("_", $content_view)[0];

		if (is_array($data)) {
			// преобразуем элементы массива в переменные
			extract($data);
		}
		/*
		динамически подключаем общий шаблон (вид),
		внутри которого будет встраиваться вид
		для отображения контента конкретной страницы.
		*/

		include ROOTPATH . '/application/views/' .  $template_view;
	}
}
