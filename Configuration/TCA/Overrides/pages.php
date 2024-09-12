<?php

$GLOBALS['TCA']['pages']['columns']['tx_t3apicontent_content_elements'] = [
    'exclude' => 1,
    'config' => [
        'type' => 'inline',
        'foreign_table' => 'tt_content',
        'foreign_field' => 'pid',
        'foreign_sortby' => 'sorting',
        'maxitems' => 9999,
    ],
];

$GLOBALS['TCA']['pages']['columns']['tx_t3apicontent_pages'] = [
    'exclude' => 1,
    'config' => [
        'type' => 'inline',
        'foreign_table' => 'pages',
        'foreign_field' => 'pid',
        'foreign_sortby' => 'sorting',
        'maxitems' => 9999,
    ],
];