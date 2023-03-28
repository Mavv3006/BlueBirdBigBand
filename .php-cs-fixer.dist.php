<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->files()
    ->in(__DIR__ . '/app')
    ->in(__DIR__ . '/database')
    ->in(__DIR__ . '/routes')
    ->in(__DIR__ . '/config')
    ->in(__DIR__ . '/lang')
    ->in(__DIR__ . '/tests');

return (new PhpCsFixer\Config())
    ->setFinder($finder)
    ->setRules(['@PSR12' => true]);
