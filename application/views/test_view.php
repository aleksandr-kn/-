<div class="card bg-light" style="min-height: 100vh; display: flex; align-items: center; justify-content: center;">
  <h1>Test Page</h1>
  <?php
  if (Session::is_logged_in()) {
    echo "logged in";
  } else {
    echo "not logged in";
  }
  @var_dump($_SESSION);

  ?>

</div>