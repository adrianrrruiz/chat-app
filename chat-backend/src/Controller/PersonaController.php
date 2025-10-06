<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\PersonaService;

class PersonaController
{
    private $personaService;

    public function __construct(PersonaService $personaService)
    {
        $this->personaService = $personaService;
    }

    #[Route('/api/persona', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $personas = $this->personaService->getAll();
        $data = array_map(fn($p) => [
            'id' => $p->getId(),
            'nombre' => $p->getNombre(),
            'telefono' => $p->getTelefono(),
        ], $personas);
        return new JsonResponse($data);
    }

    #[Route('/api/persona/{id}', methods: ['GET'])]
    public function getOne($id): JsonResponse
    {
        $persona = $this->personaService->getById($id);
        if (!$persona) return new JsonResponse(['error' => 'No encontrada'], 404);
        return new JsonResponse([
            'id' => $persona->getId(),
            'nombre' => $persona->getNombre(),
            'telefono' => $persona->getTelefono(),
        ]);
    }

    #[Route('/api/persona', methods: ['POST'])]
    public function create(Request $req): JsonResponse
    {
        $data = json_decode($req->getContent(), true);
        $persona = $this->personaService->create($data['nombre'], $data['telefono']);
        return new JsonResponse([
            'id' => $persona->getId(),
            'nombre' => $persona->getNombre(),
            'telefono' => $persona->getTelefono(),
        ], 201);
    }

    #[Route('/api/persona/{id}', methods: ['PUT'])]
    public function update($id, Request $req): JsonResponse
    {
        $data = json_decode($req->getContent(), true);
        $persona = $this->personaService->update($id, $data);
        if (!$persona) return new JsonResponse(['error' => 'No encontrada'], 404);
        return new JsonResponse(['success' => true]);
    }

    #[Route('/api/persona/{id}', methods: ['DELETE'])]
    public function delete($id): JsonResponse
    {
        $ok = $this->personaService->delete($id);
        return new JsonResponse(['success' => $ok]);
    }
}
