<?php

namespace SalleTpBundle\Controller;

use SalleTpBundle\Entity\Ordinateur;
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

    public function test25Action(){
        $em = $this->getDoctrine()->getManager();
        $ordi = new Ordinateur();
        $ordi->setNumero(702);
        $ordi->setIp('192.168.7.02');
        $repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
        $salle = $repository->findOneBy(['batiment' => 'B', "etage" => 3, 'numero' =>63]);
        $ordi->setSalle($salle);
        $em->persist($ordi);
        $em->flush();
        Debug::dump($ordi);
        return new Response('<html><body></body></html>');
    }

    public function test26Action(){
        $em = $this->getDoctrine()->getManager();
        $ordi = new Ordinateur();
        $ordi->setNumero(701);
        $ordi->setIp('192.168.7.01');
        $salle = new Salle;
        $salle->setBatiment('D')
            ->setEtage(7)
            ->setNumero(01);
        $ordi->setSalle($salle);
        $em->persist($ordi);
        $em->persist($salle);
        $em->flush();
        Debug::dump($ordi);
        return new Response('<html><body></body></html>');
    }

    public function test27Action(){
        $em = $this->getDoctrine()->getManager();
        $ordi = new Ordinateur();
        $ordi->setNumero(703)
            ->setIp('192.168.7.03');
        $salle = new Salle();
        $salle->setBatiment('D')
            ->setEtage(7)
            ->setNumero(03);
        $ordi->setSalle($salle);
        $em->persist($ordi);
        $em->flush();
        Debug::dump($ordi);
        return new Response('<html><body></body></html>');
    }

    public function test28Action(){
        $em = $this->getDoctrine()->getManager();
        $repositoryOrdi = $em->getRepository('SalleTpBundle:Ordinateur');
        $ordi = $repositoryOrdi->findOneByNumero(703);
        return new Response('<html><body><br\><br\>batiment :'.$ordi->getSalle()->getBatiment().'</body>');
    }

    public function test29Action(){
        $em = $this->getDoctrine()->getManager();
        $ordi = new Ordinateur();
        $ordi->setNumero(803)
            ->setIp('192.168.8.03');
        $salle = new Salle();
        $salle->setBatiment('D')
            ->setEtage(8)
            ->setNumero(03)
            ->addOrdinaeur($ordi);
        $em->persist($ordi);
        $em->flush();
        Debug::dump($ordi);
        return new Response('<html><body></body></html>');
    }

    public function test30Action(){
        $em = $this->getDoctrine()->getManager();
        $ordi = new Ordinateur();
        $ordi->setNumero(804)
            ->setIp('192.168.8.04');
        $salle = new Salle();
        $salle->setBatiment('D')
            ->setEtage(8)
            ->setNumero(04);
        $ordi->setSalle($salle); // remplace $salle->addOrdinateur($ordi);
        $em->persist($ordi);
        $em->flush();
        Debug::dump($ordi);
        return new Response('<html><body></body></html>');
    }

    public function test31Action(){
        $em = $this->getDoctrine()->getManager();
        $ordi = new Ordinateur();
        $ordi->setNumero(807)
            ->setIp('192.168.8.07');
        $salle = new Salle();
        $salle->setBatiment('D')
            ->setEtage(8)
            ->setNumero(07);
        $salle->addOrdinateur($ordi);
        $em->persist($ordi);
        $em->flush();
        Debug::dump($ordi);
        return new Response('<html><body></body></html>');
    }

    public function test32Action(){
        $em = $this->getDoctrine()->getManager();
        $repositoryOrdi = $em->getRepository('SalleTpBundle:Ordinateur');
        $ordi = $repositoryOrdi->findOneByNumero(807);
        $ordi2 = new Ordinateur();
        $ordi2->setNumero(808)
            ->setIp('192.168.8.08')
            ->setSalle($ordi->getSalle());
        $em->persist($ordi2);
        $id = $ordi->getSalle()->getId();
        $em->flush();
        $em->clear();
        $repositorySalle = $em->getRepository('SalleTpBundle:Salle');
        $salle = $repositorySalle->find($id);
        $result = "";
        foreach ($salle->getOrdinateur() as $ordi)
            $result .= $ordi->getIp();
        return new Response('<html><body>'.$result.'</body></html>');
    }
}
