<?php

namespace MMC\User\Component\Routing;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class ExtraLoader implements LoaderInterface
{
    private $loaded = false;
    protected $routeName;
    protected $pattern;
    protected $controllerAction;
    protected $condition;

    public function __construct(
        $routeName,
        $pattern,
        $controllerAction,
        $condition
    ) {
        $this->routeName = $routeName;
        $this->pattern = $pattern;
        $this->controllerAction = $controllerAction;
        $this->condition = $condition;
    }

    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add this loader twice');
        }

        $routes = new RouteCollection();

        if ($this->condition) {
            $defaults = [
                '_controller' => $this->controllerAction,
            ];

            $route = new Route($this->pattern, $defaults);
            $routes->add($this->routeName, $route);
        }

        return $routes;
    }

    public function supports($resource, $type = null)
    {
        return 'extra' === $type;
    }

    public function getResolver()
    {
    }

    public function setResolver(LoaderResolverInterface $resolver)
    {
        // irrelevant to us, since we don't need a resolver
    }
}
