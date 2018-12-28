<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Task;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 5; $i++)
        {
            $task= new Task;
            $task->setName("myFirstTask")
                ->setPriority(1)
                ->setDate(new \DateTime());
            $manager->persist($task);
        }

        $manager->flush();
    }
}
