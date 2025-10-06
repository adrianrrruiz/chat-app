<?php
namespace App\Service;

use App\Entity\Mensaje;
use App\Entity\Persona;
use App\Entity\Chat;
use Doctrine\ORM\EntityManagerInterface;

class MensajeService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAll(): array
    {
        return $this->em->getRepository(Mensaje::class)->findAll();
    }

    public function getById($id): ?Mensaje
    {
        return $this->em->getRepository(Mensaje::class)->find($id);
    }

    public function create(string $contenido, int $personaId, int $chatId): Mensaje
    {
        $persona = $this->em->getRepository(Persona::class)->find($personaId);
        $chat = $this->em->getRepository(Chat::class)->find($chatId);

        if (!$persona || !$chat) {
            throw new \InvalidArgumentException("Persona o Chat no encontrados");
        }

        $m = new Mensaje();
        $m->setContenido($contenido);
        $m->setPersona($persona);
        $m->setChat($chat);
        $m->setFecha(new \DateTimeImmutable('now'));

        $this->em->persist($m);
        $this->em->flush();

        return $m;
    }

    public function update(int $id, array $data): ?Mensaje
    {
        $mensaje = $this->getById($id);
        if (!$mensaje) return null;

        if (isset($data['contenido'])) $mensaje->setContenido($data['contenido']);
        if (isset($data['fecha'])) $mensaje->setFecha($data['fecha']);
        $this->em->flush();

        return $mensaje;
    }

    public function delete(int $id): bool
    {
        $mensaje = $this->getById($id);
        if (!$mensaje) return false;

        $this->em->remove($mensaje);
        $this->em->flush();
        return true;
    }
}
