<?php

namespace SolutionForest\FilamentPanzoom\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SolutionForest\FilamentPanzoom\FilamentPanzoom
 */
class FilamentPanzoom extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \SolutionForest\FilamentPanzoom\FilamentPanzoom::class;
    }
}
