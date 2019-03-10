<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 10/02/2019
 * Time: 03:13
 */

namespace App\Controller;


use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    // function construct , injection de PropertyReopository
    // 
    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {   //initialise a la construction
        $this->repository = $repository;
        $this->em = $em;
    }


    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index(): Response
    {
        // methode find/findAll/findOneBy/ recupere un enregistrment et on passe en parametre son param
        // findOneBy(['floor'=>4]); recupere ceux qui sont au 4ieme etage
        // $property = $this->repository->findAllVisible();
        //
        // $property[0]->setSold(true);
        // em flush detecte les modifs
        // $this->em->flush();

        //dump($property);

        /*
        $property = new Property();
        $property->setTitle('mon premier bien')
            ->setPrice(200000)
            ->setRooms(4)
            ->setBedrooms(3)
            ->setDescription('Une petite description')
            ->setSurface(60)
            ->setFloor(4)
            ->setHeat(1)
            ->setCity('Paris')
            ->setAddress('55 Avenue Hoche')
            ->setPostalCode('75008');
        //entity manager, class php responsable de gérer les entitées et la persistance à la base de données
        // getDoctrine = recupere la methode, une instance du managerRepository!  getManager = recup l'instance de ObjectManager
        $em = $this->getDoctrine()->getManager();
        // persist($property)
        $em->persist($property);
        // m"thode flush envois les données dans la DB
        $em->flush();*/


      /*  $property = $this->repository->findAllVisible();
        $property[0]->setSold(true);
        $this->em->flush();*/

        //1ere manière de faire un repo
        // quand on a besoin de récupérer quelque chose
        // mettre en parametre lentitée
        // On stocke le repository dans une variable
        //$repository = $this->getDoctrine()->getRepository(Property::class);

        // dump() affiche ce qui est retourné
        //dump($repository);


        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @return Response
     */
    public function show(Property $property, string $slug): Response
    {

        //dans l'annotation : requirements permet de définir des parametres.
        // et on recupere la propriete
        // $property = $this->repository->find($id);

        if ($property->getSlug() !==$slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        // retourne la page show avec le menu properties
        return $this->render('property/show.html.twig', [
            'property' => '$property',
            'current_menu' => 'properties'
        ]);
    }

}