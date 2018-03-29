<?php

namespace Netgen\Bundle\EzPlatformSiteApiBundle\Templating\Twig\Extension;

use Netgen\Bundle\EzPlatformSiteApiBundle\Search\SortClauseParser;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Twig extension for parsing sort clause strings.
 *
 * @see \Netgen\Bundle\EzPlatformSiteApiBundle\Search\SortClauseParser
 */
class SortClauseExtension extends Twig_Extension
{
    /**
     * @var \Netgen\Bundle\EzPlatformSiteApiBundle\Search\SortClauseParser
     */
    private $sortClauseParser;

    /**
     * @param \Netgen\Bundle\EzPlatformSiteApiBundle\Search\SortClauseParser
     */
    public function __construct(SortClauseParser $sortClauseParser)
    {
        $this->sortClauseParser = $sortClauseParser;
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction(
                'ng_sort',
                [
                    $this->sortClauseParser,
                    'parse',
                ]
            ),
        ];
    }
}
