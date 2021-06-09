<?php

class Model_Login extends Model
{

  //Try logging in
  public function process()
  {
    $db = create_connection();

    $loginResult = array(
      "status" => false,
      "user_data" => array(),
      "errors" => array(),
    );

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Check if username is empty
      if (empty(test_input($_POST["username"]))) {
        $loginResult["errors"]['username_err'] = "Введите имя пользователя.";
      } else {
        $loginResult["user_data"]['username'] = trim($_POST["username"]);
      }
      // Check if password is empty
      if (empty(test_input($_POST["password"]))) {
        $loginResult["errors"]['password_err'] = "Введите пароль.";
      } else {
        $loginResult["user_data"]['password'] = test_input($_POST["password"]);
      }

      //credentials

      if (empty($loginResult["errors"])) {
        $param_username = $loginResult["user_data"]['username'];
        //$param_password = $loginResult["user_data"]['password'];

        $res = pg_query($db, "SELECT EXISTS(SELECT username FROM users WHERE username = '$param_username');");
        if (pg_fetch_result($res, 0, 0) == 't') {
          $res = pg_query($db, "SELECT password, id, is_banned FROM users WHERE username = '$param_username';");
          if (pg_fetch_result($res, 0, 2) !== 't') {
            $hashed_password = pg_fetch_result($res, 0, 0);
            $id = pg_fetch_result($res, 0, 1);

            //Check if password equals to the hashed one
            if (password_verify($loginResult["user_data"]['password'], $hashed_password)) {
              $_SESSION["logged_in"] = true;
              $_SESSION["id"] = $id;
              $_SESSION["username"] = $loginResult["user_data"]['username'];

              pg_close($db);

              $loginResult['status'] = true;
              return $loginResult;
              //Admin and executor login part 
              /*
              $res = pg_query($db, "SELECT EXISTS(SELECT id FROM admins WHERE user_id = '$id');");
              if (pg_fetch_result($res, 0, 0) == 't') {
              	$_SESSION["isAdmin"] = true;
              	header("location: /adminpage");
              	exit;
              }
              
		            $res = pg_query($db, "SELECT EXISTS(SELECT id FROM executor WHERE user_id = '$id');");
		            if (pg_fetch_result($res, 0, 0) == 't') {
		            	$_SESSION["isExecutor"] = true;
		            	header("location: /executorpage");
		            	exit;
		            }*/
            } else {
              $loginResult["errors"]['password_err'] = "Неправильный пароль";
            }
          } else {
            $loginResult["errors"]['username_err'] = "Ваш аккаунт заблокирован.";
          }
        } else {
          $loginResult["errors"]['username_err'] = "Такого пользователя не существует";
        }
      }
      return $loginResult;
    }
  }
}
