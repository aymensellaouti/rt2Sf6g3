<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController
{
    /**
     * @Route("/first", name="first")
     */
    public function first() {
        return new Response("<h1>Hello RT2 G3 :) </h1>");
    }
}