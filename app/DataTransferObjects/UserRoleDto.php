<?php

namespace App\DataTransferObjects;

class UserRoleDto
{
    public function __construct(
        public readonly int    $id,
        public readonly string $name,
        public readonly bool   $assigned
    )
    {
    }

    public function toArray(): array
    {
        return ['id' => $this->id, 'name' => $this->name, 'assigned' => $this->assigned];
    }

    public function toString(): string
    {
        return json_encode($this->toArray());
    }
}
