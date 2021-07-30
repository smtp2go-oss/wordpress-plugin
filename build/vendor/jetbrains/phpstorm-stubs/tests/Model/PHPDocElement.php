<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin\StubTests\Model;

use Exception;
use SMTP2GOWPPlugin\phpDocumentor\Reflection\DocBlock\Tags\Deprecated;
use SMTP2GOWPPlugin\phpDocumentor\Reflection\DocBlock\Tags\Link;
use SMTP2GOWPPlugin\phpDocumentor\Reflection\DocBlock\Tags\See;
use SMTP2GOWPPlugin\phpDocumentor\Reflection\DocBlock\Tags\Since;
use SMTP2GOWPPlugin\PhpParser\Node;
use SMTP2GOWPPlugin\StubTests\Model\Tags\RemovedTag;
use SMTP2GOWPPlugin\StubTests\Parsers\DocFactoryProvider;
trait PHPDocElement
{
    /**
     * @var Link[]
     */
    public array $links = [];
    /**
     * @var See[]
     */
    public array $see = [];
    /**
     * @var Since[]
     */
    public array $sinceTags = [];
    /**
     * @var Deprecated[]
     */
    public array $deprecatedTags = [];
    /**
     * @var RemovedTag[]
     */
    public array $removedTags = [];
    /**
     * @var string[]
     */
    public array $tagNames = [];
    public bool $hasInheritDocTag = \false;
    public bool $hasInternalMetaTag = \false;
    protected function collectTags(Node $node) : void
    {
        if ($node->getDocComment() !== null) {
            try {
                $phpDoc = DocFactoryProvider::getDocFactory()->create($node->getDocComment()->getText());
                $tags = $phpDoc->getTags();
                foreach ($tags as $tag) {
                    $this->tagNames[] = $tag->getName();
                }
                $this->links = $phpDoc->getTagsByName('link');
                $this->see = $phpDoc->getTagsByName('see');
                $this->sinceTags = $phpDoc->getTagsByName('since');
                $this->deprecatedTags = $phpDoc->getTagsByName('deprecated');
                $this->removedTags = $phpDoc->getTagsByName('removed');
                $this->hasInternalMetaTag = $phpDoc->hasTag('meta');
                $this->hasInheritDocTag = $phpDoc->hasTag('inheritdoc') || $phpDoc->hasTag('inheritDoc') || \stripos($phpDoc->getSummary(), "inheritdoc") > 0;
            } catch (Exception $e) {
                $this->parseError = $e;
            }
        }
    }
}
