<?php

namespace SolutionForest\FilamentPanzoom\Infolists\Components;

use Filament\Schemas\Components\Component;

// Check if we're in Filament 4.x (has Schemas) or 3.x (Infolists only)
if (class_exists('Filament\Schemas\Components\Component')) {
    // Filament 4.x
    class PanZoomEntry extends Component
    {
        protected string | \Closure | null $imageUrl = null;

        protected string | \Closure | null $imageId = null;

        protected float $doubleClickZoomLevel = 3.0;

        /** @phpstan-ignore property.defaultValue */
        protected string $view = 'filament-panzoom::infolists.components.pan-zoom-entry';

        public static function make(string $name = 'panzoom-entry'): static
        {
            $component = app(static::class, ['name' => $name]);

            if (! $component instanceof static) {
                throw new \RuntimeException('Unable to resolve the panzoom component.');
            }

            $component->configure();

            return $component;
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
            $url = $this->evaluate($this->imageUrl);

            return is_string($url) ? $url : null;
        }

        public function getImageId(): ?string
        {
            $id = $this->evaluate($this->imageId);

            if (is_string($id)) {
                return $id;
            }

            return 'panzoom-entry-' . ($this->getId() ?? '');
        }
    }
} else {
    // Filament 3.x
    class PanZoomEntry extends \Filament\Infolists\Components\Component
    {
        protected string | \Closure | null $imageUrl = null;

        protected string | \Closure | null $imageId = null;

        protected float $doubleClickZoomLevel = 3.0;

        /** @phpstan-ignore property.defaultValue */
        protected string $view = 'filament-panzoom::infolists.components.pan-zoom-entry';

        public static function make(string $name = 'panzoom-entry'): static
        {
            $component = app(static::class, ['name' => $name]);

            if (! $component instanceof static) {
                throw new \RuntimeException('Unable to resolve the panzoom component.');
            }

            $component->configure();

            return $component;
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
            $url = $this->evaluate($this->imageUrl);

            return is_string($url) ? $url : null;
        }

        public function getImageId(): ?string
        {
            $id = $this->evaluate($this->imageId);

            if (is_string($id)) {
                return $id;
            }

            return 'panzoom-entry-' . ($this->getId() ?? '');
        }
    }
}
