<?php

namespace Offizium\T3pageapi\Domain\Model;

use Nng\Nnrestapi\Domain\Model\AbstractRestApiModel;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * A simple Model to test things with.
 *
 */
class TtContent extends AbstractRestApiModel
{
    /**
     * @var string
     */
    protected $cType = 'textmedia';

    /**
     * @var int
     */
    protected $colPos = 0;

    /**
     * @var string
     */
    protected $header;

    /**
     * @var ObjectStorage<FileReference>
     */
    protected $assets;

    /**
     * constructor
     *
     */
    public function __construct() {
        $this->initStorageObjects();
    }

    /**
     * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects() {
        $this->assets = new ObjectStorage();
    }

    /**
     * @return ObjectStorage
     */
    public function getAssets() {
        return $this->assets;
    }

    /**
     * @param ObjectStorage $assets
     * @return self
     */
    public function setAssets(ObjectStorage $assets) {
        $this->assets = $assets;
        return $this;
    }

    /**
     * @return  string
     */
    public function getCType() {
        return $this->cType;
    }

    /**
     * @param string $cType
     * @return  self
     */
    public function setCType($cType) {
        $this->cType = $cType;
        return $this;
    }

    /**
     * @return  int
     */
    public function getColPos() {
        return $this->colPos;
    }

    /**
     * @param int $colPos
     * @return  self
     */
    public function setColPos($colPos) {
        $this->colPos = $colPos;
        return $this;
    }

    /**
     * @return  string
     */
    public function getHeader() {
        return $this->header;
    }

    /**
     * @param string $header
     * @return  self
     */
    public function setHeader($header) {
        $this->header = $header;
        return $this;
    }
}