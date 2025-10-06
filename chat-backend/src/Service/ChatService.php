<?php
namespace App\Service;

use App\Entity\Chat;
use Doctrine\ORM\EntityManagerInterface;

class ChatService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAll(): array
    {
        return $this->em->getRepository(Chat::class)->findAll();
    }

    public function getById($id): ?Chat
    {
        return $this->em->getRepository(Chat::class)->find($id);
    }

    public function create(string $titulo): Chat
    {
        $chat = new Chat();
        $chat->setTitulo($titulo);
        $this->em->persist($chat);
        $this->em->flush();
        return $chat;
    }

    public function update(int $id, array $data): ?Chat
    {
        $chat = $this->getById($id);
        if (!$chat) return null;

        if (isset($data['titulo'])) $chat->setTitulo($data['titulo']);
        $this->em->flush();

        return $chat;
    }

    public function delete(int $id): bool
    {
        $chat = $this->getById($id);
        if (!$chat) return false;

        $this->em->remove($chat);
        $this->em->flush();
        return true;
    }
}
