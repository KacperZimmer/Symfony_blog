<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DatabaseTestController extends AbstractController
{
    #[Route('/test-database', name: 'test_database')]
    public function testDatabase(EntityManagerInterface $em): Response
    {
        try {

            $connection = $em->getConnection();
            $sql = "SELECT 1";
            $stmt = $connection->prepare($sql);
            $stmt->execute();

            return new Response('Połączenie z bazą danych jest poprawne.');
        } catch (\Exception $e) {
            return new Response('Błąd połączenia z bazą danych: ' . $e->getMessage());
        }
    }
}
