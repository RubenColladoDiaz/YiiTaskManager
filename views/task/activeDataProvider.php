<?php

use yii\grid\GridView;
use yii\bootstrap5\LinkPager;

/** @var yii\data\ActiveDataProvider $dataProvider */

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'pager' => [
        'class' => LinkPager::class,
    ],
    'columns' => [
        'title',
        'status',
        [
            'attribute' => 'priority',
            'value' => function ($model) {
                return match ($model->priority) {
                    0 => 'Very Low',
                    1 => 'Low',
                    2 => 'Medium',
                    3 => 'High',
                    4 => 'Very High',
                    5 => 'Essential',
                    default => 'Unknown',
                };
            }
        ],
        [
            'attribute' => 'category_id',
            'value' => function ($model) {
                return $model->category?->name;
            },
        ],
    ],
]) ?>