<?php
// src/Controller/PostController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PostController extends AbstractController
{
    public function show($id): Response
    {
        return("hello"); 
    }
}

