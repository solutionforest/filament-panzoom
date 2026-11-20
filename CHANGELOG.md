# Changelog

All notable changes to `filament-panzoom` will be documented in this file.

## v1.4.6 - 2026-11-20

### Fixed

- Filament 4.x: the component no longer renders empty or stuck at `0%`. The Blade view no longer adds its own form/entry wrapper, because Filament 4 renders that wrapper automatically.
- Filament 3.x: the component content now renders inside forms instead of being swallowed by the wrapper.
- The `interactiveImage` Alpine component is registered with `Alpine.data()`, which is required by Filament 4's async Alpine loader.
- `@include('filament-panzoom::filament-panzoom', ...)` now respects the `doubleClickZoomLevel` option.

### Changed

- Extracted the shared viewer markup into the `components.pan-zoom-image` Blade partial.

### Documentation

- Added a supported versions table covering Filament, Laravel and PHP.

### Tooling

- Pinned all GitHub Actions to commit SHAs and added Dependabot cooldowns.
- The test matrix now covers Filament 3.x on Laravel 11 and Filament 4.x on Laravel 12.
- PHPStan now runs at **level 10** against both Filament majors, and the Composer advisory policy is relaxed for the dev-only CI installs.
- Widened the dev dependency constraints so both Filament majors can be tested.

**Full Changelog**: https://github.com/solutionforest/filament-panzoom/compare/v1.4.5...v1.4.6

## v1.4.5 - 2025-09-03

**Full Changelog**: https://github.com/solutionforest/filament-panzoom/compare/v1.4.4...v1.4.5

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
