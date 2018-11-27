<?php

namespace SalleTpBundle\Controller;

use SalleTpBundle\Entity\Ordinateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class OrdinateurController extends Controller
{
    public function listerAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ordis = $em->getRepository('SalleTpBundle:Ordinateur')->findAll();
        return $this->render('@SalleTp/Ordinateur/lister.html.twig', ['ordinateurs' => $ordis]);
    }

    public function ajouterAction(Request $request)
    {
        $ordi = new Ordinateur();
        //$form = $this->createForm('SalleTpBundle\Form\OrdinateurType', $ordi); // Pour avoir toutes les salles
        $form = $this->createForm('SalleTpBundle\Form\OrdinateurType2', $ordi); // Pour avoir toutes les salles dont l'étage est inférieur ou égale à 1
        $form->add('submit', SubmitType::class, ['label' => 'Ajouter']);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($ordi);
            $em->flush();
            return $this->redirectToRoute('lister');
        }
        return $this->render('@SalleTp/Ordinateur/ajouter.html.twig', ['monForm' => $form->createView()]);
    }

}
