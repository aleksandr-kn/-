<?php

class Controller_Profile extends Controller
{

  function __construct()
  {
    Session::start();
    if (!Session::is_logged_in()) {
      header('Location:/login/');
      exit();
    }

    $this->view = new View();
    $this->model = new Model_Profile();
  }

  function action_index()
  {
    header('Location:/profile/dashboard/');
    exit();
  }

  function action_dashboard()
  {
    $initialData = $this->model->get_initial_data();

    $this->view->generate('dashboard_view.php', 'template_view.php', $initialData);
  }

  function action_statistics()
  {
    $initialData = $this->model->get_initial_data();

    $this->view->generate('statistics_view.php', 'template_view.php', $initialData);
  }

  function action_categories()
  {
    $initialData = $this->model->get_initial_data();
    $this->view->generate('categories_view.php', 'template_view.php', $initialData);
  }

  function action_sources()
  {
    $initialData = $this->model->get_initial_data();
    $this->view->generate('sources_view.php', 'template_view.php', $initialData);
  }

  function action_add_source() {
    if (isset($_POST["new_source_name"])) {
      $new_source_name = $_POST["new_source_name"];
      $new_source_description = $_POST["new_source_description"];
      $result = $this->model->add_source($new_source_name, $new_source_description);
      echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else {
      //to do
      header('Location:/test/');
    }
  }

  function action_delete_source()
  {
    if (isset($_POST["source_to_delete_id"])) {
      $source_to_delete_id = $_POST["source_to_delete_id"];
      $result = $this->model->delete_source($source_to_delete_id);
      echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else {
      header('Location:/site_security/');
    }
  }

  function action_settings()
  {
    $initialData = $this->model->get_initial_data();

    $this->view->generate('settings_view.php', 'template_view.php', $initialData);
  }

  function action_security()
  {
    $initialData = $this->model->get_initial_data();

    $this->view->generate('security_view.php', 'template_view.php', $initialData);
  }


  function action_add_spending()
  {
    if (
      isset($_POST["new_spending_name"])
      && isset($_POST["new_spending_amount"])
      && isset($_POST["new_spending_source_id"])
      && isset($_POST["new_spending_category_id"])
    ) {
      $new_spending_name = $_POST["new_spending_name"];
      $new_spending_amount = $_POST["new_spending_amount"];
      $new_spending_category_id = $_POST["new_spending_category_id"];
      $new_spending_subcategory_id = $_POST["new_spending_subcategory_id"];
      $new_spending_source_id = $_POST["new_spending_source_id"];

      $result = $this->model->add_spending(
        $new_spending_name, 
        $new_spending_amount, 
        $new_spending_category_id, 
        $new_spending_subcategory_id, 
        $new_spending_source_id
      );
      echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else {
      //to do
      header('Location:/site_security/');
    }
  }

  function action_delete_spending()
  {
    if (isset($_POST["spending_to_delete_id"])) {
      $spending_to_delete_id = $_POST["spending_to_delete_id"];
      $result = $this->model->delete_spending($spending_to_delete_id);
      echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else {
      header('Location:/site_security/');
    }
  }

  function action_add_category()
  {
    if (isset($_POST["new_category_name"])) {
      $category_name = $_POST["new_category_name"];
      $result = $this->model->add_category($category_name);
      echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else {
      //to do
      header('Location:/site_security/');
    }
  }

  function action_delete_category()
  {
    if (isset($_POST["category_to_delete_id"])) {
      $category_to_delete_id = $_POST["category_to_delete_id"];
      $result = $this->model->delete_category($category_to_delete_id);
      echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else {
      //to do
      header('Location:/site_security/');
    }
  }

  function action_add_subcategory()
  {
    if (isset($_POST["new_subcategory_name"]) && isset($_POST["new_subcategory_parent_id"])) {
      $new_subcategory_name = $_POST["new_subcategory_name"];
      $new_subcategory_parent_id = $_POST["new_subcategory_parent_id"];
      $result = $this->model->add_subcategory($new_subcategory_name, $new_subcategory_parent_id);
      echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else {
      //to do
      header('Location:/test/');
    }
  }

  function action_delete_subcategory()
  {
    if (isset($_POST["subcategory_to_delete_id"])) {
      $subcategory_to_delete_id = $_POST["subcategory_to_delete_id"];
      $result = $this->model->delete_subcategory($subcategory_to_delete_id);
      echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else {
      //to do
      header('Location:/site_security/');
    }
  }

  function action_get_subcategories() {
    if (isset($_POST["parent_id"])) {
      $parent_id = (int)$_POST['parent_id'];
      $result = $this->model->get_subcategories($parent_id);
      echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else {
      header('Location:/site_security/');
    }
  }

  function action_get_filtered_spendings()
  {
    if (
      isset($_POST["first_date"])
    && isset($_POST["last_date"])
    && isset($_POST["spending_category_id"])
    && isset($_POST["spending_subcategory_id"])
    && isset($_POST["spending_source_id"])
    && isset($_POST["min_sum"])
    && isset($_POST["max_sum"])
    ) {
      $first_date = $_POST['first_date'];
      $last_date = $_POST['last_date'];
      $spending_category_id = $_POST['spending_category_id'];
      $spending_subcategory_id = $_POST['spending_subcategory_id'];
      $spending_source_id = $_POST['spending_source_id'];
      $min_sum = $_POST['min_sum'];
      $max_sum = $_POST['max_sum'];

      // @var_dump($first_date);
      // @var_dump($last_date);
      // @var_dump($spending_category_id);
      // @var_dump($spending_subcategory_id);
      // @var_dump($spending_source_id);
      // @var_dump($min_sum);
      // @var_dump($max_sum);

      $result = $this->model->get_filtered_spendings(
        $first_date, 
        $last_date,
        $spending_category_id,
        $spending_subcategory_id,
        $spending_source_id,
        $min_sum,
        $max_sum
      );
      echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else {
      header('Location:/site_security/');
    }
  }

  function action_get_this_week_spendings()
  {
    $result = $this->model->get_this_week_spendings();
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
  }

  function action_update_profile()
  {

    if (
      isset($_POST["new_username"])
      || isset($_POST["new_email"])
      || isset($_POST["new_info"])
    ) {
      $new_username = $_POST["new_username"];
      $new_email = $_POST["new_email"];
      $new_info = $_POST["new_info"];

      $result = $this->model->update_profile($new_username, $new_email, $new_info);
      echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else {
      //to do
      header('Location:/site_security/');
    }
  }

  function action_test()
  {
    $initialData = $this->model->get_last_week_spendings();
    var_dump($initialData);
  }
}
