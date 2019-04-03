<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        //Ne pas oublier d'importer le use Entity User
        // fixtures servent à remplir la base de donnees
        $user = new User();
        $user->setUsername('test');
        // on utilise une méthode encoder de la class encodePassword avec des parametress
        $user->setPassword($this->encoder->encodePassword($user, 'mdproot'));
        $manager->persist($user);
        $manager->flush();
    }
}
