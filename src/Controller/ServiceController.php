<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;

class ServiceController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */

    public function index(EntityManagerInterface $em)
    {
        return $this->render( 'service/index.html.twig',[
            'categories' => $em->getRepository(Category::class)->findAll(),
            'services' => $em->getRepository(Service::class)->findAll(),
            'user' => $this->getUser()
        ]);
    }

    /**
     * Afficher le formulaire d'ajout d'un article.
     * @Route("/services/add", name="service_add", methods="get")
     */
    public function add(EntityManagerInterface $em)
    {
        return $this->render( 'service/add.html.twig',[
            'categories' => $em->getRepository(Category::class)->findAll()
        ]);
    }

    /**
     * Enregistrer un nouveau service.
     * @Route("/services/add", name="service_add_save", methods="post")
     */
    public function save(EntityManagerInterface $em, Request $request)
    {
        // dd($request->request);
        $service = new Service();
        // renseigner les informations
        $service->setTitle($request->request->get('title'))
         ->setDescription($request->request->get('description'))
         ->setExpireAt(new \DateTimeImmutable($request->request->get('expireAt')))
         ->setCreatedAt(new \DateTimeImmutable())
         ->setCategory($em->getRepository(Category::class)->find($request->request->get('category')))
         ->setUser($this->getUser());
        // persister l'entité
        $em->persist($service);
        // déclencher le traitements SQL
        $em->flush();
        // redirection
        return $this->redirectToRoute('home');
    }


    /**
     * @Route("/services/{id}", name="service_show")
     */
    public function show(Service $service): Response
    {
        dump($service);
        return new Response(
            '<html><body>
            <h1>route /services/{id} - show()</h1>
            </body></html>'
        );
    }

    /**
     * Effacer un service.
     * @Route("/services/{id}/delete", name="service_delete", methods="post")
     */
    public function delete(Service $service, EntityManagerInterface $em)
    {
        $em->remove($service);
        // déclencher le traitements SQL
        $em->flush();
        // redirection
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/services/{id}/edit", name="service_edit")
     */
    public function edit(Service $service, EntityManagerInterface $em): Response
    {
        $service->setTitle('TEST');
        // $service->setUpdatedAt(new \DateTimeImmutable());
        $em->flush();
        dump($service);
        return new Response(
        '<html><body>
        <h1>route /services/{id}/edit - edit()</h1>
        </body></html>'
        );

    }

    /**
     * @Route("/{category}", name="category")
     */
    public function category(EntityManagerInterface $em, $category)
    {
        return $this->render( 'service/index.html.twig',[
            
            'categories' => $em->getRepository(Category::class)->findAll(),
            'services' => $em->getRepository(Service::class)->findBy(['category' => $category]),
            'user' => $this->getUser()
        ]);
    }
}