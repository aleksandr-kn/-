<?php

class Session
{
  public static function start()
  {
    // If no session exist, start the session.
    if (session_status() != 2) {
      session_start();
    }
  }

  public static function destroy()
  {
    if (empty($_SESSION)) {
      session_start();
    }
    if (!empty($_SESSION)) {
      session_unset();
      session_destroy();
    }
  }

  public static function is_logged_in()
  {

    if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] === true)) {
      return true;
    } else {
      return false;
    }
  }
}
