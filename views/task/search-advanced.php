<?php

use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/** @var app\models\TaskSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'category_id',
            'value' => function ($model) {
                return $model->category?->name;
            },
            'filter' => $categories
        ],
        [
            'attribute' => 'status',
            'filter' => $statuses
        ],
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
            },
            'filter' => $priorities,
        ],
    ],
]) ?>