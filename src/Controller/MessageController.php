<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'app_message')]
    public function messagesList(): Response
    {
        $conversations = $this->getUser()->getConversations();
        return $this->render('message/index.html.twig', [
            'conversations' => $conversations,
        ]);
    }

    #[Route('/message/{uuid}', name: 'app_message_details')]
    public function messageDetails(Conversation $conversation): Response
    {
        return $this->render('message/details.html.twig', [
            'conversation' => $conversation,
        ]);
    }
}
