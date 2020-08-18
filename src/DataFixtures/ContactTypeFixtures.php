<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ContactType;

class ContactTypeFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $contactTypes = [
            'phone'=>'Phone',
            'mobilePhone'=>'Mobile Phone',
            'skype'=>'Skype',
            'email'=>'Email',
            'website'=>'Web Site',
            'viber'=>'Viber',
            'whatsApp'=>'WhatsApp',
            'telegram'=>'Telegram',
            'instagram'=>'Instagram',
            'twitter'=>'Twitter',
            'facebook'=>'Facebook',
        ];

        foreach ($contactTypes as $key=>$contactType){
            $model = new ContactType();
            $model->setCode($key);
            $model->setName($contactType);
            $manager->persist($model);
        }
        $manager->flush();
    }
}
