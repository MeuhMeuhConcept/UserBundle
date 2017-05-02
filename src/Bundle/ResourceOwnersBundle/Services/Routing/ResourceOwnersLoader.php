<?php

namespace MMC\User\Bundle\ResourceOwnersBundle\Services\Routing;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class ResourceOwnersLoader implements LoaderInterface
{
    private $loaded = false;
    protected $resourceOwners;

    public function __construct(
        array $resourceOwners
    ) {
        $this->resourceOwners = $resourceOwners;
    }

    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add this loader twice');
        }

        $routes = new RouteCollection();

        foreach ($this->resourceOwners as $key) {
            $route = new Route('/connect/'.$key, []);
            //$route = new Route('/login/check-'.$key, []);
            $routes->add('mmc_ro.'.$key, $route);
        }

        return $routes;
    }

    public function supports($resource, $type = null)
    {
        return 'resource_owners' === $type;
    }

    public function getResolver()
    {
    }

    public function setResolver(LoaderResolverInterface $resolver)
    {
        // irrelevant to us, since we don't need a resolver
    }
}
