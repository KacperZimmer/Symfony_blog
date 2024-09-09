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

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;

/**
 * Class CategoryFixtures.
 *
 * Fixtures class responsible for loading sample categories into the database.
 */
class CategoryFixtures extends Fixture
{
    /**
     * Load method to generate and persist sample categories.
     *
     * @param ObjectManager $manager the object manager to handle persistence
     */
    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create();

        for ($i = 1; $i <= 10; ++$i) {
            $category = new Category();
            $category->setName($faker->word);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
