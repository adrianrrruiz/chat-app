<?php
namespace App\Service;

use App\Entity\Persona;
use Doctrine\ORM\EntityManagerInterface;

class PersonaService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAll(): array
    {
        return $this->em->getRepository(Persona::class)->findAll();
    }

    public function getById($id): ?Persona
    {
        return $this->em->getRepository(Persona::class)->find($id);
    }

    public function create(string $nombre, string $telefono): Persona
    {
        $persona = new Persona();
        $persona->setNombre($nombre);
        $persona->setTelefono($telefono);
        $this->em->persist($persona);
        $this->em->flush();
        return $persona;
    }

    public function update(int $id, array $data): ?Persona
    {
        $persona = $this->getById($id);
        if (!$persona) return null;

        if (isset($data['nombre'])) $persona->setNombre($data['nombre']);
        if (isset($data['telefono'])) $persona->setTelefono($data['telefono']);
        $this->em->flush();

        return $persona;
    }

    public function delete(int $id): bool
    {
        $persona = $this->getById($id);
        if (!$persona) return false;

        $this->em->remove($persona);
        $this->em->flush();
        return true;
    }
}
