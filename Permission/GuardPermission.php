<?php

namespace LoremIpsum\PermissionCheckerBundle\Permission;

use LoremIpsum\PermissionCheckerBundle\Exception\InvalidPermissionException;
use LoremIpsum\PermissionCheckerBundle\Model\Guardable;

class GuardPermission extends AbstractPermission
{
    const CREATE = 'create';
    const READ = 'read';
    const UPDATE = 'update';
    const DELETE = 'delete';

    /**
     * @var Guardable
     */
    private $guard;

    /**
     * @param string    $action
     * @param Guardable $guard
     * @throws InvalidPermissionException
     */
    public function __construct(string $action, Guardable $guard)
    {
        parent::__construct($action);

        if (! $guard instanceof Guardable) {
            throw new InvalidPermissionException($this, "Guard permission object " . get_class($guard) . " has to implement Guardable");
        }
        $this->guard = $guard;
    }

    public function isGranted(): bool
    {
        $permission = $this->guard->getPermission($this->action);
        if (! $permission) {
            throw new InvalidPermissionException($this, "Invalid permission action '{$this->action}' for " . get_class($this->guard));
        }
        return $this->checker->has($permission);
    }
}
