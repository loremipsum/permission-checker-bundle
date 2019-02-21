<?php

namespace LoremIpsum\PermissionCheckerBundle\Model;

use LoremIpsum\PermissionCheckerBundle\Permission\PermissionInterface;

interface Guardable
{
    /**
     * @see GuardPermission
     *
     * @param string $action see GuardPermission constants
     *
     * @return PermissionInterface
     */
    public function getPermission($action): PermissionInterface;
}
