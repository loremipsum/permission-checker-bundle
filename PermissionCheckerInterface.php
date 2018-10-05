<?php

namespace LoremIpsum\PermissionCheckerBundle;

use Doctrine\ORM\EntityManagerInterface;
use LoremIpsum\PermissionCheckerBundle\Exception\PermissionDeniedException;

interface PermissionCheckerInterface
{
    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager();

    /**
     * @return object
     */
    public function getUser();

    /**
     * @return bool
     */
    public function isAdmin();

    /**
     * @return bool
     */
    public function isSuperAdmin();

    /**
     * @param Permission $permission
     *
     * @return bool
     */
    public function has(Permission $permission);

    /**
     * @param Permission $permission
     *
     * @return void
     * @throws PermissionDeniedException
     */
    public function mustHave(Permission $permission);
}
