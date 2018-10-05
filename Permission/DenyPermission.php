<?php

namespace LoremIpsum\PermissionCheckerBundle\Permission;

use LoremIpsum\PermissionCheckerBundle\AbstractPermission;

class DenyPermission extends AbstractPermission
{
    public function isGranted()
    {
        return false;
    }
}
