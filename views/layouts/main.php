<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var string $content */

use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;

$this->render('_head');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100" data-bs-theme="light">

<head>
    <?php $this->head() ?>
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') . '/css/main.css' ?>">
    <title><?= Html::encode($this->title) ?></title>
</head>

<body class="d-flex flex-column min-vh-100">

    <?php $this->beginBody() ?>

    <?= $this->render('_header') ?>

    <main id="main" class="flex-grow-1" role="main">
        <div class="container app-container">

            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget([
                    'links' => $this->params['breadcrumbs'],
                ]) ?>
            <?php endif ?>

            <?= Alert::widget() ?>

            <div class="content-card">
                <?= $content ?>
            </div>

        </div>
    </main>

    <?= $this->render('_footer') ?>

    <?php $this->endBody() ?>

</body>

</html>
<?php $this->endPage() ?>