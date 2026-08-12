<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Html;

$this->registerCssFile(
    '@web/css/header.css',
    ['depends' => [\yii\bootstrap5\BootstrapAsset::class]]
);

$items = [
    [
        'label' => '<i class="bi bi-house"></i> Inicio',
        'url' => ['/'],
    ],
    [
        'label' => '<i class="bi bi-house"></i> Pending',
        'url' => ['/task/pending-tasks'],
    ],
    [
        'label' => '<i class="bi bi-house"></i> Search',
        'url' => ['/task/search'],
    ]
];

?>

<header id="header">

    <?php
    NavBar::begin([
        'brandLabel' => '<span class="fw-semibold">✓ TaskManager</span>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm',
        ],
        'containerOptions' => [
            'class' => 'container app-container',
        ],
    ]);
    ?>

    <?= Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto align-items-lg-center'],
        'encodeLabels' => false,
        'items' => $items,
    ]) ?>

    <?php NavBar::end(); ?>

</header>