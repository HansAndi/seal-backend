<?php

namespace App\Enums;

enum Status: int
{
    case Pending = 1;
    case InProgress = 2;
    case Completed = 3;

    public function getStatus(): string
    {
        return match ($this) {
            Status::Pending => 'Pending',
            Status::InProgress => 'In Progress',
            Status::Completed => 'Completed',
        };
    }

    public static function getOptions(): array
    {
        return [
            self::Pending->value => self::Pending->getStatus(),
            self::InProgress->value => self::InProgress->getStatus(),
            self::Completed->value => self::Completed->getStatus(),
        ];
    }

    public static function getValues(): array
    {
        return [
            Status::Pending->value,
            Status::InProgress->value,
            Status::Completed->value,
        ];
    }
}
