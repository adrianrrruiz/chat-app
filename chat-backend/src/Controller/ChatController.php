<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ChatService;

class ChatController
{
    private $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    #[Route('/api/chat', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $chats = $this->chatService->getAll();
        $data = array_map(fn($p) => [
            'id' => $p->getId(),
            'titulo' => $p->getTitulo(),
        ], $chats);
        return new JsonResponse($data);
    }

    #[Route('/api/chat/{id}', methods: ['GET'])]
    public function getOne($id): JsonResponse
    {
        $chat = $this->chatService->getById($id);
        if (!$chat) return new JsonResponse(['error' => 'No encontrada'], 404);
        return new JsonResponse([
            'id' => $chat->getId(),
            'titulo' => $chat->getTitulo(),
        ]);
    }

    #[Route('/api/chat', methods: ['POST'])]
    public function create(Request $req): JsonResponse
    {
        $data = json_decode($req->getContent(), true);
        $chat = $this->chatService->create($data['titulo']);
        return new JsonResponse([
            'id' => $chat->getId(),
            'titulo' => $chat->getTitulo(),
        ], 201);
    }

    #[Route('/api/chat/{id}', methods: ['PUT'])]
    public function update($id, Request $req): JsonResponse
    {
        $data = json_decode($req->getContent(), true);
        $chat = $this->chatService->update($id, $data);
        if (!$chat) return new JsonResponse(['error' => 'No encontrada'], 404);
        return new JsonResponse(['success' => true]);
    }

    #[Route('/api/chat/{id}', methods: ['DELETE'])]
    public function delete($id): JsonResponse
    {
        $ok = $this->chatService->delete($id);
        return new JsonResponse(['success' => $ok]);
    }
}
