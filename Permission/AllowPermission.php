<?php

namespace LoremIpsum\PermissionCheckerBundle\Permission;

class AllowPermission extends AbstractPermission
{
    public function isGranted(): bool
    {
        return true;
    }
}
