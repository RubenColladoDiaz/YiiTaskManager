<h1>My Tasks</h1>

<ul>
    <?php foreach ($tasks as $task): ?>
        <li>
            <?= $task->title ?>
        </li>
    <?php endforeach; ?>
</ul>