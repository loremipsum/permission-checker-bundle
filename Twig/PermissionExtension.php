<?php

namespace LoremIpsum\PermissionCheckerBundle\Twig;

use LoremIpsum\PermissionCheckerBundle\Guardable;
use LoremIpsum\PermissionCheckerBundle\Permission\GuardPermission;
use LoremIpsum\PermissionCheckerBundle\PermissionCheckerInterface;
use Twig\Error\Error;

class PermissionExtension extends \Twig_Extension
{
    /**
     * @var PermissionCheckerInterface
     */
    protected $permissionChecker;

    /**
     * @var string|null
     */
    protected $actionPermission;

    /**
     * PermissionExtension constructor.
     * @param PermissionCheckerInterface $permissionChecker
     * @param string|null                $actionPermission
     */
    public function __construct(PermissionCheckerInterface $permissionChecker, $actionPermission)
    {
        $this->permissionChecker = $permissionChecker;
        $this->actionPermission  = $actionPermission;
    }

    public function getFunctions()
    {
        return [
            new \Twig_Function('hasCreatePermission', [$this, 'hasCreatePermission']),
            new \Twig_Function('hasReadPermission', [$this, 'hasReadPermission']),
            new \Twig_Function('hasUpdatePermission', [$this, 'hasUpdatePermission']),
            new \Twig_Function('hasDeletePermission', [$this, 'hasDeletePermission']),
            new \Twig_Function('hasGuardPermission', [$this, 'hasGuardPermission']),
            new \Twig_Function('hasActionPermission', [$this, 'hasActionPermission']),
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

    public function hasActionPermission($action)
    {
        if (! $this->actionPermission) {
            throw new Error("Configure 'lorem_ipsum_permission_checker.default_permission' to be used by hasActionPermission.");
        }
        return $this->permissionChecker->has(new $this->actionPermission($action));
    }
}
