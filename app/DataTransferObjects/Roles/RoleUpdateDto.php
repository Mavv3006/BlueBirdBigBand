<?php

namespace App\DataTransferObjects\Roles;

use App\DataTransferObjects\IdDto;

class RoleUpdateDto
{
    /**
     * @param int $role_id
     * @param IdDto[] $permission_ids
     */
    public function __construct(
        public readonly int   $role_id,
        public readonly array $permission_ids,
    )
    {
    }
}
