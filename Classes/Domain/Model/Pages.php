<?php

namespace Offizium\T3pageapi\Domain\Model;

use Nng\Nnrestapi\Domain\Model\AbstractRestApiModel;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

// ref: https://various.at/news/typo3-create-page-programmatically

class Pages extends AbstractRestApiModel
{
    /**
     * @var int
     */
    protected $doktype = 0;

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $subtitle = '';

    /**
     * @var ObjectStorage<FileReference>
     */
    protected $media;

    public function __construct() {
        $this->initStorageObjects();
    }

    /**
     * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects() {
        $this->media = new ObjectStorage();
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSubtitle() {
        return $this->subtitle;
    }

    /**
     * @param string $subtitle
     */
    public function setSubtitle($subtitle) {
        $this->subtitle = $subtitle;
    }

    /**
     * @return bool
     */
    public function isHidden(): bool {
        return $this->hidden;
    }

    /**
     * @param bool $hidden
     */
    public function setHidden(bool $hidden) {
        $this->hidden = $hidden;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     */
    public function setDeleted(bool $deleted) {
        $this->deleted = $deleted;
    }

    /**
     * @return ObjectStorage
     */
    public function getMedia() {
        return $this->media;
    }

    /**
     * @param ObjectStorage $media
     * @return self
     */
    public function setMedia(ObjectStorage $media) {
        $this->media = $media;
        return $this;
    }

    /**
     * @return int
     */
    public function getDoktype(): int {
        return $this->doktype;
    }

    /**
     * @param int $doktype
     */
    public function setDoktype(int $doktype) {
        $this->doktype = $doktype;
    }
}