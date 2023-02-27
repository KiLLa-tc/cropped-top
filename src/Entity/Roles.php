<?php

namespace App\Entity;

enum Roles {
    public const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_MANAGER = 'ROLE_MANAGER';
    public const ROLE_USER = 'ROLE_USER';
    public const ROLES_ADMIN = [self::ROLE_ADMIN, self::ROLE_SUPER_ADMIN, self::ROLE_MANAGER];
}