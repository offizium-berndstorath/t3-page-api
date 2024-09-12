<?php
declare(strict_types=1);

namespace offizium\T3pageapi\Domain\Model;

use SourceBroker\T3api\Annotation as T3api;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

abstract class AbstractContentElement extends AbstractEntity
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var int
     */
    protected $colPos;

    /**
     * @var string
     */
    protected $header;

    /**
     * @var string
     * @T3api\Serializer\Type\Typolink
     */
    protected $headerLink;

    public function getType(): string
    {
        return $this->type;
    }

    public function getColPos(): int
    {
        return $this->colPos;
    }

    public function getHeader(): string
    {
        return $this->header;
    }

    public function getHeaderLink(): ?string
    {
        return $this->headerLink ?: null;
    }
}