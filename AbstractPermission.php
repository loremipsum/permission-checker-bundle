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

    public function setPermissionChecker(PermissionChecker $checker)
    {
        $this->checker = $checker;
    }

    /**
     * @return bool|null
     */
    public function preCheck()
    {
        if ($this->checker->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
}
