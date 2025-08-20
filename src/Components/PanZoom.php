<?php

namespace SolutionForest\FilamentPanzoom\Components;

use Filament\Forms\Components\Component;
use Filament\Support\Concerns\EvaluatesClosures;

class PanZoom extends Component
{
    use EvaluatesClosures;

    protected string $view = 'filament-panzoom::components.pan-zoom';

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
