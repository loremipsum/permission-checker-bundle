<?php

namespace LoremIpsum\PermissionCheckerBundle;

use LoremIpsum\PermissionCheckerBundle\Exception\InvalidPermissionException;

class GuardPermission extends AbstractPermission
{
    const CREATE = 'CREATE';
    const READ = 'READ';
    const UPDATE = 'UPDATE';
    const DELETE = 'DELETE';

    /**
     * @var Guardable
     */
    private $guard;

    /**
     * @param string $action
     * @param Guardable $guard
     *
     * @throws InvalidPermissionException
     */
    public function __construct($action, $guard)
    {
        if (! $guard instanceof Guardable) {
            throw new InvalidPermissionException($this, "Guard permission object " . get_class($guard) . " has to implement Guardable");
        }
        $this->action = $action;
        $this->guard  = $guard;
    }

    public function isGranted()
    {
        $permission = $this->guard->getPermission($this->action);
        if (! $permission) {
            throw new InvalidPermissionException($this, "Invalid permission action '{$this->action}' for " . get_class($this->guard));
        }
        return $this->checker->has($permission);
    }
}
