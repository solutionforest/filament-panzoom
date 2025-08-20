# Changelog

All notable changes to `filament-panzoom` will be documented in this file.

## 1.4.0 - 2024-08-20

### Added
- **Double-click zoom functionality**: Double-click on the image to toggle between fit-to-container and 2x zoom
- Enhanced user experience with intuitive zoom controls

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
