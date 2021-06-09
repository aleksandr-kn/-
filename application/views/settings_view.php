<div class="container-fluid page-body-wrapper">
  <!-- partial:partials/_sidebar.html -->
  <?php require_once ROOTPATH . '/application/views/profile-sidebar_view.php'; ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Form elements </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Forms</a></li>
            <li class="breadcrumb-item active" aria-current="page">Form elements</li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <span id="profile-message" class="text-success"></span>
              <h4 class="card-title">Информация о профиле</h4>
              <p class="card-description">Добавьте основную инофрмацию о профиле</p>
              <form class="forms-sample" action="/profile/update_profile" method="POST">
                <div class="form-group">
                  <label for="new_username">Имя пользователя</label>
                  <input type="text" class="form-control" id="new_username" placeholder="Введите новое имя пользователя" value="<?= isset($user_data["user_info"]["username"]) ? $user_data["user_info"]["username"] : "" ?>">
                  <small id="profile-username-error" class="text-danger"></small>
                </div>
                <div class="form-group">
                  <label for="new_email">Email адрес</label>
                  <input type="email" class="form-control" id="new_email" placeholder="Введите новые E-mail" value="<?= isset($user_data["user_info"]["email"]) ? $user_data["user_info"]["email"] : "" ?>">
                  <small id="profile-email-error" class="text-danger"></small>
                </div>
                <div class="form-group">
                  <label for="new_info">Дополнительная информация</label>
                  <textarea class="form-control autosize" id="new_info" rows="4" placeholder="Добавьте любую дополнительную информацию о профиле"><?= isset($user_data["user_info"]["info"]) ? $user_data["user_info"]["info"] : "" ?></textarea>
                </div>
                <button type="button" class="btn btn-gradient-primary mr-2" id="update-user-info">Submit</button>
                <button type="reset" class="btn btn-light">Cancel</button>
              </form>

            </div>
          </div>
        </div>
        <div class="col-12 col-xs-12 col-sm-12 col-md-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Смена пароля</h4>
              <a href="/reset" class="btn btn-block btn-lg btn-gradient-primary mt-4">Смена пароля</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>