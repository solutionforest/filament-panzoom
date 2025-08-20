<?php

namespace SolutionForest\FilamentPanzoom\Infolists\Components;

use Filament\Infolists\Components\Component;

class PanZoomEntry extends Component
{
    protected string $view = 'filament-panzoom::infolists.components.pan-zoom-entry';

    protected string | \Closure | null $imageUrl = null;
    
    protected string | \Closure | null $imageId = null;

    public static function make(string $name = 'panzoom'): static
    {
        $static = app(static::class, ['name' => $name]);
        $static->configure();

        return $static;
    }

    public function imageUrl(string | \Closure | null $url): static
    {
        $this->imageUrl = $url;

        return $this;
    }

    public function imageId(string | \Closure | null $id): static
    {
        $this->imageId = $id;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->evaluate($this->imageUrl);
    }

    public function getImageId(): ?string
    {
        return $this->evaluate($this->imageId) ?? 'panzoom-' . $this->getId();
    }
}
