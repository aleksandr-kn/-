<?php

class Controller_Reset extends Controller
{
  function __construct()
  {
    //Todo: find another way to redirect if not logged in
    Session::start();
    if (!Session::is_logged_in()) {
      header('Location:/login/');
      exit();
    }
    $this->model = new Model_Reset();
    $this->view = new View();
  }

  function action_index()
  {
    //$data["login_status"] = "";

    //$data = $this->model->try_login();
    $this->view->generate('reset_view.php', 'template_view.php', $data = null);
  }

  function action_process()
  {
    $resetResult = $this->model->process();

    if ($resetResult['status'] == true) {
      header('Location:/login');
    } else {
      $this->view->generate('reset_view.php', 'template_view.php', $resetResult);
    }
  }
}
