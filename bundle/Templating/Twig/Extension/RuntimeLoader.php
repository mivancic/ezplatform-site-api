<?php

namespace Netgen\Bundle\EzPlatformSiteApiBundle\Templating\Twig\Extension;

use Twig\RuntimeLoader\RuntimeLoaderInterface;

class RuntimeLoader implements RuntimeLoaderInterface
{
    protected $runtimes;

    public function __construct(array $runtimes)
    {
        $this->runtimes = $runtimes;
    }

    public function load($class)
    {
        foreach ($this->runtimes as $runtime) {
            if (is_a($runtime, $class, true)) {
                return $runtime;
            }
        }
    }
}
