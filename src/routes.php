<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/home', \Konbu\Controller\HomeController::class . ':index');

$app->group('/instances', function () {
    $this->map(['GET'], '', '\Konbu\Controller\InstanceController:index');
    $this->map(['POST'], '', '\Konbu\Controller\InstanceController:add');
});