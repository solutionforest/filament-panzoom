<?php

use Livewire\Livewire;
use SolutionForest\FilamentPanzoom\Tests\Fixtures\SchemaPage;

it('renders panzoom through a filament 4 schema', function () {
    $html = Livewire::test(SchemaPage::class)->html();

    expect($html)
        ->toContain('x-data="interactiveImage(')
        ->toContain('imageUrl')
        ->toContain('x-ref="container"');
})->skip(! class_exists('Filament\Schemas\Schema'), 'This test requires Filament 4.');

it('renders panzoom through a filament 4 infolist schema', function () {
    $html = Livewire::test(SchemaPage::class, ['useEntry' => true])->html();

    expect($html)->toContain('x-data="interactiveImage(');
})->skip(! class_exists('Filament\Schemas\Schema'), 'This test requires Filament 4.');
