<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Material;
use App\Entity\Message;
use App\Form\MessageType;
use App\Security\Voter\UserVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'app_message')]
    public function messagesList(): Response
    {
        if(!$this->isGranted(UserVoter::VIEW, $this->getUser())){
            return $this->redirectToRoute('app_login');
        }
        $conversations = $this->getUser()->getConversations();
        return $this->render('message/index.html.twig', [
            'conversations' => $conversations,
        ]);
    }

    #[Route('/message/{uuid}', name: 'app_message_details')]
    public function messageDetails(
        Conversation $conversation,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if(!$this->isGranted(UserVoter::VIEW, $this->getUser())){
            return $this->redirectToRoute('app_login');
        }
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();
            $message->setSendBy($this->getUser());
            $message->setConversation($conversation);
            $message->setCreatedAt(date_create());
            $entityManager->persist($message);
            $entityManager->flush();
            return $this->redirectToRoute('app_message_details', ['uuid' => $conversation->getUuid()]);
        }
        return $this->render('message/details.html.twig', [
            'conversation' => $conversation,
            'form' => $form
        ]);
    }


    #[Route('/message/new/{uuid}', name: 'app_message_new')]
    public function newMessage(Material $material, Request $request, EntityManagerInterface $em): Response
    {
        if(!$this->isGranted(UserVoter::VIEW, $this->getUser())){
            return $this->redirectToRoute('app_login');
        }
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $conversation = new Conversation();
            $conversation->setTitle($material->getName())
                ->addParticipant($this->getUser())
                ->addParticipant($material->getOwner())
                ->setUuid(Uuid::v4())
                ->setCreatedAt(date_create());
            $message->setConversation($conversation)
                ->setSendBy($this->getUser())
                ->setCreatedAt(date_create());
            $em->persist($conversation);
            $em->persist($message);
            $em->flush();
            return $this->redirectToRoute('app_message_details', ['uuid'=> $conversation->getUuid()]);

        }

        return $this->render('message/new.html.twig', [
            'form' => $form
        ]);
    }

}
