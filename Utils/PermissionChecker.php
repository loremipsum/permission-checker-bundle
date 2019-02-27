<?php

namespace LoremIpsum\PermissionCheckerBundle\Utils;

use Doctrine\ORM\EntityManagerInterface;
use LoremIpsum\PermissionCheckerBundle\Exception\PermissionDeniedException;
use LoremIpsum\PermissionCheckerBundle\Model\PermissionCheckerInterface;
use LoremIpsum\PermissionCheckerBundle\Permission\PermissionInterface;
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
     * @param TokenStorageInterface         $tokenStorage
     * @param EntityManagerInterface        $em
     * @param array|string                  $roles
     */
    public function __construct(AuthorizationCheckerInterface $securityChecker, TokenStorageInterface $tokenStorage, EntityManagerInterface $em, $roles)
    {
        $this->securityChecker = $securityChecker;
        $this->tokenStorage    = $tokenStorage;
        $this->em              = $em;
        $this->roles           = (array)$roles;
    }

    public function getSecurityChecker(): AuthorizationCheckerInterface
    {
        return $this->securityChecker;
    }

    public function getTokenStorage(): TokenStorageInterface
    {
        return $this->tokenStorage;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }

    public function has(PermissionInterface $permission): bool
    {
        $permission->setPermissionChecker($this);
        return $permission->isGranted();
    }

    public function mustHave(PermissionInterface $permission)
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

    public function isAdmin(): bool
    {
        return (isset($this->roles['admin']) && $this->hasRole($this->roles['admin'])) || $this->isSuperAdmin();
    }

    public function isSuperAdmin(): bool
    {
        return isset($this->roles['super_admin']) && $this->hasRole($this->roles['super_admin']);
    }

    /**
     * @param string $role
     * @return bool
     */
    public function hasRole($role): bool
    {
        return $this->securityChecker->isGranted($role);
    }
}
