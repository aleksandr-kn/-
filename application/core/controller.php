<?php

class Controller
{

	public $model;
	public $view;

	function __construct()
	{
		$this->view = new View();
		$this->controller_name = get_class($this);
	}

	// действие (action), вызываемое по умолчанию
	function action_index()
	{
		// todo	
	}
}
