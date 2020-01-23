<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Flex\Response;

class PostController extends AbstractController
{
    /**
     * @Route("/posts", name="posts_index")
     * @Method("GET")
     */
    public function index()
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    /**
     * @Route("/posts/create", name="posts_create")
     */
    public function createPost(EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $category = new Category();
        $category->setName('space');
        $entityManager->persist($category);
        $entityManager->flush();

        $post->setTitle('We are going to Mars!!!!');
        $post->setSlug('we-are-going-to-mars');
        $post->setBody('SpaceX and Nasa are preparing to tourist routes to Mars this year....');
        $post->setCategory($category);
    }
}
