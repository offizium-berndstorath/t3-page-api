<?php

namespace Offizium\T3pageapi\Api;

use nn\t3;
use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;
use Offizium\T3pageapi\Domain\Model\Pages;
use Offizium\T3pageapi\Domain\Model\TtContent;
use Offizium\T3pageapi\Domain\Repository\TtContentRepository;

/**
 * @Api\Endpoint()
 */
class Content extends AbstractApi
{
    /**
     * @var TtContentRepository
     */
    private $ttContentRepository = null;

    private $cTypeMapping = [
        'off_txt' => [
            'name' => 'Einfacher Text',
            'description' => 'Dient zur Darstellung von reinem Text ohne weitere Elemente.',
            'fields' => [
                [
                    'id' => 'preline',
                    'type' => 'text',
                    'label' => 'Vorzeile'
                ], [
                    'id' => 'headline',
                    'type' => 'text',
                    'label' => 'Überschrift'
                ], [
                    'id' => 'subline',
                    'type' => 'text',
                    'label' => 'Unterschrift'
                ], [
                    'id' => 'bodytext',
                    'type' => 'text',
                    'label' => 'Text',
                    'required' => true,
                    'richText' => true
                ], [
                    'id' => 'button_text',
                    'type' => 'text',
                    'label' => 'Button-Text'
                ], [
                    'id' => 'button_link',
                    'type' => 'link',
                    'label' => 'Button-Verlinkung'
                ]
            ]
        ]
    ];

    /**
     * Constructor
     * Inject the TtContentRepository.
     * Ignore storagePid.
     *
     * @return void
     */
    public function __construct()
    {
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
    public function getIndexAction(TtContent $ttContent = null, int $uid = null)
    {
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
    public function postIndexAction(TtContent $ttContentElement = null)
    {
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
    public function getAllAction(TtContent $page = null)
    {
        $pid = $page->getUid();

        $rawEntries = t3::Db()->findByValues('tt_content', ['pid' => $pid]);

        $entries = [];

        foreach ($rawEntries as $entry) {
            $cType = $entry->CType;

            $cEntry = [
                'uid' => $entry->uid,
                'pid' => $entry->pid,
            ];

            if (isset($this->cTypeMapping[$cType])) {
                foreach ($this->cTypeMapping[$cType]['fields'] as $field) {
                    $cEntry[$field] = $entry->$field;
                }
            }

            $entries[] = $cEntry;
        }

        return $entries;
    }
}