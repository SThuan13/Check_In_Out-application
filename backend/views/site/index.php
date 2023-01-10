<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';

?>

<div class="px-4">
  <div class="d-sm-flex align-items-center justify-content-between my-4">
    <h2>Dashboard</h2>
  </div>

  <!-- Content Row -->
  <div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-4">
      <div class="card border-left-primary shadow h-100 py-2 rounded-0 border-4">
        <div class="card-body py-1">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-lg font-weight-bold mb-1">Departments</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 text-right"><?= $department?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-building fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-4">
      <div class="card border-left-success shadow h-100 py-2 rounded-0 border-4">
        <div class="card-body py-1">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-lg font-weight-bold mb-1">Groups</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 text-right"><?= $group?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-id-badge fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-4">
      <div class="card border-left-danger shadow h-100 py-2 rounded-0 border-4">
        <div class="card-body py-1">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-lg font-weight-bold mb-1">Employees</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 text-right"><?//= $employee?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
      <!-- Pie Chart -->
      <div class="col p-0">
        <div class="card shadow mb-4 rounded-0">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-rowz align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-muted">Departments' Employees</h6>
            <a class="text-reset font-weight-bolder text-muted" title="Go to Department List" href=""><i class="fa fa-arrow-right"></i></a>
          </div>
          <!-- Card Body -->
          <div class="card-body overflow-auto" style="max-height: 400px;">
            <table class="table table-bordered table-striped">
              <thead class="bg-gradient bg-primary text-white">
                <tr>
                  <th class="text-center p-1" scope="col">#</th>
                  <th class="p-1" scope="col">Dept Code</th>
                  <th class="p-1" scope="col">Employees</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
      <div class="col p-0">
        <div class="card shadow mb-4 rounded-0">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-muted">Employees per Shift</h6>
          </div>
          <!-- Card Body -->
          <div class="card-body" style="max-height: 370px;">
            <table class="table table-bordered table-striped">
              <thead class="bg-gradient bg-primary text-white">
                <tr>
                  <th class="text-center p-1" scope="col">#</th>
                  <th class="p-1" scope="col">Shift</th>
                  <th class="p-1" scope="col">Employees</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>
</div>
