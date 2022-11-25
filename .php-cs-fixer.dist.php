<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('var');

$config = new PhpCsFixer\Config();

return $config
    ->setRules([
        '@PHP81Migration' => true,
        '@Symfony' => true,
        'trailing_comma_in_multiline' => [
            'elements' => ['arguments', 'arrays', 'match', 'parameters'],
        ],
        'phpdoc_align' => [
            'align' => 'left',
        ],
        'concat_space' => [
            'spacing' => 'one',
        ],
        'single_line_throw' => false,
    ])
    ->setFinder($finder);
