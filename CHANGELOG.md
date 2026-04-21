## [1.2.1] - 2026-04-21
### Changed
- PHP 8.5 compatibility (also keeps PHP 8.2, 8.3 and 8.4 compatibility).
- Declare explicit PHP version constraint in `composer.json` (`~8.2.0||~8.3.0||~8.4.0||~8.5.0`).
- Cast `PageConfig::getRobots()` result to string before `explode()` to avoid deprecation/fatal when the metadata value is `null`.
- Add missing return types and cleanup PHPDoc blocks on `Model\SetMetaRobots`, `Observer\SetMetaRobotsCatalog`, `Setup\Patch\Data\*`.
- Promote constructor-promoted properties from `private readonly` to `protected readonly` to ease extension.

## [1.0.0] - 07/01/2025
### Added
- First module version
