<?php

namespace SalleTpBundle\Controller;

use SalleTpBundle\Form\SalleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use SalleTpBundle\Entity\Salle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class SalleController extends Controller {
	public function accueilAction(){
		/*
		return new Response("ici l'accueil !");
		return new Response("<html><body><h1>Salles: </h1> <p>Voici quelques informatons concernant les salles <br\>blablabla blablabla blablabla blablabla blablabla ....</p></body></html>");
		$nombre = rand(1,84);
		return $this->render('@SalleTp/Salle/accueil.html.twig', array('numero' => $nombre));
		*/
		$session = $this->get('session');
		if($session->has('nbreFois'))
			$session->set('nbreFois', $session->get('nbreFois')+1);
		else
			$session->set('nbreFois', 1);

		return $this->render('@SalleTp/Salle/accueil.html.twig', array('nbreFois' => $session->get('nbreFois')));

	}

	public function voirAction($numero) {
		if ($numero > 50 || $numero <= 0)
			throw $this->createNotFoundException ('error 404');
		else
			return $this->render('@SalleTp/Salle/voir.html.twig', array('numero' => $numero));	
	}


	/*
	public function dixAction() {
		$url = $this->generateUrl('salle_tp_voir',array('numero' => 10));
		return $this->redirect($url);
	} 
	*/

	public function dixAction() {
		return $this->redirectToRoute('salle_tp_voir',array('numero' => 10));
	}
	
	public function treizeAction() {
		$salle = new Salle;
		$salle->setBatiment('D');
		$salle->setEtage(1);
		$salle->setNumero(13);
		return $this->render('@SalleTp/Salle/treize.html.twig', array('salle' => $salle));
	}
	public function treize_bisAction() {
		$salle = new Salle;
		$salle->setBatiment('D');
		$salle->setEtage(1);
		$salle->setNumero(13);
		return $this->render('@SalleTp/Salle/treizebis.html.twig', array('designation' => $salle->__toString()));
	}	

	public function voir2Action($id) {
		$repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
		$salle = $repository->find($id);
		if($salle === null)
			throw $this->createNotFoundException('Salle[id='.$id.'] inexistante');
		return $this->render('@SalleTp/Salle/voir2.html.twig',array('salle' => $salle));	
	}

	public function ajouterAction($batiment, $etage, $numero) {
		$entityManager = $this->getDoctrine()->getManager();
		$salle = new Salle;
		$salle->setBatiment($batiment);
		$salle->setEtage($etage);
		$salle->setNumero($numero);
		$entityManager->persist($salle);
		$entityManager->flush();
		return $this->redirectToRoute('salle_tp_voir2', array('id' => $salle->getId()));
	}
	
	public function ajouter2Action(Request $request) {
		$salle = new Salle;
		//$form = $this->createFormBuilder($salle)
		//	->add('Batiment', TextType::class)
		//	->add('Etage', TextType::class)
		//	->add('Numero', TextType::class)
		//	->add('Envoyer', SubmitType::class)
		//	->getForm();
		$form = $this->createForm(SalleType::class, $salle, array('action' => $this->generateUrl('salle_tp_ajouter2')));
		$form->add('submit', SubmitType::class, array ('label' => 'Ajouter'));
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid()){
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($salle);
			$entityManager->flush();
			//$this->get('session')->getFlashBag()
			//	->add('infoAjout','nouvelle salle ajoutée : '.$salle->__toString()); 
			return $this->redirectToRoute('salle_tp_voir2', array('id' => $salle->getId()));
		}
		return $this->render('@SalleTp/Salle/ajouter2.html.twig', array('monFormulaire' => $form->createView()));
	}
	
	public function navigationAction() {
		$repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
		$salles = $repository->findAll();
		return $this->render('@SalleTp/Salle/navigation.html.twig',array('salles' => $salles));		
	}
	
	public function modifierAction($id) {
		$em = $this->getDoctrine()->getManager();
		if(! $salle=$em->getRepository('SalleTpBundle:Salle')->find($id))
			throw $this->createNotFoundException('Salle[id='.$id.']inexistante');
		$form = $this->createForm(SalleType::class, $salle, ['action' => $this->generateUrl('salle_tp_modifier_suite',['id' => $salle->getId()])]);
		$form->add('submit', SubmitType::class, ['label' => 'Modifier']);
		return $this->render('@SalleTp/Salle/modifier.html.twig', ['monFormulaire' => $form->createView()]);
	}
	
		public function modifierSuiteAction(Request $request, $id) {
		$em = $this->getDoctrine()->getManager();
		$salle=$em->getRepository('SalleTpBundle:Salle')->find($id);
		$form = $this->createForm(SalleType::class,$salle, ['action' => $this->generateUrl('salle_tp_modifier_suite',['id' => $salle->getId()])]);
		$form->add('submit', SubmitType::class, ['label' => 'Modifier']);
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid()){
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($salle);
			$entityManager->flush();
			$url = $this->generateUrl('salle_tp_voir', array('id' => $salle->getId()));
			return $this->redirect($url);
		}
		return $this->render('@SalleTp/Salle/modifier.html.twig', ['monFormulaire' => $form->createView()]);
	}
		
}


