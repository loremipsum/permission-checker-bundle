<?php

namespace LoremIpsum\PermissionCheckerBundle\Permission;

use LoremIpsum\PermissionCheckerBundle\AbstractPermission;

class AllowPermission extends AbstractPermission
{
    public function isGranted()
    {
        return true;
    }
}
