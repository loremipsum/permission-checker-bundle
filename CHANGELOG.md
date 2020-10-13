# PermissionCheckerBundle Changelog

## [0.3.1] - 2020-10-13
### Change
- Update dependencies

## [0.3.0] - 2020-06-21
### Change
- **BC-BREAK** Set supported php version to ^7.1
- **BC-BREAK** Move AbstractPermission to Permission namespace
- **BC-BREAK** Rename Permission to Permission\PermissionInterface
- **BC-BREAK** Move Guardable to Model namespace
- **BC-BREAK** Move PermissionCheckerInterface to Model namespace
- **BC-BREAK** Move PermissionChecker to Utils namespace

## [0.2.2] - 2019-01-24
### Add
- `hasActionPermission` twig function using permission class configured via `default_permission`

### Change
- Add constructor to `AbstractPermission` class

## [0.2.1] - 2018-10-05
### Add
- Setup phpunit tests

### Change
- Allow to set admin roles in configuration
- Do not use App\Entity\User

## [0.2.0] - 2018-10-05
### Add
- Add AllowPermission and DenyPermission

### Change
- Guardable getPermission() must return Permission
- **BC-BREAK** Move GuardPermission into Permission namespace

### Remove
- **BC-BREAK** Remove __toString() from Guardable interface
- **BC-BREAK** Remove preCheck() from Permission interface

## [0.1.2] - 2018-10-04
### Change
- Add getSecurityChecker and getTokenStorage methods to PermissionChecker

## [0.1.1] - 2018-10-04
### Added
- Guardable interface and twig extensions

## [0.1.0] - 2018-10-02
### Added
- Initial version
