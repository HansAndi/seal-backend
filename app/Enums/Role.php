<?php

namespace App\Enums;

enum Role: int
{
    case Manager = 1;
    case Employee = 2;

    public function getRole(): string
    {
        return match ($this) {
            Role::Manager => 'Manager',
            Role::Employee => 'Employee',
        };
    }

    public static function getValues(): array
    {
        return [
            Role::Manager->value,
            Role::Employee->value,
        ];
    }
    public static function getValue($value): Role
    {
        return match ($value) {
            Role::Manager->value => Role::Manager,
            Role::Employee->value => Role::Employee,
        };
    }
}
