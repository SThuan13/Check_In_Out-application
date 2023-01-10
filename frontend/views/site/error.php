<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Lỗi trên xảy ra khi Web máy chủ xử lý yêu cầu 
    </p>
    <p>
        Liên hệ với chũng tôi nếu bạn nghĩ máy chủ lỗi. Cảm ơn
    </p>

</div>
