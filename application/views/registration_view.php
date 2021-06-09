<div class="container-fluid page-body-wrapper full-page-wrapper">
  <div class="content-wrapper d-flex align-items-center auth">
    <div class="row flex-grow">
      <div class="col-lg-4 mx-auto">
        <div class="auth-form-light text-left p-5">
          <div class="brand-logo">
            <!-- <img src="<?= $assets_folder_path ?>/images/logo.svg"> -->
          </div>
          <h4>Добро пожаловать.</h4>
          <h6 class="font-weight-light">Зарегестрировать просто. Всего несколько шагов.</h6>
          <form class="pt-3" method="POST" action="/registration/process">
            <div class="form-group">
              <input type="text" name="username" class="form-control form-control-lg" placeholder="Имя пользователя" value="<?php echo isset($user_data['username']) ? $user_data['username'] : ''; ?>">
              <span class="help-block text-danger"><?php echo isset($errors['username_err']) ? $errors['username_err'] : ''; ?></span>
            </div>
            <div class="form-group">
              <input type="email" name="email" class="form-control form-control-lg" placeholder="Email">
              <span class="help-block text-danger"><?php echo isset($errors['email_err']) ? $errors['email_err'] : ''; ?></span>
            </div>
            <div class="form-group">
              <input type="password" name="password" class="form-control form-control-lg" placeholder="Пароль">
              <span class="help-block text-danger"><?php echo isset($errors['password_err']) ? $errors['password_err'] : ''; ?></span>
            </div>
            <div class="form-group">
              <input type="password" name="confirm_password" class="form-control form-control-lg" placeholder="Подтверждение пароля">
              <span class="help-block text-danger"><?php echo isset($errors['confirm_password_err']) ? $errors['confirm_password_err'] : ''; ?></span>
            </div>
            <div class="mb-4">
              <div class="form-check">
                <label class="form-check-label text-muted">
                  <input type="checkbox" class="form-check-input"> Я соглашаюсь на использования файлов Cookie. <i class="input-helper"></i></label>
              </div>
            </div>
            <div class="mt-3">
              <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">SIGN UP</button>
            </div>
            <div class="text-center mt-4 font-weight-light"> Уже Зарегестрировались? <a href="/login/" class="text-primary">Войти</a>
            </div>
            <input name="date" value="" type="hidden">
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- content-wrapper ends -->
</div>