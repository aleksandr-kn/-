<?php
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function load_scripts($view_name)
{

  if (is_dir(ROOTPATH . "/public/assets/js/" . $view_name)) {
    $all_files = scandir(ROOTPATH . "/public/assets/js/" . $view_name);
    $filtered_files = array_diff($all_files, array('.', '..'));

    if (empty($filtered_files)) {
      return false;
    } else {
      return $filtered_files;
    }
  } else {
    return false;
  }
}

function load_styles($view_name)
{
  if (is_dir(ROOTPATH . "/public/assets/css/" . $view_name)) {
    $all_files = scandir(ROOTPATH . "/public/assets/css/" . $view_name);
    $filtered_files = array_diff($all_files, array('.', '..'));

    if (empty($filtered_files)) {
      return false;
    } else {
      return $filtered_files;
    }
  } else {
    return false;
  }
}