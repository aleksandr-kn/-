<?php

class Controller_Test extends Controller
{
  function action_index()
  {
    Session::start();

    $this->view->generate('test_view.php', 'template_view.php');
  }
}
