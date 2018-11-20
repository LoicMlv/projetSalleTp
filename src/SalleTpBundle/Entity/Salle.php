<?php

namespace SalleTpBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salle
 *
 * @ORM\Table(name="salle")
 * @ORM\Entity(repositoryClass="SalleTpBundle\Repository\SalleRepository")
 */
class Salle
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="batiment", type="string", length=255)
     * @Assert\Length( min=1, max=1, exactMessage= "Votre nom doit faire {{ limit }} caractère")
     */
    private $batiment;

    /**
     * @var int
     *
     * @ORM\Column(name="etage", type="smallint")
     * @Assert\Regex( pattern="/^[0-9]$/", message="La valeur doit être comprise entre 0 et 9.")
     */
    private $etage;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="smallint")
     * @Assert\Regex( pattern="/^[0-9]+$/", message="La valeur doit être numérique.")
     * @Assert\LessThan( value=80, message="La valeur est inférieure ou égale à 80.")
     */
    private $numero;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set batiment
     *
     * @param string $batiment
     *
     * @return Salle
     */
    public function setBatiment($batiment)
    {
        $this->batiment = $batiment;

        return $this;
    }

    /**
     * Get batiment
     *
     * @return string
     */
    public function getBatiment()
    {
        return $this->batiment;
    }

    /**
     * Set etage
     *
     * @param integer $etage
     *
     * @return Salle
     */
    public function setEtage($etage)
    {
        $this->etage = $etage;

        return $this;
    }

    /**
     * Get etage
     *
     * @return int
     */
    public function getEtage()
    {
        return $this->etage;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     *
     * @return Salle
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    public function __toString() {
    	return $this->getBatiment().'-'.$this->getEtage().'.'.$this->getNumero();
    }
    

    

}

