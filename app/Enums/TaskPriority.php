<?php

namespace App\Enums;

enum TaskPriority: int
{
    case Low = 1;
    case Medium = 2;
    case High = 3;

    public function getPriority(): string
    {
        return match ($this) {
            TaskPriority::Low => 'Low',
            TaskPriority::Medium => 'Medium',
            TaskPriority::High => 'High',
        };
    }

    public static function getValues(): array
    {
        return [
            TaskPriority::Low->value,
            TaskPriority::Medium->value,
            TaskPriority::High->value,
        ];
    }
}
