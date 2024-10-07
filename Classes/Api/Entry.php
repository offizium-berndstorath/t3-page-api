<?php

namespace Offizium\T3pageapi\Api;

use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;

/**
 * This annotation registers this class as an Endpoint!
 *
 * @Api\Endpoint()
 */
class Entry extends AbstractApi
{
    /**
     * @Api\Access("public")
     * @return array
     */
    public function getExampleAction() {
        return ['great' => 'it works!'];
    }
}