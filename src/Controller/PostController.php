<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class PostController extends AbstractController
{
    /**
     * @Route("/posts", name="posts_index")
     */
    public function index()
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/posts/create", name="posts_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $category = new Category();
            $category->setName('space');

            $post->setCategory($category);

            $entityManager->persist($category);
            $entityManager->persist($post);


            $entityManager->flush();
            return $this->redirectToRoute('posts_index');
        }

        return $this->render('post/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/posts/{id}/edit", name="posts_edit")
     */
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($post);

            $entityManager->flush();
            return $this->redirectToRoute('posts_index');
        }

        return $this->render('post/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/posts/delete/{id}", name="posts_delete")
     */
    public function delete(Post $post, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirectToRoute('posts_index');
    }

}
