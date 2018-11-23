<?php

namespace SalleTpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use SalleTpBundle\Entity\Salle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use SalleTpBundle\Form\SalleType;

class SalleController extends Controller
{
	public function accueilAction()
	{
		$session = $this->get('session');
		if ($session->has('nbreFois'))
			$session->set('nbreFois', $session->get('nbreFois') + 1);
		else
			$session->set('nbreFois', 1);
		$numero = rand(1, 84);
		return $this->render('@SalleTp/Salle/accueil.html.twig', array('nbreFois' => $session->get('nbreFois')));
	}
	public function voirAction($numero)
	{
		if ($numero > 50)
			throw $this->createNotFoundException("C'est trop !");
		else
			return $this->render('@SalleTp/Salle/voir.html.twig', array('numero' => $numero));
	}
	public function dixAction()
	{
		return $this->redirectToroute('salle_tp_voir', array("numero" => 10));
	}

	public function treizeAction()
	{
		$salle = new Salle;
		$salle->setBatiment('D');
		$salle->setEtage(1);
		$salle->setNumero(13);
		return $this->render('@SalleTp/Salle/treize.html.twig', array("salle" => $salle));
	}

	public function treize_bisAction()
	{
		$salle = new Salle;
		$salle->setBatiment('D');
		$salle->setEtage(1);
		$salle->setNumero(13);
		return $this->render('@SalleTp/Salle/treizebis.html.twig', array("designation" => $salle->__toString()));
	}

	public function voir2Action($id)
	{
		$repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
		$salle = $repository->find($id);
		if ($salle === null) {
			throw $this->createNotFoundException('Salle[id=' . $id . '] inexistante');
		}
		return $this->render('@SalleTp/Salle/voir2.html.twig', array('salle' => $salle));
	}

	public function ajouterAction($batiment, $etage, $numero)
	{
		$entityManager = $this->getDoctrine()->getManager();
		$salle = new Salle;
		$salle->setBatiment($batiment);
		$salle->setEtage($etage);
		$salle->setNumero($numero);
		$entityManager->persist($salle);
		$entityManager->flush();
		return $this->redirectToRoute('salle_tp_voir2', array('id' => $salle->getId()));
	}

	public function ajouter2Action(Request $request)
	{
		$salle = new Salle;
		$form = $this->createForm(SalleType::class, $salle, array('action' => $this->generateUrl('salle_tp_ajouter2')));
		$form->add("submit", SubmitType::class, array('label' => 'Ajouter'));

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($salle);
			$entityManager->flush();
			$url = $this->generateUrl('salle_tp_voir2', array('id' => $salle->getId()));
			return $this->redirect($url);
		}
		return $this->render('@SalleTp/Salle/ajouter2.html.twig', array('monFormulaire' => $form->createView()));
	}

	public function navigationAction()
	{
		$repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
		$salles = $repository->findAll();
		return $this->render('@SalleTp/Salle/navigation.html.twig', array('salles' => $salles));
	}

	public function modifierAction($id)
	{
		$entityManager = $this->getDoctrine()->getManager();
		if (!$salle = $entityManager->getRepository('SalleTpBundle:Salle')->find($id))
			throw $this->createNotFoundException('Salle[id=' . $id . '] inexistante');
		$form = $this->createForm(SalleType::class, $salle, array('action' => $this->generateUrl('salle_tp_modifier_suite', array('id' => $salle->getId()))));
		$form->add("submit", SubmitType::class, array("label" => "Modifier"));
		return $this->render('@SalleTp/Salle/modifier.html.twig', array('monFormulaire' => $form->createView()));
	}

	public function modifierSuiteAction(Request $request, $id)
	{
		$entityManager = $this->getDoctrine()->getManager();
		$salle = $entityManager->getRepository('SalleTpBundle:Salle')->find($id);
		$form = $this->createForm(SalleType::class, $salle, array('action' => $this->generateUrl('salle_tp_modifier_suite', array('id' => $salle->getId()))));
		$form->add("submit", SubmitType::class, array("label" => "Modifier"));
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager->persist($salle);
			$entityManager->flush();
			$url = $this->generateUrl('salle_tp_voir2', array('id' => $salle->getId()));
			return $this->redirect($url);
		}
		return $this->render('@SalleTp/Salle/modifier.html.twig', array('monFormulaire' => $form->createView()));
	}
}
