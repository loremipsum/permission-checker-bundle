<?php

namespace LoremIpsum\PermissionCheckerBundle\Model;

use LoremIpsum\PermissionCheckerBundle\Permission\PermissionInterface;

interface Guardable
{
    /**
     * @param string $action see GuardPermission constants
     * @return PermissionInterface
     * @see GuardPermission
     */
    public function getPermission(string $action): PermissionInterface;
}
