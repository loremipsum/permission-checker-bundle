# PermissionCheckerBundle Changelog

## [0.2.0] - 2018-10-05
### Add
- Add AllowPermission and DenyPermission

### Change
- Guardable getPermission() must return Permission
- Move GuardPermission into Permission namespace

### Remove
- Remove __toString() from Guardable interface
- Remove preCheck() from Permission interface

## [0.1.2] - 2018-10-04
### Change
- Add getSecurityChecker and getTokenStorage methods to PermissionChecker

## [0.1.1] - 2018-10-04
### Added
- Guardable interface and twig extensions

## [0.1.0] - 2018-10-02
### Added
- Initial version
