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
        'label' => '<i class="bi bi-house"></i> Home',
        'url' => ['/'],
    ],
    [
        'label' => '<i class="bi bi-house"></i> Pending',
        'url' => ['/task/pending-tasks'],
    ],
    [
        'label' => '<i class="bi bi-house"></i> Search',
        'url' => ['/task/search'],
    ],
    [
        'label' => '<i class="bi bi-house"></i> ActiveDataProvider',
        'url' => ['/task/active-data-provider'],
    ],
    [
        'label' => '<i class="bi bi-house"></i> Advanced Search',
        'url' => ['/task/search-advanced'],
    ],
];

// Condicional para mostrar Login o Logout según el estado de la sesión
if (Yii::$app->user->isGuest) {
    $items[] = [
        'label' => '<i class="bi bi-box-arrow-in-right"></i> Login',
        'url' => ['/auth/login'],
    ];
} else {
    $items[] = '<li class="nav-item">'
        . Html::beginForm(['/auth/logout'], 'post', ['class' => 'd-flex'])
        . Html::submitButton(
            '<i class="bi bi-box-arrow-right"></i> Cerrar sesión (' . Html::encode(Yii::$app->user->identity->username) . ')',
            ['class' => 'btn btn-link nav-link logout text-decoration-none']
        )
        . Html::endForm()
        . '</li>';
}

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