<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PropertyRepository;
use PhpParser\Builder\Property;
use App\Form\PropertyType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;


class AdminPropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;

    // j'ai besoin de recuperer donc j instancie un repository
    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        // findAll pour tout recuperer car l'admin doit pouvoir voir tout
        $properties = $this->repository->findAll();
        // renvois vers la page index avec un tableau compact
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin/property/create", name="admin.property.new")
     */
    public function new(Request $request)
    {
        $property = new Property();
        //exit(var_dump($property));

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        //exit(var_dump($property));
        if($form->isSubmitted() && $form->isValid()) {
            $this->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Bien créé avec succès');

            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     * @param Property $property
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property, Request $request)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.delete")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Property $property, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get("_token")))
        {
            $this->em->remove();
            $this->em->flush();
            $this->addFlash('success', 'Bien supprimé avec succès');

           // return new Response('Suppression');
        }
        return $this->redirectToRoute('admin.property.index');
    }
}