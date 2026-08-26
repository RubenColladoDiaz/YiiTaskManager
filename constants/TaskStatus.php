<?php

namespace app\constants;

class TaskStatus
{
    public const PENDING = 'pending';
    public const IN_PROGRESS = 'in_progress';
    public const COMPLETED = 'completed';

    public static function options(): array
    {
        return [
            TaskStatus::PENDING => 'Pending',
            TaskStatus::IN_PROGRESS => 'In Progress',
            TaskStatus::COMPLETED => 'Completed',
        ];
    }
}