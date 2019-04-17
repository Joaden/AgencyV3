<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 10/02/2019
 * Time: 04:56
 * monoprocess
 */

namespace App\Controller;


use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Entity\Property;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

// class abstract qui se voit injecter le container
class HomeController extends AbstractController
{
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /*public function index(): Response
    {
        return new Response($this->render('pages/home.html.twig'));
    }*/


    /**
     * @Route("/", name="home")
     * @param PropertyRepository $repository
     * @return Response
     */
    public function index(PropertyRepository $repository): Response
    {
        //on a injecté le propertyrepo dans le index,(plus besoin du $this->)
        // je récupère le derniers biens créés avec la methode findLatest()
        // puis je renvoi les données sur la page home avec les properties en parametre
        $properties = $repository->findLatest();
        return $this->render('pages/home.html.twig', [
            'properties' => $properties
        ]);
      //return new Response('coucou');
    }

    /**
     * @Route("/account", name="account")
     * 
     */
    public function account()
    {
        $user = $repository->findAll();

        return $this->render('/account.html.twig', [
            'users' => $user
        ]);
    }

    /**
     * @Route("/about", name="about")
     * @return Response
     */
    public function about(): Response
    {
        
        return $this->render('pages/about.html.twig');
      //return new Response('about');
    }

    /**
     * @Route("/infos", name="infos")
     * @return Response
     */
    public function infos(): Response
    {
        return $this->render('pages/infos.html.twig');
      //return new Response('infos');
    }

     /**
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function contact(): Response
    {
        return $this->render('pages/contact.html.twig');
      //return new Response('contact');
    }
    
    /**
     * @Route("/louer", name="louer")
     * @return Response
     */
    public function louer(): Response
    {
        return $this->render('pages/louer.html.twig');
      //return new Response('louer');
    }

    /**
     * @Route("/register", name="register")
     * @return Response
     */
    public function register(): Response
    {
        return $this->render('pages/register.html.twig');
      //return new Response('register');
    }
   

}