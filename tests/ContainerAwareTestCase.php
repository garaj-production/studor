<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;

class ContainerAwareTestCase extends TestCase
{
    /** @var \AppKernel */
    protected $kernel;

    /** @var Container */
    protected $container;

    public function setUp()
    {
        $this->kernel = new \AppKernel('dev', true);
        $this->kernel->boot();

        $this->container = $this->kernel->getContainer();
    }

    public function get(string $serviceId)
    {
        return $this->container->get($serviceId);
    }
}
