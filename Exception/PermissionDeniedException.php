<?php

namespace LoremIpsum\PermissionCheckerBundle\Exception;

use LoremIpsum\PermissionCheckerBundle\Permission;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PermissionDeniedException extends AccessDeniedException
{
    /**
     * @var Permission
     */
    private $permission;

    /**
     * PermissionDeniedException constructor.
     *
     * @param Permission $permission
     */
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;

        parent::__construct();
    }

    /**
     * @return Permission
     */
    public function getPermission()
    {
        return $this->permission;
    }
}
