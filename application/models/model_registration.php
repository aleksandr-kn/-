<?php

class Model_Registration extends Model
{

  //Try logging in
  public function process()
  {
    $db = create_connection();

    $registrationResult = array(
      "status" => false,
      "user_data" => array(),
      "errors" => array(),
    );

    $username = $email = $password = $confirm_password = "";


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Validate username
      if (empty(test_input($_POST["username"]))) {
        $registrationResult["errors"]["username_err"] = "Введите имя пользователя.";
      } else {
        $registrationResult["user_data"]["username"] = test_input($_POST["username"]);
        $res = pg_query($db, "SELECT EXISTS(SELECT username FROM users WHERE username = '{$registrationResult["user_data"]["username"]}');");
        if (pg_fetch_result($res, 0, 0) == 't') {
          $registrationResult["errors"]["username_err"] = "Это имя пользователя уже занято.";
        }
        //$result = pg_query($db, $smt);
        //$val = pg_fetch_result($result, 0, 0);
      }

      //Validate email
      if (empty(test_input($_POST["email"]))) {
        $registrationResult["errors"]["email_err"] = "Введите ваш E-mail";
      }
      if (!filter_var(($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $registrationResult["errors"]["email_err"] = "Неправильный формат E-Mail";
      } else {
        $registrationResult["user_data"]["email"] = test_input($_POST["email"]);
        $res = pg_query($db, "SELECT EXISTS(SELECT email FROM users WHERE email = '{$registrationResult["user_data"]["email"]}');");
        if (pg_fetch_result($res, 0, 0) == 't') {
          $registrationResult["errors"]["email_err"] = "Этот E-mail уже использован.";
        }
      }

      //Validate password
      if (empty(test_input($_POST["password"]))) {
        $registrationResult["errors"]["password_err"] = "Введите пароль";
      } else if (strlen(test_input($_POST["password"])) < 6) {
        $registrationResult["errors"]["password_err"] = "Пароль должен быть не меньше 6 символов";
      } else {
        $registrationResult["user_data"]["password"] = test_input($_POST["password"]);
      }

      //Validate password confirmation
      if (empty(test_input($_POST["confirm_password"]))) {
        $registrationResult["errors"]["confirm_password_err"] = "Введите подтверждение пароля";
      } else {
        $registrationResult["user_data"]["confirm_password"] = trim($_POST["confirm_password"]);
        if (
          empty($registrationResult["errors"]["password_err"])
          && ($registrationResult["user_data"]["password"] != $registrationResult["user_data"]["confirm_password"])
        ) {
          $registrationResult["errors"]["confirm_password_err"] = "Пароли не совпадают.";
        }
      }

      //Insert only if there are no errors
      if (empty($registrationResult["errors"])) {
        $param_username = $registrationResult["user_data"]["username"];
        $param_email = $registrationResult["user_data"]["email"];
        $param_password = password_hash($registrationResult["user_data"]["password"], PASSWORD_DEFAULT);

        //Insert server date if user timezone field is empty
        if (!empty(test_input($_POST["date"]))) {
          $param_date = test_input($_POST["date"]);
        } else {
          $param_date = date("Y-m-d");
        }

        $res = pg_query($db, "INSERT INTO users (id, username, email, password, registration_date) VALUES (DEFAULT, '$param_username', '$param_email', '$param_password', '$param_date');");
        if ($res) {
          //Create default spending categories if a new user is registered. To Do
          $res = pg_query($db, "SELECT id FROM users WHERE username = '$param_username';");
          $user_id = pg_fetch_result($res, 0, 0);
          $res = pg_query($db, "INSERT INTO spending_category(user_id, name) 
                   VALUES ('$user_id', 'Автомобиль'),
                    ('$user_id', 'Дом'),
                    ('$user_id', 'Здоровье'),
                    ('$user_id', 'Питание'),
                    ('$user_id', 'Личные Расходы'),
                    ('$user_id', 'Услуги') RETURNING id;");
          $parent_ids = pg_fetch_all($res);
          
          foreach ($parent_ids as $parent_item) {
            $parent_id = $parent_item['id'];
            pg_query($db, "INSERT INTO spending_subcategory(parent_category, name)
                            VALUES ('$parent_id', 'Основная');" );
          }

          //Creating default spending sources
          pg_query($db, "INSERT INTO spending_source(user_id, name) 
                   VALUES ('$user_id', 'Автомобиль'), 
                   ('$user_id', 'Наличные деньги'), 
                   ('$user_id', 'Основная банковская карта');");

          pg_close($db);
          $registrationResult["status"] = true;
          return $registrationResult;
        } else {
          #Return user_database error, do something about it in controller
          #Our services are temporarily unavailable, try again later
          die("Извините, произошла внутренная ошибка.");
        }
      } else {
        return $registrationResult;
      }
    }
  }
}
