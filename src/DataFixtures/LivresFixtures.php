<?php

namespace App\DataFixtures;

use App\Entity\Livres;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LivresFixtures extends Fixture
{
    public function load(ObjectManager $em): void
    {   for ($i = 1; $i <=100; $i++) {
        $livre = new Livres();
        $livre->setTitre('titre'.$i)
            ->setQte(random_int(1,200))
            ->setPrix(random_int(10, 200))
            ->setEditeur('editeur'.$i)
            ->setIsbn('111111111'.$i)
            ->setImage('https://picsum.photos/400/?id='.$i)
            ->setDateEdition(new \DateTime('2025-2-4'))
            ->setResume('resumé de titre'.$i)
            ->setSlug('titre-'.$i);
        $em->persist($livre);
    }

        $em->flush();
    }
}
