<?php

namespace LoremIpsum\PermissionCheckerBundle\Model;

use Doctrine\ORM\EntityManagerInterface;
use LoremIpsum\PermissionCheckerBundle\Exception\PermissionDeniedException;
use LoremIpsum\PermissionCheckerBundle\Permission\PermissionInterface;

interface PermissionCheckerInterface
{
    public function getEntityManager(): EntityManagerInterface;

    /** @return object */
    public function getUser();

    public function isAdmin(): bool;

    public function isSuperAdmin(): bool;

    public function has(PermissionInterface $permission): bool;

    /**
     * @param PermissionInterface $permission
     * @throws PermissionDeniedException
     */
    public function mustHave(PermissionInterface $permission);
}
