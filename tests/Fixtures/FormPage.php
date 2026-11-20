<?php

namespace SolutionForest\FilamentPanzoom\Tests\Fixtures;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use SolutionForest\FilamentPanzoom\Components\PanZoom;

class FormPage extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                PanZoom::make('image_preview')->imageUrl('https://example.com/a.jpg'),
            ])
            ->statePath('data');
    }

    public function render()
    {
        return '<div>{{ $this->form }}</div>';
    }
}
