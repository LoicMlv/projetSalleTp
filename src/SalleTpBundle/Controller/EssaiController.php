<?php

namespace SalleTpBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use SalleTpBundle\Entity\Salle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Util\Debug;
class EssaiController extends Controller
{
    public function test1Action() {
        $entityManager = $this->getDoctrine()->getManager();
        $salle = new Salle();
        $salle->setBatiment('D');
        $salle->setEtage(7);
        $salle->setNumero(70);
        $entityManager->persist($salle);
        $result = 'persist ---  '.$salle.'  id:'.$salle->getId().'<br />';
        $entityManager->flush();
        $result .= 'flush   ----  id:'.$salle->getId().'<br />';
        $repositorySalle = $entityManager->getRepository('SalleTpBundle:Salle');
        $salle2 = $repositorySalle->find($salle->getId());
        if ($salle2 != null)
            $result .= 'find('.$salle->getId().') ----'.$salle2;
        return new Response('<html><body>'.$result.'</body></html>');
    }

    public function test2Action() {
        $entityManager = $this->getDoctrine()->getManager();
        $salle = new Salle();
        $salle->setBatiment('D');
        $salle->setEtage(7);
        $salle->setNumero(73);
        $entityManager->persist($salle);
        $salle->setNumero($salle->getNumero() + 1);
        $entityManager->flush();
        $repositorySalle = $entityManager->getRepository('SalleTpBundle:Salle');
        $salle2 = $repositorySalle->find($salle->getId());
        return new Response('<html><body>'.$salle2.'</body></html>');
    }

    public function test3Action() {
        $entityManager = $this->getDoctrine()->getManager();
        $salle = new Salle();
        $salle->setBatiment('D');
        $salle->setEtage(7);
        $salle->setNumero(75);
        $entityManager->persist($salle);
        $result = 'persist '.$salle.'<br />';
        $entityManager->flush();
        $id = $salle->getId();
        $result .= 'flush id:'.$id.'    --- contains:'.$entityManager->contains($salle).'<br />';
        $entityManager->clear();
        $result .= 'clear --- contains:'.$entityManager->contains($salle).'<br />';
        $repositorySalle = $entityManager->getRepository('SalleTpBundle:Salle');
        $salle = $repositorySalle->find($id);
        $result .= 'find('.$id.')   ---- contains(cette salle):'.$entityManager->contains($salle).'<br />';

        return new Response('<html><body>'.$result.'</body></html>');
    }
    
    public function test4Action() {
        $entityManager = $this->getDoctrine()->getManager();
        $salle = new Salle();
        $salle->setBatiment('D');
        $salle->setEtage(7);
        $salle->setNumero(76);
        $entityManager->persist($salle);
        $result = 'persist '.$salle.'<br />';
        $entityManager->flush();
        $id = $salle->getId();
        $result .= 'flush ---- id:'.$id.'<br />';
        $repositorySalle = $entityManager->getRepository('SalleTpBundle:Salle');
        $salle = $repositorySalle->find($id);
        $result .= 'find('.$id.')   ---salle: '.$salle.'<br />';
        $entityManager->remove($salle);
        $entityManager->flush();
        $result .= 'remove salle puis flush <br />';
        $result .= 'find('.$id.')= '.$repositorySalle->find($id).'<br />';
        $result .= 'contains(salle):'.$entityManager->contains($salle);
        return new Response("<html><body>".$result."</body></html>");
    }

    public function test6Action() {
        $repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
        $salle = $repository->find(1);
        // var_dump($salle);
        Debug::dump($salle);
        return new Response('<html><body></body></html>');
    }

    public function test7Action() {
        $repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
        $salle = $repository->findAll();
        return $this->render('@SalleTp/Salle/liste.html.twig', array('listeSalles'=>$salle));
    }

    public function test8Action() {
        $repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
        $salle = $repository->findBy(array('etage' => 1),array('numero' => 'asc'), 2,1);
        return $this->render('@SalleTp/Salle/liste.html.twig', array('listeSalles'=>$salle));
    }

    public function test9Action() {
        $repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
        $salle = $repository->findOneBy(array('etage'=>1));
        return new Response('<html><body>'.$salle.'</body></html>');
    }

    public function test10Action() {
        $repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
        $salle = $repository->findByBatiment('B');
        return $this->render('@SalleTp/Salle/liste.html.twig', array('listeSalles'=>$salle));
    }

    public function test11Action() {
        $repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
        $salle = $repository->findOneByEtage(1);
        return new Response('<html><body>'.$salle.'</body></html>');
    }

    public function test12Action() {
        $repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
        $salle = $repository->findByBatimentAndEtageMax('C',6);
        return $this->render('@SalleTp/Salle/liste.html.twig', array('listeSalles'=>$salle));
    }

    public function test13Action() {
        $repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
        $salle = $repository->findSalleBatAouB();
        return $this->render('@SalleTp/Salle/liste.html.twig', array('listeSalles'=>$salle));
    }
    
    public function test14Action() {
        $repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
        $salle = $repository->plusUnEtage();
        return new Response('<html><body><a href="http://localhost/phpmyadmin">voir phpmyadmin</a></body></html>');
    }

    public function test16Action() {
        $repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
        $salle = $repository->testGetResult();
        Debug::dump($salle);
        return new Response('<html><body></body></html>');
    }

    public function test19Action() {
        $repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
        $salle = $repository->testGetSingleScalarResult();
        Debug::dump($salle);
        return new Response('<html><body></body></html>');
    }

    public function test23Action() {
        $entityManager = $this->getDoctrine()->getManager();
        $salle = new Salle;
        $salle->setBatiment('b');
        $salle->setEtage(3);
        $salle->setNumero(63);
        $entityManager->persist($salle);
        $entityManager->flush();
        return $this->redirectToRoute('salle_tp_voir2', array('id'=>$salle->getId()));
    }
}
