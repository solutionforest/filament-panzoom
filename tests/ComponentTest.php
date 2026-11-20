<?php

use SolutionForest\FilamentPanzoom\Components\PanZoom;
use SolutionForest\FilamentPanzoom\Infolists\Components\PanZoomEntry;

it('exposes the configured image properties', function () {
    $component = PanZoom::make('image_preview')
        ->imageUrl('https://example.com/image.jpg')
        ->imageId('image-preview')
        ->doubleClickZoomLevel(2.5);

    expect($component->getImageUrl())->toBe('https://example.com/image.jpg');
    expect($component->getImageId())->toBe('image-preview');
    expect($component->getDoubleClickZoomLevel())->toBe(2.5);
});

it('falls back to a generated image id', function () {
    $component = PanZoom::make('image_preview')
        ->imageUrl('https://example.com/image.jpg');

    expect($component->getImageId())->toStartWith('panzoom-');
});

it('exposes the configured infolist image properties', function () {
    $component = PanZoomEntry::make('receipt_image')
        ->imageUrl('https://example.com/receipt.jpg')
        ->imageId('receipt-image')
        ->doubleClickZoomLevel(4.0);

    expect($component->getImageUrl())->toBe('https://example.com/receipt.jpg');
    expect($component->getImageId())->toBe('receipt-image');
    expect($component->getDoubleClickZoomLevel())->toBe(4.0);
});

it('renders the interactive image markup with the configured zoom level', function () {
    $html = view('filament-panzoom::components.pan-zoom-image', [
        'imageUrl' => 'https://example.com/image.jpg',
        'imageId' => 'image-preview',
        'doubleClickZoomLevel' => 2.5,
    ])->render();

    expect($html)
        ->toContain('x-data="interactiveImage(')
        ->toContain('image-preview')
        ->toContain('2.5')
        ->toContain('x-ref="container"')
        ->toContain('x-ref="image"');
});

it('registers the alpine component for filament 4', function () {
    $script = file_get_contents(__DIR__ . '/../resources/dist/filament-panzoom.js');

    expect($script)
        ->toContain('Alpine.data')
        ->toContain('interactiveImage')
        ->toContain('alpine:init');
});
