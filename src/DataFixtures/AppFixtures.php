<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Project;
use App\Entity\Technology;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
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
// Create an admin user
        $adminUser = new User();
        $adminUser->setEmail('admin@example.com');
        $adminUser->setRoles(['ROLE_ADMIN']);
        $adminUser->setPassword($this->passwordHasher->hashPassword(
            $adminUser,
            'xxx'
        ));
        $manager->persist($adminUser);

// Create a regular user
        $user = new User();
        $user->setEmail('user@example.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            'xxx'
        ));
        $manager->persist($user);

        $category = new Category();
        $category->setName('E-Commerce');
        $manager->persist($category);

        // Create Technology
        $technology = new Technology();
        $technology->setName('PHP');
        $manager->persist($technology);

        // Create Project
        $project = new Project();
        $project->setName('My First Project');
        $project->setThumbnail('path/to/thumbnail.jpg');
        $project->setDescription('A detailed description of the project.');
        $project->setLink('http://example.com');
        $project->setStartDate(new \DateTime('now'));
        $project->setEndDate(new \DateTime('+1 month'));
        $project->setCreatedAt(new \DateTime('now'));
        $project->setUpdatedAt(new \DateTime('now'));
        $project->setCategory($category);
        $project->addTechnology($technology);

        $manager->persist($project);

        $manager->flush();
    }
}
