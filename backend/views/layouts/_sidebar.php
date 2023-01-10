<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;
?>

<nav id="sidebarMenu" class="col-md-2 col-lg-2 d-md-block bg-light sidebar collapse">
	<div class="position-sticky pt-3 sidebar-sticky">
		<ul class="nav flex-column ">
			<li class="nav-item">
				<a 
					class="nav-link active" 
					aria-current="page" 
					href="
						<?= Url::to(['site/index']);?>
					"
				>
					<span data-feather="home" class="align-text-bottom"></span>
					Dashboard
				</a>
			</li>
			<li class="nav-item">
				<a 
					class="nav-link" 
					href="
						<?= Url::to(['department/index']);?>
					"
				>
					<span data-feather="file" class="align-text-bottom"></span>
					Phòng ban
				</a>
			</li>
			<li class="nav-item">
				<a 
					class="nav-link"
					href="
						<?= Url::to(['group/index']);?>
					"
				>
					<span data-feather="shopping-cart" class="align-text-bottom"></span>
					Nhóm/ Tổ
				</a>
			</li>
			<li class="nav-item">
				<a 
					class="nav-link"
					href="
						<?= Url::to(['detail-group/index']);?>
					"
				>
					<span data-feather="shopping-cart" class="align-text-bottom"></span>
					Nhân viên trong nhóm
				</a>
			</li>
			<li class="nav-item">
				<a 
					class="nav-link"
					href="
						<?= Url::to(['user/index']);?>
					"
				>
					<span data-feather="users" class="align-text-bottom"></span>
					Người dùng
				</a>
			</li>
			<li class="nav-item">
				<a 
					class="nav-link" 
					href="
						<?= Url::to(['attendance/index']);?>
					"
				>
					<span data-feather="bar-chart-2" class="align-text-bottom"></span>
					Chấm công
				</a>
			</li>
		</ul>

		<!-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
			<span>Saved reports</span>
			<a class="link-secondary" href="#" aria-label="Add a new report">
				<span data-feather="plus-circle" class="align-text-bottom"></span>
			</a>
		</h6>
		<ul class="nav flex-column mb-2">
			<li class="nav-item">
				<a class="nav-link" href="#">
					<span data-feather="file-text" class="align-text-bottom"></span>
					Current month
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">
					<span data-feather="file-text" class="align-text-bottom"></span>
					Last quarter
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">
					<span data-feather="file-text" class="align-text-bottom"></span>
					Social engagement
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">
					<span data-feather="file-text" class="align-text-bottom"></span>
					Year-end sale
				</a>
			</li>
		</ul> -->
	</div>
</nav>