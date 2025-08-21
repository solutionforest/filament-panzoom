# Changelog

All notable changes to `filament-panzoom` will be documented in this file.

## v1.4.4 - 2025-08-21

### What's Changed

* Bump actions/checkout from 4 to 5 by @dependabot[bot] in https://github.com/solutionforest/filament-panzoom/pull/1

### New Contributors

* @dependabot[bot] made their first contribution in https://github.com/solutionforest/filament-panzoom/pull/1

**Full Changelog**: https://github.com/solutionforest/filament-panzoom/compare/v1.4.3...v1.4.4

## v1.4.3 - 2025-08-20

**Full Changelog**: https://github.com/solutionforest/filament-panzoom/compare/v1.4.2...v1.4.3

## 1.4.0 - 2024-08-20

### Added

- **Configurable double-click zoom functionality**: Double-click to zoom to exact position with customizable zoom level
- **Zoom level configuration**: Set custom zoom levels (0.5x to 5.0x) via `doubleClickZoomLevel()` method
- Enhanced user experience with precise zoom-to-position controls
- Default zoom level of 3.0x for optimal detail viewing

## 1.3.0 - 2024-08-20

### Added

- **Filament 4.0 compatibility**: Full support for Filament 4.0+ with conditional component base class selection
- Runtime detection of Filament version (3.x vs 4.x)
- Automatic selection of correct base class (`Filament\Schemas\Components\Component` for 4.x, `Filament\Forms\Components\Component` for 3.x)

### Changed

- Updated component inheritance to support both Filament 3.x and 4.x architectures
- Improved compatibility detection and error handling

## 1.2.5 - 2024-08-20

### Fixed

- Resolved `ArgumentCountError` in Infolist component by removing complex wrapper logic
- Simplified `pan-zoom-entry.blade.php` to render content directly

## 1.2.4 - 2024-08-20

### Fixed

- Fixed `ArgumentCountError` in Infolist component by using direct entry wrapper

## 1.2.3 - 2024-08-20

### Fixed

- Fixed `Undefined variable $entry` error in Infolist component
- Added explicit variable assignment in Blade template

## 1.2.2 - 2024-08-20

### Fixed

- Re-introduced separate `PanZoomEntry` component for Infolists to resolve `TypeError`
- Added clear documentation about component selection based on context

## 1.2.1 - 2024-08-20

### Fixed

- Removed conflicting `EvaluatesClosures` trait usage to resolve `FatalError`
- Fixed "Class was composed with trait conflicts" error

## 1.2.0 - 2024-08-20

### Changed

- Attempted universal component approach (reverted in 1.2.2)
- Updated documentation for simplified usage

## 1.1.0 - 2024-08-20

### Added

- Introduced `PanZoom::make()` component for simplified usage
- Added comprehensive installation and usage documentation

## 1.0.1 - 2024-08-19

### Fixed

- Add missing built CSS file (`filament-panzoom.css`) to fix package installation error
- Resolves "Failed to open stream: No such file or directory" error during `filament:upgrade` command
- Update built JavaScript assets

## 1.0.0 - 202X-XX-XX

- initial release
