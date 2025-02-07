<?php

namespace Offizium\T3pageapi\Api;

use nn\t3;
use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;
use Offizium\T3pageapi\Domain\Model\Pages;
use Offizium\T3pageapi\Domain\Repository\PagesRepository;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
     * # Retrieve all Subpages for a Page
     *
     * @Api\Access("be_users,fe_users")
     * @Api\Label("/api/page/all/{pid}")
     *
     * @param Pages $entry
     * @return array
     */
    public function getAllAction() {
        $args =  $this->request->getArguments();
        $pid = $args['uid'] ?? null;
        if (!isset($pid)) {
            return $this->response->notFound("No uid passed in URL.");
        }
        return $this->pagesRepository->findBy(['pid' => $pid])->toArray();
    }

    /**
     * # Retrieve all Root Pages
     *
     * @Api\Access("be_users,fe_users")
     * @Api\Label("/api/page/roots")
     *
     * @return array
     */
    public function getRootsAction() {
        $absolutePath = GeneralUtility::getFileAbsFileName('EXT:site_package/Configuration/Mask/mask.json');
        $fileContent = file_get_contents($absolutePath);
        return $fileContent;
        return $this->pagesRepository->findBy(['pid' => 0, 'doktype' => 1])->toArray();
    }

    /**
     * # Delete an existing Page
     *
     * @Api\Access("be_users,fe_users")
     * @Api\Label("/api/page/{uid}")
     *
     * @param Pages $entry
     * @param int $uid
     * @return array
     */
    public function deleteIndexAction(Pages $page = null, int $uid = null) {
        if (!$uid) {
            return $this->response->notFound("No uid passed in URL. Send the request with `api/page/{uid}`");
        }
        if (!$page) {
            return $this->response->notFound("Page with uid [{$uid}] was not found.");
        }
        return t3::Db()->delete($page);
    }
}