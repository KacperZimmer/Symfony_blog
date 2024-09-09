<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class PostFixtures
 *
 * Fixtures class responsible for loading sample posts into the database.
 */
class PostFixtures extends Fixture
{
    /**
     * Load method to generate and persist sample posts.
     *
     * @param ObjectManager $manager The object manager to handle persistence.
     */
    public function load(ObjectManager $manager): void
    {
        $title = 'Lorem Ipsum Post';
        $content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent ';

        for ($i = 1; $i <= 50; $i++) {
            $post = new Post();
            $post->setTitle($title . ' ' . $i)
                ->setContent($content);

            $manager->persist($post);
        }

        $manager->flush();
    }
}
