<?php

namespace LoremIpsum\PermissionCheckerBundle;

interface Guardable
{
    /**
     * @see GuardPermission
     *
     * @param string $action see GuardPermission constants
     *
     * @return Permission|null
     */
    public function getPermission($action);

    public function __toString();
}
