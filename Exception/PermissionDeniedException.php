<?php

namespace LoremIpsum\PermissionCheckerBundle\Exception;

use LoremIpsum\PermissionCheckerBundle\Permission\PermissionInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PermissionDeniedException extends AccessDeniedException
{
    /**
     * @var PermissionInterface
     */
    private $permission;

    public function __construct(PermissionInterface $permission)
    {
        $this->permission = $permission;

        parent::__construct();
    }

    public function getPermission(): PermissionInterface
    {
        return $this->permission;
    }
}
