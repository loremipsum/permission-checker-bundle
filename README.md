# PermissionChecker bundle

Symfony bundle to handle authorization, i.e. check permission to perform action on a resource.
This bundle is similar to the symfony voter but uses permission objects.

## Configuration

```yaml
# config/packages/lorem_ipsum_permission_checker.yaml 

lorem_ipsum_permission_checker:
    roles:
        admin: ROLE_ADMIN
        super_admin: ROLE_SUPER_ADMIN
    default_permission: \App\Security\Permission\AppPermission
```

`default_permission` is used by `hasActionPermission` twig function.

## Permission example

Usage example:  
Check if the current user has permission to update an existing user. Call `mustHave` or `has` 
on the `PermissionChecker` instance with the `UserPermission`.
`mustHave` throws an exception if the permission is not granted, whereas `has` just returns a boolean.

```php
/** @var LoremIpsum\PermissionCheckerBundle\PermissionChecker $permissionChecker **/
$permissionChecker->mustHave(new UserPermission(UserPermission::UPDATE, $user));
```

`AppPermission` example:

```php
<?php

namespace App\Security\Permission;

use LoremIpsum\PermissionCheckerBundle\AbstractPermission;
use LoremIpsum\PermissionCheckerBundle\Exception\InvalidPermissionException;

class AppPermission extends AbstractPermission
{
    const SETTINGS = 'settings';
    
    public function isGranted()
    {
        switch ($this->getAction()) {
            case self::SETTINGS:
                return $this->checker->isAdmin();
        }
        throw new InvalidPermissionException($this, "Invalid action '{$this->getAction()}'");
    }
}
```

`UserPermission` example:

```php
<?php

namespace App\Security\Permission;

use App\Entity\User;
use LoremIpsum\PermissionCheckerBundle\AbstractPermission;
use LoremIpsum\PermissionCheckerBundle\Exception\InvalidPermissionException;

class UserPermission extends AbstractPermission
{
    const CREATE = 'create';
    const READ = 'read';
    const UPDATE = 'update';
    const DELETE = 'delete';
    const CHANGE_PASSWORD = 'change_password';

    private $user;

    public function __construct($action, User $user)
    {
        parent::__construct($action);
        $this->user = $user;
    }

    public function isGranted()
    {
        switch ($this->getAction()) {
            case self::READ:
                // All users can view other users
                return true;
            case self::CHANGE_PASSWORD:
                // Admins can change passwords, users can change their own password 
                return $this->checker->isAdmin() || $this->checker->getUser() === $this->user;
            case self::CREATE:
            case self::UPDATE:
            case self::DELETE:
                // Admins can create/update/delete users
                return $this->checker->isAdmin();
        }

        throw new InvalidPermissionException($this, "Invalid action '{$this->getAction()}'");
    }
}
```