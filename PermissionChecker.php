<?php

namespace LoremIpsum\PermissionCheckerBundle;

use Doctrine\ORM\EntityManagerInterface;
use LoremIpsum\PermissionCheckerBundle\Exception\PermissionDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class PermissionChecker implements PermissionCheckerInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    protected $securityChecker;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var object
     */
    protected $user;

    /**
     * @var array
     */
    protected $roles;

    /**
     * @param AuthorizationCheckerInterface $securityChecker
     * @param TokenStorageInterface $tokenStorage
     * @param EntityManagerInterface $em
     * @param array $roles
     */
    public function __construct(AuthorizationCheckerInterface $securityChecker, TokenStorageInterface $tokenStorage, EntityManagerInterface $em, $roles)
    {
        $this->securityChecker = $securityChecker;
        $this->tokenStorage    = $tokenStorage;
        $this->em              = $em;
        $this->roles           = (array)$roles;
    }

    public function getSecurityChecker()
    {
        return $this->securityChecker;
    }

    public function getTokenStorage()
    {
        return $this->tokenStorage;
    }

    public function getEntityManager()
    {
        return $this->em;
    }

    public function has(Permission $permission)
    {
        $permission->setPermissionChecker($this);
        return $permission->isGranted();
    }

    public function mustHave(Permission $permission)
    {
        if (! $this->has($permission)) {
            throw new PermissionDeniedException($permission);
        }
    }

    public function getUser()
    {
        if (! $this->user && null !== ($token = $this->tokenStorage->getToken()) && is_object($user = $token->getUser())) {
            $this->user = $user;
        }
        return $this->user;
    }

    public function isAdmin()
    {
        return (isset($this->roles['admin']) && $this->hasRole($this->roles['admin'])) || $this->isSuperAdmin();
    }

    public function isSuperAdmin()
    {
        return isset($this->roles['super_admin']) && $this->hasRole($this->roles['super_admin']);
    }

    /**
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->securityChecker->isGranted($role);
    }
}
