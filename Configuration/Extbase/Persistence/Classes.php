<?php
return [
    Offizium\T3pageapi\Domain\Model\TtContent::class => [
        'tableName' => 'tt_content',
        'properties' => [
            'cType' => [
                'fieldName' => 'CType'
            ],
        ],
    ],
    Offizium\T3pageapi\Domain\Model\Pages::class => [
        'tableName' => 'pages',
    ],
];