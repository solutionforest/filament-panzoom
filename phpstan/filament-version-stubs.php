<?php

/*
 * Filament 4 removed several package-level base classes that this package still
 * references from its Filament 3 compatibility branch (and vice versa). The
 * branches are selected with `class_exists()` at runtime, so only one branch is
 * ever declared, but PHPStan analyses both and cannot resolve the missing
 * parent class. These minimal definitions give PHPStan a parent to resolve.
 */

namespace Filament\Forms\Components;

use Filament\Support\Components\ViewComponent;

abstract class Component extends ViewComponent
{
    protected function configure(): void {}

    public function getId(): ?string
    {
        return null;
    }

    public function evaluate(mixed $value, array $namedInjections = [], array $typedInjections = []): mixed
    {
        return null;
    }
}

namespace Filament\Infolists\Components;

use Filament\Support\Components\ViewComponent;

abstract class Component extends ViewComponent
{
    protected function configure(): void {}

    public function getId(): ?string
    {
        return null;
    }

    public function evaluate(mixed $value, array $namedInjections = [], array $typedInjections = []): mixed
    {
        return null;
    }
}

namespace Filament\Schemas\Components;

use Filament\Support\Components\ViewComponent;

abstract class Component extends ViewComponent
{
    protected function configure(): void {}

    public function getId(): ?string
    {
        return null;
    }

    public function evaluate(mixed $value, array $namedInjections = [], array $typedInjections = []): mixed
    {
        return null;
    }
}
