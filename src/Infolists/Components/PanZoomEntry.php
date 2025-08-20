<?php

namespace SolutionForest\FilamentPanzoom\Infolists\Components;

// Check if we're in Filament 4.x (has Schemas) or 3.x (Infolists only)
if (class_exists('Filament\Schemas\Components\Component')) {
    // Filament 4.x
    class PanZoomEntry extends \Filament\Schemas\Components\Component
    {
        protected string $view = 'filament-panzoom::infolists.components.pan-zoom-entry';

        protected string | \Closure | null $imageUrl = null;

        protected string | \Closure | null $imageId = null;

        protected float $doubleClickZoomLevel = 3.0;

        public static function make(string $name = 'panzoom-entry'): static
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
            return $this->evaluate($this->imageId) ?? 'panzoom-entry-' . $this->getId();
        }
    }
} else {
    // Filament 3.x
    class PanZoomEntry extends \Filament\Infolists\Components\Component
    {
        protected string $view = 'filament-panzoom::infolists.components.pan-zoom-entry';

        protected string | \Closure | null $imageUrl = null;

        protected string | \Closure | null $imageId = null;

        protected float $doubleClickZoomLevel = 3.0;

        public static function make(string $name = 'panzoom-entry'): static
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
            return $this->evaluate($this->imageId) ?? 'panzoom-entry-' . $this->getId();
        }
    }
}
