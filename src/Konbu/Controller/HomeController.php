<?php
namespace Konbu\Controller;

use Psr\Container\ContainerInterface;

class HomeController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function index($request, $response, $args)
    {
        echo 'Hello World';
        return $response;
    }
}