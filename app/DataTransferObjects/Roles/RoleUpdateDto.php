<?php

namespace App\DataTransferObjects\Roles;

use App\DataTransferObjects\IdDto;

readonly class RoleUpdateDto
{
    /**
     * @param IdDto[] $permission_ids
     */
    public function __construct(
        public int $role_id,
        public array $permission_ids,
    ) {}
}
