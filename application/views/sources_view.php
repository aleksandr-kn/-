<div class="container-fluid page-body-wrapper">
  <!-- partial:partials/_sidebar.html -->
  <?php require_once ROOTPATH . '/application/views/profile-sidebar_view.php'; ?>
  <!-- partial -->
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title">
          <span class="page-title-icon bg-gradient-primary text-white mr-2">
            <i class="mdi mdi-home"></i>
          </span>
          Управление Источниками Расходов
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
        <div class="col-md-4 stretch-card grid-margin">
          <div class="card bg-gradient-dark card-img-holder text-white">
            <div class="card-body">
              <h2 class="mb-5">Новый источник</h2>
              <div class="add-source">
                <p class="add-source__input-title">
                  Введите название
                </p>
                <div class="add-source__input-wrap">
                  <input class="add-source__input" id="new-source-name" type="text" placeholder="Название" required="required">
                </div>
                <p class="add-source__input-title" style="margin-top: 35px;">
                  Введите описание
                </p>
                <div class="add-source__input-wrap">
                  <input class="add-source__input" type="text" id="new-source-description" class="form-control">
                </div>
                <button type="button" class="btn btn-outline-secondary btn-fw" id="add-new-source" style="margin-top: 35px;">Secondary</button>
              </div>
              <span class="source-error"></span>
            </div>
          </div>
        </div>

        <?php if (!empty($user_data["sources"])) foreach ($user_data["sources"] as $source) : ?>
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
              <div class="card-body">
                <img src="/public/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
                <h2 class="mb-3"><?= $source['name'] ?></h2>
                <h4 class="font-weight-normal mb-5"><?= $source['description'] ?> <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                </h4>
                <h6 class="card-text">Сумарные расходы 25%</h6>
                <button data-source-id="<?=$source['id']  ?>"  type="button" class="delete-source btn btn-outline-light text-black btn-fw mt-5" style="color: #fff;">Удалить</button>
              </div>
            </div>
          </div>
        <?php endforeach ?>

      </div>


    </div>

  </div>
  <!-- main-panel ends -->
</div>