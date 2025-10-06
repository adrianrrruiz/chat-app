<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MensajeService;

class MensajeController
{
    private $mensajeService;

    public function __construct(MensajeService $mensajeService)
    {
        $this->mensajeService = $mensajeService;
    }

    #[Route('/api/mensaje', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $mensajes = $this->mensajeService->getAll();
        $data = array_map(fn($p) => [
            'id' => $p->getId(),
            'contenido' => $p->getContenido(),
            'fecha' => $p->getFecha(),
        ], $mensajes);
        return new JsonResponse($data);
    }

    #[Route('/api/mensaje/{id}', methods: ['GET'])]
    public function getOne($id): JsonResponse
    {
        $mensaje = $this->mensajeService->getById($id);
        if (!$mensaje) return new JsonResponse(['error' => 'No encontrada'], 404);
        return new JsonResponse([
            'id' => $mensaje->getId(),
            'contenido' => $mensaje->getContenido(),
            'fecha' => $mensaje->getFecha(),
        ]);
    }

    #[Route('/api/mensaje', methods: ['POST'])]
    public function create(Request $req): JsonResponse
    {
        $data = json_decode($req->getContent(), true);
        $mensaje = $this->mensajeService->create($data['contenido'], $data['persona_id'], $data['chat_id']);
        return new JsonResponse([
            'id'       => $mensaje->getId(),
            'contenido'=> $mensaje->getContenido(),
            'fecha'    => $mensaje->getFecha()->format(DATE_ATOM),
            'persona'  => [
                'id' => $mensaje->getPersona()->getId(),
                'nombre' => $mensaje->getPersona()->getNombre()
            ],
            'chat' => [
                'id' => $mensaje->getChat()->getId(),
                'titulo' => $mensaje->getChat()->getTitulo()
            ]
        ], 201);
    }

    #[Route('/api/mensaje/{id}', methods: ['PUT'])]
    public function update($id, Request $req): JsonResponse
    {
        $data = json_decode($req->getContent(), true);
        $mensaje = $this->mensajeService->update($id, $data);
        if (!$mensaje) return new JsonResponse(['error' => 'No encontrada'], 404);
        return new JsonResponse(['success' => true]);
    }

    #[Route('/api/mensaje/{id}', methods: ['DELETE'])]
    public function delete($id): JsonResponse
    {
        $ok = $this->mensajeService->delete($id);
        return new JsonResponse(['success' => $ok]);
    }
}
