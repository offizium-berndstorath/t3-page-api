<?php

declare(strict_types=1);

use offizium\T3pageapi\Domain\Model\Page;

return [
    Page::class => [
        'tableName' => 'pages',
        'properties' => [
            'pages' => ['fieldName' => 'tx_t3apicontent_pages'],
            'contentElements' => ['fieldName' => 'tx_t3apicontent_content_elements'],
        ],
    ]
];