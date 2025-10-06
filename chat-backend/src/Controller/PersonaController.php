<?php
namespace App\Controller;

use App\Entity\Persona;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PersonaController
{
    #[Route('/api/persona', name: 'app_persona_registrar', methods: ['POST'])]
    public function registrar(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $telefono = $data['telefono'] ?? null;

        if (!$telefono) {
            return new JsonResponse(['error' => 'Número requerido'], 400);
        }

        $repo = $em->getRepository(Persona::class);
        $persona = $repo->findOneBy(['telefono' => $telefono]);

        if (!$persona) {
            $persona = new Persona();
            $persona->setNombre('Usuario ' . $telefono);
            $persona->setTelefono($telefono);
            $em->persist($persona);
            $em->flush();
        }

        return new JsonResponse([
            'id' => $persona->getId(),
            'telefono' => $persona->getTelefono(),
            'nombre' => $persona->getNombre()
        ], 200);
    }
}
