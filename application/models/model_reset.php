<?php

class Model_Reset extends Model
{

  //Try logging in
  public function process()
  {
    $db = create_connection();

    $resetResult = array(
      "status" => false,
      "user_data" => array(),
      "errors" => array(),
    );
    $resetErrors = array();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      //Валидация нового пароля
      if (empty(test_input($_POST["new_password"]))) {
        $resetResult["errors"]["new_password_err"] = "Please enter the new password.";
      } elseif (strlen(test_input($_POST["new_password"])) < 6) {
        $resetResult["errors"]["new_password_err"] = "Пароль не должен быть менее 6 символов.";
      } else {
        $resetResult["user_data"]["new_password"] = test_input($_POST["new_password"]);
      }

      //Валидация подтверждения нового пароля
      if (empty(test_input($_POST["confirm_password"]))) {
        $resetResult["errors"]["confirm_password_err"]  = "Пожалуйста подтвердите новый пароль.";
      } else {
        $resetResult["user_data"]["confirm_password"] = trim($_POST["confirm_password"]);
        if (
          isset($resetResult["user_data"]["new_password"])
          && ($resetResult["user_data"]["new_password"] != $resetResult["user_data"]["confirm_password"])
        ) {
          $resetResult["errors"]["confirm_password_err"] = "Пароли не совпадают.";
        }
      }

      //credentials
      if (empty($resetResult["errors"])) {
        $param_password = password_hash($resetResult["user_data"]["new_password"], PASSWORD_DEFAULT);
        //Get session id
        $param_id = $_SESSION["id"];
        $res = pg_query($db, "UPDATE users SET password = '$param_password' WHERE id = '$param_id';");

        if ($res) {
          Session::destroy();
          pg_close($db);
          $resetResult['status'] = true;
          return $resetResult;
        } else {
          die("Что-то о чем никто абсолютно не подумал все таки произошло");
        }
      } else {
        return $resetResult;
      }
    }
  }
}
