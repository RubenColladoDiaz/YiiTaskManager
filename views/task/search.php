<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="mx-auto" style="max-width: 700px;">

    <div class="mb-4">
        <h2 class="fw-bold mb-1">Search Task</h2>
        <p class="text-muted mb-0">
            Complete the information below to search a specific task.
        </p>
    </div>

    <form action="<?= Url::to(['task/search']) ?>" method="get">

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter a title..." autofocus>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <?= Html::a('Cancel', ['task/index'], ['class' => 'btn btn-outline-secondary']) ?>

            <?= Html::submitButton('Search Task', ['class' => 'btn btn-primary']) ?>
        </div>

    </form>

</div>