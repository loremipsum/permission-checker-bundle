<?php

namespace LoremIpsum\PermissionCheckerBundle;

abstract class AbstractPermission implements Permission
{
    /**
     * @var PermissionChecker
     */
    protected $checker;

    /**
     * @var string
     */
    protected $action;

    public function __construct($action)
    {
        $this->action = $action;
    }

    public function setPermissionChecker(PermissionChecker $checker)
    {
        $this->checker = $checker;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
}
