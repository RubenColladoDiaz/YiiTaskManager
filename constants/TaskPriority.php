<?php

namespace app\constants;

class TaskPriority
{
    public const VERY_LOW = 0;
    public const LOW = 1;
    public const MEDIUM = 2;
    public const HIGH = 3;
    public const VERY_HIGH = 4;
    public const ESSENTIAL = 5;

    public static function options(): array
    {
        return [
            self::VERY_LOW => 'Very Low',
            self::LOW => 'Low',
            self::MEDIUM => 'Medium',
            self::HIGH => 'High',
            self::VERY_HIGH => 'Very High',
            self::ESSENTIAL => 'Essential',
        ];
    }
}