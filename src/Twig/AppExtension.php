<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension {

    public function getFilters(): array {
        return [
            new TwigFilter('simpleName', [AppRuntime::class, 'getSimpleName']),
            new TwigFilter('mixedToString', [AppRuntime::class, 'mixedToString']),
            new TwigFilter('objectToString', [AppRuntime::class, 'objectToString']),
        ];
    }

    public function getFunctions(): array {
        return [
            new TwigFilter('className', [AppRuntime::class, 'getClassName']),
            new TwigFilter('classSimpleName', [AppRuntime::class, 'getClassSimpleName']),
        ];
    }

}