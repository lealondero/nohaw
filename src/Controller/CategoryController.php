<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="category_index")
     */
    public function index(EntityManagerInterface $em)
    {
        // dd( $em->getRepository( Category::class )->findDetailled());
        return $this->render( 'category/index.html.twig',[
            'categories' => $em->getRepository( Category::class )->findDetailled()
        ]);
    }

}