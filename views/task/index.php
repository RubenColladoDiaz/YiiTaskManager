<h1>My Tasks</h1>

<ul>
    <?php foreach ($tasks as $task): ?>
        <li>
            <?= $task->title ?> <a href="task/update/<?= $task->id ?>">Edit</a> <a
                href="task/delete/<?= $task->id ?>">Delete</a>
        </li>
    <?php endforeach; ?>
</ul>