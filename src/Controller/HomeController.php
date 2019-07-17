<?php

namespace App\Controller;

use App\Entity\Post;
use App\Handler\PostHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/", name="index", methods={"get"})
     */
    public function index(Request $request, PostHandler $handler): Response
    {
        $posts = $handler->handle($request)->list();
        return $this->render('home/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @param Request $request
     * @param PostHandler $handler
     * @return JsonResponse
     *
     * @Route("/", methods={"post"})
     */
    public function create(Request $request, PostHandler $handler): JsonResponse
    {
        $data = $handler->handle($request)->create();

        return new JsonResponse($data, 201);
    }
}