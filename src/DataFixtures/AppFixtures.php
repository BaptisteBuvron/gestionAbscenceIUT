<?php

namespace App\DataFixtures;

use App\Entity\Department;
use App\Entity\GroupTD;
use App\Entity\GroupTP;
use App\Entity\Promotion;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('FR-fr');

        $teacher = new Teacher();
        $teacher->setFirstName('John');
        $teacher->setLastName('Doe');
        $teacher->setEmail('john@doe.fr');
        $teacher->setPassword($this->passwordHasher->hashPassword($teacher,'password'));
        $teacher->setRoles(['ROLE_TEACHER']);
        $teacher->setSubject("Computer Science");
        $manager->persist($teacher);
        $admin = new User();
        $admin->setFirstName('Jane');
        $admin->setLastName('Doe');
        $admin->setEmail('jane@doe.fr');
        $admin->setPassword($this->passwordHasher->hashPassword($admin,'password'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $yearResponsable = new User();
        $yearResponsable->setFirstName('Petter');
        $yearResponsable->setLastName('Doe');
        $yearResponsable->setEmail('petter@doe.fr');
        $yearResponsable->setPassword($this->passwordHasher->hashPassword($yearResponsable,'password'));
        $yearResponsable->setRoles(['ROLE_YEAR_RESPONSIBLE']);
        $manager->persist($yearResponsable);

        $td11 = new GroupTD();
        $td11->setName('TD11');

        $td12 = new GroupTD();
        $td12->setName('TD12');

        $tp11A = new GroupTP();
        $tp11A->setName('TP11A');

        $tp11B = new GroupTP();
        $tp11B->setName('TP11B');

        $tp12A = new GroupTP();
        $tp12A->setName('TP12A');

        $tp12B = new GroupTP();
        $tp12B->setName('TP12B');

        $td11->addGroupsTP($tp11A);
        $td11->addGroupsTP($tp11B);

        $td12->addGroupsTP($tp12A);
        $td12->addGroupsTP($tp12B);

        $info2 = new Promotion();
        $info2->setName('Info2');
        $info2->setYear(2022);

        $dptInfo = new Department();
        $dptInfo->setName('Info');

        $info2->setDepartment($dptInfo);

        $td11->setPromotion($info2);
        $td12->setPromotion($info2);

        $genres = ['male', 'female'];
        $groups = [$tp11A,$tp11B, $tp12A, $tp12B];
        $idGroup = 0;
        for ($i = 0; $i <=10 ; $i++){
            $genre = $faker->randomElement($genres);
            $student = new Student();
            $student->setFirstName($faker->firstName($genre));
            $student->setLastName($faker->lastName($genre));
            $student->setPromotion($info2);
            $student->setPicture('https://randomuser.me/api/portraits/'. ($genre === 'male' ? 'men/' : 'women/').$faker->numberBetween(1,99).'.jpg');
            $student->setPromotion($info2);
            $student->setGroupTP($groups[$idGroup]);
            $idGroup++;
            if ($idGroup === 4) {
                $idGroup = 0;
            }
            $manager->persist($student);
        }
        $manager->persist($td11);
        $manager->persist($td12);
        $manager->persist($tp11A);
        $manager->persist($tp11B);
        $manager->persist($tp12A);
        $manager->persist($tp12B);
        $manager->persist($info2);
        $manager->persist($dptInfo);


        $manager->flush();
    }
}
{

}