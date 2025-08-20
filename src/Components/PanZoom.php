<?php

namespace SolutionForest\FilamentPanzoom\Components;

// Check if we're in Filament 4.x (has Schemas) or 3.x (Forms only)
if (class_exists('Filament\Schemas\Components\Component')) {
    // Filament 4.x
    class PanZoom extends \Filament\Schemas\Components\Component
    {
        protected string $view = 'filament-panzoom::components.pan-zoom';

        protected string | \Closure | null $imageUrl = null;

        protected string | \Closure | null $imageId = null;

        protected float $doubleClickZoomLevel = 3.0;

        public static function make(string $name = 'panzoom'): static
        {
            $static = app(static::class, ['name' => $name]);
            $static->configure();

            return $static;
        }

        public function doubleClickZoomLevel(float $level): static
        {
            $this->doubleClickZoomLevel = $level;

            return $this;
        }

        public function getDoubleClickZoomLevel(): float
        {
            return $this->doubleClickZoomLevel;
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
} else {
    // Filament 3.x
    class PanZoom extends \Filament\Forms\Components\Component
    {
        protected string $view = 'filament-panzoom::components.pan-zoom';

        protected string | \Closure | null $imageUrl = null;

        protected string | \Closure | null $imageId = null;

        protected float $doubleClickZoomLevel = 3.0;

        public static function make(string $name = 'panzoom'): static
        {
            $static = app(static::class, ['name' => $name]);
            $static->configure();

            return $static;
        }

        public function doubleClickZoomLevel(float $level): static
        {
            $this->doubleClickZoomLevel = $level;

            return $this;
        }

        public function getDoubleClickZoomLevel(): float
        {
            return $this->doubleClickZoomLevel;
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
}
