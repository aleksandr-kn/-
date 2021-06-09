<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="/profile/" class="nav-link">
        <div class="nav-profile-image">
          <img src="<?= $assets_folder_path ?>/images/icons/user_icon.png" alt="profile">
          <span class="login-status online"></span>
          <!--change to offline or busy as needed-->
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2">Username</span>
          <span class="text-secondary text-small">Role</span>
        </div>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/profile/dashboard">
        <span class="menu-title">Расходы</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/profile/categories">
        <span class="menu-title">Категории</span>
        <i class="mdi mdi-contacts menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/profile/sources">
        <span class="menu-title">Источники</span>
        <i class="mdi mdi-credit-card menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/profile/statistics">
        <span class="menu-title">Статистика</span>
        <i class="mdi mdi-chart-bar menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/profile/settings">
        <span class="menu-title">Настройки</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
    </li>

    <li class="nav-item sidebar-actions">
      <span class="nav-link">
        <div class="border-bottom">
          <h6 class="font-weight-normal mb-3">Быстрый доступ</h6>
        </div>
        <a href="/profile/dashboard" class="btn btn-block btn-lg btn-gradient-primary mt-4">
          +  Новый расход
        </a>
        <div class="mt-4">
          <div class="border-bottom">
            <p class="text-secondary">Добавить расход
        </div>
      </span>
    </li>
  </ul>
</nav>