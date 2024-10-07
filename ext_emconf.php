<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 't3 page api',
    'description' => 'Create Pages using the Api',
    'category' => 'frontend',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
            'nnhelpers' => '2.0.0-0.0.0',
            'nnrestapi' => '2.0.0-0.0.0',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
