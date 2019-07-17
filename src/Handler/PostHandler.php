<?php

namespace App\Handler;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Service\Curl;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class PostHandler extends Handler
{
    /** @var PostRepository */
    private $repository;
    /** @var Request */
    private $request;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(PostRepository $repository, EntityManagerInterface $entityManager, Handler $handler = null)
    {
        parent::__construct($handler);
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public function list()
    {
        $posts = $this->repository->findAll();
        return $posts;
    }

    public function create()
    {
        $curl = new Curl('https://jsonplaceholder.typicode.com/posts');

        $post = new Post();
        $post
            ->setName('random_'.rand(0, 100))
            ->setValue($curl->execute());
        $this->entityManager->persist($post);
        $this->entityManager->flush();

        $posts = $this->entityManager->getRepository(Post::class)->createQueryBuilder('p')
            ->getQuery()
            ->getArrayResult();

        return $posts;
    }

    /**
     * @param mixed $request
     * @return mixed
     */
    protected function processing($request)
    {
        $this->request = $request;

        return $this;
    }
}