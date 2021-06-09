<div class="container-fluid page-body-wrapper">
  <!-- partial:partials/_sidebar.html -->
  <?php require_once ROOTPATH . '/application/views/profile-sidebar_view.php'; ?>
  <!-- partial -->
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title">
          <span class="page-title-icon bg-gradient-primary text-white mr-2">
            <i class="mdi mdi-settings"></i>
          </span>
          Управление Категориями
        </h3>
        <nav aria-label="breadcrumb">
          <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
              <span>Категории</span>
              <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle pl-1"></i>
            </li>
          </ul>
        </nav>
      </div>

      <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Категории расходов</h4>
              <div class="add-items d-flex">
                <input type="text" class="form-control" id="new-category-name" placeholder="Название Новой Категории">
                <button class="add btn btn-gradient-primary font-weight-bold todo-list-add-btn" id="add-new-category">
                  Добавить
                </button>
              </div>
              <small class="category-error"></small>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th width="20%">#</th>
                      <th width="30%">Название</th>
                      <th width="30%">Цвет</th>
                      <th width="20%">Управление</th>
                    </tr>
                  </thead>
                  <tbody class="category-list">
                  <?php if (!empty($user_data['categories'])): ?>
                     <?php foreach ($user_data['categories'] as $category) : ?>
                      <tr class="category-list__item" data-category-id="<?= $category["id"]; ?>">
                        <td><?php echo $category["id"]; ?></td>
                        <td><?php echo $category["name"]; ?></td>
                        <td>
                          <div class="progress">
                            <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </td>
                        <td>
                          <button class="btn btn-outline-secondary btn-fw delete-category" type="button" data-category-id="<?= $category["id"]; ?>">Удалить</button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif;?>  
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card subcategories-card">
            <div class="card-body">
              <h4 class="card-title">Настройки <span class="subcategories-card__name"></span></h4>
              <small class="subcategory-error"></small>
              <div class="add-items d-flex">
                <input type="text" class="form-control todo-list-input" id="new-subcategory-name" placeholder="Добавить новую подкатегорию">
                <button class="btn btn-gradient-primary font-weight-bold" id="add-new-subcategory">
                  Добавить
                </button>
              </div>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Номер</th>
                    <th>Название</th>
                    <th>Процент</th>
                    <th>Управление</th>
                  </tr>
                </thead>
                <tbody class="subcategory-list">
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>      
    </div>

  </div>
  <!-- main-panel ends -->
</div>