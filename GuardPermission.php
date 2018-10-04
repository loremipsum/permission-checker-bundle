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
     * @param Guardable $entity
     *
     * @throws InvalidPermissionException
     */
    public function __construct($action, $entity)
    {
        if (! $entity instanceof Guardable) {
            throw new InvalidPermissionException($this, "Invalid permission for " . get_class($entity) . " '$entity': has to implement Guardable");
        }
        $this->action = $action;
        $this->guard  = $entity;
    }

    public function isGranted()
    {
        $permission = $this->guard->getPermission($this->action);
        if (! $permission) {
            throw new InvalidPermissionException($this, "Invalid permission action '{$this->action}' for " . get_class($this->guard) . " '{$this->guard}'");
        }
        return $this->checker->has($permission);
    }
}
