<?php

namespace Exo1Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('Exo1Bundle:Default:index.html.twig');
    }
}
