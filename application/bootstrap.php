<?php
// подключаем файлы ядра
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';

require_once 'core/config.php';

require_once 'core/temporary_functions.php';

require_once ROOTPATH . '/application/utility/Session.php';
define('SITE_NAME', $_SERVER['SERVER_NAME']);


require_once 'core/route.php';
Route::start(); // запускаем маршрутизатор
