<?php
namespace App\WebSocket;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Mensaje;
use App\Entity\Persona;
use App\Entity\Chat;

class ChatServer implements MessageComponentInterface
{
    private $clients;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->clients = new \SplObjectStorage;
        $this->em = $em;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "Nueva conexión ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo "Mensaje recibido: $msg\n";

        $data = json_decode($msg, true);
        if (!$data) return;

        // Guardar en BD
        $mensaje = new Mensaje();
        $mensaje->setContenido($data['contenido'] ?? '');
        $mensaje->setFecha(new \DateTimeImmutable($data['fecha'] ?? 'now'));

        // Relacionar con Persona y Chat
        $persona = $this->em->getRepository(Persona::class)->find($data['personaId'] ?? 1);
        $chat = $this->em->getRepository(Chat::class)->find($data['chatId'] ?? 1);

        $mensaje->setPersona($persona);
        $mensaje->setChat($chat);

        $this->em->persist($mensaje);
        $this->em->flush();

        // Reenviar a todos
        foreach ($this->clients as $client) {
            $client->send(json_encode($data));
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Conexión cerrada ({$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}
