<?php

namespace Exo1Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ExoController extends Controller {
	public function accueilAction(){
		return $this->render('@Exo1/Exo/accueil.html.twig');
	}

	public function nombreAction($numero) {
		return $this->render('@Exo1/Exo/nombre.html.twig', array('numero' => $numero));	
	}
	
	public function additionAction($numero1,$numero2){
		$numero = $numero1 + $numero2;
		// return $this->redirectToRoute('exo1_nombre', array('numero' => $numero));	
		// return $this->render('@Exo1/Exo/nombre.html.twig', array('numero' => $numero));
		return $this->render('@Exo1/Exo/addition.html.twig', array('numero' => $numero));
	}

	public function quotientAction($numero1,$numero2){
		if ( $numero2 == 0)
			throw $this->createNotFoundException('pas de div par zero zebi');
		else{		
			$numero = $numero1 / $numero2;
			return $this->redirectToRoute('exo1_nombre', array('numero' => $numero));	
		}
	}
}


