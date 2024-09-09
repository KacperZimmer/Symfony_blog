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

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for testing database connection.
 */
class DatabaseTestController extends AbstractController
{
    /**
     * Tests the database connection.
     *
     * @Route("/test-database", name="test_database")
     *
     * @param EntityManagerInterface $em The entity manager
     *
     * @return Response
     */
    public function testDatabase(EntityManagerInterface $em): Response
    {
        try {
            $connection = $em->getConnection();
            $sql = 'SELECT 1';
            $stmt = $connection->prepare($sql);
            $stmt->execute();

            return new Response('Połączenie z bazą danych jest poprawne.');
        } catch (\Exception $e) {
            return new Response('Błąd połączenia z bazą danych:'.$e->getMessage());
        }
    }
}
