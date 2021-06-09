<?php

class Model_Profile
{

  function __construct()
  {
    $this->resultData = array(
      "status" => false,
      "user_data" => array(),
      "errors" => array(),
    );
  }


  public function get_user_info()
  {
    $db = create_connection();
    $id_param = $_SESSION["id"];
    $res = pg_query($db, "SELECT username, email, info FROM users WHERE id='$id_param';");
    $user_info = pg_fetch_all($res)[0];
    pg_close($db);
    return $user_info;
  }

  private function get_categories($quantity = 'default')
  {
    $db = create_connection();
    $id_param = $_SESSION["id"];
    $res = pg_query($db, "SELECT id, name FROM spending_category WHERE user_id = '$id_param';");
    $categories = pg_fetch_all($res);
    pg_close($db);
    return $categories;
  }

  private function get_sources($quantity = 'default')
  {
    $db = create_connection();
    $id_param = $_SESSION["id"];
    $res = pg_query($db, "SELECT id, name, description FROM spending_source WHERE user_id = '$id_param';");
    $sources = pg_fetch_all($res);
    pg_close($db);
    return $sources;
  }

  public function delete_source($source_id)
  {
    $db = create_connection();
    $source_id = (int)$source_id;

    if (is_int($source_id) && pg_affected_rows(pg_query($db, "DELETE FROM spending_source WHERE id = '{$source_id}';"))) {
      $result['status'] = true;
    } else {
      $result['status'] = false;
    }
    pg_close($db);
    return $result;
  }

  private function get_spendings($quantity = 'default')
  {
    $db = create_connection();

    $id_param = $_SESSION["id"];

    $res = pg_query(
      $db,
      "SELECT spendings.id, spending_category.name as category_name, spending_subcategory.name as subcategory_name, 
      spending_source.name as source_name,
      spendings.spending_date, spendings.name, spendings.sum 
      FROM spendings
      LEFT JOIN spending_category ON spending_category.id = spendings.spending_category_id
      LEFT JOIN spending_subcategory ON spending_subcategory.id = spendings.spending_subcategory_id
      LEFT JOIN spending_source ON spending_source.id = spendings.spending_source_id
      WHERE spendings.user_id = '$id_param'
      ORDER BY spendings.id DESC;"
    );
    $spendings = pg_fetch_all($res);
    pg_close($db);
    return $spendings;
  }

