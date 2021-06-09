<div class="container-fluid page-body-wrapper full-page-wrapper">
	<div class="content-wrapper d-flex align-items-center auth">
		<div class="row flex-grow">
			<div class="col-12 col-sm-8 col-xl-4 mx-auto">
				<div class="auth-form-light text-left p-5">
					<div class="brand-logo">

						<!-- <img src="/public/assets/images/logo.svg"> -->
					</div>
					<h4>Добро пожаловать!</h4>
					<h6 class="font-weight-light">Войдите в учетную запись чтобы продолжить.</h6>
					<form class="pt-3" method="post" action="/login/process">
						<div class="form-group">
							<input type="text" name="username" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Имя пользователя">
							<span class="help-block text-danger"><?php echo isset($errors['username_err']) ? $errors['username_err'] : ''; ?></span>
						</div>
						<div class="form-group">
							<input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Пароль">
							<span class="help-block text-danger"><?php echo isset($errors['password_err']) ? $errors['password_err'] : ''; ?></span>
						</div>
						<div class="mt-3">
							<button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">ВОЙТИ</button>
						</div>
						<div class="text-center mt-4 font-weight-light"> Пока нет учетной записи? <a href="/registration/" class="text-primary">Создать</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- content-wrapper ends -->
</div>