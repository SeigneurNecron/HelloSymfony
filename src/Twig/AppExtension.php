<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension {

    public function getFilters(): array {
        return [
            new TwigFilter('simpleName', [AppRuntime::class, 'getSimpleName']),
        ];
    }

    public function getFunctions(): array {
        return [
            new TwigFilter('className', [AppRuntime::class, 'getClassName']),
            new TwigFilter('classSimpleName', [AppRuntime::class, 'getClassSimpleName']),
        ];
    }

}