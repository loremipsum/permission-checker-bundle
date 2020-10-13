<?php

namespace LoremIpsum\PermissionCheckerBundle\Permission;

use LoremIpsum\PermissionCheckerBundle\Utils\PermissionChecker;

abstract class AbstractPermission implements PermissionInterface
{
    /** @var PermissionChecker */
    protected $checker;

    /** @var mixed */
    protected $action;

    /** @param mixed $action */
    public function __construct($action)
    {
        $this->action = $action;
    }

    public function setPermissionChecker(PermissionChecker $checker)
    {
        $this->checker = $checker;
    }

    public function getAction()
    {
        return $this->action;
    }
}
