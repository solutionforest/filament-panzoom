# Filament Pan & Zoom

[![Latest Version on Packagist](https://img.shields.io/packagist/v/solutionforest/filament-panzoom.svg?style=flat-square)](https://packagist.org/packages/solutionforest/filament-panzoom)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/solutionforest/filament-panzoom/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/solutionforest/filament-panzoom/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/solutionforest/filament-panzoom/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/solutionforest/filament-panzoom/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/solutionforest/filament-panzoom.svg?style=flat-square)](https://packagist.org/packages/solutionforest/filament-panzoom)

An interactive image zoom and pan component for Filament PHP. This package provides a beautiful, responsive image viewer with smooth zoom and pan functionality, perfect for viewing receipts, documents, or any images that require detailed inspection.

**Features:**
- 🔍 Mouse wheel zooming
- 🖱️ Click and drag panning
- 📱 Touch support for mobile devices
- ⚡ Smooth transitions and animations
- 🎯 Zoom in/out buttons
- 🔄 Reset view functionality
- 📊 Real-time zoom percentage display
- 🎨 Modern, clean UI design

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

### In Blade Views

You can use the component directly in any Blade view:

```blade
@include('filament-panzoom::filament-panzoom', [
    'imageUrl' => 'https://example.com/image.jpg',
    'imageId' => 'unique-image-id'
])
```

### Usage

**⚠️ Important: Choose the correct component for your context!**

Filament requires different component base classes for different contexts:

**For Forms, Actions & Tables:**
```php
use SolutionForest\FilamentPanzoom\Components\PanZoom;

PanZoom::make('image_viewer')
    ->imageUrl(fn ($record) => $record?->image_url)
    ->columnSpanFull(),
```

**For Infolists:**
```php
use SolutionForest\FilamentPanzoom\Infolists\Components\PanZoomEntry;

PanZoomEntry::make('image_viewer')
    ->imageUrl(fn ($record) => $record?->image_url)
    ->imageId(fn ($record) => 'receipt-' . $record->id),
```

> **Why two components?** Filament has separate component hierarchies for Forms (`Filament\Forms\Components\Component`) and Infolists (`Filament\Infolists\Components\Component`). Using the wrong one will cause a TypeError.

### Usage Examples

**In Forms:**
```php
public static function form(Form $form): Form
{
    return $form->schema([
        PanZoom::make('image_preview')
            ->imageUrl(fn ($record) => $record?->image_url)
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
            ->imageUrl($this->imageUrl)
            ->columnSpanFull(),
    ];
}
```

## Component Properties

The component accepts the following properties:

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `imageUrl` | string | Yes | The URL of the image to display |
| `imageId` | string | Yes | Unique identifier for the component instance |

## Features

### Zoom Controls
- **Mouse Wheel**: Scroll to zoom in/out
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

### Quick Reference

| Context | Component | Import |
|---------|-----------|--------|
| Forms | `PanZoom` | `use SolutionForest\FilamentPanzoom\Components\PanZoom;` |
| Actions | `PanZoom` | `use SolutionForest\FilamentPanzoom\Components\PanZoom;` |
| Tables | `PanZoom` | `use SolutionForest\FilamentPanzoom\Components\PanZoom;` |
| Infolists | `PanZoomEntry` | `use SolutionForest\FilamentPanzoom\Infolists\Components\PanZoomEntry;` |

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
