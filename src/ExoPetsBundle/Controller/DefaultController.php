<?php

namespace ExoPetsBundle\Controller;

use ExoPetsBundle\Form\AnimalType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ExoPetsBundle\Entity\Animal;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	return $this->render('@ExoPets/Default/index.html.twig');
    }

	public function ajouterAction($nom, $poids) {
		$entityManager = $this->getDoctrine()->getManager();
		$animal = new Animal;
		$animal->setNom('a');
		$animal->setPoids(5);
		$now = (new \DateTime("now"));
		$animal->setDateNais($now);
		$entityManager->persist($animal);
		$entityManager->flush();
		return $this->redirectToRoute('exo_pets_homepage', array('id' => $animal->getId()));
	}
	
	public function ajouter2Action(Request $request) {
		$animal = new Animal;
		$form = $this->createFormBuilder($animal)
			->add('Nom', TextType::class)
			->add('Poids', TextType::class)
			->add('Envoyer', SubmitType::class)
			->getForm();
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid()){
			$entityManager = $this->getDoctrine()->getManager();
			$now = (new \DateTime("now"));
			$animal->setDateNais($now);
			$entityManager->persist($animal);
			$entityManager->flush();
			return $this->redirectToRoute('exo_pets_homepage', array('id' => $animal->getId()));
		}
		return $this->render('@ExoPets/Default/ajouter2.html.twig', array('monFormulaire' => $form->createView()));
	}
	
	public function voirAction($id) {
		$repository = $this->getDoctrine()->getManager()->getRepository('ExoPetsBundle:Animal');
		$animal = $repository->find($id);
		if($animal === null)
			throw $this->createNotFoundException('Animal[id='.$id.'] inexistant');
		return $this->render('@ExoPets/Default/voir.html.twig',array('animal' => $animal));	
	}
	
	public function navigationAction() {
		$repository = $this->getDoctrine()->getManager()->getRepository('ExoPetsBundle:Animal');
		$animals = $repository->findAll();
		return $this->render('@ExoPets/Default/navigation.html.twig',array('animal' => $animals));		
	}
	
	public function ajouter3Action(Request $request) {
		$animal = new Animal;
		$form = $this->createForm(AnimalType::class, $animal, array('action' => $this->generateUrl('exo_pets_ajouter3')));
		$form->add('submit', SubmitType::class, array ('label' => 'Ajouter'));
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid()){
			$now = (new \DateTime("now"));
			$animal->setDateNais($now);
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($animal);
			$entityManager->flush();
			return $this->redirectToRoute('exo_pets_voir', array('id' => $animal->getId()));
		}
		return $this->render('@ExoPets/Default/ajouter3.html.twig', array('monFormulaire' => $form->createView()));
	}

	public function modifierAction($id) {
		$em = $this->
		$form = $this->createForm(AnimalType::class, $animal, array('action' => $this->generateUrl('exo_pets_modifier')));
		$form->add('submit', SubmitType::class, array ('label' => 'Ajouter'));
		$form->handleRequest($request);
		
		if($form->isSubmitted() && $form->isValid()){
			$now = (new \DateTime("now"));
			$animal->setDateNais($now);
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($animal);
			$entityManager->flush();
			return $this->redirectToRoute('exo_pets_voir', array('id' => $animal->getId()));
		}
		return $this->render('@ExoPets/Default/ajouter3.html.twig', array('monFormulaire' => $form->createView()));
	}
}
