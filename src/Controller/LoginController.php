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

// src/Controller/LoginController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for handling login functionality.
 */
class LoginController extends AbstractController
{
    /**
     * Displays the login page or redirects to the home page if the user is already authenticated.
     *
     * @Route("/login", name="login")
     *
     * @param Request $request The HTTP request object
     *
     * @return Response The HTTP response object
     */
    public function login(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        return $this->render('login/login.html.twig', []);
    }
}
