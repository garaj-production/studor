<?php

namespace Tests;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Nelmio\Alice\Loader\NativeLoader;
use Psr\Container\ContainerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /** @var string */
    protected $fixturePath;

    /** @var \AppKernel */
    protected $kernel;

    /** @var ContainerInterface */
    protected $container;

    public function setUp()
    {
        parent::setUp();

        $this->kernel = new \AppKernel('test', true);
        $this->kernel->boot();

        $this->container = $this->kernel->getContainer();

        if (null !== $this->fixturePath) {
            $loader = new NativeLoader();
            $objectSet = $loader->loadFile(__DIR__ . "/../fixtures{$this->fixturePath}");

            $manager = $this->getDoctrine()->getManager();

            $this->purgeDataBase();

            foreach ($objectSet->getObjects() as $object) {
                $manager->persist($object);
            }

            $manager->flush();
        }
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->purgeDataBase();
    }

    private function purgeDataBase()
    {
        $manager = $this->getDoctrine()->getManager();

        $purger = new ORMPurger($manager);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $executor = new ORMExecutor($manager, $purger);
        $executor->execute([]);
    }

    protected function get(string $serviceId)
    {
        return $this->container->get($serviceId);
    }

    private function getDoctrine(): RegistryInterface
    {
        return $this->get('doctrine');
    }
}
