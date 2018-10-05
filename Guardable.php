<?php

namespace LoremIpsum\PermissionCheckerBundle;

interface Guardable
{
    /**
     * @see GuardPermission
     *
     * @param string $action see GuardPermission constants
     *
     * @return Permission
     */
    public function getPermission($action);
}
