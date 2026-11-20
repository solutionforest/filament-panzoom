<?php

use Livewire\Livewire;
use SolutionForest\FilamentPanzoom\Tests\Fixtures\FormPage;

it('renders panzoom through a filament 3 form', function () {
    $html = Livewire::test(FormPage::class)->html();

    expect($html)
        ->toContain('x-data="interactiveImage(')
        ->toContain('imageUrl')
        ->toContain('x-ref="container"');
})->skip(class_exists('Filament\Schemas\Schema'), 'Filament 4 renders through schemas.');
