<?php

namespace Offizium\T3pageapi\Api;

use nn\t3;
use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;
use Offizium\T3pageapi\Domain\Model\Pages;
use Offizium\T3pageapi\Domain\Repository\PagesRepository;

/**
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
     * Inject the PagesRepository.
     * Ignore storagePid.
     *
     * @return void
     */
    public function __construct() {
        $this->pagesRepository = t3::injectClass(PagesRepository::class);
        t3::Db()->ignoreEnableFields($this->pagesRepository);
    }

    /**
     * # Retrieve an existing Page
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
     * # Create a new Page
     *
     * @Api\Access("be_users,fe_users")
     * @Api\Upload("config[t3pageapi]")
     * @Api\Example("{'pid':1, 'title':0, 'subtitle':'Test', 'media':['UPLOAD:/file-0']}");
     *
     * @param Pages $pageElement
     * @return array
     */
    public function postIndexAction(Pages $pageElement = null) {
        t3::Db()->save($pageElement);
        return $pageElement;
    }

    /**
     * # Retrieve all Pages for Page
     *
     * @Api\Access("be_users,fe_users")
     * @Api\Label("/api/page/all/{pid}")
     *
     * @param Pages $entry
     * @param int $pid
     * @return array
     */
    public function getAllAction(Pages $page = null, int $uid = null) {
        return ['test' => 'test'];
    }
}