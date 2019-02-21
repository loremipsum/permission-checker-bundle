<?php

namespace LoremIpsum\PermissionCheckerBundle\Permission;

class DenyPermission extends AbstractPermission
{
    public function isGranted(): bool
    {
        return false;
    }
}
