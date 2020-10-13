<?php

namespace LoremIpsum\PermissionCheckerBundle\Exception;

use LoremIpsum\PermissionCheckerBundle\Permission\PermissionInterface;
use RuntimeException;

class InvalidPermissionException extends RuntimeException
{
    /** @var PermissionInterface */
    private $permission;

    public function __construct(PermissionInterface $permission, string $message)
    {
        $this->permission = $permission;

        parent::__construct($message);
    }

    public function getPermission(): PermissionInterface
    {
        return $this->permission;
    }
}
