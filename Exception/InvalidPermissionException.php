<?php

namespace LoremIpsum\PermissionCheckerBundle\Exception;

use LoremIpsum\PermissionCheckerBundle\Permission;

class InvalidPermissionException extends \RuntimeException
{
    private $permission;

    public function __construct(Permission $permission, $message)
    {
        $this->permission = $permission;

        parent::__construct($message);
    }

    /**
     * @return Permission
     */
    public function getPermission()
    {
        return $this->permission;
    }
}
