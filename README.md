# Filament Pan & Zoom
![filament-panzoom](https://github.com/user-attachments/assets/f1724153-4344-4579-be41-d9e65de612c1)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/solutionforest/filament-panzoom.svg?style=flat-square)](https://packagist.org/packages/solution-forest/filament-panzoom)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/solutionforest/filament-panzoom/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/solutionforest/filament-panzoom/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/solutionforest/filament-panzoom/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/solutionforest/filament-panzoom/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/solutionforest/filament-panzoom.svg?style=flat-square)](https://packagist.org/packages/solution-forest/filament-panzoom)

An interactive image zoom and pan component for Filament PHP. This package provides a beautiful, responsive image viewer with smooth zoom and pan functionality, perfect for viewing receipts, documents, or any images that require detailed inspection.

**Features:**
- 🔍 Mouse wheel zooming
- 🖱️ Click and drag panning
- 🖱️ Double-click zoom to position (configurable level)
- 📱 Touch support for mobile devices
- ⚡ Smooth transitions and animations
- 🎯 Zoom in/out buttons
- 🔄 Reset view functionality
- 📊 Real-time zoom percentage display
- 🎨 Modern, clean UI design


https://github.com/user-attachments/assets/a62bb402-cf1c-497b-a3f3-509819db6926


## Requirements

- PHP 8.3+
- Laravel 10.0+
- Filament 3.3+ or 4.0+

## Installation

You can install the package via composer:

```bash
composer require solution-forest/filament-panzoom
```

### Register the Plugin

Add the plugin to your Filament Panel Provider (e.g., `app/Providers/Filament/AdminPanelProvider.php`):

```php
use SolutionForest\FilamentPanzoom\FilamentPanzoomPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->default()
        ->id('admin')
        ->path('admin')
        // ... other configuration
        ->plugins([
            FilamentPanzoomPlugin::make(),
            // ... other plugins
        ]);
}
```

### Optional: Publish Assets

Optionally, you can publish the views for customization:

```bash
php artisan vendor:publish --tag="filament-panzoom-views"
```

You can also publish the config file:

```bash
php artisan vendor:publish --tag="filament-panzoom-config"
```

## Usage

### Filament Version Compatibility

This package supports both **Filament 3.0+** and **Filament 4.0+** with automatic compatibility detection.

#### Filament 3.0+ (Legacy)
```php
// Forms, Actions & Tables
use SolutionForest\FilamentPanzoom\Components\PanZoom;

public static function form(Form $form): Form
{
    return $form->schema([
        PanZoom::make('image_preview')
            ->imageUrl(fn ($record) => $record?->image_url)
            ->label('Image Preview')
            ->columnSpanFull(),
    ]);
}

// Infolists
use SolutionForest\FilamentPanzoom\Infolists\Components\PanZoomEntry;

public function infolist(Infolist $infolist): Infolist
{
    return $infolist->schema([
        PanZoomEntry::make('image_preview')
            ->imageUrl(fn ($record) => $record?->image_url)
            ->label('Image Preview'),
    ]);
}
```

#### Filament 4.0+ (Current)
```php
// Forms - Uses Schemas
use SolutionForest\FilamentPanzoom\Components\PanZoom;

public static function configure(Schema $schema): Schema
{
    return $schema->components([
        PanZoom::make('image_preview')
            ->imageUrl(fn ($record) => $record?->image_url),
        // Note: label() and columnSpanFull() methods not available in 4.0+
    ]);
}

// Infolists - Uses Schemas
use SolutionForest\FilamentPanzoom\Infolists\Components\PanZoomEntry;

public static function configure(Schema $schema): Schema
{
    return $schema->components([
        PanZoomEntry::make('image_preview')
            ->imageUrl(fn ($record) => $record?->image_url),
    ]);
}
```

### Configurable Double-Click Zoom

You can customize the double-click zoom level for each component. Double-clicking again will return the image to the original fit-to-container view:

```php
// Filament 3.0+ Forms
PanZoom::make('image_preview')
    ->imageUrl(fn ($record) => $record?->image_url)
    ->doubleClickZoomLevel(2.5)  // Zoom to 2.5x instead of default 3x
    ->label('Image Preview');

// Filament 4.0+ Forms
PanZoom::make('image_preview')
    ->imageUrl(fn ($record) => $record?->image_url)
    ->doubleClickZoomLevel(4.0)  // Zoom to 4x for more detail
    ->columnSpanFull();

// Infolists (both 3.0+ and 4.0+)
PanZoomEntry::make('image_preview')
    ->imageUrl(fn ($record) => $record?->image_url)
    ->doubleClickZoomLevel(2.0)  // Zoom to 2x
    ->imageId(fn ($record) => 'image-' . $record->id);
```

**Available Zoom Levels:**
- **Range**: 0.5x to 5.0x
- **Default**: 3.0x (good balance for detail viewing)
- **Common values**:
  - `2.0` - Moderate zoom
  - `2.5` - Balanced zoom  
  - `3.0` - Default (detailed view)
  - `4.0` - High zoom
  - `5.0` - Maximum zoom

### In Blade Views

You can use the component directly in any Blade view (works in both 3.0+ and 4.0+):

```blade
@include('filament-panzoom::filament-panzoom', [
    'imageUrl' => 'https://example.com/image.jpg',
    'imageId' => 'unique-image-id',
    'doubleClickZoomLevel' => 2.5  // Custom zoom level (double-click again to return to fit)
])
```

### Component Selection Guide

**⚠️ Important: Choose the correct component for your context!**

| Context | Component | Import |
|---------|-----------|--------|
| Forms (3.0+) | `PanZoom` | `use SolutionForest\FilamentPanzoom\Components\PanZoom;` |
| Forms (4.0+) | `PanZoom` | `use SolutionForest\FilamentPanzoom\Components\PanZoom;` |
| Actions | `PanZoom` | `use SolutionForest\FilamentPanzoom\Components\PanZoom;` |
| Tables | `PanZoom` | `use SolutionForest\FilamentPanzoom\Components\PanZoom;` |
| Infolists (3.0+) | `PanZoomEntry` | `use SolutionForest\FilamentPanzoom\Infolists\Components\PanZoomEntry;` |
| Infolists (4.0+) | `PanZoomEntry` | `use SolutionForest\FilamentPanzoom\Infolists\Components\PanZoomEntry;` |

> **Why two components?** Filament has separate component hierarchies for Forms and Infolists. Using the wrong one will cause a TypeError.

### Key Differences: Filament 3.0+ vs 4.0+

| Feature | Filament 3.0+ | Filament 4.0+ |
|---------|---------------|---------------|
| **Forms Structure** | `form(Form $form): Form` | `configure(Schema $schema): Schema` |
| **Infolists Structure** | `infolist(Infolist $infolist): Infolist` | `configure(Schema $schema): Schema` |
| **Available Methods** | `label()`, `columnSpanFull()`, etc. | Limited methods (Schemas-based) |
| **Component Base** | `Filament\Forms\Components\Component` | `Filament\Schemas\Components\Component` |
| **Auto-detection** | ✅ Yes | ✅ Yes |

### Usage Examples

#### Filament 3.0+ Examples

**In Forms:**
```php
public static function form(Form $form): Form
{
    return $form->schema([
        PanZoom::make('image_preview')
            ->imageUrl(fn ($record) => $record?->image_url)
            ->label('Image Preview')
            ->columnSpanFull(),
    ]);
}
```

**In Infolists:**
```php
use SolutionForest\FilamentPanzoom\Infolists\Components\PanZoomEntry;

public function infolist(Infolist $infolist): Infolist
{
    return $infolist->schema([
        PanZoomEntry::make('receipt_image')
            ->imageUrl(fn ($record) => asset('storage/' . $record->image_path))
            ->label('Receipt Image')
            ->imageId(fn ($record) => 'receipt-' . $record->id),
    ]);
}
```

**In Table Actions:**
```php
public static function table(Table $table): Table
{
    return $table->actions([
        Action::make('viewImage')
            ->form([
                PanZoom::make('image_viewer')
                    ->imageUrl(fn ($record) => $record->image_url)
                    ->label('Image Viewer'),
            ])
    ]);
}
```

**In Custom Pages:**
```php
protected function getFormSchema(): array
{
    return [
        PanZoom::make('document_viewer')
            ->imageUrl($this->imageUrl)
            ->label('Document Viewer')
            ->columnSpanFull(),
    ];
}
```

#### Filament 4.0+ Examples

**In Forms (Schemas):**
```php
public static function configure(Schema $schema): Schema
{
    return $schema->components([
        PanZoom::make('image_preview')
            ->imageUrl(fn ($record) => $record?->image_url),
        // Note: label() and columnSpanFull() methods not available in 4.0+
    ]);
}
```

**In Infolists (Schemas):**
```php
use SolutionForest\FilamentPanzoom\Infolists\Components\PanZoomEntry;

public static function configure(Schema $schema): Schema
{
    return $schema->components([
        PanZoomEntry::make('receipt_image')
            ->imageUrl(fn ($record) => asset('storage/' . $record->image_path))
            ->imageId(fn ($record) => 'receipt-' . $record->id),
    ]);
}
```

**In Table Actions:**
```php
public static function table(Table $table): Table
{
    return $table->actions([
        Action::make('viewImage')
            ->form([
                PanZoom::make('image_viewer')
                    ->imageUrl(fn ($record) => $record->image_url),
            ])
    ]);
}
```

**In Custom Pages:**
```php
protected function getFormSchema(): array
{
    return [
        PanZoom::make('document_viewer')
            ->imageUrl($this->imageUrl),
        // Note: columnSpanFull() method not available in 4.0+
    ];
}
```

## Component Properties

The component accepts the following properties:

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `imageUrl` | string | Yes | The URL of the image to display |
| `imageId` | string | Yes | Unique identifier for the component instance |
| `doubleClickZoomLevel` | float | No | Zoom level for double-click (0.5-5.0, default: 3.0) |

## Quick Tips

💡 **Pro Tip**: Double-click anywhere on the image to zoom to that exact position (configurable, default 3x). Double-click again to return to fit.

## Features

### Zoom Controls
- **Mouse Wheel**: Scroll to zoom in/out
- **Double-Click**: Double-click to zoom to exact position (configurable level, default: 3x). Double-click again to return to fit.
- **Zoom Buttons**: Click the + and - buttons in the control panel
- **Zoom Range**: 0.5x to 5x magnification

### Pan Controls
- **Mouse Drag**: Click and drag to pan around the image
- **Touch Support**: Touch and drag on mobile devices

### Reset View
- **Reset Button**: Click the reset button to return to the original view
- **Auto-fit**: Images are automatically fitted to the container on load

### Visual Feedback
- **Zoom Percentage**: Real-time zoom level display
- **Cursor States**: Visual feedback for grabbable/grabbing states
- **Smooth Transitions**: Animated zoom and pan movements

## Styling

The component uses Tailwind CSS classes and is designed to work seamlessly with Filament's design system. The component is fully responsive and includes:

- Modern, clean interface
- Smooth hover effects
- Mobile-friendly touch controls
- Consistent with Filament's design patterns

## Troubleshooting

### Common Issues

**TypeError: Argument #1 ($component) must be of type Filament\Infolists\Components\Component**
- ❌ You're using `PanZoom` in an Infolist
- ✅ Use `PanZoomEntry` for Infolists instead

**TypeError: Argument #1 ($component) must be of type Filament\Forms\Components\Component**  
- ❌ You're using `PanZoomEntry` in a Form/Action
- ✅ Use `PanZoom` for Forms/Actions instead

**Fatal Error: Class was composed with trait conflicts**
- ✅ Fixed in v1.2.1+ - update your package

**Method not found: label() or columnSpanFull() in Filament 4.0+**
- ❌ These methods aren't available in Filament 4.0+ Schemas
- ✅ Remove these method calls or use Filament 3.0+ syntax

**Undefined type 'Filament\Schemas\Components\Component'**
- ❌ Linter error in Filament 3.0+ environment
- ✅ This is expected - the package uses runtime detection for compatibility

### Version-Specific Issues

#### Filament 3.0+
- ✅ All methods available (`label()`, `columnSpanFull()`, etc.)
- ✅ Traditional Forms/Infolists structure

#### Filament 4.0+
- ⚠️ Limited methods available (Schemas-based)
- ⚠️ Different structure (`configure(Schema $schema)`)
- ✅ Automatic compatibility detection

### Quick Reference

| Context | Component | Import |
|---------|-----------|--------|
| Forms (3.0+) | `PanZoom` | `use SolutionForest\FilamentPanzoom\Components\PanZoom;` |
| Forms (4.0+) | `PanZoom` | `use SolutionForest\FilamentPanzoom\Components\PanZoom;` |
| Actions | `PanZoom` | `use SolutionForest\FilamentPanzoom\Components\PanZoom;` |
| Tables | `PanZoom` | `use SolutionForest\FilamentPanzoom\Components\PanZoom;` |
| Infolists (3.0+) | `PanZoomEntry` | `use SolutionForest\FilamentPanzoom\Infolists\Components\PanZoomEntry;` |
| Infolists (4.0+) | `PanZoomEntry` | `use SolutionForest\FilamentPanzoom\Infolists\Components\PanZoomEntry;` |

## Browser Support

- Chrome 70+
- Firefox 65+
- Safari 12+
- Edge 79+

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [SolutionForest Team](https://github.com/solutionforest)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
