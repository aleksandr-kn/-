<?php

class Auth
{
  public static function checkAuthenticated()
  {
    session_start();
  }

  /**
   * Check Unauthenticated: Checks to see if the user is unauthenticated,
   * redirecting to a specific location if the user session exist.
   * @access public
   * @param string $redirect
   * @since 1.0.2
   */
  public static function checkUnauthenticated()
  {
    Session::init();
    if (Session::exists("id")) {
      return false;
    } else {
      return true;
    }
  }
}
