<?php

namespace SolutionForest\FilamentPanzoom\Tests\Fixtures;

use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Livewire\Component;
use SolutionForest\FilamentPanzoom\Components\PanZoom;
use SolutionForest\FilamentPanzoom\Infolists\Components\PanZoomEntry;

class SchemaPage extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    public bool $useEntry = false;

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            $this->useEntry
                ? PanZoomEntry::make('receipt_image')->imageUrl('https://example.com/a.jpg')
                : PanZoom::make('image_preview')->imageUrl('https://example.com/a.jpg'),
        ]);
    }

    public function render()
    {
        return '<div>{{ $this->content }}</div>';
    }
}
