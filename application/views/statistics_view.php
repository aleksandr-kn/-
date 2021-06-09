<head>

</head>

<div class="container-fluid page-body-wrapper">
  <!-- partial:../../partials/_sidebar.html -->
  <?php require_once ROOTPATH . '/application/views/profile-sidebar_view.php'; ?>
  <!-- partial -->


  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Статистика </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Здесь можно получить статистику</li>
            <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle pl-1 pt-1"></i>
          </ol>
        </nav>
      </div>

      <!-- <div class="row">
        <div class="col-12 col-xs-12 col-md-8 col-lg-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="mr-4">
                  <label for="first-date">С даты:</label>
                  <input type="date" class="form-control" id="first-date">
                </div>
                <div class="mr-4">
                  <label for="last-date">По дату:</label>
                  <input type="date" class="form-control" id="last-date">
                </div>
                <div class="pt-4">
                  <button id="filter-dates" class="btn btn-primary" type="button">Посмотреть</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <div class="row">
        <div class="col-12 col-md-6 stretch-card grid-margin">
          <div class="card h-100 bg-gradient-primary card-img-holder text-white">
            <div class="card-body spendings">
              <h3 class="font-weight-normal mb-3 spendings__title">
                Сформировать статистику
                <i class="mdi mdi-chart-line mdi-24px float-right spendings-icon"></i>
              </h3>

              <div class="spendings__inner">
                <div class="spendings__inner-left">
                  <p>С даты:</p>
                  <input type="date" class="form-control mb-3" id="first-date">

                  <p style="margin-top: 35px;">По дату:</p>
                  <input type="date" class="form-control" id="last-date">
                </div>
               <div class="spendings__inner-right">
                  <div class="categories-wrap">
                    <p class="spendings__category-title">Выберете основную категорию</p>
                    <select id="new_spending_category">
                      <option value="0">Все</option>
                      <?php if (isset($user_data["categories"])) foreach ($user_data["categories"] as $category) : ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category["name"]; ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="subcategories-wrap">
                    <p class="spendings__category-title" style="padding-top: 35px;">Выберете дополнительную категорию</p>
                    <select id="new_spending_subcategory">
                      
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group source-select">
                <div class="col-12 source-select__wrap">
                  <div class="input-group">
                    <div id="radioBtn" class="btn-group">
                      <a data-source-id="0" class="source-select__btn btn btn-inverse-dark btn-sm notActive" data-toggle="fun">Все</a>
                      <?php if (isset($user_data["sources"])) foreach ($user_data["sources"] as $source) : ?>
                        <a data-source-id="<?=$source['id']?>" class="source-select__btn btn btn-inverse-dark btn-sm <?= $source == $user_data["sources"][0] ? 'active' : 'notActive' ?>" data-toggle="fun"><?=$source['name']?></a>
                      <?php endforeach ?>
                    </div>
                    <input type="hidden" name="fun" id="fun">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-12 amount-select__wrap">
                  <span class="amount-select__start"> <?= $user_data['min_max'][0]['min'] ?> руб. </span>
                    <input id="spendings-amount" type="text" class="span2" value="" data-slider-min="<?= $user_data['min_max'][0]['min'] ?>" data-slider-max="<?= $user_data['min_max'][0]['max'] ?>" data-slider-step="10" data-slider-value="[<?= $user_data['min_max'][0]['min'] ?>,<?= $user_data['min_max'][0]['max'] ?>]"/>
                  <span class="amount-select__end"> <?= $user_data['min_max'][0]['max'] ?> руб.</span>
                </div>
              </div>
              <button type="button" id="get-statistics" class="btn btn-inverse-dark btn-lg btn-block">Получить статистику</button>
            </div>
          </div>
        </div>
      </div>

      <div class="row">

        <div class="col-lg-6 grid-margin stretch-card bar-card">
          <div class="card">
            <div class="card-body">
              <div class="chartjs-size-monitor">
                <div class="chartjs-size-monitor-expand">
                  <div class=""></div>
                </div>
                <div class="chartjs-size-monitor-shrink">
                  <div class=""></div>
                </div>
              </div>
              <h4 class="card-title">Bar chart</h4>
              <canvas id="barChart" style="height: 204px; display: block; width: 409px;" width="409" height="204" class="chartjs-render-monitor"></canvas>
            </div>
          </div>
        </div>
        <div class="col-lg-6 grid-margin stretch-card doughnut-card">
          <div class="card">
            <div class="card-body">
              <div class="chartjs-size-monitor">
                <div class="chartjs-size-monitor-expand">
                  <div class=""></div>
                </div>
                <div class="chartjs-size-monitor-shrink">
                  <div class=""></div>
                </div>
              </div>
              <h4 class="card-title">Doughnut chart</h4>
              <canvas id="doughnutChart" style="height: 204px; display: block; width: 409px;" width="409" height="204" class="chartjs-render-monitor"></canvas>
            </div>
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-12 grid-margin filtered-spendings-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Расходы по выбранным параметрам</h4>
              <small id="spendings-error"><?= isset($errors["spending_error"]) ? $errors["spending_error"] : "" ?></small>
              <div class="table-responsive ">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Сумма</th>
                      <th>Описание</th>
                      <th>Источник</th>
                      <th>Дата</th>
                      <th>Категория</th>
                      <th>Доп. Категория</th>
                      <th>Управление</th>
                    </tr>
                  </thead>
                  <tbody class="all-spendings-list">
                   
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
  </div>
  <!-- main-panel ends -->
</div>