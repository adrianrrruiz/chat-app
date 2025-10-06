#!/usr/bin/env php
<?php
// Desactivar los warnings deprecados (para limpiar logs)
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

require dirname(__DIR__) . '/vendor/autoload.php';

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Dotenv\Dotenv;
use App\WebSocket\ChatServer;
use App\Kernel;

// 🔹 Cargar variables de entorno (.env)
$dotenv = new Dotenv();
$dotenv->loadEnv(dirname(__DIR__) . '/.env');

// 🔹 Inicializar el kernel de Symfony
$kernel = new Kernel('dev', true);
$kernel->boot();

// 🔹 Obtener el EntityManager de Doctrine
$container = $kernel->getContainer();
$em = $container->get('doctrine')->getManager();

// 🔹 Crear el servidor WebSocket
$wsServer = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChatServer($em)
        )
    ),
    8081 // 💥 Puerto dedicado al WebSocket
);

echo "✅ Servidor WebSocket corriendo en ws://localhost:8081\n";
echo "⚙️  API REST sigue disponible en http://localhost:8080\n";

$wsServer->run();
