<?php

namespace Offizium\T3pageapi\Api;

use nn\t3;
use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;
use Offizium\T3pageapi\Domain\Model\Pages;
use Offizium\T3pageapi\Domain\Model\TtContent;
use Offizium\T3pageapi\Domain\Repository\TtContentRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
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

    /**
     * # Retrieve all Elements for a Page
     *
     * @Api\Access("be_users,fe_users")
     * @Api\Label("/api/content/all/{pid}")
     *
     * @param Pages $entry
     * @return array
     */
    public function getAllAction(TtContent $page = null) {
        $uid = $page->getUid();
        $entries = $this->ttContentRepository->findBy(['pid' => $uid])->toArray();

        $absolutePath = GeneralUtility::getFileAbsFileName('EXT:site_package/Configuration/Mask/mask.json');
        $fileContent = file_get_contents($absolutePath);
        $maskConfig = json_decode($fileContent, true);

        $a = [];

        foreach ($entries as $entry) {
            $cType = $entry->getCType();
            if (!str_starts_with($cType, 'mask_')) {
                continue;
            }
            // remove mask_ from ctype
            $parsedCType = substr($cType, strlen('mask_'));
            $entryConfig = $maskConfig['tables']['tt_content']['elements'][$parsedCType];
            $columns = $entryConfig['columns'];
            $columnConfigs = $maskConfig['tables']['tt_content']['tca'];
            $filteredTca = array_filter($columnConfigs, function($key) use ($columns) {
                return in_array($key, $columns);
            }, ARRAY_FILTER_USE_KEY);
            $a[] = $filteredTca;
        }
        return $a;
    }

    /**
     * # Retrieve all Elements for a Page
     *
     * @Api\Access("be_users,fe_users")
     * @Api\Label("/api/content/allc/{pid}")
     *
     * @return array
     */
    public function getAllCAction() {
        $pid = $this->request->getArguments()['uid'] ?? null;

        return t3::Db()->findByValues('tt_content', ['pid' => $pid]);
    }
}