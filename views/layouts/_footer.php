<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->registerCssFile(
    '@web/css/footer.css',
    ['depends' => [\yii\bootstrap5\BootstrapAsset::class]]
);

?>

<footer id="footer" class="footer py-4 mt-auto">
    <div class="container app-container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">

            <div class="footer-copy">
                &copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?>
            </div>

            <div class="footer-text">
                Organize your tasks in an efficient and simply way.
            </div>

        </div>
    </div>
</footer>