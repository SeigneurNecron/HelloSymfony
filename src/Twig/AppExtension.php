<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension {

    public function getFilters(): array {
        return [
            new TwigFilter('getSimpleName', [AppRuntime::class, 'getSimpleName']),
            new TwigFilter('getClassName', [AppRuntime::class, 'getClassName']),
            new TwigFilter('getClassSimpleName', [AppRuntime::class, 'getClassSimpleName']),
            new TwigFilter('getFQN', [AppRuntime::class, 'getFQN']),
            new TwigFilter('mixedToString', [AppRuntime::class, 'mixedToString']),
            new TwigFilter('objectToString', [AppRuntime::class, 'objectToString']),
            new TwigFilter('isNameableEntity', [AppRuntime::class, 'isNameableEntity']),
            new TwigFilter('isNamedEntity', [AppRuntime::class, 'isNamedEntity']),
            new TwigFilter('getParentEntityFields', [AppRuntime::class, 'getParentEntityFields']),
        ];
    }

}