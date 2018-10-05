<?php

namespace LoremIpsum\PermissionCheckerBundle\Twig;

use LoremIpsum\PermissionCheckerBundle\Guardable;
use LoremIpsum\PermissionCheckerBundle\Permission\GuardPermission;
use LoremIpsum\PermissionCheckerBundle\PermissionCheckerInterface;

class PermissionExtension extends \Twig_Extension
{
    /**
     * @var PermissionCheckerInterface
     */
    protected $permissionChecker;

    public function __construct(PermissionCheckerInterface $permissionChecker)
    {
        $this->permissionChecker = $permissionChecker;
    }

    public function getFunctions()
    {
        return [
            new \Twig_Function('hasCreatePermission', [$this, 'hasCreatePermission']),
            new \Twig_Function('hasReadPermission', [$this, 'hasReadPermission']),
            new \Twig_Function('hasUpdatePermission', [$this, 'hasUpdatePermission']),
            new \Twig_Function('hasDeletePermission', [$this, 'hasDeletePermission']),
            new \Twig_Function('hasGuardPermission', [$this, 'hasGuardPermission']),
        ];
    }

    public function hasCreatePermission(Guardable $guard)
    {
        return $this->hasGuardPermission($guard, GuardPermission::CREATE);
    }

    public function hasReadPermission(Guardable $guard)
    {
        return $this->hasGuardPermission($guard, GuardPermission::READ);
    }

    public function hasUpdatePermission(Guardable $guard)
    {
        return $this->hasGuardPermission($guard, GuardPermission::UPDATE);
    }

    public function hasDeletePermission(Guardable $guard)
    {
        return $this->hasGuardPermission($guard, GuardPermission::DELETE);
    }

    public function hasGuardPermission(Guardable $guard, $action)
    {
        return $this->permissionChecker->has($guard->getPermission($action));
    }
}
