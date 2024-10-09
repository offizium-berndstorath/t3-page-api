<?php

namespace Offizium\T3pageapi\Api;

use Offizium\T3pageapi\Domain\Model\TtContent;
use Offizium\T3pageapi\Domain\Repository\TtContentRepository;
use nn\t3;
use Nng\Nnrestapi\Api\AbstractApi;

use Nng\Nnrestapi\Annotations as Api;

/**
 * This annotation registers this class as an Endpoint!
 *
 * @Api\Endpoint()
 */
class Content extends AbstractApi
{
    /**
     * @var TtContentRepository
     */
    private $ttContentRepository = null;

    /**
     * Constructor
     * Inject the TtContentRepository.
     * Ignore storagePid.
     *
     * @return void
     */
    public function __construct() {
        $this->ttContentRepository = t3::injectClass(TtContentRepository::class);
        t3::Db()->ignoreEnableFields($this->ttContentRepository);
    }

    /**
     * # Retrieve an existing Content-Element
     *
     * Send a simple GET request to retrieve a content-element by its uid from the database.
     *
     * Replace `{uid}` with the uid of the Entry:
     * ```
     * https://www.mysite.com/api/content/{uid}
     * ```
     *
     * @Api\Access("be_users,fe_users")
     * @Api\Label("/api/content/{uid}")
     *
     * @param TtContent $entry
     * @param int $uid
     * @return array
     */
    public function getIndexAction(TtContent $ttContent = null, int $uid = null) {
        if (!$uid) {
            return $this->response->notFound("No uid passed in URL. Send the request with `api/content/{uid}`");
        }
        if (!$ttContent) {
            return $this->response->notFound("Content-Element with uid [{$uid}] was not found.");
        }
        return $ttContent;
    }

    /**
     * # Create a new Content-Element
     *
     * Send a POST request to this endpoint including a JSON to create a
     * new ContentElement in the tt_content-table. You can also upload file(s).
     *
     * You __must be logged in__ as a frontend OR backend user to access
     * this endpoint.
     *
     * @Api\Access("be_users,fe_users")
     * @Api\Upload("config[t3pageapi]")
     * @Api\Example("{'pid':1, 'colPos':0, 'header':'Test', 'assets':['UPLOAD:/file-0']}");
     *
     * @param TtContent $ttContentElement
     * @return array
     */
    public function postIndexAction(TtContent $ttContentElement = null) {
        t3::Db()->save($ttContentElement);
        return $ttContentElement;
    }

}