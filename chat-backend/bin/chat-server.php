#!/usr/bin/env php
<?php
require dirname(__DIR__).'/vendor/autoload.php';

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use App\WebSocket\ChatServer;
use Symfony\Component\Dotenv\Dotenv;

// 👇 Cargar variables de entorno manualmente
$dotenv = new Dotenv();
$dotenv->loadEnv(dirname(__DIR__).'/.env');

$kernel = new \App\Kernel('dev', true);
$kernel->boot();

$container = $kernel->getContainer();
$em = $container->get('doctrine')->getManager();

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChatServer($em)
        )
    ),
    8080
);

echo "Servidor WebSocket con BD en ws://localhost:8080\n";
$server->run();
