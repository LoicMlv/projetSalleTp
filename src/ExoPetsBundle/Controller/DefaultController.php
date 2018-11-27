<?php

namespace ExoPetsBundle\Controller;

use Doctrine\Common\Util\Debug;
use ExoPetsBundle\Entity\Maitre;
use ExoPetsBundle\Form\AnimalType;
use Symfony\Component\HttpFoundation\Response;
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
        $repo = $this->getDoctrine()->getManager()->getRepository('ExoPetsBundle:Animal');
        $animal = $repo->findAll();
    	return $this->render('@ExoPets/Default/index.html.twig', ['animals' => $animal]);
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

//	public function modifierAction($id) {
//		$em = $this->$this->getDoctrine()->getManager();
//		$form = $this->createForm(AnimalType::class, $animal, array('action' => $this->generateUrl('exo_pets_modifier')));
//		$form->add('submit', SubmitType::class, array ('label' => 'Ajouter'));
//		$form->handleRequest($request);
//
//		if($form->isSubmitted() && $form->isValid()){
//			$now = (new \DateTime("now"));
//			$animal->setDateNais($now);
//			$entityManager = $this->getDoctrine()->getManager();
//			$entityManager->persist($animal);
//			$entityManager->flush();
//			return $this->redirectToRoute('exo_pets_voir', array('id' => $animal->getId()));
//		}
//		return $this->render('@ExoPets/Default/ajouter3.html.twig', array('monFormulaire' => $form->createView()));
//	}

    public function updateAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $animal = $em->getRepository('ExoPetsBundle:Animal')->find($id);
        $form = $this->createForm(AnimalType::class, $animal);
        $form->add('submit',SubmitType::class, ['label' => 'Modifier']);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $now = (new \DateTime("now"));
            $animal->setDateNais($now);
            $em->persist($animal);
            $em->flush();
            return $this->redirectToRoute('exo_pets_voir', ['id' => $animal->getId()]);
        }
        return $this->render('@ExoPets/Default/modifier.html.twig', ['monFormulaire' => $form->createView(), 'id' => $id]);
    }

    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $animal = $em->getRepository('ExoPetsBundle:Animal')->find($id);
        $em->remove($animal);
        $em->flush();
        return $this->redirectToRoute('exo_pets_homepage');
    }

    public function substringAction($souschaine){
        $repository = $this->getDoctrine()->getManager()->getRepository('ExoPetsBundle:Animal');
        $result = $repository->findByNomApproximatif($souschaine);
        return $this->render('@ExoPets/Default/vue.html.twig', ['result' => $result]);
    }

    public function lourdAction($poids){
        $repository = $this->getDoctrine()->getManager()->getRepository('ExoPetsBundle:Animal');
        $result = $repository->findAnimalLourd($poids);
        return $this->render('@ExoPets/Default/vue.html.twig', ['result' => $result]);
    }

//    public function poidsminAction(){
//        $repository = $this->getDoctrine()->getManager()->getRepository('ExoPetsBundle:Animal');
//        $result = $repository->findCPoidsMin();
//        Debug::dump($result);
//        return new Response('<html><body></body></html>');
//        return $this->render('@ExoPets/Default/vue.html.twig', ['result' => $result]);
//    }

    public function doublerAction(){
        $repository = $this->getDoctrine()->getManager()->getRepository('ExoPetsBundle:Animal');
        $repository->doubler();
        return $this->redirectToRoute('exo_pets_homepage');
    }

    public function voirToutAction($id){
        $em = $this->getDoctrine()->getManager();
        $maitre = $em->getRepository('ExoPetsBundle:Maitre')->find($id);
        return $this->render('@ExoPets/Default/maitre.html.twig', ['maitre' => $maitre]);
    }

    public function delAction($id){
        $em = $this->getDoctrine()->getManager();
        $repositoryMaitre = $em->getRepository('ExoPetsBundle:Maitre');
        $maitre = $repositoryMaitre->find($id);
        $em->remove($maitre);
        $em->flush();
        return new Response('<html><body>Le maître numéro '.$id.' ainsi que ces animaux, ont été delete</body></html>');
    }

    public function addAMAction(Request $request){
        $animal = new Animal();
        $form = $this->createForm('ExoPetsBundle\Form\AnimalType2', $animal);
        $form->add('submit',SubmitType::class, ['label' => 'Ajouter']);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $now = (new \DateTime("now"));
            $animal->setDateNais($now);
            $em->persist($animal);
            $em->flush();
            return $this->redirectToRoute('exo_pets_homepage');
        }
        return $this->render('@ExoPets/Default/ajouterAM.html.twig', ['form' => $form->createView()]);
    }
}