  public function get_filtered_spendings($first_date, $last_date, 
  $spending_category_id = null, 
  $spending_subcategory_id = null,
  $spending_source_id = null, 
  $min_sum = 0, 
  $max_sum = 9999999 )
  {
    $db = create_connection();
    $id_param = $_SESSION['id'];

    //validate dates
    //*****
    //to do

    if (empty($first_date)) {
      $first_date = pg_fetch_result(pg_query($db, "SELECT registration_date FROM users WHERE id = '{$id_param}';"), 0, 0);
    }

    if (empty($spending_category_id)) {
      $spending_category_id = "::TEXT LIKE '%'";
    } else {
      $spending_category_id = "=" . $spending_category_id;
    }

    if (empty($spending_subcategory_id)) {
      $spending_subcategory_id = "::TEXT LIKE '%'";
    } else {
      $spending_subcategory_id = "=" . $spending_subcategory_id;
    }

    if (empty($spending_source_id)) {
      $spending_source_id = "::TEXT LIKE '%'";
    } else {
      $spending_source_id = "=" . $spending_source_id;
    }
    //fixing date problem
    pg_query('SET datestyle = dmy;');

    $resource = pg_query($db, 
    "SELECT spendings.id, spending_category.name as category_name, spending_subcategory.name as subcategory_name, 
    spending_source.name as source_name,
    spendings.spending_date, spendings.name, spendings.sum 
    FROM spendings
    LEFT JOIN spending_category ON spending_category.id = spendings.spending_category_id
    LEFT JOIN spending_subcategory ON spending_subcategory.id = spendings.spending_subcategory_id
    LEFT JOIN spending_source ON spending_source.id = spendings.spending_source_id
    WHERE spendings.user_id = '$id_param' AND spendings.spending_date >= '$first_date' AND spendings.spending_date <= '$last_date'
    AND spendings.sum >= '$min_sum' AND spendings.sum <= '$max_sum'
    AND spendings.spending_category_id{$spending_category_id}
    AND spendings.spending_subcategory_id{$spending_subcategory_id}
    AND spendings.spending_source_id{$spending_source_id}
    ORDER BY spendings.id DESC;");
    $filteredSpendings = pg_fetch_all($resource);

    if ($filteredSpendings) {
      $filteredSpendings['status'] = true;
    } else {
      $filteredSpendings['status'] = false;
    }
    pg_close($db);
    return $filteredSpendings;
  }

  public function get_this_week_spendings()
  {
    $start_week = date('d-m-Y', strtotime('monday this week'));
    $end_week = date('d-m-Y', strtotime('sunday this week'));

    $filteredSpendings = $this->get_filtered_spendings($start_week, $end_week);

    return $filteredSpendings;
  }

  public function add_spending($spending_name, $spending_amount, $spending_category_id, $spending_subcategory_id = null, $spending_source_id)
  {
    $db = create_connection();
    $id = $_SESSION['id'];
    $spending_name = pg_escape_string($spending_name);
    $spending_category_id = (int)$spending_category_id;
    if (!empty($spending_subcategory_id)) {
      $spending_subcategory_id = (int)$spending_subcategory_id;
    }

    $spending_source_id = pg_escape_string($spending_source_id);

    $spending_amount = pg_escape_string($spending_amount);
    $current_date_param = date("Y/m/d");

    if (is_numeric($spending_amount)) {
      pg_query('SET datestyle = dmy;');
      $resource = pg_query($db, "INSERT INTO spendings (user_id, spending_category_id, spending_subcategory_id, spending_source_id,
      name, sum, spending_date) 
      VALUES ('$id', '$spending_category_id', '$spending_subcategory_id', '$spending_source_id', 
      '$spending_name', '$spending_amount', '$current_date_param') RETURNING id;");
      if (pg_affected_rows($resource)) {
        $result['status'] = true;
        $result["inserted_id"] = pg_fetch_result($resource, 0, 0);
      } else {
        $result['status'] = false;
      }
    } else {
      $result['status'] = false;
    }

    pg_close($db);
    return $result;
  }

  public function delete_spending($spending_id)
  {
    $db = create_connection();

    $spending_id = (int)$spending_id;

    if (is_int($spending_id) && pg_affected_rows(pg_query($db, "DELETE FROM spendings WHERE id = '{$spending_id}';"))) {
      $result['status'] = true;
    } else {
      $result['status'] = false;
    }
    pg_close($db);
    // ????
    $this->resultData = $this->get_initial_data();
    return $result;
  }

  public function add_category($new_category_name)
  {
    $db = create_connection();
    $id = $_SESSION['id'];
    $new_category_name = pg_escape_string($new_category_name);
    $resource = pg_query($db, "INSERT INTO spending_category(user_id, name) VALUES ('$id', '$new_category_name') RETURNING id;");
    if (pg_affected_rows($resource)) {
      $result['status'] = true;
      $result["inserted_id"] = pg_fetch_result($resource, 0, 0);
    } else {
      $result['status'] = false;
    }
    pg_close($db);
    return $result;
  }

  public function delete_category($category_id)
  {
    $db = create_connection();
    $id = $_SESSION['id'];
    $category_id = (int)$category_id;

    if (is_int($category_id) && pg_affected_rows(pg_query($db, "DELETE FROM spending_category WHERE user_id = '$id' AND id = '{$category_id}';"))) {
      $result['status'] = true;
    } else {
      $result['status'] = false;
    }
    pg_close($db);
    return $result;
  }

  public function add_subcategory($new_subcategory_name, $new_subcategory_parent_id)
  {
    $db = create_connection();
    $new_subcategory_name = pg_escape_string($new_subcategory_name);
    $new_subcategory_parent_id = (int)$new_subcategory_parent_id;

    $resource = pg_query($db, "INSERT INTO spending_subcategory(parent_category, name) VALUES ('$new_subcategory_parent_id', '$new_subcategory_name') RETURNING id;");
    if (pg_affected_rows($resource)) {
      $result['status'] = true;
      $result["inserted_id"] = pg_fetch_result($resource, 0, 0);
    } else {
      $result['status'] = false;
    }
    pg_close($db);
    return $result;
  }

  public function add_source($new_source_name, $new_source_description)
  {
    $db = create_connection();
    $id_param = $_SESSION["id"];

    $new_source_name = pg_escape_string($new_source_name);
    if (!empty($new_source_description)) {
      $new_source_description = pg_escape_string($new_source_description);
    }

    $resource = pg_query($db, "INSERT INTO spending_source(user_id, name, description) VALUES ('$id_param', '$new_source_name', '$new_source_description');");
    if (pg_affected_rows($resource)) {
      $result['status'] = true;
    } else {
      $result['status'] = false;
    }
    pg_close($db);
    return $result;
  }

  public function delete_subcategory($subcategory_id)
  {
    $db = create_connection();
    $subcategory_id = (int)$subcategory_id;

    if (is_int($subcategory_id) && pg_affected_rows(pg_query($db, "DELETE FROM spending_subcategory WHERE id = '{$subcategory_id}';"))) {
      $result['status'] = true;
    } else {
      $result['status'] = false;
    }
    pg_close($db);
    return $result;
  }

  public function get_subcategories($parent_id) {
    $db = create_connection();
    $res = pg_query($db, "SELECT id, name FROM spending_subcategory WHERE parent_category = '$parent_id';");
    $result = pg_fetch_all($res);
    if (!empty($result)) {
      $result['status'] = true;
    } else {
      $result['status'] = false;
    }
    
    pg_close($db);
    return $result;
  }

  public function update_profile($new_username, $new_email, $new_info)
  {
    $db = create_connection();

    $result = array(
      "status" => "false",
      "errors" => array(),
    );

    $resource = pg_query($db, "SELECT username, email, info FROM users WHERE id = {$_SESSION['id']};");
    $current_fields = pg_fetch_all($resource);

    $new_username = test_input($new_username);
    $new_email = test_input($new_email);
    $new_info = test_input($new_info);

    $email_err = "";
    $username_err = "";

    if (empty(test_input($new_username))) {
      $username_err = "Введите имя пользователя";
    }
    if ((pg_fetch_result(pg_query($db, "SELECT EXISTS(SELECT username FROM users WHERE username = '$new_username');"), 0, 0) == 't') && ($new_username != $current_fields[0]['username'])) {
      $username_err = "Это имя пользователя уже занято";
    }
    if (empty(test_input($new_email))) {
      $email_err = "Введите Email";
    }
    if ((pg_fetch_result(pg_query($db, "SELECT EXISTS(SELECT email FROM users WHERE email = '$new_email');"), 0, 0) == 't') && ($new_email != $current_fields[0]['email'])) {
      $email_err = "Этот уже Email использован";
    }

    if (empty($username_err) && empty($email_err)) {
      pg_query($db, "UPDATE users SET username='$new_username', email = '$new_email', info = '$new_info' WHERE id = {$_SESSION['id']};");
      $result['status'] = true;
    } else {
      $result["errors"]["email_err"] = $email_err;
      $result["errors"]["username_err"] = $username_err;
    }

    pg_close($db);

    return $result;
  }

  private function get_spendings_sum($spendings_list)
  {
    return array_sum(array_column($spendings_list, 'sum'));
  }

  private function get_spendings_quantity($spendings_list) {
    array_pop($spendings_list);
    return count($spendings_list);
  }
  //rounded average of spendings sums for given period
  private static function get_spendings_average(array $array, bool $includeEmpties = true): float
  {
      $array = array_filter($array, fn($v) => (
          $includeEmpties ? is_numeric($v) : is_numeric($v) && ($v > 0)
      ));
      
      if (count($array) != 0) {
        return round((array_sum($array) / count($array)), 0, PHP_ROUND_HALF_UP);
      } else {
        return 0;
      }
      
  }
  

  private function pct_change($old, $new, int $precision = 2): float
  {
    if ($old == 0) {
      $old++;
      $new++;
    }

    $change = (($new - $old) / $old) * 100;

    return round($change, $precision);
  }

  private function spendings_change_status($spendings_difference)
  {
    if ($spendings_difference > 0) {
      $change_status = "Увеличились";
    } else if ($spendings_difference < 0) {
      $change_status = "Уменьшились";
    } else {
      $change_status = "Не изменились";
    }
    return $change_status;
  }

  private function get_min_max_sum()
  {
    $db = create_connection();
    $id_param = $_SESSION["id"];
    $res = pg_query($db, "SELECT MAX(sum), MIN(sum)
    FROM spendings;");
    $min_max = pg_fetch_all($res);
    pg_close($db);
    return $min_max;
  }

  public function get_initial_data()
  {
    $this->resultData["user_data"]["spendings"] = $this->get_spendings();
    $this->resultData["user_data"]["categories"] = $this->get_categories();
    $this->resultData["user_data"]["sources"] = $this->get_sources();
    $this->resultData["user_data"]["user_info"] = $this->get_user_info();

    $this->resultData["user_data"]["min_max"] = $this->get_min_max_sum();
    
    

    //total spendigns of this week
    $this_week_spendings = $this->get_this_week_spendings();
    $this_week_spendings_sum = $this->get_spendings_sum($this_week_spendings);
    $this->resultData["user_data"]["this_week_spendings_sum"] = $this_week_spendings_sum;

    //last week spendings
    $last_week_start = date('d-m-Y', strtotime('monday last week'));
    $last_week_end = date('d-m-Y', strtotime('sunday last week'));
    $last_week_spendings = $this->get_filtered_spendings($last_week_start, $last_week_end);
    $last_week_spendings_sum =  $this->get_spendings_sum($last_week_spendings);
    $this->resultData["user_data"]["last_week_spendings_sum"] = $last_week_spendings_sum;

    //average
    $this_week_average_sum = $this->get_spendings_average(array_column($this_week_spendings, 'sum'));
    $last_week_average_sum = $this->get_spendings_average(array_column($last_week_spendings, 'sum'));
    $this->resultData["user_data"]["this_week_average_sum"] = $this_week_average_sum;

    $percentage_difference_average_sum = $this->pct_change($last_week_average_sum, $this_week_average_sum);
    $this->resultData["user_data"]["percentage_difference_average_sum"] = abs($percentage_difference_average_sum);
    $this->resultData["user_data"]["percentage_difference_average_sum_status"] = $this->spendings_change_status($percentage_difference_average_sum);

    //quantity of spendings this week
    $this_week_spendings_quantity = $this->get_spendings_quantity($this_week_spendings);
    $last_week_spendings_quantity = $this->get_spendings_quantity($last_week_spendings);

    //quantity info
    $percentage_difference_quantity = $this->pct_change($last_week_spendings_quantity, $this_week_spendings_quantity);
    $this->resultData["user_data"]["percentage_difference_quantity"] = abs($percentage_difference_quantity);
    $this->resultData["user_data"]["this_week_spendings_quantity"] = $this_week_spendings_quantity;
    $this->resultData["user_data"]["percentage_difference_quantity_status"] = $this->spendings_change_status($percentage_difference_quantity);

    //amount info 
    $percentage_difference_amount = $this->pct_change($last_week_spendings_sum, $this_week_spendings_sum);
    $this->resultData["user_data"]["percentage_difference_amount"] = abs($percentage_difference_amount);
    $this->resultData["user_data"]["percentage_difference_amount_status"] = $this->spendings_change_status($percentage_difference_amount);

    
    return $this->resultData;
  }
}
