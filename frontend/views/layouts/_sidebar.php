<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;
?>

<nav id="sidebarMenu" class="col-md-2 col-lg-2 d-md-block bg-light sidebar collapse">
	<div class="position-sticky pt-3 sidebar-sticky">
		<ul class="nav flex-column ">
			<li class="nav-item">
				<a 
					class="nav-link" 
					aria-current="page" 
					href="
						<?= Url::to(['site/index']);?>
					"
				>
					<span data-feather="home" class="align-text-bottom"></span>
					Trang chủ
				</a>
			</li>
			<li class="nav-item">
				<a 
					class="nav-link" 
					aria-current="page" 
					href="
						<?= Url::to(['attendance/index']);?>
					"
				>
					<span data-feather="home" class="align-text-bottom"></span>
					Đơn chấm công
				</a>
			</li>
			<li class="nav-item">
				<a 
					class="nav-link"
					href="
						<?= Url::to(['employee/profile']);?>
					"
				>
					<span data-feather="shopping-cart" class="align-text-bottom"></span>
					Hồ sơ cá nhân
				</a>
			</li>
		</ul>
	</div>
</nav>