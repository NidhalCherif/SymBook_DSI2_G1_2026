<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Livres;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LivresFixtures extends Fixture
{
    public function load(ObjectManager $em): void
    {    $faker=Factory::create('fr_FR');
        $categories=['Informatique','Cuisine','Mecanique'];
        for($j=0;$j<3;$j++)
        {   $cat=new Categories();
            $cat->setLibelle($categories[$j])
                 ->setSlug(strtolower(str_replace('','-',$cat->getLibelle())))
                 ->setDescription($faker->paragraph(5));
            $em->persist($cat);
                    for ($i = 1; $i <=random_int(1,15); $i++) {
                    $livre = new Livres();
                    $livre->setTitre($faker->name)
                        ->setQte(random_int(1,200))
                        ->setPrix($faker->randomFloat(2,10, 200))
                        ->setEditeur($faker->company)
                        ->setIsbn($faker->isbn13())
                        ->setImage('https://picsum.photos/400/?id='.$i)
                        ->setDateEdition($faker->dateTimeBetween('-5 years', 'now'))
                        ->setResume($faker->paragraph())
                        ->setSlug(strtolower(str_replace('','-',$livre->getTitre())))
                        ->setCat($cat);
                    $em->persist($livre);
    }}
        $em->flush();
    }
}
