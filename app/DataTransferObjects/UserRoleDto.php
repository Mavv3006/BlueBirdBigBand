<?php

namespace App\DataTransferObjects;

readonly class UserRoleDto
{
    public function __construct(
        public int $id,
        public string $name,
        public bool $assigned
    ) {}

    public function toArray(): array
    {
        return ['id' => $this->id, 'name' => $this->name, 'assigned' => $this->assigned];
    }

    public function toString(): string
    {
        return json_encode($this->toArray());
    }
}
