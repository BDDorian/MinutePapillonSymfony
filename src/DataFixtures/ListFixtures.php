<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\ListOfTasks;

class ListFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 5; $i++)
        {
            $list= new ListOfTasks;
            $list->setName("myFirstList")
                ->setPriority(1)
                ->setDate(new \DateTime());
            $manager->persist($list);


        }
        $manager->flush();

        $manager->flush();
    }
}
