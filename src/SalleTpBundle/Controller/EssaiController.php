<?php

namespace SalleTpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use SalleTpBundle\Entity\Salle;
use Doctrine\Common\Util\Debug ;

class EssaiController extends Controller
{
	public function test1Action(){
		$em = $this->getDoctrine()->getManager();
		$salle = new Salle;
		$salle->setBatiment("D");
		$salle->setEtage(7);
		$salle->setNumero(10);
		$em->persist($salle);
		$result = 'persist --- '.$salle.' id: '.$salle->getId().'<br />';
		$em->flush();
		$result .= 'flush --- id: '.$salle->getId().'<br />';
		$repositorySalle = $em->getRepository('SalleTpBundle:Salle');
		$salle2 = $repositorySalle->find($salle->getId());
		if($salle2 !== null)
			$result .= 'find('.$salle->getId().') ---'.$salle2;
		return new Response('<html><body>'.$result.'</body></html>'); 
	}

	public function test2Action(){
		$em = $this->getDoctrine()->getManager();
		$salle = new Salle;
		$salle->setBatiment("D");
		$salle->setEtage(7);
		$salle->setNumero(73);
		$em->persist($salle);
		$salle->setNumero($salle->getNumero()+1);
		$em->flush();
		$repositorySalle = $em->getRepository('SalleTpBundle:Salle');
		$salle2 = $repositorySalle->find($salle->getId());
		return new Response('<html><body>'.$salle2.'</body></html>'); 
	}

	public function test3Action(){
		$em = $this->getDoctrine()->getManager();
		$salle = new Salle;
		$salle->setBatiment("D");
		$salle->setEtage(7);
		$salle->setNumero(75);
		$em->persist($salle);
		$result = 'persist --- '.$salle.'<br />';
		$em->flush();
		$id = $salle->getId();
		$result .= 'flush id: '.$id.' --- contains:'.$em->contains($salle).'<br />';
		$em->clear();
		$result .= 'clear contains:'.$em->contains($salle).'<br />';
		$repositorySalle = $em->getRepository('SalleTpBundle:Salle');
		$salle = $repositorySalle->find($id);
		$result .= 'find('.$id.') contains(cette salle):'.$em->contains($salle).'<br />';
		return new Response('<html><body>'.$result.'</body></html>'); 
	}

	public function test4Action(){
		$em = $this->getDoctrine()->getManager();
		$salle = new Salle;
		$salle->setBatiment("D");
		$salle->setEtage(7);
		$salle->setNumero(76);
		$em->persist($salle);
		$result = 'persist --- '.$salle.'<br />';
		$em->flush();
		$id = $salle->getId();
		$result .= 'flush id: '.$id.' --- contains:'.$em->contains($salle).'<br />';		
		$repositorySalle = $em->getRepository('SalleTpBundle:Salle');
		$salle = $repositorySalle->find($id);
		$result .='find('.$id.') salle:'.$salle.'<br/>';
		$em->remove($salle);
		$em->flush();
		$result .= 'remove salle puis flush <br />';
		$result .= 'find('.$id.') '.$repositorySalle->find($id).'<br />';
		$result .= 'contains(salle):'.$em->contains($salle).'<br />';
		return new Response('<html><body>'.$result.'</body></html>'); 
	}

	public function test6Action(){
		$repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
		$salle = $repository->find(1);
		var_dump($salle);
		echo '<br/>';
		Debug::dump($salle);
		return new Response('<html><body></body></html>'); 
	}

	public function test7Action(){
		$repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
		$salles = $repository->findAll();
		return $this->render('@SalleTp/Salle/liste.html.twig',array('salles' => $salles)); 
	}

	public function test8Action(){
		$repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
		$salles = $repository->findBy(array('etage' => 1),array('numero' =>'asc'));
		return $this->render('@SalleTp/Salle/liste.html.twig',array('salles' => $salles)); 
	}

	public function test9Action(){
		$repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
		$salles = $repository->findOneBy(array('etage' => 1));
		return new Response("<html><body>$salles</body></html>"); 
	}

	public function test10Action(){
		$repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
		$salles = $repository->findByBatiment('D');
		return $this->render('@SalleTp/Salle/liste.html.twig',array('salles' => $salles)); 
	}

	public function test11Action(){
		$repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
		$salles = $repository->findOneByBatiment('D');
		return new Response("<html><body>$salles</body></html>"); 
	}

	public function test12Action(){
		$repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
		$salles = $repository->findBE('D', 6);
		return $this->render('@SalleTp/Salle/liste.html.twig',array('salles' => $salles)); 
	}

	public function test13Action(){
		$repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
		$salles = $repository->salleAouB();
		return $this->render('@SalleTp/Salle/liste.html.twig',array('salles' => $salles)); 
	}

	public function test14Action(){
		$repository = $this->getDoctrine()->getManager()->getRepository('SalleTpBundle:Salle');
		$salles = $repository->plusUnEtage();
		return new Response('<html><body><a href="http://10.1.16.236/phpmyadmin"> voir phpmyadmin </a></body></html>'); 
	}
}
