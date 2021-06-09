<?php

class Controller_Registration extends Controller
{
  function __construct()
  {
    Session::start();
    if (Session::is_logged_in()) {
      header('Location:/profile/');
      exit();
    }
    $this->model = new Model_Registration();
    $this->view = new View();
  }

  function action_index()
  {
    $this->view->generate('registration_view.php', 'template_view.php', $data = null);
  }

  function action_process()
  {
    $registrationResult = $this->model->process();

    if ($registrationResult['status'] == true) {
      header('Location:/login');
    } else {
      $this->view->generate('registration_view.php', 'template_view.php', $registrationResult);
    }
  }
}
