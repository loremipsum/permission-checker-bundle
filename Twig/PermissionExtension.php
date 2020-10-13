<?php

namespace LoremIpsum\PermissionCheckerBundle\Twig;

use LoremIpsum\PermissionCheckerBundle\Model\Guardable;
use LoremIpsum\PermissionCheckerBundle\Permission\GuardPermission;
use LoremIpsum\PermissionCheckerBundle\Model\PermissionCheckerInterface;
use Twig\Error\Error;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PermissionExtension extends AbstractExtension
{
    /** @var PermissionCheckerInterface */
    protected $permissionChecker;

    /** @var string|null */
    protected $actionPermission;

    public function __construct(PermissionCheckerInterface $permissionChecker, ?string $actionPermission)
    {
        $this->permissionChecker = $permissionChecker;
        $this->actionPermission  = $actionPermission;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('hasCreatePermission', [$this, 'hasCreatePermission']),
            new TwigFunction('hasReadPermission', [$this, 'hasReadPermission']),
            new TwigFunction('hasUpdatePermission', [$this, 'hasUpdatePermission']),
            new TwigFunction('hasDeletePermission', [$this, 'hasDeletePermission']),
            new TwigFunction('hasGuardPermission', [$this, 'hasGuardPermission']),
            new TwigFunction('hasActionPermission', [$this, 'hasActionPermission']),
        ];
    }

    public function hasCreatePermission(Guardable $guard): bool
    {
        return $this->hasGuardPermission($guard, GuardPermission::CREATE);
    }

    public function hasReadPermission(Guardable $guard): bool
    {
        return $this->hasGuardPermission($guard, GuardPermission::READ);
    }

    public function hasUpdatePermission(Guardable $guard): bool
    {
        return $this->hasGuardPermission($guard, GuardPermission::UPDATE);
    }

    public function hasDeletePermission(Guardable $guard): bool
    {
        return $this->hasGuardPermission($guard, GuardPermission::DELETE);
    }

    public function hasGuardPermission(Guardable $guard, $action): bool
    {
        return $this->permissionChecker->has($guard->getPermission($action));
    }

    public function hasActionPermission($action): bool
    {
        if (! $this->actionPermission) {
            throw new Error("Configure 'lorem_ipsum_permission_checker.default_permission' to be used by hasActionPermission.");
        }
        return $this->permissionChecker->has(new $this->actionPermission($action));
    }
}
