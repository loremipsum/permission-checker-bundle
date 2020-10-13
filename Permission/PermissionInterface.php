<?php

namespace LoremIpsum\PermissionCheckerBundle\Permission;

use LoremIpsum\PermissionCheckerBundle\Utils\PermissionChecker;

interface PermissionInterface
{
    public function isGranted(): bool;

    public function setPermissionChecker(PermissionChecker $checker);

    /** @return mixed */
    public function getAction();
}
