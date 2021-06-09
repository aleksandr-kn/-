<div class="container-fluid page-body-wrapper full-page-wrapper">
  <div class="content-wrapper d-flex align-items-center auth">
    <div class="row flex-grow">
      <div class="col-lg-4 mx-auto">
        <div class="auth-form-light text-left p-5">
          <div class="brand-logo">
            <img src="<?= $assets_folder_path ?>/images/logo.svg">
          </div>
          <h4>Смена пароля</h4>
          <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
          <form class="pt-3" method="POST" action="/reset/process">
            <div class="form-group">
              <input type="password" name="new_password" class="form-control form-control-lg" placeholder="Password">
              <span class="help-block text-danger"><?php echo isset($errors['new_password_err']) ? $errors['new_password_err'] : ''; ?></span>
            </div>
            <div class="form-group">
              <input type="password" name="confirm_password" class="form-control form-control-lg" placeholder="Password">
              <span class="help-block text-danger"><?php echo isset($errors['confirm_password_err']) ? $errors['confirm_password_err'] : ''; ?></span>
            </div>
            <div class="mt-3">
              <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Сменить пароль</button>
            </div>
            <div class="text-center mt-4 font-weight-light"> Передумали? <a href="/profile/settings" class="text-primary">Профиль</a>
            </div>
            <input name="date" value="" type="hidden">
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- content-wrapper ends -->
</div>