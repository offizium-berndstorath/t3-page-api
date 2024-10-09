<?php

namespace Offizium\T3pageapi\Api;

use nn\t3;
use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;
use Offizium\T3pageapi\Domain\Model\Pages;
use Offizium\T3pageapi\Domain\Repository\PagesRepository;

/**
 * This annotation registers this class as an Endpoint!
 *
 * @Api\Endpoint()
 */
class Page extends AbstractApi
{
    /**
     * @var PagesRepository
     */
    private $pagesRepository = null;

    /**
     * Constructor
     * Inject the TtContentRepository.
     * Ignore storagePid.
     *
     * @return void
     */
    public function __construct() {
        $this->pagesRepository = t3::injectClass(Pages::class);
        t3::Db()->ignoreEnableFields($this->pagesRepository);
    }

    /**
     * # Retrieve an existing Page
     *
     * Send a simple GET request to retrieve a page by its uid from the database.
     *
     * Replace `{uid}` with the uid of the Entry:
     * ```
     * https://www.mysite.com/api/page/{uid}
     * ```
     *
     * @Api\Access("be_users,fe_users")
     * @Api\Label("/api/page/{uid}")
     *
     * @param Pages $entry
     * @param int $uid
     * @return array
     */
    public function getIndexAction(Pages $page = null, int $uid = null) {
        if (!$uid) {
            return $this->response->notFound("No uid passed in URL. Send the request with `api/page/{uid}`");
        }
        if (!$page) {
            return $this->response->notFound("Page with uid [{$uid}] was not found.");
        }
        return $page;
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
     * @Api\Example("{'pid':1, 'title':0, 'subtitle':'Test', '$media':['UPLOAD:/file-0']}");
     *
     * @param Pages $pageElement
     * @return array
     */
    public function postIndexAction(Pages $pageElement = null) {
        t3::Db()->save($pageElement);
        return $pageElement;
    }

}