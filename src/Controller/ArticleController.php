<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticlePicture;
use App\Entity\ProfilPicture;
use App\Form\ArticleType;
use App\Security\Voter\UserVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleController extends AbstractController
{
    #[Route('/article/add', name: 'app_article_add')]
    public function addArticle(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        if(!$this->isGranted(UserVoter::ACCESS, $this->getUser())){
            return $this->redirectToRoute('app_home');
        }
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $pictureFiles = $form->get('articlePicture')->getData();

            foreach ($pictureFiles as $pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);

                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);

                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $pictureFile->move(
                        $this->getParameter('articleImageDirectory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file uploads
                }
                $articlePicture = new ArticlePicture();
                $articlePicture->setLink($newFilename);
                $article->setArticlePicture($articlePicture);
            }
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('article/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/article/{id}', name: 'app_article_details')]
    public function articleDetails(Article $article): Response
    {
        return $this->render('article/details.html.twig', ['article' => $article]);
    }
}
