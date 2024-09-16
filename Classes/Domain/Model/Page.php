<?php
declare(strict_types=1);

namespace offizium\T3pageapi\Domain\Model;

use SourceBroker\T3api\Annotation as T3api;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Psr\Log\LoggerInterface;

/**
 * @T3api\ApiResource(
 *     itemOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/content/pages/{id}",
 *          },
 *     },
 *     collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/content/pages",
 *          },
 *     },
 * )
 */
class Page extends AbstractEntity
{
    /**
     * @var string
     */
    protected string $title;

    /**
     * @var string
     */
    protected string $slug;

    /**
     * @var ObjectStorage<Page>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @T3api\Serializer\MaxDepth(3)
     */
    protected ObjectStorage $pages;

    /**
     * @var ObjectStorage<AbstractContentElement>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ObjectStorage $contentElements;

    public function __construct(private readonly LoggerInterface $logger) {
        $this->pages = new ObjectStorage();
        $this->contentElements = new ObjectStorage();
        $this->logger->debug('Class created');
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getSlug(): string {
        return $this->slug;
    }

    public function getPages(): ObjectStorage {
        $this->logger->debug('Get Pages');
        return $this->pages;
    }

    public function getContentElements(): ObjectStorage {
        return $this->contentElements;
    }
}