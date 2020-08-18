<?php

namespace App\DataFixtures;

use App\Entity\Skills;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $skills = ['PHP','IOS','HTML','CSS','JavaScript','Java','Xml','MySQL','PostgresSQL','Android'];
        foreach ($skills as $skill){
            $skillModel = new Skills();
            $skillModel->setSkill($skill);
            $manager->persist($skillModel);

            $manager->flush();
        }
    }
}