<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Services\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/post", name="post.")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        
        return $this->render('post/index.html.twig', [
            "posts" => $posts
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    

    public function create(Request $request, FileUploader $fileUploader)
    {
        // create a new post with title
        //Post comes from the Entity folder, it's an object and we jsut create a new one
        $post = new Post();
        
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //entity manager
            $em = $this->getDoctrine()->getManager();
            // dump($request);
            // die();
            // $article = $request->get('post')['article'];
            // dump($article);
            // die();
            $em->persist($post);
            $em->flush();
            
            return $this->redirect($this->generateUrl('post.index'));
        }

       

        // return a response
        return $this->render('post/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     * @return Response
     */

    public function show($id, PostRepository $postRepository)
    {
        $post = $postRepository->find($id);
        // $post = $postRepository->findPostWithCategory($id);

        // dump($post);
        //create the show view
        return $this->render("post/show.html.twig", [
            'post' => $post
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */

    public function remove($id, PostRepository $postRepository)
    {
        $post = $postRepository->find($id);

        $em = $this->getDoctrine()->getManager();

        $em->remove($post);
        $em->flush();

        $this->addFlash('success', "Your message was deleted");

        return $this->redirect($this->generateUrl('post.index'));
    }
}
