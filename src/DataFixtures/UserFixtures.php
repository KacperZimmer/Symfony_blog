<?php

/**
 * This file is part of the [Blog app] project.
 *
 * (c) [2024] [Kacper Zimmer]
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 *
 * For more information, please view the LICENSE file that was
 * distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class UserFixtures.
 *
 * Fixtures class responsible for loading a sample admin user into the database.
 */
class UserFixtures extends Fixture
{
    /**
     * Load method to generate and persist a sample admin user.
     *
     * @param ObjectManager $manager the object manager to handle persistence
     */
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword('$2a$12$S2F1s55bpVC1cXnqvTWOlO7/6vSXX1SSBykVbyQbL.m2b8vCAxXlG'); // Predefined password (encoded)

        $manager->persist($user);

        $manager->flush();
    }
}
